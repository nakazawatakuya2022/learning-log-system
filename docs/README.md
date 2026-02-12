# 設計ドキュメント

このリポジトリの設計ドキュメントは docs/ 配下で管理する（設計の正）。

## 図と表
- テーブル設計・データ辞書：Excel（docs/ 配下に配置）
- ER図：diagrams.net（.drawio を正、PNGは参照用）
- シーケンス図・画面遷移図：Mermaid（Markdown内を正）
- Notion：裏ログ（思考・作業メモ）

## ディレクトリ方針
- docs/00_overview/：要件・前提（上流）
- docs/01_ui/：画面仕様（項目定義・バリデーション等）
- docs/02_db/：DB設計（Excel/ER図）
- docs/03_api_flow/：URL/HTTP、ユースケース→SQL、シーケンス（Mermaid）
- docs/04_program/：プログラム設計・ファイル構成
- docs/05_test/：テスト仕様
- docs/backup/：DBダンプ置き場（Git管理しない）

## lunguage検索について
「language検索は（すべて）/（言語なし=NULL）/各言語」を提供する