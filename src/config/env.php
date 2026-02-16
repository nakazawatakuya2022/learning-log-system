<?php
declare(strict_types=1);

function load_env(string $path): array
{
    if (!is_file($path)) return [];

    $env = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || substr($line, 0, 1) === '#') continue;

        $pos = strpos($line, '=');
        if ($pos === false) continue;

        $key = trim(substr($line, 0, $pos));
        $val = trim(substr($line, $pos + 1));

        // クォート除去
        if (
            (substr($val, 0, 1) === '"' && substr($val, -1) === '"') ||
            (substr($val, 0, 1) === "'" && substr($val, -1) === "'")
        ) {
            $val = substr($val, 1, -1);
        }

        $env[$key] = $val;
        $_ENV[$key] = $val;
    }

    return $env;
}

function env(string $key, $default = null)
{
    return isset($_ENV[$key]) ? $_ENV[$key] : $default;
}