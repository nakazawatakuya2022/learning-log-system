<?php
declare(strict_types=1);

require __DIR__ . '/src/bootstrap.php';

try {
    if (is_post()) {
        // CSRF
        if (!csrf_verify($_POST['csrf_token'] ?? null)) {
            http400(['E_BAD_REQUEST']);
        }

        // id（POST）
        $id_raw = (string)($_POST['id'] ?? '');
        if (!ctype_digit($id_raw)) {
            http404();
        }
        $id = (int)$id_raw;

        // 現在データ
        $current = logs_find_by_id($id);
        if ($current === null) {
            http404();
        }

        // 入力の正規化 + バリデーション（更新用）
        $input  = log_input_from_post($_POST);
        $errors = validate_log_update($input);

        if (!empty($errors)) {
            http_response_code(400);

            // 画面に入力値を戻す（currentに上書きして表示）
            $log_for_view = array_merge($current, $input);

            render('detail', [
                'errors' => $errors,
                'log'    => $log_for_view,
                'mode'   => 'edit',
            ]);
            exit;
        }

        // UPDATE（occurred_at は更新対象にしない前提）
        logs_update($id, [
            'language'     => $input['language'],
            'level'        => $input['level'],
            'title'        => $input['title'],
            'message'      => $input['message'],
            'solution'     => $input['solution'],
            'is_resolved'  => $input['is_resolved'],
            'is_knowledge' => $input['is_knowledge'],
        ]);

        redirect("./detail.php?id={$id}"); // PRG
    }

    // GET
    $id_raw = (string)($_GET['id'] ?? '');
    if (!ctype_digit($id_raw)) {
        http404();
    }
    $id = (int)$id_raw;

    $log = logs_find_by_id($id);
    if ($log === null) {
        http404();
    }

    render('detail', ['log' => $log, 'mode' => 'view']);

} catch (Throwable $e) {
    http_response_code(500);
    // detail画面側で共通メッセージを出せるならこちらが自然
    render('detail', ['errors' => ['E_SYSTEM'], 'log' => [], 'mode' => 'view']);
}