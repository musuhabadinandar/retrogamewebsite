async function loadCatalog() {
  const response = await fetch("games.json", { cache: "no-store" });
  if (!response.ok) {
    throw new Error(`Unable to load catalog (${response.status})`);
  }

  return response.json();
}

async function apiRequest(url, options = {}) {
  const response = await fetch(url, {
    cache: "no-store",
    credentials: "same-origin",
    headers: {
      Accept: "application/json",
      ...(options.headers || {})
    },
    ...options
  });

  let payload = {};
  try {
    payload = await response.json();
  } catch (error) {
    payload = {};
  }

  if (!response.ok || payload.ok === false) {
    const message = payload.error || `Request failed (${response.status})`;
    throw new Error(message);
  }

  return payload;
}

async function loadSession() {
  return apiRequest("api/auth.php");
}

async function submitAuth(action, username, password) {
  return apiRequest("api/auth.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      action,
      username,
      password
    })
  });
}

async function logout(csrfToken) {
  return apiRequest("api/auth.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-Token": csrfToken
    },
    body: JSON.stringify({
      action: "logout",
      csrfToken
    })
  });
}

async function loadAccountDetails() {
  return apiRequest("api/account.php");
}

async function changePassword(csrfToken, currentPassword, newPassword) {
  return apiRequest("api/account.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-Token": csrfToken
    },
    body: JSON.stringify({
      action: "change_password",
      csrfToken,
      currentPassword,
      newPassword
    })
  });
}

async function clearGameSave(csrfToken, gameId) {
  return apiRequest("api/save.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-Token": csrfToken
    },
    body: JSON.stringify({
      action: "clear",
      csrfToken,
      game_id: gameId
    })
  });
}

function clearGuestFrameStorage(frameElement) {
  if (!frameElement || !frameElement.contentWindow) {
    return false;
  }

  try {
    frameElement.contentWindow.localStorage.clear();
    frameElement.contentWindow.sessionStorage.clear();
    return true;
  } catch (error) {
    console.warn("Unable to clear guest frame storage", error);
    return false;
  }
}

const knownCompatibilityIssues = {
  "01": {
    title: "Legacy backend dependency",
    message: "This bundle still calls the retired qcymw heartbeat/login endpoints and websocket flow. If it stalls at 0%, that is a game-code dependency issue, not a Laragon engine failure."
  }
};

function escapeHtml(value) {
  return String(value)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#39;");
}

function authLinksMarkup(session) {
  if (session.authenticated && session.user) {
    return `
      <div class="inline-links">
        <a class="text-link" href="account.html">Open Account Center</a>
        <a class="text-link" href="api/account.php?export=1">Export My Saves JSON</a>
      </div>
    `;
  }

  return `
    <div class="inline-links">
      <a class="text-link" href="login.html">Open Sign-In Page</a>
      <a class="text-link" href="register.html">Open Register Page</a>
    </div>
  `;
}

function mountInlineAuthForm(container, session, onSessionChange) {
  container.innerHTML = `
    <div class="account-shell">
      <div>
        <p class="metric-label">Account</p>
        <strong class="account-name">Guest Mode</strong>
        <p class="account-copy">
          Create an account or sign in to sync saves per user. Guest saves stay only in this browser.
        </p>
      </div>
      <form class="auth-form" data-auth-form data-auth-default="login">
        <input class="auth-input" name="username" type="text" minlength="3" maxlength="32" placeholder="Username" required>
        <input class="auth-input" name="password" type="password" minlength="6" maxlength="128" placeholder="Password" required>
        <div class="account-actions">
          <button type="submit" class="btn btn-primary" data-auth-action="login">Sign In</button>
          <button type="button" class="btn btn-secondary" data-auth-action="register">Create Account</button>
        </div>
        <p class="auth-feedback" data-auth-feedback></p>
      </form>
      ${authLinksMarkup(session)}
    </div>
  `;

  const form = container.querySelector("[data-auth-form]");
  const feedback = container.querySelector("[data-auth-feedback]");
  let intent = "login";

  form.querySelectorAll("[data-auth-action]").forEach((button) => {
    button.addEventListener("click", () => {
      intent = button.getAttribute("data-auth-action") || "login";
      if (button.type !== "submit") {
        form.requestSubmit();
      }
    });
  });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    const username = form.elements.username.value.trim();
    const password = form.elements.password.value;
    feedback.textContent = intent === "register" ? "Creating account..." : "Signing in...";

    try {
      const nextSession = await submitAuth(intent, username, password);
      feedback.textContent = intent === "register" ? "Account created." : "Signed in.";
      onSessionChange(nextSession);
    } catch (error) {
      feedback.textContent = error instanceof Error ? error.message : "Authentication failed.";
    }
  });
}

