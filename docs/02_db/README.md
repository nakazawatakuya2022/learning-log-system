# DB設計

## この配下の正
- テーブル設計：Excel（logs_table.xlsx）
- データ辞書：data_dictionary.md
- ER図：er_diagram.drawio（正） / er_diagram.png（参照）

## ファイル一覧
- logs_table.xlsx：テーブル設計書（正）
- data_dictionary.md：データ辞書
- table_design.md：補足ルール（保存方針・並び順など）
- er_diagram.drawio / er_diagram.png：ER図

## 設計ステータス

- logs テーブル：確定
- インデックス設計：確定（MVP）
- 並び順仕様：確定（sort_priority）
- 本ドキュメント以降の変更は「実装フェーズでの差分」として扱う

※ 本DDLを変更する場合は、必ず Git 管理下で差分を残すこと

## NULL / NOT NULL の最終方針

カラム	方針	理由
title	NOT NULL	無いとログとして成立しない
message	NOT NULL	同上
occurred_at	NOT NULL	学習ログの軸
solution	NULL可	未解決時は存在しない
language	NULL可	言語未確定ログを許容
level	NOT NULL + DEFAULT 'NOTE'	常に何かに分類される思想

## DB設計 最終判断ログ（logsテーブル）
ステータス

状態：確定

対象：logs テーブル（DDL / 運用ルール / データ辞書）

目的：

学習ログの一覧表示を最適化

未解決 → 解決 → ナレッジの順で安定表示

MVPとして過不足のない制約設計

1. sort_priority と CASE 式の扱い
方針

CASE式はやめない

sort_priority は生成カラム（STORED）として維持

CASE
  WHEN is_resolved = 0 THEN 0
  WHEN is_knowledge = 1 THEN 2
  ELSE 1
END

理由

ORDER BY に CASE を毎回書かないため

インデックスを効かせるため

一覧表示SQLを単純に保つため

CASE は「表示順ロジック専用」として使用する。

2. CHECK制約を入れる判断
結論

CHECK制約は入れる

入れる制約（最小セット）
CHECK (is_resolved IN (0,1)),
CHECK (is_knowledge IN (0,1)),
CHECK (is_knowledge = 0 OR is_resolved = 1)

理由

is_knowledge = 1 なのに is_resolved = 0 という
意味が壊れた状態をDBレベルで防ぐ

アプリのバグ／手動SQL更新でも事故らない

運用ルールを「文章」ではなく「制約」で保証できる


CASE = 並べ方
CHECK = 入ってはいけない状態を防ぐ柵

役割分担が明確。

3. level の値制約を入れない判断
検討した制約（※不採用）
CHECK (level IN ('NOTE','QUESTION','IMPORTANT'))

結論

この制約は入れない

理由

level は「状態」ではなく 人間向けの分類ラベル

DBで厳密に縛らなくても、アプリの挙動は壊れない

将来の拡張（TIPS / MEMO / TODO など）を
DDL変更なしで可能にしたい

DB制約は「壊れると困るもの」だけに使う。
分類ルールは データ辞書側で管理する。


HTML必須 = UXの制約
NOT NULL = データの意味の制約
という役割分担で設計。

4. 最終DDLの位置づけ

CASE：続投

CHECK：

フラグの0/1

knowledge ⇒ resolved

level値制約：意図的に入れない

インデックス：

idx_logs_priority_occurred_updated を中心に一覧最適化

このDDLを 正本 として実装フェーズに進む。