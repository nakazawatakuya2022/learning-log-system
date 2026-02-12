# 共通仕様

学習ログ管理システム／MVP

---

## 0. 対象

- 画面：**2画面のみ**
    - `index.php`：登録＋一覧
    - `detail.php/{id}`：詳細（表示・編集）
- DB：`learning_log.logs`（単一テーブル）

---

## 1. ファイル構成

- 画面数＝ファイル数
- 処理と表示は同一ファイル内で完結

### ファイル

- `index.php`
    - 一覧表示
    - 新規登録
- `detail.php`
    - 詳細表示
    - 編集（UI切替はJS）
    - 更新（POST）

---

## 2. 命名

- DB / PHP：snake_case
- フラグ：`is_xxx`（0 / 1）
- 日付：
    - `occurred_at`（学習日）
    - `created_at` / `updated_at`（DB自動）

---

## 3. NULL / デフォルト

- NULL可：`solution`, `language`
- NULL不可：
    - `title`
    - `message`
    - `occurred_at`
    - `level`（DEFAULT = 'NOTE'）
    - フラグ類

---

## 4. フラグルール

- `is_resolved`, `is_knowledge` は 0 / 1
- **is_knowledge = 1 ⇒ is_resolved = 1**
- DB制約で保証

---

## 5. 一覧表示順

```sql
ORDERBY
  sort_priorityASC,
  occurred_atDESC,
  updated_atDESC
```

---

## 6. バリデーション

- **HTMLのみ**
    - `required` による必須チェック
- JS：行わない
- PHP：存在確認のみ
- 整合性：DB制約

---

## 7. JavaScriptの役割

- DOMの表示切替のみ
- 入力チェックは行わない

---

## 8. 方針

- 仕様はこれ以上増やさない
- 迷ったらこの仕様に戻る