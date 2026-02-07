# 機能要件（functional Requirements）

Status: Draft  
Last Updated: 2026-02-08

## 1. 学習ログ登録機能

- 学習ログを新規登録できる
- 未解決の状態でも登録できる
- 登録時に以下を入力できる
    - 学習日（occurred_at）
    - 言語（language）
    - タイトル（title）※必須
    - 分類（level）
    - 学習過程（message）※必須
- 登録時の初期状態
    - is_resolved：0（未解決）
    - is_knowledge：0（通常ログ）

---

## 2. 学習ログ一覧表示・検索機能

- 学習ログを一覧表示できる
- 新しい順（更新日時順）で表示できる

※最近更新・整理したログを優先的に表示するため

- 以下の条件で絞り込み検索ができる
    - 期間（occurred_at）
    - 言語（language）
    - 分類（level）
    - 解決状態
        - 未解決（is_resolved = 0）
        - 解決済み（is_resolved = 1）
    - ナレッジのみ（is_knowledge = 1）
- 一覧には以下を表示する
    - 学習日
    - 言語
    - 分類
    - 状態（Resolved / Unresolved）
    - ナレッジ表示（Knowledge バッジ）

---

## 3. 学習ログ詳細表示・編集機能

- 学習ログ1件の詳細を表示できる
- 表示内容
    - タイトル
    - 学習日 / 言語 / 分類
    - 更新日時（updated_at）
    - 学習過程（message）
        - 問題 / エラー / 試したこと
    - 解決方法（solution）
        - 原因 / 解決 / 学び（未解決時は未表示または未記入）
- 詳細画面で以下を **同一画面内で表示／編集切り替え**できる
    - title
    - message
    - solution
    - is_knowledge
- 解決状態（is_resolved）を切り替えできる
- 編集・解決状態変更・ナレッジ切替時は updated_at を更新する

---

## 4. 解決方法追記・更新機能

- 未解決ログに対して解決方法（solution）を後から追記できる
- 既存の solution を編集・更新できる
- 解決完了時に is_resolved を 1 に切り替えできる
- 解決取り消し時に is_resolved を 0 に戻すこともできる
- solution 未記入時は NULL に統一する

※ solution の記入有無と解決状態は独立して管理する

---

## 5. ナレッジ化機能

- 学習ログをナレッジとして扱うかどうかを切り替えできる
- is_knowledge を ON / OFF できる
- ナレッジと未解決は共存可能とする

---

## 補足（設計思想の要約）

```
is_resolved ＝ 解決状態（状態）
solution     ＝ 解決内容（本文）
is_knowledge ＝ 再利用価値（価値）

```

- 解決状態は専用フラグで管理する
- 本文の有無で状態を判断しない
- 学習途中のログやメモも柔軟に扱える設計とする