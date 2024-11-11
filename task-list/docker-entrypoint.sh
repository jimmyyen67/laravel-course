#!/bin/bash

# 等待 SQLite 容器準備就緒
sleep 5

# 建立 SQLite 資料庫檔案（如果不存在）
if [ ! -f /var/www/html/database/database.sqlite ]; then
    mkdir -p /var/www/html/database
    touch /var/www/html/database/database.sqlite
    chmod 777 /var/www/html/database/database.sqlite
fi

# 執行遷移和填充資料
php artisan migrate --force

# 啟動 Laravel 開發伺服器
php artisan serve --host=0.0.0.0 --port=8000
