<?php
declare(strict_types=1);

function h(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function redirect(string $url): void
{
    header("Location: {$url}");
    exit;
}

function http400(array $errors = ['E_BAD_REQUEST']): void
{
    http_response_code(400);
    render('index', ['errors' => $errors]); // 最小は index に出す（後で共通化OK）
    exit;
}

function http404(): void
{
    http_response_code(404);
    render('not_found', ['errors' => ['E_NOT_FOUND']]);
    exit;
}

function render(string $view, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    require __DIR__ . "/../components/header.php";
    require __DIR__ . "/../components/messages.php";
    require __DIR__ . "/../../views/{$view}.php";
    require __DIR__ . "/../components/footer.php";
}