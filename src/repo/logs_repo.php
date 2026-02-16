<?php
declare(strict_types=1);

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
        ':language' => $data['language'],
        ':level' => $data['level'],
        ':title' => $data['title'],
        ':message' => $data['message'],
        ':solution' => $data['solution'],
        ':is_resolved' => $data['is_resolved'],
        ':is_knowledge' => $data['is_knowledge'],
    ]);
    return (int)db()->lastInsertId();
}

function logs_update(int $id, array $data): bool
{
    // occurred_at は絶対に更新しない
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
        ':language' => $data['language'],
        ':level' => $data['level'],
        ':title' => $data['title'],
        ':message' => $data['message'],
        ':solution' => $data['solution'],
        ':is_resolved' => $data['is_resolved'],
        ':is_knowledge' => $data['is_knowledge'],
        ':id' => $id,
    ]);
}