function renderAccountPanel(container, session, onSessionChange) {
  if (!container) {
    return;
  }

  if (session.authenticated && session.user) {
    container.innerHTML = `
      <div class="account-shell">
        <div>
          <p class="metric-label">Signed in</p>
          <strong class="account-name">${escapeHtml(session.user.username)}</strong>
          <p class="account-copy">
            Cloud saves are active for this account. Each game now uses a separate namespaced save slot in the database.
          </p>
        </div>
        <div class="account-actions">
          <a class="btn btn-secondary" href="account.html">Account Center</a>
          <a class="btn btn-secondary" href="api/account.php?export=1">Export JSON</a>
          <button type="button" class="btn btn-primary" data-auth-logout>Log Out</button>
        </div>
        ${authLinksMarkup(session)}
      </div>
    `;

    const logoutButton = container.querySelector("[data-auth-logout]");
    logoutButton.addEventListener("click", async () => {
      logoutButton.disabled = true;
      logoutButton.textContent = "Logging out...";

      try {
        const nextSession = await logout(session.csrfToken);
        onSessionChange(nextSession);
      } catch (error) {
        logoutButton.disabled = false;
        logoutButton.textContent = "Log Out";
        window.alert(error instanceof Error ? error.message : "Unable to log out.");
      }
    });
    return;
  }

  mountInlineAuthForm(container, session, onSessionChange);
}

function setupIndexPage(catalog, session) {
  const state = { search: "", category: "All" };
  const searchInput = document.getElementById("search-input");
  const categoryFilters = document.getElementById("category-filters");
  const gameGrid = document.getElementById("game-grid");
  const resultsSummary = document.getElementById("results-summary");
  const liveCount = document.getElementById("live-count");
  const reviewCount = document.getElementById("review-count");
  const accountPanel = document.getElementById("account-panel");
  const games = catalog.games;
  const categories = ["All", ...new Set(games.map((game) => game.category))];
  const liveGames = games.filter((game) => game.status === "live").length;
  const heldGames = games.length - liveGames;
  let sessionState = session;

  liveCount.textContent = String(liveGames);
  reviewCount.textContent = String(heldGames);

  function rerenderAccount(nextSession) {
    sessionState = nextSession;
    renderAccountPanel(accountPanel, sessionState, rerenderAccount);
    renderGrid();
  }

  function renderFilters() {
    categoryFilters.innerHTML = categories
      .map((category) => {
        const activeClass = category === state.category ? " is-active" : "";
        return `<button type="button" class="filter-chip${activeClass}" data-category="${escapeHtml(category)}">${escapeHtml(category)}</button>`;
      })
      .join("");

    categoryFilters.querySelectorAll("[data-category]").forEach((button) => {
      button.addEventListener("click", () => {
        state.category = button.getAttribute("data-category") || "All";
        renderFilters();
        renderGrid();
      });
    });
  }

  function renderGrid() {
    const normalizedSearch = state.search.trim().toLowerCase();
    const visibleGames = games.filter((game) => {
      const matchesCategory = state.category === "All" || game.category === state.category;
      const haystack = `${game.name} ${game.hint} ${game.category}`.toLowerCase();
      const matchesSearch = !normalizedSearch || haystack.includes(normalizedSearch);
      return matchesCategory && matchesSearch;
    });

    resultsSummary.textContent = `${visibleGames.length} game${visibleGames.length === 1 ? "" : "s"} shown`;

    gameGrid.innerHTML = visibleGames
      .map((game) => {
        const previewUrl = `previews/${encodeURIComponent(game.preview)}`;
        const statusChip = game.status === "live"
          ? '<span class="chip chip-live">Playable Now</span>'
          : '<span class="chip chip-review">Under Review</span>';
        const cloudChip = sessionState.authenticated && game.status === "live"
          ? '<span class="chip chip-category">Cloud Save Ready</span>'
          : "";
        const actionMarkup = game.status === "live"
          ? `<a class="btn btn-primary" href="${escapeHtml(game.launchUrl)}">Play Now</a>`
          : '<span class="btn btn-disabled">Audit Pending</span>';

        return `
          <article class="game-card">
            <img class="card-preview" src="${previewUrl}" alt="${escapeHtml(game.name)} preview" loading="lazy">
            <div class="card-body">
              <div class="card-top">
                <div><h3>${escapeHtml(game.name)}</h3></div>
                ${statusChip}
              </div>
              <div class="chip-row">
                <span class="chip chip-category">${escapeHtml(game.category)}</span>
                ${cloudChip}
              </div>
              <p class="card-hint">${escapeHtml(game.hint)}</p>
              <p class="card-note">${escapeHtml(game.auditNote)}</p>
              <div class="card-actions">${actionMarkup}</div>
            </div>
          </article>
        `;
      })
      .join("");

    if (!visibleGames.length) {
      gameGrid.innerHTML = `
        <article class="game-card">
          <div class="card-body">
            <h3>No matches found</h3>
            <p class="card-note">Try another search term or switch back to the All filter.</p>
          </div>
        </article>
      `;
    }
  }

  searchInput.addEventListener("input", (event) => {
    state.search = event.target.value;
    renderGrid();
  });

  renderAccountPanel(accountPanel, sessionState, rerenderAccount);
  renderFilters();
  renderGrid();
}

