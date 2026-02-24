<?php
/**
 * Cookie-Based Session Helper for Serverless PHP (Vercel)
 * 
 * Vercel serverless PHP cannot persist file-based sessions between requests.
 * This helper stores session data in a signed cookie so it survives between
 * serverless invocations. Include this INSTEAD of calling session_start().
 */

// A secret key used to sign/verify the cookie (change this in production)
define('SESSION_SECRET', 'sk_skillsoft_2025_secure_key_x9q');
define('SESSION_COOKIE', 'ss_session');
define('SESSION_EXPIRE', 86400 * 7); // 7 days

/**
 * Initialize the custom session from the cookie.
 * Call this at the top of every page instead of session_start().
 */
function init_session() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        // If session_start() was somehow already called, just return
        return;
    }

    // Start a PHP session for in-memory use during this request
    session_start();

    // If $_SESSION is empty, try to restore from cookie
    if (empty($_SESSION['valid']) && isset($_COOKIE[SESSION_COOKIE])) {
        $data = read_session_cookie();
        if ($data) {
            foreach ($data as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }
    }
}

/**
 * Save session data to a signed cookie. Call this after setting session variables
 * (e.g., after login).
 */
function save_session() {
    $data = [
        'valid' => $_SESSION['valid'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'id' => $_SESSION['id'] ?? null,
    ];

    $payload = base64_encode(json_encode($data));
    $signature = hash_hmac('sha256', $payload, SESSION_SECRET);
    $cookie_value = $payload . '.' . $signature;

    setcookie(SESSION_COOKIE, $cookie_value, [
        'expires' => time() + SESSION_EXPIRE,
        'path' => '/',
        'httponly' => true,
        'secure' => true,
        'samesite' => 'Lax',
    ]);
}

/**
 * Read and verify the session cookie. Returns the decoded data or false.
 */
function read_session_cookie() {
    if (!isset($_COOKIE[SESSION_COOKIE])) {
        return false;
    }

    $parts = explode('.', $_COOKIE[SESSION_COOKIE]);
    if (count($parts) !== 2) {
        return false;
    }

    list($payload, $signature) = $parts;

    // Verify signature
    $expected = hash_hmac('sha256', $payload, SESSION_SECRET);
    if (!hash_equals($expected, $signature)) {
        return false; // Tampered cookie
    }

    $data = json_decode(base64_decode($payload), true);
    return $data ?: false;
}

/**
 * Destroy the session and clear the cookie. Call this on logout.
 */
function destroy_session() {
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    setcookie(SESSION_COOKIE, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'secure' => true,
        'samesite' => 'Lax',
    ]);
}
?>
