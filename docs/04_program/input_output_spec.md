# 入出力I/F定義（MVP）

---

# 1. index.php（一覧＋登録）

---

## 1-1. GET（一覧表示・検索）

### 入力（Query Parameters）

| 項目名 | key | 型 | 必須 | 例 | 意味/備考 |
| --- | --- | --- | --- | --- | --- |
| 言語フィルタ | language_filter | string | 任意 | ALL / NULL / PHP | ALL=絞り込みなし、NULL=language IS NULL |
| 分類フィルタ | level_filter | string | 任意 | ALL / NOTE | ALL=絞り込みなし |
| 状態フィルタ | resolved_filter | string | 任意 | ALL / 0 / 1 | 0=未解決のみ、1=解決済のみ |
| 期間From | date_from | date | 任意 | 2026-02-01 | occurred_at >= date_from |
| 期間To | date_to | date | 任意 | 2026-02-15 | occurred_at <= date_to |
| ナレッジのみ | knowledge_only | string | 任意 | 1 | 指定時 is_knowledge=1 |

---

## 1-2. POST（新規登録）

### 入力（Form Parameters）

| 項目名 | key | 必須 | NULL可 | 備考 |
| --- | --- | --- | --- | --- |
| 学習日 | occurred_at | 必須 | × | 変更不可項目（登録時のみ入力） |
| 言語 | language | 任意 | ○ | '' → NULL保存 |
| 分類 | level | 必須 | × | NOTE / QUESTION / IMPORTANT |
| タイトル | title | 必須 | × |  |
| 学習過程 | message | 必須 | × |  |

### 固定値（サーバ側で自動設定）

| 項目 | 値 |
| --- | --- |
| is_resolved | 0 |
| is_knowledge | 0 |
| solution | NULL |

---

### 出力（レスポンス）

- 成功：index.php（GET）へリダイレクト（PRG）
- 失敗：index.php にエラー表示

---

# 2. detail.php（詳細＋編集）

---

## 2-1. GET（詳細表示）

### 入力

| 項目名 | key | 必須 |
| --- | --- | --- |
| ログID | id | 必須 |

### 出力

- 詳細表示
- 編集フォーム（DOM切替）
- created_at 表示
- updated_at 表示

---

## 2-2. POST（更新）

### 入力

### Query

| 項目名 | key | 必須 |
| --- | --- | --- |
| ログID | id | 必須 |

### Form（更新可能項目）

| 項目 | key | 必須 | NULL可 |
| --- | --- | --- | --- |
| 言語 | language | 任意 | ○ |
| 分類 | level | 必須 | × |
| タイトル | title | 必須 | × |
| 学習過程 | message | 必須 | × |
| 解決内容 | solution | 任意 | ○ |
| 解決済み | is_resolved | 任意 | × |
| ナレッジ化 | is_knowledge | 任意 | × |

---

### 更新不可項目（I/Fとして受け取らない）

| 項目 | 理由 |
| --- | --- |
| id | 主キー |
| occurred_at | 学習日固定 |
| created_at | 監査項目 |
| updated_at | DB自動更新 |
| sort_priority | 生成カラム |

---

### 出力（レスポンス）

- 成功：detail.php?id={id} へリダイレクト（PRG）
- 失敗：detail.php にエラー表示

---

# 3. 共通変換ルール

- language：'' → NULL
- solution：'' → NULL
- checkbox：送信あり=1、未送信=0
- knowledge=1 の場合、DB制約により resolved=1 必須