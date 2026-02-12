<?php
declare(strict_types=1);

/**
 * src/config/db.php
 * - プロジェクト直下の .env を読み込む
 * - PDO を生成して $pdo を提供する
 */

$project_root = dirname(__DIR__, 2);          // project-root/src/config -> project-root
$env_path     = $project_root . '/.env';

if (!file_exists($env_path)) {
    throw new RuntimeException('.env file not found: ' . $env_path);
}

/**
 * .env loader (minimal)
 * - KEY=VALUE
 * - 空行と # コメント行は無視
 * - VALUEの前後空白は除去
 */
$lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    $line = trim($line);

    if ($line === '' || str_starts_with($line, '#')) {
        continue;
    }

    // "KEY=VALUE" 以外は無視（壊れた行で落ちないように）
    if (!str_contains($line, '=')) {
        continue;
    }

    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);

    // 値が "..." や '...' で囲われていたら外す（任意）
    if (
        (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
        (str_starts_with($value, "'") && str_ends_with($value, "'"))
    ) {
        $value = substr($value, 1, -1);
    }

    $_ENV[$key] = $value;
}

$required_keys = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
foreach ($required_keys as $k) {
    if (!array_key_exists($k, $_ENV)) {
        throw new RuntimeException("Missing env key: {$k}");
    }
}

$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=%s',
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $charset
);

$pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
]);
