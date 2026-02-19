<?php
declare(strict_types=1);

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
            $logs = logs_find(10, 0);
            render('index', [
                'errors' => $errors,
                'logs'   => $logs,
                'old'    => $input,   // ← $_POSTじゃなくinput推奨
            ]);
            exit;
        }

        $new_id = logs_insert($input);
        flash_set('success', "created id={$new_id}");
        redirect('./index.php');
    }

    $logs = logs_find(10, 0);
    render('index', ['logs' => $logs]);

} catch (Throwable $e) {
    http_response_code(500);
    render('index', ['errors' => ['E_SYSTEM'], 'logs' => []]);
}
