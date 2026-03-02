<?php
declare(strict_types=1);

/**
 * src/repo/logs_repo.php
 * - 一覧（10件+ページング）
 * - 検索（language / level / status）
 *   status: '' | unresolved | resolved | knowledge
 */

function logs_find(int $limit = 10, int $offset = 0): array
{
    $sql = "SELECT id, occurred_at, language, level, title, is_resolved, is_knowledge, updated_at
            FROM logs
            ORDER BY sort_priority ASC, occurred_at DESC, updated_at DESC
            LIMIT :limit OFFSET :offset";
    $st = db()->prepare($sql);
    $st->bindValue(':limit', $limit, PDO::PARAM_INT);
    $st->bindValue(':offset', $offset, PDO::PARAM_INT);
    $st->execute();
    return $st->fetchAll();
}

function logs_find_by_id(int $id): ?array
{
    $st = db()->prepare("SELECT * FROM logs WHERE id = :id");
    $st->bindValue(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $row = $st->fetch();
    return $row === false ? null : $row;
}

function logs_insert(array $data): int
{
    $sql = "INSERT INTO logs (occurred_at, language, level, title, message, solution, is_resolved, is_knowledge)
            VALUES (:occurred_at, :language, :level, :title, :message, :solution, :is_resolved, :is_knowledge)";
    $st = db()->prepare($sql);
    $st->execute([
        ':occurred_at' => $data['occurred_at'],
        ':language'    => $data['language'],
        ':level'       => $data['level'],
        ':title'       => $data['title'],
        ':message'     => $data['message'],
        ':solution'    => $data['solution'],
        ':is_resolved' => $data['is_resolved'],
        ':is_knowledge'=> $data['is_knowledge'],
    ]);
    return (int)db()->lastInsertId();
}

function logs_update(int $id, array $data): bool
{
    $sql = "UPDATE logs
            SET language = :language,
                level = :level,
                title = :title,
                message = :message,
                solution = :solution,
                is_resolved = :is_resolved,
                is_knowledge = :is_knowledge
            WHERE id = :id";
    $st = db()->prepare($sql);
    return $st->execute([
        ':language'     => $data['language'],
        ':level'        => $data['level'],
        ':title'        => $data['title'],
        ':message'      => $data['message'],
        ':solution'     => $data['solution'],
        ':is_resolved'  => $data['is_resolved'],
        ':is_knowledge' => $data['is_knowledge'],
        ':id'           => $id,
    ]);
}

/**
 * 検索（ページング対応）
 * $cond:
 * - language: string
 * - level   : string
 * - status  : ''|'unresolved'|'resolved'|'knowledge'
 */
function logs_search(array $cond, int $limit = 10, int $offset = 0): array
{
    [$whereSql, $params] = logs_build_where($cond);

    $sql = "SELECT id, occurred_at, language, level, title, is_resolved, is_knowledge, updated_at
            FROM logs
            {$whereSql}
            ORDER BY sort_priority ASC, occurred_at DESC, updated_at DESC
            LIMIT :limit OFFSET :offset";

    $st = db()->prepare($sql);

    foreach ($params as $k => $v) {
        $st->bindValue($k, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $st->bindValue(':limit', $limit, PDO::PARAM_INT);
    $st->bindValue(':offset', $offset, PDO::PARAM_INT);

    $st->execute();
    return $st->fetchAll();
}

/**
 * 検索件数（ページ数計算用）
 */
function logs_search_count(array $cond): int
{
    [$whereSql, $params] = logs_build_where($cond);

    $sql = "SELECT COUNT(*) AS cnt
            FROM logs
            {$whereSql}";

    $st = db()->prepare($sql);
    foreach ($params as $k => $v) {
        $st->bindValue($k, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $st->execute();

    return (int)$st->fetchColumn();
}

/**
 * @return array{0:string, 1:array<string,mixed>}
 */
function logs_build_where(array $cond): array
{
    $w = [];
    $p = [];

    $language = trim((string)($cond['language'] ?? ''));
    if ($language !== '') {
        $w[] = "language = :language";
        $p[':language'] = $language;
    }

    $level = trim((string)($cond['level'] ?? ''));
    if ($level !== '') {
        $w[] = "level = :level";
        $p[':level'] = $level;
    }

    // status: '' | unresolved | resolved | knowledge
    // - unresolved: is_resolved=0（ナレッジは除外される想定）
    // - resolved  : is_resolved=1 AND is_knowledge=0
    // - knowledge : is_knowledge=1
    $status = (string)($cond['status'] ?? '');
    if ($status === 'unresolved') {
        $w[] = "is_resolved = 0";
    } elseif ($status === 'resolved') {
        $w[] = "is_resolved = 1 AND is_knowledge = 0";
    } elseif ($status === 'knowledge') {
        $w[] = "is_knowledge = 1";
    }

    $whereSql = '';
    if (!empty($w)) {
        $whereSql = 'WHERE ' . implode(' AND ', $w);
    }

    return [$whereSql, $p];
}