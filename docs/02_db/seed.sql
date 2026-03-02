INSERT INTO logs
(occurred_at, language, level, title, message, solution, is_resolved, is_knowledge)
VALUES

-- ===== 未解決（0）=====
('2026-02-12', 'PHP', 'QUESTION',
'PDO接続で SQLSTATE[HY000] が発生',
'Docker環境からMySQLへ接続時に connection refused が出る。env設定かポートの問題を疑っている。',
NULL, 0, 0),

('2026-02-11', 'JavaScript', 'QUESTION',
'fetch POSTでCSRFエラーになる',
'フォーム送信をfetchへ変更後、サーバ側でCSRF検証に失敗する。',
NULL, 0, 0),

('2026-02-10', 'CSS', 'NOTE',
'gridレイアウト中央寄せメモ',
'max-width + margin:auto を併用するとレイアウトが安定する。',
NULL, 0, 0),

-- ===== 解決（1）=====
('2026-02-12', 'PHP', 'IMPORTANT',
'$_POST が空になる問題',
'POST送信しているのにPHP側で値が取得できない。',
'formタグ内inputのname属性が未設定だった。name追加で解決。',
1, 0),

('2026-02-11', 'JavaScript', 'NOTE',
'submitイベントの挙動整理',
'検証中にページ遷移してログ確認できなかった。',
'addEventListener("submit") 内で preventDefault() を使用して解決。',
1, 0),

('2026-02-09', 'Docker', 'NOTE',
'MySQL接続先はlocalhostではない',
'PHPコンテナからDB接続できなかった。',
'Docker Composeではサービス名(mysql)をホスト名にする必要があった。',
1, 0),

-- ===== ナレッジ（2）=====
('2026-02-12', 'PHP', 'IMPORTANT',
'学習ログ状態設計パターン',
'is_resolved と is_knowledge の2フラグで3状態を表現。',
'UIはラジオボタン1つに集約し、DB値へマッピングすると矛盾が防げる。',
1, 1),

('2026-02-10', 'Design', 'IMPORTANT',
'2画面MVP設計の利点',
'画面数を増やすと責務分散で実装速度が落ちる。',
'登録+一覧を統合し詳細で編集する構成が最短開発になる。',
1, 1),

('2026-02-08', 'Database', 'IMPORTANT',
'並び順はDB責務に寄せる',
'アプリ側sortは複雑化しやすい。',
'generated column(sort_priority)でORDER BYを単純化する設計が有効。',
1, 1),
-- ===== 未解決（0）=====
('2026-02-10', 'PHP', 'QUESTION',
'PDO接続が失敗する',
'PDOでMySQLに接続しようとするとエラーになる。原因切り分け中。',
NULL, 0, 0),

('2026-02-09', 'JavaScript', 'QUESTION',
'fetchでPOSTしたがサーバに届かない',
'フォーム送信をfetchに置き換えたらPHP側に値が入らない。',
NULL, 0, 0),

('2026-02-08', 'HTML', 'NOTE',
'入力フォームの必須設計メモ',
'titleとmessageは必須。languageは未記入でもよい方針。',
NULL, 0, 0),

-- ===== 解決（1）=====
('2026-02-10', 'PHP', 'IMPORTANT',
'フォーム値が空になる原因',
'POSTしているのに$_POSTが空になることがあった。',
'name属性の付け忘れが原因。フォームのinputにnameを付けて解決。',
1, 0),

('2026-02-09', 'JavaScript', 'NOTE',
'event.preventDefaultの使いどころ',
'submit時にページ遷移してしまい検証がしづらい。',
'submitイベントでpreventDefaultしてから処理するようにした。',
1, 0),

('2026-02-07', 'CSS', 'NOTE',
'display: gridの列幅が崩れる',
'grid-template-columnsの指定が意図と違う挙動になった。',
'px指定の抜け（600px）が原因で修正した。',
1, 0),

-- ===== ナレッジ（2）=====
('2026-02-10', 'PHP', 'IMPORTANT',
'学習ログの状態設計（未解決/解決/ナレッジ）',
'is_resolved / is_knowledge の2フラグで3状態を表現する。',
'knowledge=1はresolved=1前提。UIはラジオで3状態にすると矛盾しない。',
1, 1),

('2026-02-08', 'JavaScript', 'IMPORTANT',
'状態はラジオボタンが安全',
'チェックボックスだと矛盾状態が作れてしまう。',
'未解決/解決/ナレッジをラジオで選び、DB値にマッピングする。',
1, 1),

('2026-02-06', 'HTML', 'IMPORTANT',
'最小MVPは2画面（/logs と /logs/{id}）',
'画面を増やしすぎると実装が遅れる。',
'登録+一覧を統合し、詳細で編集する構成が最短。',
1, 1);