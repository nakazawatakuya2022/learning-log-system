# ワイヤーフレーム（簡易）

Status: Draft  
Last Updated: 2026-02-08

## index.php

────────────────────────────────
Logs
────────────────────────────────

[ New Log ]  ← 新規登録（上）

Date *（必須）
[ yyyy-mm-dd ]

Language *（必須）
[ PHP ▼ ]

Level *（必須）
[ NOTE ▼ ]

Title *（必須）
[ input ]

Message *（必須）
┌──────────────────────────────┐
│【問題】                       │
│【エラー】                     │
│【試したこと】                 │
│                              │
└──────────────────────────────┘

[ Save ]
────────────────────────────────

[ Filters ]  ← 条件検索（一覧の上）

From [ yyyy-mm-dd ]   To [ yyyy-mm-dd ]
Language [ All ▼ ]    Level [ All ▼ ]

解決状態
[ ] 未解決   [ ] 解決済み     [ ] ナレッジのみ

[ Reset ]  [ Search ]

────────────────────────────────
[ Logs List ]  ← 一覧（下）

Date         Lang   Level      Status                     Title
──────────────────────────────────────────────────────────────
2026-02-01   PHP    NOTE       [Unresolved]               タイトル →
2026-02-02   Java   QUESTION   [Resolved][Knowledge]      タイトル →
──────────────────────────────────────────────────────────────

## detail.php

← Back

Title
Language / Date / Level
Last updated: yyyy-mm-dd hh:mm

Status:   [ Resolved / Unresolved ]（is_resolved）
Knowledge:[ ON / OFF ]（is_knowledge）

────────────────────────────────
Message
【問題】
【エラー】
【試したこと】

────────────────────────────────
Solution
（未記入なら未記入表示 or 非表示）
【原因】
【解決】
【学び】

[ Edit ]  → 編集モード

title / message / solution / is_resolved / is_knowledge を編集
[ Cancel ]（元に戻す） [ Save ]（保存）


# ワイヤー設計メモ

- 登録はトップ画面に統合（記録頻度が高いため）
- 詳細画面で以下を行う
    - 内容編集（title / message / solution）
    - 解決状態の切り替え（is_resolved）
    - ナレッジ化の切り替え（is_knowledge）
- 必須入力
    - Date / Language / Level / Title / Message
- 解決済み判定
    - is_resolved = 1
- solution は解決方法の本文専用フィールド