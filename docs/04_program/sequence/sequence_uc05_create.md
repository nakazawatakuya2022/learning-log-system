# UC-05 新規登録（未解決ログ作成）

```mermaid
sequenceDiagram
  actor U as User
  participant B as Browser
  participant I as index.php
  participant V as Validator
  participant DB as MySQL
  participant S as Session

  U->>B: 入力して登録
  B->>I: POST（登録データ）
  I->>V: validate

  alt OK
    I->>DB: INSERT（固定値含む）
    DB-->>I: OK
    I->>S: flash="登録しました"
    I-->>B: 302 /index.php
    B->>I: GET /index.php
    I->>S: flash表示→unset
    I->>DB: COUNT + LIST（10件）
    DB-->>I: rows
    I-->>B: 200（一覧 + flash）
  else NG
    V-->>I: errors
    I-->>B: 200（エラー + 入力保持）
  end