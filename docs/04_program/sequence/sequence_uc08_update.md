# UC-08 更新保存（PRG）

```mermaid
sequenceDiagram
  actor U as User
  participant B as Browser
  participant D as detail.php
  participant V as Validator
  participant DB as MySQL

  U->>B: Edit→Save
  B->>D: POST（更新データ + id）
  D->>V: validate（整合性含む）

  alt OK
    D->>DB: UPDATE
    DB-->>D: OK
    D-->>B: 302 /detail.php?id=xx
    B->>D: GET /detail.php?id=xx
    D->>DB: SELECT（by id）
    DB-->>D: row
    D-->>B: 200（View表示）
  else NG
    V-->>D: errors
    D-->>B: 200（Edit表示 + 入力保持 + エラー）
  end