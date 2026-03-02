<?php
declare(strict_types=1);

/**
 * public/index.php
 * - POST: 新規登録（既存仕様維持、CSRF/validation/flash/PRG）
 * - GET : 検索 + 10件ページング（language/level/status）
 */

require __DIR__ . '/src/bootstrap.php';

try {
    if (is_post()) {
        if (!csrf_verify($_POST['csrf_token'] ?? null)) {
            http400(['E_BAD_REQUEST']);
        }

        $input  = log_input_from_post($_POST);
        $errors = validate_log_create($input);

        if (!empty($errors)) {
            http_response_code(400);

            // GET検索条件 + 一覧も一緒に返す（画面が崩れない）
            $limit = 10;

            $page_raw = (string)($_GET['page'] ?? '1');
            $page = (ctype_digit($page_raw) && (int)$page_raw >= 1) ? (int)$page_raw : 1;
            $offset = ($page - 1) * $limit;

            $cond = [
                'language' => (string)($_GET['language'] ?? ''),
                'level'    => (string)($_GET['level'] ?? ''),
                'status'   => (string)($_GET['status'] ?? ''),
            ];

            $total = logs_search_count($cond);
            $logs  = logs_search($cond, $limit, $offset);
            $total_pages = max(1, (int)ceil($total / $limit));

            render('index', [
                'errors'      => $errors,
                'old'         => $input,  // POST入力復元（New Log）
                'logs'        => $logs,
                'cond'        => $cond,   // GET入力復元（Filters）
                'page'        => $page,
                'total'       => $total,
                'total_pages' => $total_pages,
            ]);
            exit;
        }

        $new_id = logs_insert($input);
        flash_set('success', "created id={$new_id}");
        redirect('./index.php');
    }

    // ===== GET（検索 + 10件ページング）=====
    $limit = 10;

    $page_raw = (string)($_GET['page'] ?? '1');
    $page = (ctype_digit($page_raw) && (int)$page_raw >= 1) ? (int)$page_raw : 1;
    $offset = ($page - 1) * $limit;

    $cond = [
        'language' => (string)($_GET['language'] ?? ''),
        'level'    => (string)($_GET['level'] ?? ''),
        'status'   => (string)($_GET['status'] ?? ''),
    ];

    $total = logs_search_count($cond);
    $logs  = logs_search($cond, $limit, $offset);
    $total_pages = max(1, (int)ceil($total / $limit));

    render('index', [
        'logs'        => $logs,
        'cond'        => $cond,
        'page'        => $page,
        'total'       => $total,
        'total_pages' => $total_pages,
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    render('index', ['errors' => ['E_SYSTEM'], 'logs' => []]);
}