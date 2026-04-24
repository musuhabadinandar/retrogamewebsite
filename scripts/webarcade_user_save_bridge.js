(function () {
  "use strict";

  function parseGameId() {
    var match = window.location.pathname.match(/\/game\/([0-9]{2})\//);
    return match ? match[1] : "";
  }

  function syncJsonRequest(method, url, body, headers) {
    try {
      var xhr = new XMLHttpRequest();
      xhr.open(method, url, false);
      xhr.withCredentials = true;
      xhr.setRequestHeader("Accept", "application/json");
      if (headers) {
        Object.keys(headers).forEach(function (key) {
          xhr.setRequestHeader(key, headers[key]);
        });
      }
      xhr.send(body || null);
      if (xhr.status >= 200 && xhr.status < 300 && xhr.responseText) {
        return JSON.parse(xhr.responseText);
      }
    } catch (error) {
      console.warn("Cloud-save bridge request failed", error);
    }

    return null;
  }

  function installNamespacedStorage(prefix, csrfToken, gameId, user) {
    var nativeStorage = window.localStorage;
    var storageProto = Object.getPrototypeOf(nativeStorage);
    var originalGetItem = storageProto.getItem;
    var originalSetItem = storageProto.setItem;
    var originalRemoveItem = storageProto.removeItem;
    var originalClear = storageProto.clear;
    var originalKey = storageProto.key;
    var syncTimer = 0;
    var isSyncing = false;
    var saveEndpoint = "/webarcade/api/save.php";

    function visibleKeys() {
      var keys = [];
      var total = nativeStorage.length;

      for (var index = 0; index < total; index += 1) {
        var fullKey = originalKey.call(nativeStorage, index);
        if (typeof fullKey === "string" && fullKey.indexOf(prefix) === 0) {
          keys.push(fullKey.slice(prefix.length));
        }
      }

      keys.sort();
      return keys;
    }

    function collectPayload() {
      var payload = {};
      visibleKeys().forEach(function (key) {
        payload[key] = originalGetItem.call(nativeStorage, prefix + key) || "";
      });
      return payload;
    }

    function uploadNow() {
      if (isSyncing) {
        return;
      }

      isSyncing = true;
      fetch(saveEndpoint, {
        method: "POST",
        credentials: "same-origin",
        keepalive: true,
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-Token": csrfToken
        },
        body: JSON.stringify({
          game_id: gameId,
          storageData: collectPayload()
        })
      })
        .catch(function (error) {
          console.warn("Cloud-save upload failed", error);
        })
        .finally(function () {
          isSyncing = false;
        });
    }

    function scheduleUpload() {
      if (syncTimer) {
        window.clearTimeout(syncTimer);
      }

      syncTimer = window.setTimeout(function () {
        syncTimer = 0;
        uploadNow();
      }, 900);
    }

    storageProto.getItem = function (key) {
      return originalGetItem.call(this, prefix + String(key));
    };

    storageProto.setItem = function (key, value) {
      originalSetItem.call(this, prefix + String(key), String(value));
      scheduleUpload();
    };

    storageProto.removeItem = function (key) {
      originalRemoveItem.call(this, prefix + String(key));
      scheduleUpload();
    };

    storageProto.clear = function () {
      visibleKeys().forEach(function (key) {
        originalRemoveItem.call(nativeStorage, prefix + key);
      });
      scheduleUpload();
    };

    storageProto.key = function (index) {
      var keys = visibleKeys();
      return typeof keys[index] === "string" ? keys[index] : null;
    };

    try {
      Object.defineProperty(storageProto, "length", {
        configurable: true,
        get: function () {
          return visibleKeys().length;
        }
      });
    } catch (error) {
      console.warn("Cloud-save bridge could not patch localStorage.length", error);
    }

    window.__webarcadeCloudSave = {
      active: true,
      gameId: gameId,
      user: user,
      flush: uploadNow
    };

    window.addEventListener("beforeunload", uploadNow);
    window.addEventListener("pagehide", uploadNow);
    document.addEventListener("visibilitychange", function () {
      if (document.visibilityState === "hidden") {
        uploadNow();
      }
    });
  }

  function bootstrap() {
    var gameId = parseGameId();
    if (!gameId) {
      return;
    }

    var session = syncJsonRequest("GET", "/webarcade/api/auth.php");
    if (!session || !session.authenticated || !session.user || !session.csrfToken) {
      window.__webarcadeCloudSave = {
        active: false,
        gameId: gameId,
        mode: "guest"
      };
      return;
    }

    var prefix = "webarcade:user:" + session.user.id + ":game:" + gameId + ":";
    var restore = syncJsonRequest("GET", "/webarcade/api/save.php?game_id=" + encodeURIComponent(gameId));
    var nativeStorage = window.localStorage;
    var storageProto = Object.getPrototypeOf(nativeStorage);
    var originalSetItem = storageProto.setItem;
    var originalRemoveItem = storageProto.removeItem;
    var originalKey = storageProto.key;
    var total = nativeStorage.length;
    var clearList = [];

    for (var index = 0; index < total; index += 1) {
      var fullKey = originalKey.call(nativeStorage, index);
      if (typeof fullKey === "string" && fullKey.indexOf(prefix) === 0) {
        clearList.push(fullKey);
      }
    }

    clearList.forEach(function (fullKey) {
      originalRemoveItem.call(nativeStorage, fullKey);
    });

    if (restore && restore.storageData && typeof restore.storageData === "object") {
      Object.keys(restore.storageData).forEach(function (key) {
        originalSetItem.call(nativeStorage, prefix + key, String(restore.storageData[key] || ""));
      });
    }

    installNamespacedStorage(prefix, session.csrfToken, gameId, session.user);
  }

  bootstrap();
})();
