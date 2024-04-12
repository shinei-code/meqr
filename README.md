# MeQR
環境構築手順
本番と開発環境は基本的に同じ。
違う部分
- 開発: `docker-compose -f docker-compose.dev.yml 〜 `
- 本番: `docker-compose -f docker-compose.prod.yml 〜 `

## 各環境に合わせてenvファイルをコピー
- 開発: `cp .env.dev .env`
- VPS: `cp .env.vps .env`
- 本番: `cp .env.prod .env`

## コンテナのビルド
```
docker-compose -f docker-compose.dev.yml build --build-arg PUID=$(id -u) --build-arg PGID=$(id -g) 
```

## コンテナ起動
```
docker-compose -f docker-compose.dev.yml up -d
```

## バックエンド構築
```
docker-compose -f docker-compose.dev.yml exec backend composer install
docker-compose -f docker-compose.dev.yml exec backend cp .env.example .env
docker-compose -f docker-compose.dev.yml exec backend php artisan key:generate
docker-compose -f docker-compose.dev.yml exec backend php artisan migrate
```

## 最新ソース取り込み
```
# dockerサービス停止
docker-compose -f docker-compose.dev.yml stop

# 最新ソース
git pull

# dockerサービス起動
docker-compose -f docker-compose.dev.yml up -d
```

### マスタデータ(codes)インポート
* 下記CSVからインポートします。
* ファイル: database/seeders/csv/codes.csv
```
docker-compose exec backend php artisan db:seed --class=CodesFromCsvSeeder
```

## トップページ
http://localhost:8080
