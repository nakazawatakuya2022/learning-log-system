# HTML設計書

## 1. テンプレ構成

- views

- views/index.php

- views/detail.php

- views/not_found.php

- components（src/components）

- header.php（CSS読み込み含む）

- footer.php

- messages.php

- --

## 2. CSS読み込み方針（FIX）

- CSSは3分割：

- `assets/css/base.css`（共通）

- `assets/css/index.css`（index専用）

- `assets/css/detail.css`（detail専用）

- 画面ごとに「base + page」を読み込む

### 読み込み担当

- 読み込みタグ自体は `src/components/header.php` に置く
- view側で `$page_css` を指定して header に渡す

例：

- views/index.php：`$page_css = 'index'; require header.php;`
- views/detail.php：`$page_css = 'detail'; require header.php;`
- --

## 3. header.php のHTML骨格（概念）

- `<!doctype html> ... <head> ...`
- `<link rel="stylesheet" href="assets/css/base.css">`
- `<link rel="stylesheet" href="assets/css/{page}.css">`
- `<body><main class="container">`
- --

## 4. index のDOM骨格（要点）

- messages
- 新規登録フォーム（csrf_token）
- 検索フォーム（GET）
- 一覧（table推奨）
- ページング（totalPages<=1は非表示）
- --

## 5. detail のDOM骨格（要点）

- messages
- View領域 / Edit領域（JSで切替）
- `$mode='edit'` の場合は Edit 初期表示
- detail.js はDOM切替のみ（CSS制御は `.is-hidden` 推奨）