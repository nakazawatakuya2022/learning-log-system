# UC-06 詳細表示

```mermaid
sequenceDiagram
  actor U as User
  participant B as Browser
  participant D as detail.php
  participant V as Validator
  participant DB as MySQL

  U->>B: ログを開く
  B->>D: GET（id）
  D->>V: validate id

  alt OK
    D->>DB: SELECT（by id）
    alt Found
      DB-->>D: row
      D-->>B: 200（View表示）
    else Not Found
      DB-->>D: none
      D-->>B: 404相当（Not Found）
    end
  else NG
    V-->>D: invalid
    D-->>B: 404相当（Not Found）
  end