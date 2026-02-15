# バリデーション仕様

## 1. 適用対象

| I/F | 画面 | メソッド | 内容 |
| --- | --- | --- | --- |
| 1 | index.php | POST | 新規登録 |
| 2 | detail.php | POST | 更新 |
| 3 | index.php | GET | 検索 |
| 4 | detail.php | GET | 詳細表示 |

---

## 2. 前提（DB/値の方針）

### level（必須）

- 候補（アプリ側で制御）：`NOTE / QUESTION / IMPORTANT`
- DB定義：`VARCHAR(20) NOT NULL DEFAULT 'NOTE'`
- 目的：必ず値が入り、未指定時は NOTE になる（保険）

### language（任意）

- 候補（アプリ側で制御）：定義済みの言語一覧（例：PHP/Java/C++…）
- DB定義：NULL許可（未選択＝NULL）
- 検索では `NULL` を条件として扱える

---

## 3. 共通処理（サーバ）

### 3-1. 正規化

- 文字列：`trim()` を行う
- 空文字：項目ルールにより **NULL変換 or エラー**
- checkbox：`isset()` で 0/1 化
- 日付：`YYYY-MM-DD` 形式のみ許可（不正はエラー）
- 数値：整数のみ許可（不正はエラー）

### 3-2. バリデーション責務

- HTMLの必須・形式は補助
- **サーバ側で必ず検証する（必須）**

---

## 4. 新規登録（index.php POST）

### 4-1. 入力仕様

| 項目 | 必須 | バリデーション |
| --- | --- | --- |
| occurred_at | ⭕ | `YYYY-MM-DD` |
| language | ❌ | 空→NULL、指定時は候補のみ（アプリ側で制御） |
| level | ⭕ | `NOTE/QUESTION/IMPORTANT` のみ許可（アプリ側で制御） |
| title | ⭕ | trim後空NG、1〜100文字 |
| message | ⭕ | trim後空NG |
| solution | — | 送信されても無視 |
| is_resolved | — | 送信されても無視 |
| is_knowledge | — | 送信されても無視 |

### 4-2. 固定値（登録時）

- is_resolved = 0
- is_knowledge = 0
- solution = NULL

※ 画面上でどう見えても、登録時は未解決固定

---

## 5. 更新（detail.php POST）

### 5-1. id

- 必須
- 正整数
- 該当レコードなし → **404相当（Not Found）**

### 5-2. 更新可能項目

| 項目 | 必須 | バリデーション |
| --- | --- | --- |
| language | ❌ | 空→NULL、指定時は候補のみ（アプリ側で制御） |
| level | ⭕ | `NOTE/QUESTION/IMPORTANT` のみ許可（アプリ側で制御） |
| title | ⭕ | trim後空NG、1〜100文字 |
| message | ⭕ | trim後空NG |
| solution | ❌ | 空ならNULL（未解決でも保持OK） |
| is_resolved | ⭕ | 0 / 1 |
| is_knowledge | ⭕ | 0 / 1 |
| occurred_at | — | 更新不可（POSTにあっても無視） |

### 5-3. 整合性ルール（必須）

- **is_knowledge = 1 の場合 is_resolved = 1 必須**
    
    → 違反時エラー
    

※ `is_resolved=0` でも solution 記載は許容（強制NULLしない）

### 5-4. 成功/失敗（PRG）

- 成功：`detail.php?id={id}` へリダイレクト
- 失敗：detail.php にエラー表示（入力値保持）

---

## 6. 検索（index.php GET）

### 6-1. 方針

- **補正しない**
- 不正値は **エラー表示**（一覧は出さない）

### 6-2. 許容値

| パラメータ | 許容 |
| --- | --- |
| language | ALL / NULL / 候補値 |
| level | ALL / NOTE / QUESTION / IMPORTANT |
| resolved | ALL / 0 / 1 |
| knowledge_only | 0 / 1 |
| date_from | 空 or YYYY-MM-DD |
| date_to | 空 or YYYY-MM-DD |
| page | 正整数 |

### 6-3. エラー条件

- language が `ALL/NULL/候補値` 以外
- level が `ALL/NOTE/QUESTION/IMPORTANT` 以外
- resolved が `ALL/0/1` 以外
- knowledge_only が `0/1` 以外
- date_from/date_to の形式不正
- page が整数でない / 0以下
- date_from > date_to

---

## 7. 詳細表示（detail.php GET）

以下は **404相当表示**：

- id未指定
- idが整数でない
- idが0以下
- 該当レコードなし

---

## 8. エラーメッセージ方針（最小）

- 画面上部にまとめて表示（ul形式）
- 成功時はPRGで再表示

### 文言形式

- `{項目名}は必須です`
- `{項目名}の形式が正しくありません`
- `ナレッジ化するには解決済みにしてください`