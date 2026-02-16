<?php
declare(strict_types=1);

function flash_set(string $key, string $value): void
{
    $_SESSION['_flash'][$key] = $value;
}

function flash_get_all(): array
{
    $data = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return is_array($data) ? $data : [];
}