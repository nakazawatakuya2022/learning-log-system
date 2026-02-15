## messages の「運用ルール」

- エラーは errors[] に貯めて画面上部 <ul> で出す
- フラッシュは $_SESSION['flash'] で 1回表示して unset
- 検索パラメータ不正は エラー表示のみでSQLは発行しない

## language候補一覧
- src/config/constants.php に LANGUAGES 配列
- LEVELS も同じ場所に置く
※最終FIXではなく、候補は constants に定義

## 404相当の表示テンプレ方針
- detail.php 内で http_response_code(404)＋メッセ表示