function setupPlayPage(catalog, session) {
  const params = new URLSearchParams(window.location.search);
  const gameId = params.get("id");
  const titleElement = document.getElementById("play-title");
  const hintElement = document.getElementById("play-hint");
  const statusElement = document.getElementById("play-status");
  const savePanel = document.getElementById("save-panel");
  const accountPanel = document.getElementById("account-panel");
  const frameElement = document.getElementById("game-frame");
  const directOpenElement = document.getElementById("direct-open");
  const game = catalog.games.find((entry) => entry.id === gameId);
  let sessionState = session;
  const issue = game ? knownCompatibilityIssues[game.id] : null;

  function reloadFrame() {
    if (frameElement && frameElement.src) {
      frameElement.src = frameElement.src;
    }
  }

  function updateSavePanel() {
    if (!savePanel) {
      return;
    }

    if (sessionState.authenticated && sessionState.user) {
      savePanel.innerHTML = `
        <div class="account-shell">
          <div>
            <p>Cloud saves are active for <strong>${escapeHtml(sessionState.user.username)}</strong>. This game's local save data is restored before boot and synced back to MySQL while you play.</p>
            <p class="panel-note">If the title opens in the middle of a run, that is usually an old save being restored rather than a loader bug.</p>
          </div>
          <div class="account-actions">
            <button type="button" class="btn btn-secondary" data-clear-cloud-save>Reset This Game Save</button>
            <button type="button" class="btn btn-secondary" data-reload-game>Reload Game</button>
          </div>
        </div>
      `;

      const clearButton = savePanel.querySelector("[data-clear-cloud-save]");
      const reloadButton = savePanel.querySelector("[data-reload-game]");

      reloadButton.addEventListener("click", () => {
        reloadFrame();
      });

      clearButton.addEventListener("click", async () => {
        if (!window.confirm("Clear the saved progress for this account on this game and reload it from the beginning?")) {
          return;
        }

        const originalLabel = clearButton.textContent;
        clearButton.disabled = true;
        clearButton.textContent = "Resetting...";

        try {
          await clearGameSave(sessionState.csrfToken, gameId);
          reloadFrame();
          window.alert("The cloud save for this game was cleared. The game is reloading from a clean slot.");
        } catch (error) {
          window.alert(error instanceof Error ? error.message : "Unable to clear the cloud save.");
        } finally {
          clearButton.disabled = false;
          clearButton.textContent = originalLabel;
        }
      });
    } else {
      savePanel.innerHTML = `
        <div class="account-shell">
          <div>
            <p>Guest mode is active. The game can still save locally in this browser, but sign in if you want a separate cloud-backed save slot per user.</p>
            <p class="panel-note">If a guest title opens in the middle of a run, clear the local browser save and reload it from scratch.</p>
          </div>
          <div class="account-actions">
            <button type="button" class="btn btn-secondary" data-clear-guest-save>Reset Local Browser Save</button>
            <button type="button" class="btn btn-secondary" data-reload-game>Reload Game</button>
          </div>
        </div>
      `;

      const clearButton = savePanel.querySelector("[data-clear-guest-save]");
      const reloadButton = savePanel.querySelector("[data-reload-game]");

      reloadButton.addEventListener("click", () => {
        reloadFrame();
      });

      clearButton.addEventListener("click", () => {
        if (!window.confirm("Clear local browser storage for this title and reload it from the beginning?")) {
          return;
        }

        const cleared = clearGuestFrameStorage(frameElement);
        reloadFrame();
        window.alert(
          cleared
            ? "Local browser save data was cleared and the game is reloading."
            : "The game was reloaded, but local browser storage could not be cleared from this page."
        );
      });
    }
  }

  function rerenderAccount(nextSession) {
    sessionState = nextSession;
    renderAccountPanel(accountPanel, sessionState, rerenderAccount);
    updateSavePanel();
    if (frameElement && frameElement.src) {
      frameElement.src = frameElement.src;
    }
  }

  if (!game) {
    titleElement.textContent = "Game not found";
    hintElement.textContent = "The requested title is not in the current HTML5 catalog.";
    statusElement.innerHTML = "<p>This game ID does not exist in the imported collection.</p>";
    if (savePanel) {
      savePanel.innerHTML = "<p>No save slot is available because the selected title does not exist.</p>";
    }
    frameElement.remove();
    directOpenElement.classList.add("btn-disabled");
    directOpenElement.removeAttribute("href");
    directOpenElement.removeAttribute("target");
    renderAccountPanel(accountPanel, sessionState, rerenderAccount);
    return;
  }

  document.title = `${game.name} | Webarcade`;
  titleElement.textContent = game.name;
  hintElement.textContent = game.hint;

  renderAccountPanel(accountPanel, sessionState, rerenderAccount);
  updateSavePanel();

  if (game.status !== "live") {
    statusElement.innerHTML = `<p>${escapeHtml(game.auditNote)}</p>`;
    frameElement.remove();
    directOpenElement.classList.add("btn-disabled");
    directOpenElement.removeAttribute("href");
    directOpenElement.removeAttribute("target");
    return;
  }

  const launchPath = `game/${encodeURIComponent(game.id)}/`;
  statusElement.innerHTML = `
    <p>${escapeHtml(game.auditNote)}</p>
    ${issue ? `<p><strong>${escapeHtml(issue.title)}:</strong> ${escapeHtml(issue.message)}</p>` : ""}
  `;
  frameElement.src = launchPath;
  directOpenElement.href = launchPath;
}

