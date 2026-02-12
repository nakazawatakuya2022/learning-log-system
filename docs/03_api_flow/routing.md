# ルーティング定義（MVP）

## 方針

- URL の書き換えは行わない
- Web サーバ設定は使用しない
- アクセスされた PHP ファイルがそのまま処理を行う

## 一覧・登録

| URL | Method | ファイル | 内容 |
| --- | --- | --- | --- |
| `index.php` | GET | index.php | 一覧表示／登録フォーム表示 |
| `index.php` | POST | index.php | 新規登録 |

## 詳細・編集

| URL | Method | ファイル | 内容 |
| --- | --- | --- | --- |
| `detail.php?id={id}` | GET | detail.php | 詳細表示 |
| `detail.php?id={id}` | POST | detail.php | 更新 |

## 補足

- `{id}` は `logs.id`
- ページ遷移は a タグまたは form 送信によって行う
- JavaScript による画面遷移は行わない
- 共通処理は `require` で読み込む
- GET：表示のみ
- POST：DB更新あり
- 同一URLで GET / POST を使い分ける
- JSは DOM切替のみ