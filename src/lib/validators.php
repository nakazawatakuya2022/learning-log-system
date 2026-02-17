<?php
declare(strict_types=1);

/**
 * POSTからログ入力を取り出して正規化する
 * - trim
 * - 型寄せ
 * - checkbox を 0/1 に正規化
 * - solution は空なら null
 */
function log_input_from_post(array $post): array
{
    $occurred_at  = trim((string)($post['occurred_at'] ?? ''));
    $language     = trim((string)($post['language'] ?? ''));
    $level        = trim((string)($post['level'] ?? ''));
    $title        = trim((string)($post['title'] ?? ''));
    $message      = trim((string)($post['message'] ?? ''));
    $solution_raw = trim((string)($post['solution'] ?? ''));

    return [
        'occurred_at'  => $occurred_at,
        'language'     => $language,
        'level'        => $level,
        'title'        => $title,
        'message'      => $message,
        'solution'     => ($solution_raw === '' ? null : $solution_raw),
        'is_resolved'  => isset($post['is_resolved']) ? 1 : 0,
        'is_knowledge' => isset($post['is_knowledge']) ? 1 : 0,
    ];
}

/**
 * 新規登録用バリデーション（MVP最小）
 */
function validate_log_create(array $input): array
{
    $errors = [];

    $occurred_at = (string)($input['occurred_at'] ?? '');
    $title       = (string)($input['title'] ?? '');
    $message     = (string)($input['message'] ?? '');

    if ($occurred_at === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $occurred_at)) {
        $errors[] = 'E_BAD_REQUEST';
    }
    if ($title === '') {
        $errors[] = 'E_BAD_REQUEST';
    }
    if ($message === '') {
        $errors[] = 'E_BAD_REQUEST';
    }

    return $errors;
}

/**
 * 更新用バリデーション（occurred_atは更新対象外なのでチェックしない）
 */
function validate_log_update(array $input): array
{
    $errors = [];

    $title   = (string)($input['title'] ?? '');
    $message = (string)($input['message'] ?? '');

    if ($title === '') {
        $errors[] = 'E_BAD_REQUEST';
    }
    if ($message === '') {
        $errors[] = 'E_BAD_REQUEST';
    }

    return $errors;
}