function mountStandaloneAuthForm(container, mode, onSessionChange) {
  const isRegister = mode === "register";
  container.innerHTML = `
    <div class="library-head">
      <h2>${isRegister ? "Create Your Account" : "Sign In to Your Account"}</h2>
      <p>${isRegister ? "Create a local user for this Laragon site." : "Use your existing Webarcade account."}</p>
    </div>
    <div class="auth-shell">
      <form class="auth-form auth-form-wide" data-auth-form>
        <input class="auth-input" name="username" type="text" minlength="3" maxlength="32" placeholder="Username" required>
        <input class="auth-input" name="password" type="password" minlength="6" maxlength="128" placeholder="Password" required>
        <div class="account-actions">
          <button type="submit" class="btn btn-primary">${isRegister ? "Create Account" : "Sign In"}</button>
          <a class="btn btn-secondary" href="${isRegister ? "login.html" : "register.html"}">${isRegister ? "Already Have an Account?" : "Need to Register?"}</a>
        </div>
        <p class="auth-feedback" data-auth-feedback></p>
      </form>
    </div>
  `;

  const form = container.querySelector("[data-auth-form]");
  const feedback = container.querySelector("[data-auth-feedback]");

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    const username = form.elements.username.value.trim();
    const password = form.elements.password.value;
    feedback.textContent = isRegister ? "Creating account..." : "Signing in...";

    try {
      const nextSession = await submitAuth(isRegister ? "register" : "login", username, password);
      feedback.textContent = isRegister ? "Account created. Redirecting..." : "Signed in. Redirecting...";
      onSessionChange(nextSession);
      window.setTimeout(() => {
        window.location.href = "account.html";
      }, 350);
    } catch (error) {
      feedback.textContent = error instanceof Error ? error.message : "Authentication failed.";
    }
  });
}

