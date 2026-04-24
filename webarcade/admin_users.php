<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$pdo = webarcade_pdo();

function webarcade_admin_is_logged_in(): bool
{
    return !empty($_SESSION['webarcade_admin_logged_in']);
}

function webarcade_admin_flash_set(string $type, string $message): void
{
    $_SESSION['webarcade_admin_flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function webarcade_admin_flash_pull(): ?array
{
    if (empty($_SESSION['webarcade_admin_flash']) || !is_array($_SESSION['webarcade_admin_flash'])) {
        return null;
    }

    $flash = $_SESSION['webarcade_admin_flash'];
    unset($_SESSION['webarcade_admin_flash']);
    return $flash;
}

function webarcade_admin_redirect(): never
{
    header('Location: admin_users.php');
    exit;
}

function webarcade_admin_render_login(?string $error = null): never
{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Webarcade Admin Login</title>
      <style>
        :root {
          color-scheme: light;
          --bg: #f4efe7;
          --panel: rgba(255, 255, 255, 0.92);
          --ink: #1f1c19;
          --muted: #5e564e;
          --line: rgba(31, 28, 25, 0.12);
          --accent: #d7572a;
          --accent-2: #1f7a5c;
          --shadow: 0 22px 60px rgba(46, 30, 18, 0.16);
        }
        * { box-sizing: border-box; }
        body {
          margin: 0;
          min-height: 100vh;
          display: grid;
          place-items: center;
          padding: 1.2rem;
          font-family: "Segoe UI", Tahoma, sans-serif;
          color: var(--ink);
          background:
            radial-gradient(circle at top left, rgba(215, 87, 42, 0.2), transparent 30%),
            radial-gradient(circle at bottom right, rgba(31, 122, 92, 0.15), transparent 28%),
            linear-gradient(180deg, #f8f4ee 0%, #efe2cf 100%);
        }
        .panel {
          width: min(100%, 430px);
          padding: 2rem;
          border-radius: 28px;
          background: var(--panel);
          border: 1px solid var(--line);
          box-shadow: var(--shadow);
        }
        h1 {
          margin: 0 0 0.65rem;
          font-size: 2rem;
          line-height: 1.05;
        }
        p {
          margin: 0 0 1rem;
          color: var(--muted);
        }
        label {
          display: block;
          margin-bottom: 0.9rem;
          font-weight: 700;
        }
        input {
          width: 100%;
          margin-top: 0.45rem;
          padding: 0.9rem 1rem;
          border-radius: 14px;
          border: 1px solid rgba(31, 28, 25, 0.14);
          font: inherit;
        }
        button, a {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          min-height: 46px;
          padding: 0.8rem 1.1rem;
          border-radius: 999px;
          border: 0;
          text-decoration: none;
          font-weight: 800;
          cursor: pointer;
        }
        button {
          width: 100%;
          color: #fff;
          background: linear-gradient(135deg, var(--accent), #f28d3c);
          box-shadow: 0 12px 28px rgba(215, 87, 42, 0.28);
        }
        .error {
          margin-bottom: 1rem;
          padding: 0.9rem 1rem;
          border-radius: 14px;
          background: rgba(200, 68, 68, 0.1);
          color: #9a2a2a;
          border: 1px solid rgba(200, 68, 68, 0.18);
        }
        .links {
          display: flex;
          gap: 0.75rem;
          margin-top: 1rem;
        }
        .links a {
          color: #fff;
          background: linear-gradient(135deg, #1f7a5c, #2e9f79);
          flex: 1;
        }
      </style>
    </head>
    <body>
      <main class="panel">
        <p>Webarcade</p>
        <h1>Admin Users</h1>
        <p>Sign in with the local admin credential from the main Laragon configuration.</p>
        <?php if ($error !== null): ?>
          <div class="error"><?= webarcade_html($error) ?></div>
        <?php endif; ?>
        <form method="post">
          <input type="hidden" name="action" value="login">
          <label>
            Username
            <input type="text" name="username" required autocomplete="username">
          </label>
          <label>
            Password
            <input type="password" name="password" required autocomplete="current-password">
          </label>
          <button type="submit">Sign In</button>
        </form>
        <div class="links">
          <a href="index.html">HTML5 Library</a>
          <a href="/">Main Library</a>
        </div>
      </main>
    </body>
    </html>
    <?php
    exit;
}

$loginError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) && is_string($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'login') {
        global $admin_user, $admin_pass;
        $candidateUser = isset($_POST['username']) && is_string($_POST['username']) ? trim($_POST['username']) : '';
        $candidatePass = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';

        if ($candidateUser === $admin_user && $candidatePass === $admin_pass) {
            $_SESSION['webarcade_admin_logged_in'] = true;
            session_regenerate_id(true);
            webarcade_admin_flash_set('success', 'Signed in to the Webarcade admin panel.');
            webarcade_admin_redirect();
        }

        $loginError = 'Incorrect admin username or password.';
    } elseif (webarcade_admin_is_logged_in()) {
        webarcade_validate_csrf();

        if ($action === 'logout') {
            unset($_SESSION['webarcade_admin_logged_in']);
            session_regenerate_id(true);
            webarcade_admin_redirect();
        }

        if ($action === 'delete_user') {
            $userId = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
            if ($userId > 0) {
                $statement = $pdo->prepare('DELETE FROM webarcade_users WHERE id = :id');
                $statement->execute(['id' => $userId]);
                webarcade_admin_flash_set('success', 'User account and all linked saves were deleted.');
            } else {
                webarcade_admin_flash_set('error', 'Invalid user id.');
            }
            webarcade_admin_redirect();
        }

        if ($action === 'delete_save') {
            $saveId = isset($_POST['save_id']) ? (int) $_POST['save_id'] : 0;
            if ($saveId > 0) {
                $statement = $pdo->prepare('DELETE FROM webarcade_cloud_saves WHERE id = :id');
                $statement->execute(['id' => $saveId]);
                webarcade_admin_flash_set('success', 'Save slot deleted.');
            } else {
                webarcade_admin_flash_set('error', 'Invalid save id.');
            }
            webarcade_admin_redirect();
        }

        if ($action === 'export_user') {
            $userId = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
            $query = $pdo->prepare(
                'SELECT id, username
                 FROM webarcade_users
                 WHERE id = :id
                 LIMIT 1'
            );
            $query->execute(['id' => $userId]);
            $userRow = $query->fetch();

            if (!$userRow) {
                webarcade_admin_flash_set('error', 'The requested user was not found.');
                webarcade_admin_redirect();
            }

            $payload = webarcade_build_user_export_payload($pdo, (int) $userRow['id'], (string) $userRow['username']);
            webarcade_send_json_download($payload, 'webarcade-admin-export-' . $userRow['username'] . '.json');
        }

        webarcade_admin_flash_set('error', 'Unknown admin action.');
        webarcade_admin_redirect();
    }
}

if (!webarcade_admin_is_logged_in()) {
    webarcade_admin_render_login($loginError);
}

$flash = webarcade_admin_flash_pull();
$csrfToken = webarcade_csrf_token();
$gamesIndex = webarcade_games_index();

$stats = $pdo->query(
    'SELECT
        (SELECT COUNT(*) FROM webarcade_users) AS total_users,
        (SELECT COUNT(*) FROM webarcade_cloud_saves) AS total_saves,
        (SELECT MAX(updated_at) FROM webarcade_cloud_saves) AS latest_save_at'
)->fetch();

$userRows = $pdo->query(
    'SELECT
        u.id,
        u.username,
        u.created_at,
        u.updated_at,
        COUNT(s.id) AS save_count,
        MAX(s.updated_at) AS last_save_at
     FROM webarcade_users u
     LEFT JOIN webarcade_cloud_saves s ON s.user_id = u.id
     GROUP BY u.id, u.username, u.created_at, u.updated_at
     ORDER BY u.created_at DESC, u.id DESC'
)->fetchAll();

$saveRows = $pdo->query(
    'SELECT
        s.id,
        s.user_id,
        u.username,
        s.game_id,
        s.revision,
        s.updated_at,
        CHAR_LENGTH(s.storage_json) AS payload_bytes,
        s.storage_json
     FROM webarcade_cloud_saves s
     INNER JOIN webarcade_users u ON u.id = s.user_id
     ORDER BY s.updated_at DESC, s.id DESC
     LIMIT 400'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Webarcade Admin Users</title>
  <style>
    :root {
      --bg: #f4efe7;
      --panel: rgba(255, 255, 255, 0.92);
      --line: rgba(31, 28, 25, 0.12);
      --ink: #1f1c19;
      --muted: #5e564e;
      --accent: #d7572a;
      --accent-2: #1f7a5c;
      --accent-3: #154d8c;
      --danger: #b23535;
      --shadow: 0 20px 60px rgba(46, 30, 18, 0.15);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, sans-serif;
      color: var(--ink);
      background:
        radial-gradient(circle at top left, rgba(215, 87, 42, 0.2), transparent 32%),
        radial-gradient(circle at bottom right, rgba(21, 77, 140, 0.14), transparent 30%),
        linear-gradient(180deg, #f8f4ee 0%, #f0e4d3 100%);
    }
    .page {
      width: min(1380px, calc(100% - 1.4rem));
      margin: 0 auto;
      padding: 1.4rem 0 2rem;
    }
    .hero, .panel, .table-shell {
      background: var(--panel);
      border: 1px solid var(--line);
      border-radius: 28px;
      box-shadow: var(--shadow);
      backdrop-filter: blur(14px);
    }
    .hero, .panel, .table-shell {
      padding: 1.25rem;
    }
    .hero {
      display: grid;
      gap: 1rem;
      grid-template-columns: minmax(0, 1.5fr) minmax(260px, 0.9fr);
      align-items: start;
      margin-bottom: 1rem;
    }
    h1, h2 {
      margin: 0;
      line-height: 1.05;
    }
    h1 {
      font-size: clamp(2rem, 3vw, 3.2rem);
    }
    .hero p, .metric-label, .muted {
      color: var(--muted);
    }
    .hero-actions, .metric-grid, .toolbar, .inline-form {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
    }
    .metric-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 0.8rem;
    }
    .metric {
      padding: 1rem;
      border-radius: 18px;
      border: 1px solid rgba(31, 28, 25, 0.08);
      background: rgba(255, 255, 255, 0.84);
    }
    .metric strong {
      display: block;
      margin-top: 0.3rem;
      font-size: 1.2rem;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 42px;
      padding: 0.72rem 1rem;
      border-radius: 999px;
      border: 0;
      color: #fff;
      font-weight: 800;
      text-decoration: none;
      cursor: pointer;
    }
    .btn-primary { background: linear-gradient(135deg, var(--accent), #f28d3c); }
    .btn-secondary { background: linear-gradient(135deg, var(--accent-3), #3a7dc3); }
    .btn-success { background: linear-gradient(135deg, var(--accent-2), #2e9f79); }
    .btn-danger { background: linear-gradient(135deg, var(--danger), #d45d5d); }
    .flash {
      margin-bottom: 1rem;
      padding: 0.95rem 1rem;
      border-radius: 16px;
      border: 1px solid transparent;
    }
    .flash-success {
      background: rgba(31, 122, 92, 0.12);
      color: #155c46;
      border-color: rgba(31, 122, 92, 0.18);
    }
    .flash-error {
      background: rgba(178, 53, 53, 0.1);
      color: #8f2424;
      border-color: rgba(178, 53, 53, 0.18);
    }
    .layout {
      display: grid;
      gap: 1rem;
    }
    .table-shell {
      overflow: hidden;
    }
    .table-shell h2 {
      margin-bottom: 0.9rem;
    }
    .table-wrap {
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 860px;
    }
    th, td {
      padding: 0.8rem 0.72rem;
      text-align: left;
      border-top: 1px solid rgba(31, 28, 25, 0.08);
      vertical-align: top;
    }
    th {
      border-top: 0;
      color: var(--muted);
      font-size: 0.84rem;
      letter-spacing: 0.03em;
      text-transform: uppercase;
    }
    .tag {
      display: inline-flex;
      align-items: center;
      padding: 0.34rem 0.68rem;
      border-radius: 999px;
      background: rgba(21, 77, 140, 0.1);
      color: var(--accent-3);
      font-size: 0.78rem;
      font-weight: 800;
    }
    .inline-form {
      margin: 0;
    }
    .inline-form button {
      min-height: 34px;
      padding: 0.52rem 0.82rem;
      font-size: 0.86rem;
    }
    code {
      padding: 0.18rem 0.42rem;
      border-radius: 8px;
      background: rgba(31, 28, 25, 0.06);
    }
    @media (max-width: 960px) {
      .hero {
        grid-template-columns: 1fr;
      }
      .metric-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <main class="page">
    <?php if ($flash !== null): ?>
      <div class="flash <?= $flash['type'] === 'success' ? 'flash-success' : 'flash-error' ?>">
        <?= webarcade_html((string) ($flash['message'] ?? '')) ?>
      </div>
    <?php endif; ?>

    <section class="hero">
      <div>
        <p class="muted">Webarcade</p>
        <h1>User Admin</h1>
        <p>Review player accounts, inspect cloud-save activity, export one user to JSON, or remove broken data directly from the Laragon site.</p>
        <div class="hero-actions">
          <a class="btn btn-secondary" href="index.html">HTML5 Library</a>
          <a class="btn btn-success" href="account.html">Account Center</a>
          <a class="btn btn-primary" href="/">Main Library</a>
        </div>
      </div>

      <div class="panel">
        <div class="metric-grid">
          <div class="metric">
            <span class="metric-label">Accounts</span>
            <strong><?= (int) ($stats['total_users'] ?? 0) ?></strong>
          </div>
          <div class="metric">
            <span class="metric-label">Save Slots</span>
            <strong><?= (int) ($stats['total_saves'] ?? 0) ?></strong>
          </div>
          <div class="metric">
            <span class="metric-label">Latest Save</span>
            <strong><?= webarcade_html($stats['latest_save_at'] ?? 'No saves yet') ?></strong>
          </div>
        </div>
        <form method="post" style="margin-top: 1rem;">
          <input type="hidden" name="action" value="logout">
          <input type="hidden" name="csrfToken" value="<?= webarcade_html($csrfToken) ?>">
          <button class="btn btn-danger" type="submit">Log Out</button>
        </form>
      </div>
    </section>

    <section class="layout">
      <section class="table-shell">
        <h2>Accounts</h2>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Save Count</th>
                <th>Last Save</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!$userRows): ?>
                <tr>
                  <td colspan="7">No user accounts have been created yet.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($userRows as $userRow): ?>
                  <tr>
                    <td><code><?= (int) $userRow['id'] ?></code></td>
                    <td><?= webarcade_html((string) $userRow['username']) ?></td>
                    <td><?= webarcade_html((string) $userRow['created_at']) ?></td>
                    <td><?= webarcade_html((string) $userRow['updated_at']) ?></td>
                    <td><span class="tag"><?= (int) $userRow['save_count'] ?> saves</span></td>
                    <td><?= webarcade_html($userRow['last_save_at'] ?? 'No saves yet') ?></td>
                    <td>
                      <div class="toolbar">
                        <form method="post" class="inline-form">
                          <input type="hidden" name="action" value="export_user">
                          <input type="hidden" name="csrfToken" value="<?= webarcade_html($csrfToken) ?>">
                          <input type="hidden" name="user_id" value="<?= (int) $userRow['id'] ?>">
                          <button class="btn btn-success" type="submit">Export JSON</button>
                        </form>
                        <form method="post" class="inline-form" onsubmit="return confirm('Delete this user account and every linked save slot?');">
                          <input type="hidden" name="action" value="delete_user">
                          <input type="hidden" name="csrfToken" value="<?= webarcade_html($csrfToken) ?>">
                          <input type="hidden" name="user_id" value="<?= (int) $userRow['id'] ?>">
                          <button class="btn btn-danger" type="submit">Delete User</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>

      <section class="table-shell">
        <h2>Recent Save Slots</h2>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Save ID</th>
                <th>User</th>
                <th>Game</th>
                <th>Revision</th>
                <th>Updated</th>
                <th>Payload</th>
                <th>Keys</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!$saveRows): ?>
                <tr>
                  <td colspan="8">No cloud saves have been written yet.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($saveRows as $saveRow): ?>
                  <?php
                    $gameId = (string) $saveRow['game_id'];
                    $gameMeta = $gamesIndex[$gameId] ?? ['name' => 'Unknown game'];
                    $decoded = json_decode((string) $saveRow['storage_json'], true);
                    $savedKeys = is_array($decoded) ? count($decoded) : 0;
                  ?>
                  <tr>
                    <td><code><?= (int) $saveRow['id'] ?></code></td>
                    <td><?= webarcade_html((string) $saveRow['username']) ?></td>
                    <td>
                      <strong><?= webarcade_html((string) $gameMeta['name']) ?></strong><br>
                      <span class="muted"><?= webarcade_html($gameId) ?></span>
                    </td>
                    <td><?= (int) $saveRow['revision'] ?></td>
                    <td><?= webarcade_html((string) $saveRow['updated_at']) ?></td>
                    <td><?= (int) $saveRow['payload_bytes'] ?> bytes</td>
                    <td><?= $savedKeys ?></td>
                    <td>
                      <form method="post" class="inline-form" onsubmit="return confirm('Delete this save slot only?');">
                        <input type="hidden" name="action" value="delete_save">
                        <input type="hidden" name="csrfToken" value="<?= webarcade_html($csrfToken) ?>">
                        <input type="hidden" name="save_id" value="<?= (int) $saveRow['id'] ?>">
                        <button class="btn btn-danger" type="submit">Delete Save</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </section>
  </main>
</body>
</html>
