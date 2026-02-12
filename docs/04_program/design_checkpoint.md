# 画面項目仕様書（MVP／最終確定版）

## 1. 対象画面

| 画面名 | ファイル | 役割 |
| --- | --- | --- |
| 一覧＋登録画面 | index.php | ログ登録／一覧表示／検索 |
| 詳細＋編集画面 | detail.php | 1件表示／同一画面内編集 |

---

# 2. 共通入力項目仕様

## 2.1 入力項目一覧

| 項目名 | name属性 | UI | 必須 | NULL可 | 備考 |
| --- | --- | --- | --- | --- | --- |
| 学習日 | occurred_at | date | 必須 | × | 学習実施日 |
| 言語 | language | select | 任意 | ○ | 未選択はNULL保存 |
| 分類 | level | select | 必須 | × | NOTE / QUESTION / IMPORTANT |
| タイトル | title | text | 必須 | × |  |
| 学習過程 | message | textarea | 必須 | × |  |
| 解決内容 | solution | textarea | 任意 | ○ | 未入力はNULL |
| 解決済み | is_resolved | checkbox | 任意 | × | 0/1 |
| ナレッジ化 | is_knowledge | checkbox | 任意 | × | 0/1（DB制約あり） |

---

# 3. level仕様（確定）

- UI形式：select
- 未選択：不可
- DEFAULT：NOTE

| 値 | 意味 |
| --- | --- |
| NOTE | メモ |
| QUESTION | 質問 |
| IMPORTANT | 重要 |

---

# 4. language仕様（確定）

- UI形式：select
- 未選択：許可
- 未選択時の保存値：NULL
- 言語に依存しないログも登録可能

### 検索時の仕様

| 選択値 | 動作 |
| --- | --- |
| （すべて） | 絞り込みなし |
| （言語なし） | language IS NULL |
| 各言語 | language = 選択値 |

---

# 5. 詳細画面表示項目

## 5.1 表示項目一覧

- 学習日
- 言語
- 分類
- タイトル
- 学習過程
- 解決内容
- 解決済み
- ナレッジ化
- 作成日時（created_at）
- 更新日時（updated_at）

※ 作成日時・更新日時は表示専用（編集不可）

---

# 6. UI制御仕様

- 編集は同一画面内で切替（閲覧 ⇄ 編集）
- JavaScriptはDOM表示切替のみを担当
- バリデーションはHTML標準機能（required等）のみ使用
- データ整合性はDB制約で担保

---

# 7. 設計方針まとめ

- 画面数は2画面固定
- 入力項目は一覧画面と詳細画面で共通
- 設定値（level）は固定選択式
- languageはNULLを許容し柔軟性を確保
- 過剰な分割・フレームワーク導入は行わない