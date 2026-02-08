1. テーブル

対象テーブル：logs

2. 並び順（/logs 標準ソート）

目的：未解決を上に、次に解決、最後にナレッジを表示し、各グループ内は新しい順

ソート仕様：

ORDER BY sort_priority ASC, occurred_at DESC, updated_at DESC

3. sort_priority（生成カラム）

目的：一覧表示の優先度を固定し、ORDER BY で CASE を直接使わない（インデックスを効かせる）

定義（生成カラム STORED）：

CASE
  WHEN is_resolved = 0 THEN 0
  WHEN is_knowledge = 1 THEN 2
  ELSE 1
END


運用ルール：

is_knowledge = 1 ⇒ is_resolved = 1（ナレッジ化は解決済み前提）

4. インデックス方針（MVP）

一覧表示最適化を最優先し、複合インデックス中心で設計

採用インデックス（確定案）：

PRIMARY (id)

idx_logs_priority_occurred_updated (sort_priority, occurred_at, updated_at)：一覧表示用

idx_logs_resolved_occurred (is_resolved, occurred_at)：未解決/解決の絞り込み用

（任意）idx_logs_language_occurred (language, occurred_at)：言語フィルタ

（任意）idx_logs_level_occurred (level, occurred_at)：分類フィルタ

重複整理：

idx_logs_occurred_updated は idx_logs_priority_occurred_updated と役割が重複するため、優先度を下げる（必要なら後で追加）