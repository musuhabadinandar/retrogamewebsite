(function () {
  "use strict";

  var blockedSchemes = /^(?:https?:)?\/\//i;
  var allowedPrefixes = ["data:", "blob:", "about:blank"];
  var noop = function () {};
  var noopPromise = function (payload) {
    return Promise.resolve(payload || { errMsg: "ok" });
  };

  function isAllowedUrl(url) {
    if (!url) {
      return true;
    }

    var normalized = String(url).trim();
    if (!normalized) {
      return true;
    }

    for (var i = 0; i < allowedPrefixes.length; i += 1) {
      if (normalized.indexOf(allowedPrefixes[i]) === 0) {
        return true;
      }
    }

    if (normalized.indexOf("/") === 0 || normalized.indexOf("./") === 0 || normalized.indexOf("../") === 0) {
      return true;
    }

    if (!blockedSchemes.test(normalized)) {
      return true;
    }

    try {
      return new URL(normalized, window.location.href).origin === window.location.origin;
    } catch (error) {
      return false;
    }
  }

  function blockedResponse() {
    return {
      ok: false,
      status: 204,
      statusText: "Blocked",
      url: "",
      redirected: false,
      type: "basic",
      headers: new Headers(),
      text: function () { return Promise.resolve(""); },
      json: function () { return Promise.resolve({ blocked: true }); },
      blob: function () { return Promise.resolve(new Blob([])); },
      arrayBuffer: function () { return Promise.resolve(new ArrayBuffer(0)); },
      clone: blockedResponse
    };
  }

  function asyncCallback(fn, payload) {
    if (typeof fn !== "function") {
      return;
    }

    setTimeout(function () {
      try {
        fn(payload);
      } catch (error) {
        console.warn("Browser-safe shim callback failed", error);
      }
    }, 0);
  }

  function createAdStub() {
    return {
      show: function () { return noopPromise({ errMsg: "show:ok" }); },
      hide: noop,
      load: function () { return noopPromise({ errMsg: "load:ok" }); },
      destroy: noop,
      onLoad: noop,
      offLoad: noop,
      onError: noop,
      offError: noop,
      onClose: noop,
      offClose: noop,
      onResize: noop,
      offResize: noop,
      onHide: noop,
      offHide: noop,
      onShow: noop,
      offShow: noop,
      style: {}
    };
  }

  function createStorageApi() {
    return {
      getStorageSync: function (key) {
        try {
          return window.localStorage.getItem(key);
        } catch (error) {
          return null;
        }
      },
      setStorageSync: function (key, value) {
        try {
          window.localStorage.setItem(key, String(value));
        } catch (error) {
          noop(error);
        }
      },
      removeStorageSync: function (key) {
        try {
          window.localStorage.removeItem(key);
        } catch (error) {
          noop(error);
        }
      },
      clearStorageSync: function () {
        try {
          window.localStorage.clear();
        } catch (error) {
          noop(error);
        }
      }
    };
  }

  function createPlatformApi(platformName) {
    var storage = createStorageApi();
    var listeners = { show: [], hide: [] };

    function request(opts) {
      var options = opts || {};
      var url = options.url || "";

      if (!isAllowedUrl(url)) {
        var blockedPayload = {
          data: {},
          statusCode: 204,
          errMsg: platformName + ".request blocked"
        };
        asyncCallback(options.success, blockedPayload);
        asyncCallback(options.complete, blockedPayload);
        return noopPromise(blockedPayload);
      }

      return fetch(url, {
        method: options.method || "GET",
        body: options.data ? JSON.stringify(options.data) : undefined,
        credentials: "same-origin",
        headers: options.header || {}
      })
        .then(function (response) {
          return response.text().then(function (text) {
            var payload = { data: text, statusCode: response.status, errMsg: platformName + ".request:ok" };
            asyncCallback(options.success, payload);
            asyncCallback(options.complete, payload);
            return payload;
          });
        })
        .catch(function () {
          var payload = { errMsg: platformName + ".request blocked" };
          asyncCallback(options.fail, payload);
          asyncCallback(options.complete, payload);
          return payload;
        });
    }

    function login(opts) {
      var payload = { code: platformName + "-browser-local", errMsg: platformName + ".login:ok" };
      asyncCallback((opts || {}).success, payload);
      asyncCallback((opts || {}).complete, payload);
      return noopPromise(payload);
    }

    function navigate(opts) {
      var payload = { errMsg: platformName + ".navigateToMiniProgram blocked" };
      asyncCallback((opts || {}).success, payload);
      asyncCallback((opts || {}).complete, payload);
      return noopPromise(payload);
    }

    function share(opts) {
      var payload = { errMsg: platformName + ".shareAppMessage suppressed" };
      asyncCallback((opts || {}).success, payload);
      asyncCallback((opts || {}).complete, payload);
      return payload;
    }

    return {
      login: login,
      request: request,
      requestSubscribeMessage: function (opts) {
        var payload = { errMsg: platformName + ".requestSubscribeMessage blocked" };
        asyncCallback((opts || {}).success, payload);
        asyncCallback((opts || {}).complete, payload);
        return noopPromise(payload);
      },
      shareAppMessage: share,
      showShareMenu: noop,
      hideShareMenu: noop,
      updateShareMenu: noop,
      onShareAppMessage: noop,
      offShareAppMessage: noop,
      getLaunchOptionsSync: function () {
        return { scene: 1001, path: "", query: {}, referrerInfo: {}, shareTicket: "" };
      },
      getSystemInfoSync: function () {
        return {
          brand: "browser",
          model: navigator.userAgent,
          pixelRatio: window.devicePixelRatio || 1,
          screenWidth: window.innerWidth || 1280,
          screenHeight: window.innerHeight || 720,
          windowWidth: window.innerWidth || 1280,
          windowHeight: window.innerHeight || 720,
          platform: "web",
          system: navigator.platform || "web",
          language: navigator.language || "en-US",
          version: "web"
        };
      },
      getMenuButtonBoundingClientRect: function () {
        return { top: 0, left: 0, width: 0, height: 0, right: 0, bottom: 0 };
      },
      getAccountInfoSync: function () {
        return { miniProgram: { appId: "browser-local", envVersion: "release" } };
      },
      getOpenDataContext: function () {
        return { postMessage: noop, canvas: document.createElement("canvas") };
      },
      createRewardedVideoAd: createAdStub,
      createBannerAd: createAdStub,
      createInterstitialAd: createAdStub,
      createCustomAd: createAdStub,
      createGridAd: createAdStub,
      createGameClubButton: createAdStub,
      createFeedbackButton: createAdStub,
      createUserInfoButton: createAdStub,
      createInnerAudioContext: function () {
        return {
          play: noop,
          pause: noop,
          stop: noop,
          destroy: noop,
          onPlay: noop,
          onPause: noop,
          onStop: noop,
          onEnded: noop,
          onError: noop,
          offPlay: noop,
          offPause: noop,
          offStop: noop,
          offEnded: noop,
          offError: noop
        };
      },
      navigateToMiniProgram: navigate,
      openEmbeddedMiniProgram: navigate,
      exitMiniProgram: noop,
      onShow: function (fn) { listeners.show.push(fn); },
      offShow: noop,
      onHide: function (fn) { listeners.hide.push(fn); },
      offHide: noop,
      triggerShow: function (payload) { listeners.show.forEach(function (fn) { asyncCallback(fn, payload || {}); }); },
      triggerHide: function (payload) { listeners.hide.forEach(function (fn) { asyncCallback(fn, payload || {}); }); },
      vibrateShort: noop,
      vibrateLong: noop,
      canIUse: function () { return false; },
      env: { USER_DATA_PATH: "." },
      getClipboardData: function (opts) {
        var payload = { data: "" };
        asyncCallback((opts || {}).success, payload);
        return noopPromise(payload);
      },
      setClipboardData: function (opts) {
        var payload = { errMsg: platformName + ".setClipboardData:ok" };
        asyncCallback((opts || {}).success, payload);
        return noopPromise(payload);
      },
      openCustomerServiceConversation: noop,
      setEnableDebug: noop,
      setPreferredFramesPerSecond: noop,
      showToast: function (opts) {
        asyncCallback((opts || {}).success, { errMsg: platformName + ".showToast:ok" });
      },
      hideToast: noop,
      showModal: function (opts) {
        asyncCallback((opts || {}).success, { confirm: true, cancel: false, errMsg: platformName + ".showModal:ok" });
      },
      showLoading: noop,
      hideLoading: noop,
      authorize: function (opts) {
        asyncCallback((opts || {}).success, { errMsg: platformName + ".authorize:ok" });
        return noopPromise({ errMsg: platformName + ".authorize:ok" });
      },
      getUserInfo: function (opts) {
        var payload = {
          userInfo: {
            nickName: "Webarcade Player",
            avatarUrl: "",
            gender: 0,
            country: "",
            province: "",
            city: "",
            language: navigator.language || "en-US"
          },
          errMsg: platformName + ".getUserInfo:ok"
        };
        asyncCallback((opts || {}).success, payload);
        return noopPromise(payload);
      },
      getUserProfile: function (opts) {
        var payload = {
          userInfo: {
            nickName: "Webarcade Player",
            avatarUrl: ""
          },
          errMsg: platformName + ".getUserProfile:ok"
        };
        asyncCallback((opts || {}).success, payload);
        return noopPromise(payload);
      },
      ...storage
    };
  }

  var originalOpen = window.open ? window.open.bind(window) : null;
  if (originalOpen) {
    window.open = function (url, target, features) {
      if (!isAllowedUrl(url)) {
        console.warn("Blocked external window.open", url);
        return null;
      }
      return originalOpen(url, target, features);
    };
  }

  if (window.fetch) {
    var originalFetch = window.fetch.bind(window);
    window.fetch = function (input, init) {
      var url = typeof input === "string" ? input : (input && input.url) || "";
      if (!isAllowedUrl(url)) {
        console.warn("Blocked external fetch", url);
        return Promise.resolve(blockedResponse());
      }
      return originalFetch(input, init);
    };
  }

  if (window.XMLHttpRequest) {
    var originalOpenMethod = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function (method, url) {
      this.__blockedExternal = !isAllowedUrl(url);
      this.__blockedUrl = url;
      return originalOpenMethod.apply(this, arguments);
    };

    var originalSendMethod = XMLHttpRequest.prototype.send;
    XMLHttpRequest.prototype.send = function () {
      if (!this.__blockedExternal) {
        return originalSendMethod.apply(this, arguments);
      }
      console.warn("Blocked external XHR", this.__blockedUrl);
      this.readyState = 4;
      this.status = 204;
      this.responseText = "";
      asyncCallback(this.onreadystatechange, {});
      asyncCallback(this.onload, {});
      return undefined;
    };
  }

  if (navigator.sendBeacon) {
    var originalBeacon = navigator.sendBeacon.bind(navigator);
    navigator.sendBeacon = function (url, data) {
      if (!isAllowedUrl(url)) {
        console.warn("Blocked external sendBeacon", url);
        return true;
      }
      return originalBeacon(url, data);
    };
  }

  document.addEventListener("click", function (event) {
    var node = event.target;
    while (node && node !== document.body) {
      if (node.tagName === "A") {
        var href = node.getAttribute("href");
        if (!isAllowedUrl(href)) {
          event.preventDefault();
          event.stopPropagation();
          console.warn("Blocked external navigation", href);
        }
        return;
      }
      node = node.parentElement;
    }
  }, true);

  window.wx = window.wx || createPlatformApi("wx");
  window.tt = window.tt || createPlatformApi("tt");
  window.qq = window.qq || createPlatformApi("qq");
  window.my = window.my || createPlatformApi("my");
  window.qg = window.qg || createPlatformApi("qg");
  window.swan = window.swan || createPlatformApi("swan");
  window.GameGlobal = window.GameGlobal || window;

  window.aldSendEvent = window.aldSendEvent || noop;
  window.aldOnShareAppMessage = window.aldOnShareAppMessage || noop;
  window.aldSendOpenid = window.aldSendOpenid || noop;
  window.GravityAnalytics = window.GravityAnalytics || { track: noop, init: noop };
  window.wx.aldSendEvent = window.wx.aldSendEvent || noop;
  window.tt.aldSendEvent = window.tt.aldSendEvent || noop;

  window.__webarcadeBrowserSafe = {
    isAllowedUrl: isAllowedUrl
  };
})();