function setupStandaloneAuthPage(session) {
  const container = document.getElementById("auth-page");
  if (!container) {
    return;
  }

  let sessionState = session;
  const mode = container.dataset.authMode === "register" ? "register" : "login";

  function rerender(nextSession) {
    sessionState = nextSession;
    render();
  }

  function render() {
    if (sessionState.authenticated && sessionState.user) {
      container.innerHTML = `
        <div class="library-head">
          <h2>You are already signed in</h2>
          <p>${escapeHtml(sessionState.user.username)} is active in this browser.</p>
        </div>
        <div class="auth-shell">
          <div class="notice-card">
            <p class="account-copy">
              Open the account center to change your password or export your save data. You can also return to the library and start playing immediately.
            </p>
            <div class="account-actions">
              <a class="btn btn-primary" href="account.html">Open Account Center</a>
              <a class="btn btn-secondary" href="index.html">Back to HTML5 Games</a>
              <button type="button" class="btn btn-secondary" data-auth-logout>Log Out</button>
            </div>
          </div>
        </div>
      `;

      const logoutButton = container.querySelector("[data-auth-logout]");
      logoutButton.addEventListener("click", async () => {
        logoutButton.disabled = true;
        logoutButton.textContent = "Logging out...";

        try {
          const nextSession = await logout(sessionState.csrfToken);
          rerender(nextSession);
        } catch (error) {
          logoutButton.disabled = false;
          logoutButton.textContent = "Log Out";
          window.alert(error instanceof Error ? error.message : "Unable to log out.");
        }
      });
      return;
    }

    mountStandaloneAuthForm(container, mode, rerender);
  }

  render();
}

function renderSaveTable(saves) {
  if (!Array.isArray(saves) || !saves.length) {
    return `
      <div class="empty-state">
        <h3>No cloud saves yet</h3>
        <p class="card-note">Open a game while signed in and let it write browser save data first. Your save slots will appear here afterward.</p>
      </div>
    `;
  }

  return `
    <div class="table-shell">
      <div class="table-scroll">
        <table class="data-table">
          <thead>
            <tr>
              <th>Game</th>
              <th>Game ID</th>
              <th>Category</th>
              <th>Revision</th>
              <th>Updated</th>
              <th>Saved Keys</th>
            </tr>
          </thead>
          <tbody>
            ${saves.map((save) => `
              <tr>
                <td>${escapeHtml(save.gameName)}</td>
                <td><code>${escapeHtml(save.gameId)}</code></td>
                <td>${escapeHtml(save.category || "-")}</td>
                <td>${escapeHtml(save.revision)}</td>
                <td>${escapeHtml(save.updatedAt || "-")}</td>
                <td>${escapeHtml(save.savedKeys)}</td>
              </tr>
            `).join("")}
          </tbody>
        </table>
      </div>
    </div>
  `;
}

