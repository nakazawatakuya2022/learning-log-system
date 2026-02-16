# CSS設計書

## 1. 方針（FIX）

- CSSは3ファイルに分割する

- `base.css`：全画面共通

- `index.css`：index専用

- `detail.css`：detail専用

- 読み込み順は必ず `base.css → page.css`
- assetsパスは相対（`assets/...`）
- --

## 2. base.css（共通）

### 含めるもの（例）

- reset / box-sizing / body / font
- layout：`.container`, `.section`, `.section__title`
- form：`.form`, `.field`, `.field__label`, `.field__control`, `.form__actions`
- button：`.btn`, `.btn--primary`, `.btn--secondary`
- messages：`.messages`, `.messages__errors`, `.messages__flash`, `.messages__info`
- badge：`.badge`, `.badge--unresolved`, `.badge--resolved`, `.badge--knowledge`
- utility：`.is-hidden { display:none; }`

### 含めないもの

- table/pagination の個別調整（index.cssへ）
- detailのView/Edit配置（detail.cssへ）
- --

## 3. index.css（index専用）

### 対象

- 一覧表示（table or list）
- ページング
- index専用の微調整

例クラス

- `.table`, `.table__row`
- `.pagination`, `.pagination__link`, `.pagination__link--active`
- --

## 4. detail.css（detail専用）

### 対象

- detailページのレイアウト
- View/Edit領域の見た目（表示切替は `.is-hidden` を利用）
- solution表示など detail特有調整
- --

## 5. 読み込み仕様（FIX）

- index：`base.css + index.css`
- detail：`base.css + detail.css`
- not_found：`base.css`（必要なら index.css は不要）
- --

## 6. 最小クラス一覧（実装チェック用）

- base：`container`, `section`, `section__title`, `form`, `field`, `btn`, `messages`, `badge`, `is-hidden`
- index：`table`（or `list`）, `pagination`
- detail：detail固有（必要な分だけ）