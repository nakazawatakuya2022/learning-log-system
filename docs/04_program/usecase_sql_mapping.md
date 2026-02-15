# ユースケース定義書（MVP／設計確定版・修正版）

## 1. 前提仕様

- 画面数：2画面（index / detail）
- 1ページ表示件数：10件
- 並び順：`sort_priority ASC, occurred_at DESC, updated_at DESC`
- フィルタは任意指定
- ページングは検索条件を維持する
- PRG（Post-Redirect-Get）採用
- 学習日（occurred_at）は更新不可
- 検索パラメータは **補正しない**（不正値はエラー）

---

## 2. ユースケース一覧

### UC-01 一覧表示（初期表示）

**概要**：検索条件なしでログ一覧を表示する。

**入力**：GET: page（任意、default=1）

**処理**：

- 総件数取得（COUNT）
- ページ数計算
- LIMIT/OFFSET付きで一覧取得
    
    **出力**：
    
- 一覧（最大10件）
- ページリンク表示

---

### UC-02 一覧検索（条件あり）

**概要**：指定した検索条件でログを絞り込む。

**入力（GET）**：

| 項目 | key | 備考 |
| --- | --- | --- |
| 言語 | language_filter | ALL / NULL / 値 |
| 分類 | level_filter | ALL / NOTE / QUESTION / IMPORTANT |
| 状態 | resolved_filter | ALL / 0 / 1 |
| 期間From | date_from | 任意 |
| 期間To | date_to | 任意 |
| ナレッジのみ | knowledge_only | 1 のとき適用 |
| ページ | page | default=1 |

**処理**：

- パラメータ検証（不正値はエラー）
- WHERE条件を組み立て
- COUNT(*)取得
- LIMIT/OFFSETで一覧取得
    
    **出力**：
    
- 条件付き一覧表示
- ページリンク（条件維持）

---

### UC-03 一覧検索（0件）

**概要**：検索結果が0件の場合。

**出力**：

- 「該当するログはありません」表示
- ページリンクは非表示または1のみ

---

### UC-04 ページ移動

**概要**：前へ／次へ／ページ番号クリック。

**入力**：

- page
- 既存検索条件
    
    **処理**：
    
- パラメータ検証（不正値はエラー）
- 再検索実行
    
    **出力**：
    
- 指定ページの一覧表示（条件維持）

---

### UC-05 新規登録（未解決ログ作成）

**概要**：新しい学習ログを登録する。

**入力（POST）**：

| 項目 | 必須 |
| --- | --- |
| occurred_at | 必須 |
| language | 任意 |
| level | 必須 |
| title | 必須 |
| message | 必須 |

**固定値**：

- is_resolved = 0
- is_knowledge = 0
- solution = NULL

**出力**：

- 成功：index.phpへリダイレクト（PRG）＋`$_SESSION['flash']` に「登録しました」を格納
- 失敗：index.php にエラー表示（入力保持）

---

### UC-06 詳細表示

**概要**：1件のログを表示する。

**入力**：GET: id（必須）

**出力**：

- 全項目表示
- created_at / updated_at 表示

---

### UC-07 編集開始

**概要**：閲覧モードから編集モードへ切替。

**処理**：

- JSでDOM表示切替のみ
- サーバ処理なし

---

### UC-08 更新保存

**概要**：ログ内容を更新する。

**入力**：POST + id

**更新可能項目**：

- language
- level
- title
- message
- solution
- is_resolved
- is_knowledge

**更新不可**：

- id
- occurred_at
- created_at
- updated_at
- sort_priority

**出力**：

- 成功：detail.php?id=xxへリダイレクト（PRG）
- 失敗：detail.php（Edit状態）にエラー表示（入力保持）

---

### UC-09 ナレッジ化

**概要**：is_knowledge=1へ更新する。

**制約**：

- **サーババリデーション**により `is_knowledge=1 ⇒ is_resolved=1` 必須

---

### UC-10 不正ID

**概要**：存在しないID指定。

**出力**：

- エラーメッセージ表示（Not Found）

---

## 3. ページング仕様（確定）

- 1ページ10件
- page未指定 → 1
- 検索条件は常に維持
- 検索パラメータは補正しない（不正値はエラー）

---

## 4. 検索フィルタ仕様まとめ

フィルタ	UI
language	select
level	select
resolved	select
日付	from / to
knowledge	checkbox