async function setupAccountPage(session) {
  const container = document.getElementById("account-dashboard");
  if (!container) {
    return;
  }

  let sessionState = session;

  async function render() {
    if (!sessionState.authenticated || !sessionState.user) {
      container.innerHTML = `
        <div class="library-head">
          <h2>Sign In Required</h2>
          <p>You need a Webarcade account before you can manage passwords or export save data.</p>
        </div>
      `;
      mountStandaloneAuthForm(container, "login", (nextSession) => {
        sessionState = nextSession;
        render();
      });
      return;
    }

    container.innerHTML = `
      <div class="library-head">
        <h2>Loading Account Data</h2>
        <p>Please wait while your save slots are loaded.</p>
      </div>
    `;

    let accountData;
    try {
      accountData = await loadAccountDetails();
    } catch (error) {
      const message = error instanceof Error ? error.message : "Unable to load the account page.";
      container.innerHTML = `
        <div class="library-head">
          <h2>Account Error</h2>
          <p>${escapeHtml(message)}</p>
        </div>
      `;
      return;
    }

    container.innerHTML = `
      <div class="library-head">
        <h2>Welcome, ${escapeHtml(sessionState.user.username)}</h2>
        <p>Your save slots are isolated per game and can be exported as a JSON backup at any time.</p>
      </div>
      <div class="dashboard-grid">
        <section class="dashboard-card">
          <p class="metric-label">Account</p>
          <strong class="account-name">${escapeHtml(sessionState.user.username)}</strong>
          <p class="account-copy">Current browser session is linked to your cloud-save slot on this Laragon site.</p>
          <ul class="info-list">
            <li><span>Cloud saves</span><strong>${escapeHtml(accountData.saveCount)}</strong></li>
            <li><span>Export format</span><strong>JSON</strong></li>
            <li><span>Scope</span><strong>Per user, per game</strong></li>
          </ul>
          <div class="account-actions">
            <a class="btn btn-primary" href="${escapeHtml(accountData.exportUrl || "api/account.php?export=1")}">Download My Saves JSON</a>
            <button type="button" class="btn btn-secondary" data-auth-logout>Log Out</button>
          </div>
        </section>

        <section class="dashboard-card">
          <p class="metric-label">Change Password</p>
          <strong class="account-name">Security</strong>
          <p class="account-copy">Use a new password to protect this local account. Your cloud saves stay attached to the same username.</p>
          <form class="auth-form auth-form-wide" data-password-form>
            <input class="auth-input" name="currentPassword" type="password" minlength="6" maxlength="128" placeholder="Current password" required>
            <input class="auth-input" name="newPassword" type="password" minlength="6" maxlength="128" placeholder="New password" required>
            <div class="account-actions">
              <button type="submit" class="btn btn-primary">Update Password</button>
              <a class="btn btn-secondary" href="index.html">Back to Library</a>
            </div>
            <p class="auth-feedback" data-password-feedback></p>
          </form>
        </section>
      </div>

      <section class="dashboard-card">
        <div class="library-head">
          <h2>Cloud Save Slots</h2>
          <p>These are the save entries currently stored for your account.</p>
        </div>
        ${renderSaveTable(accountData.saves)}
      </section>
    `;

    const logoutButton = container.querySelector("[data-auth-logout]");
    logoutButton.addEventListener("click", async () => {
      logoutButton.disabled = true;
      logoutButton.textContent = "Logging out...";

      try {
        sessionState = await logout(accountData.csrfToken || sessionState.csrfToken);
        render();
      } catch (error) {
        logoutButton.disabled = false;
        logoutButton.textContent = "Log Out";
        window.alert(error instanceof Error ? error.message : "Unable to log out.");
      }
    });

    const passwordForm = container.querySelector("[data-password-form]");
    const passwordFeedback = container.querySelector("[data-password-feedback]");

    passwordForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const currentPassword = passwordForm.elements.currentPassword.value;
      const newPassword = passwordForm.elements.newPassword.value;
      passwordFeedback.textContent = "Updating password...";

      try {
        const nextSession = await changePassword(accountData.csrfToken || sessionState.csrfToken, currentPassword, newPassword);
        sessionState = nextSession;
        passwordForm.reset();
        passwordFeedback.textContent = nextSession.message || "Password updated successfully.";
      } catch (error) {
        passwordFeedback.textContent = error instanceof Error ? error.message : "Unable to update password.";
      }
    });
  }

  await render();
}

async function main() {
  try {
    const needsCatalog = Boolean(document.getElementById("game-grid") || document.getElementById("game-frame"));
    const [session, catalog] = await Promise.all([
      loadSession(),
      needsCatalog ? loadCatalog() : Promise.resolve(null)
    ]);

    if (catalog && document.getElementById("game-grid")) {
      setupIndexPage(catalog, session);
    }

    if (catalog && document.getElementById("game-frame")) {
      setupPlayPage(catalog, session);
    }

    if (document.getElementById("auth-page")) {
      setupStandaloneAuthPage(session);
    }

    if (document.getElementById("account-dashboard")) {
      await setupAccountPage(session);
    }
  } catch (error) {
    const summary = document.getElementById("results-summary");
    const playStatus = document.getElementById("play-status");
    const savePanel = document.getElementById("save-panel");
    const authPage = document.getElementById("auth-page");
    const accountDashboard = document.getElementById("account-dashboard");
    const message = error instanceof Error ? error.message : "Unknown error";

    if (summary) {
      summary.textContent = message;
    }

    if (playStatus) {
      playStatus.innerHTML = `<p>${escapeHtml(message)}</p>`;
    }

    if (savePanel) {
      savePanel.innerHTML = `<p>${escapeHtml(message)}</p>`;
    }

    if (authPage) {
      authPage.innerHTML = `
        <div class="library-head">
          <h2>Authentication Error</h2>
          <p>${escapeHtml(message)}</p>
        </div>
      `;
    }

    if (accountDashboard) {
      accountDashboard.innerHTML = `
        <div class="library-head">
          <h2>Account Error</h2>
          <p>${escapeHtml(message)}</p>
        </div>
      `;
    }
  }
}

main();
