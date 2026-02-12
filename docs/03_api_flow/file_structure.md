# ファイル構成図（MVP／最終FIX）

## 方針
- 画面数＝ファイル数（2画面）
- 処理（POST）と表示（HTML）は同一ファイル内で完結
- 共通処理は `require` のみ
- 環境差（自宅／学校）は `.env` で吸収する
- `.env` 読み込みは `db.php` に統合する（env.php は作らない）

## 構成（最小）

project-root/
├─ public/                       # Web公開（ここだけ公開する想定）
│  ├─ index.php                  # 一覧表示／登録（GET/POST）
│  ├─ detail.php                 # 詳細表示／編集／更新（GET/POST）
│  └─ assets/
│     ├─ css/
│     │  └─ app.css
│     └─ js/
│        └─ detail.js            # DOM切替のみ
│
├─ src/                          # Webから直接アクセスさせない
│  └─ config/
│  │  └─ db.php                  # .env読込 + PDO生成（統合）
│  └─ components/
├─ .env                          # 環境ごとのDB設定（Git管理しない）
├─ .env.example                  # ひな形（Git管理する）
├─ .gitignore                    # .env を除外
│
└─ docs/                         # 設計ドキュメント（省略）

## 学校環境での配置
- Web公開領域：`public/` の中身のみ配置
- 非公開領域：`src/` と `.env` を配置（公開領域の外）

## require 方針
- `public/index.php` と `public/detail.php` の先頭で `src/config/db.php` を `require` する
