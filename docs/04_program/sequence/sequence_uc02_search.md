# UC-02/04 一覧検索＋ページ移動

```mermaid
sequenceDiagram
  actor U as User
  participant B as Browser
  participant I as index.php
  participant V as Validator
  participant DB as MySQL

  U->>B: 条件指定／ページ移動
  B->>I: GET（filters + page）
  I->>V: validate params

  alt OK
    I->>DB: COUNT（WHERE）
    DB-->>I: total
    I->>DB: LIST（WHERE + ORDER + LIMIT/OFFSET）
    DB-->>I: rows
    I-->>B: 200（一覧 + ページリンク）
  else NG
    V-->>I: errors
    I-->>B: 200（エラー表示のみ）
  end