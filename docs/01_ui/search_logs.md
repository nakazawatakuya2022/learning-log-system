## /logs 検索仕様（MVP）

- 期間：occurred_at（FROM / TO）
- 言語：language（完全一致）
- 分類：level（完全一致）
- 解決状態：is_resolved（0/1）
- ナレッジ：is_knowledge（0/1）
- 並び順：
  ORDER BY sort_priority ASC, occurred_at DESC, updated_at DESC

## MVPでやらないこと（意図的に除外）

- ユーザー認証
- 共有・公開機能
- 自動バックアップ
- タグ・コメント機能
- 全文検索（LIKE / FTS）

理由：
- 学習ログ用途では優先度が低いため
- 設計・実装の複雑化を避けるため