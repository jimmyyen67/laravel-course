#!/bin/bash
set -e

# 等待 MySQL 準備好
while ! php artisan db:monitor > /dev/null 2>&1; do
    sleep 1
done

# 只在有待處理的遷移時才執行
if php artisan migrate:status | grep -q "Pending"; then
    echo "Running pending migrations..."
    php artisan migrate --force
fi

# 啟動 Laravel 開發伺服器
php artisan serve --host=0.0.0.0 --port=8000
