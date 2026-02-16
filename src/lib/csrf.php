<?php
declare(strict_types=1);

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return (string)$_SESSION['csrf_token'];
}

function csrf_verify(?string $token): bool
{
    if (!is_string($token) || $token === '') return false;
    return hash_equals((string)($_SESSION['csrf_token'] ?? ''), $token);
}