# ファイル構成図（MVP／最終FIX）

## 構成（最小）

project-root/
├─ public/                          # Web公開（ここだけ公開する想定）
│  ├─ index.php                     # Controller：一覧/検索（GET）, 登録（POST）
│  ├─ detail.php                    # Controller：詳細（GET）, 更新（POST）
│  └─ assets/
│     ├─ css/
│     │  └─ app.css
│     └─ js/
│        └─ detail.js               # DOM切替のみ
│
├─ views/                           # HTMLテンプレート
│  ├─ index.php
│  ├─ detail.php
│  └─ not_found.php
│
├─ src/                             # Webから直接アクセスさせない
│  ├─ bootstrap.php                 # session/tz/require集約
│  ├─ config/
│  │  ├─ env.php                    # .env読込のみ
│  │  ├─ db.php                     # PDO生成のみ（ERRMODE_EXCEPTION）
│  │  └─ constants.php              # LANGUAGES / LEVELS
│  ├─ lib/
│  │  ├─ helpers.php                # h()
│  │  ├─ flash.php                  # flash set/get（表示後unset）
│  │  └─ validation.php             # validate_*（errors配列返却）
│  ├─ repo/
│  │  └─ logs_repo.php              # SQL集約
│  └─ components/
│     ├─ header.php                 # doctype〜body開始
│     ├─ footer.php                 # body閉じ
│     └─ messages.php               # errors/flash/0件表示
│
├─ .env                             # 環境ごとのDB設定（Git管理しない）
├─ .env.example                     # ひな形（Git管理する）
├─ .gitignore                       # .env を除外
└─ docs/                            # 設計ドキュメント
   └─ ...（省略）

学校環境での配置

Web公開領域：public/ の中身のみ配置

非公開領域：src/, views/, .env を配置（公開領域の外）

require 方針

public側は __DIR__ 固定で src/bootstrap.php を require

require __DIR__ . '/../src/bootstrap.php';