<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

try {
    if (is_post()) {
        if (!csrf_verify($_POST['csrf_token'] ?? null)) {
            http400(['E_BAD_REQUEST']);
        }

        $id_raw = (string)($_POST['id'] ?? '');
        if (!ctype_digit($id_raw)) http404();
        $id = (int)$id_raw;

        $current = logs_find_by_id($id);
        if ($current === null) http404();

        $language = trim((string)($_POST['language'] ?? ''));
        $level = trim((string)($_POST['level'] ?? ''));
        $title = trim((string)($_POST['title'] ?? ''));
        $message = trim((string)($_POST['message'] ?? ''));
        $solution = trim((string)($_POST['solution'] ?? ''));
        $is_resolved = isset($_POST['is_resolved']) ? 1 : 0;
        $is_knowledge = isset($_POST['is_knowledge']) ? 1 : 0;

        if ($title === '' || $message === '') {
            http_response_code(400);
            render('detail', [
                'errors' => ['E_BAD_REQUEST'],
                'log' => array_merge($current, [
                    'language' => $language,
                    'level' => $level,
                    'title' => $title,
                    'message' => $message,
                    'solution' => $solution,
                    'is_resolved' => $is_resolved,
                    'is_knowledge' => $is_knowledge,
                ]),
                'mode' => 'edit',
            ]);
            exit;
        }

        logs_update($id, [
            'language' => $language,
            'level' => $level,
            'title' => $title,
            'message' => $message,
            'solution' => ($solution === '' ? null : $solution),
            'is_resolved' => $is_resolved,
            'is_knowledge' => $is_knowledge,
        ]);

        redirect("/detail.php?id={$id}"); // PRG
    }

    // GET
    $id_raw = (string)($_GET['id'] ?? '');
    if (!ctype_digit($id_raw)) http404();
    $id = (int)$id_raw;

    $log = logs_find_by_id($id);
    if ($log === null) http404();

    render('detail', ['log' => $log, 'mode' => 'view']);

} catch (Throwable $e) {
    http_response_code(500);
    render('index', ['errors' => ['E_SYSTEM'], 'logs' => []]);
}