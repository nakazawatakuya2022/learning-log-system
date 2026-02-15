メッセージ／文言一覧（最終FIX）

## 1. 表示ルール

- **フラッシュ（成功）**：`$_SESSION['flash']` を index.php で **1回だけ表示**（表示後 unset）
- **エラー**：画面上部に `<ul>` でまとめて表示
- **検索0件**：結果エリアに固定文言表示

---

## 2. フラッシュメッセージ（成功）

| 種別 | ID | 文言 | 表示箇所 | 備考 |
| --- | --- | --- | --- | --- |
| 成功 | I_CREATED | 登録しました | index.php | PRG後に1回だけ |

---

## 3. 共通エラー

| 種別 | ID | 文言 | 表示箇所 |
| --- | --- | --- | --- |
| Not Found | E_NOT_FOUND | 対象のログが見つかりません | detail.php |
| 不正リクエスト | E_BAD_REQUEST | リクエストが不正です | index.php / detail.php |

※ 検索条件の不正は「個別ID」でも「E_BAD_REQUEST一括」でも良いが、本PJは **実装簡略のため E_BAD_REQUEST に統一**してOK。

（個別化したい場合は下の「検索パラメータ」表を使う）

---

## 4. バリデーション（新規登録：index.php POST）

| ID | 文言 |
| --- | --- |
| E_OCCURRED_REQUIRED | 学習日は必須です |
| E_OCCURRED_INVALID | 学習日の形式が正しくありません |
| E_LEVEL_REQUIRED | 分類は必須です |
| E_LEVEL_INVALID | 分類の値が不正です |
| E_LANGUAGE_INVALID | 言語の値が不正です |
| E_TITLE_REQUIRED | タイトルは必須です |
| E_TITLE_LENGTH | タイトルは1〜100文字で入力してください |
| E_MESSAGE_REQUIRED | 学習過程は必須です |

---

## 5. バリデーション（更新：detail.php POST）

| ID | 文言 |
| --- | --- |
| E_LEVEL_INVALID | 分類の値が不正です |
| E_LANGUAGE_INVALID | 言語の値が不正です |
| E_TITLE_REQUIRED | タイトルは必須です |
| E_TITLE_LENGTH | タイトルは1〜100文字で入力してください |
| E_MESSAGE_REQUIRED | 学習過程は必須です |
| E_RESOLVED_INVALID | 解決状態の値が不正です |
| E_KNOWLEDGE_INVALID | ナレッジの値が不正です |
| E_KNOWLEDGE_NEEDS_RESOLVED | ナレッジ化するには解決済みにしてください |

※ `solution` は未解決でも許容（エラーなし）

---

## 6. 検索パラメータ（不正時：個別化したい場合）

| ID | 文言 |
| --- | --- |
| E_SEARCH_LANGUAGE_INVALID | 検索条件（言語）が不正です |
| E_SEARCH_LEVEL_INVALID | 検索条件（分類）が不正です |
| E_SEARCH_RESOLVED_INVALID | 検索条件（解決状態）が不正です |
| E_SEARCH_KNOWLEDGE_INVALID | 検索条件（ナレッジ）が不正です |
| E_SEARCH_DATE_INVALID | 検索条件（日付）の形式が不正です |
| E_SEARCH_DATE_RANGE | 検索条件（日付範囲）が不正です |
| E_SEARCH_PAGE_INVALID | 検索条件（ページ）が不正です |

---

## 7. 検索結果0件

| ID | 文言 |
| --- | --- |
| I_NO_RESULTS | 該当するログはありません |