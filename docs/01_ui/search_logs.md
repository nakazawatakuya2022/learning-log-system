## /logs 検索仕様（MVP）

- 期間：occurred_at（FROM / TO）
- 言語：language（完全一致）
- 分類：level（完全一致）
- 解決状態：is_resolved（0/1）
- ナレッジ：is_knowledge（0/1）
- 並び順：
  ORDER BY sort_priority ASC, occurred_at DESC, updated_at DESC
