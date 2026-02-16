<?php

declare(strict_types=1);

//bootstrapを読み込む
require __DIR__ . '/../src/bootstrap.php';

try {
    if (is_post()) {
        if (!csrf_verify($_POST['csrf_token'] ?? null)) {
            http400(['E_BAD_REQUEST']);
        }

        $occurred_at = trim((string)($_POST['occurred_at'] ?? ''));
        $language = trim((string)($_POST['language'] ?? ''));
        $level = trim((string)($_POST['level'] ?? ''));
        $title = trim((string)($_POST['title'] ?? ''));
        $message = trim((string)($_POST['message'] ?? ''));
        $solution = trim((string)($_POST['solution'] ?? ''));
        $is_resolved = isset($_POST['is_resolved']) ? 1 : 0;
        $is_knowledge = isset($_POST['is_knowledge']) ? 1 : 0;

        $errors = [];
        if ($occurred_at === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $occurred_at)) $errors[] = 'E_BAD_REQUEST';
        if ($title === '') $errors[] = 'E_BAD_REQUEST';
        if ($message === '') $errors[] = 'E_BAD_REQUEST';

        if (!empty($errors)) {
            http_response_code(400);
            $logs = logs_find(10, 0);
            render('index', [
                'errors' => ['E_BAD_REQUEST'],
                'logs' => $logs,
                'old' => $_POST,
            ]);
            exit;
        }

        $new_id = logs_insert([
            'occurred_at' => $occurred_at,
            'language' => $language,
            'level' => $level,
            'title' => $title,
            'message' => $message,
            'solution' => ($solution === '' ? null : $solution),
            'is_resolved' => $is_resolved,
            'is_knowledge' => $is_knowledge,
        ]);

        flash_set('success', "created id={$new_id}");
        redirect('./index.php'); // PRG
    }

    
    $logs = logs_find(10, 0);
    render('index', ['logs' => $logs]);

} catch (Throwable $e) {
    http_response_code(500);
    render('index', ['errors' => ['E_SYSTEM'], 'logs' => []]);
}