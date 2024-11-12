#!/bin/bash

# 執行遷移和填充資料
php artisan migrate --force

# 啟動 Laravel 開發伺服器
php artisan serve --host=0.0.0.0 --port=8000
