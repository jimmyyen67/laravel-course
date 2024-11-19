#!/bin/bash
set -e

# 檢查是否可以連接到 MySQL
wait_for_mysql() {
    echo "等待 MySQL 啟動..."
    while ! nc -z mysql 3306; do
        sleep 1
    done
    echo "MySQL 已啟動"
}

# 檢查並安裝 Composer 依賴
check_and_install_composer() {
    if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
        echo "未檢測到 vendor 目錄或 autoload.php，開始安裝依賴..."
        if [ -f "composer.lock" ]; then
            echo "檢測到 composer.lock，使用 composer install..."
            composer install --no-interaction
        else
            echo "未檢測到 composer.lock，使用 composer update..."
            composer update --no-interaction
        fi
    else
        echo "Composer 依賴已安裝"
    fi
}

# 檢查是否需要執行遷移
check_and_migrate() {
    echo "檢查資料庫連接..."
    wait_for_mysql

    # 檢查資料庫中是否有 migrations 表
    if php artisan migrate:status 2>/dev/null | grep -q "Migration table not found."; then
        echo "Migration 表不存在，執行初始遷移..."
        php artisan migrate --force
        echo "執行資料填充..."
        php artisan db:seed --force
    else
        PENDING_MIGRATIONS=$(php artisan migrate:status | grep -c "N")
        if [ "$PENDING_MIGRATIONS" -gt 0 ]; then
            echo "檢測到 $PENDING_MIGRATIONS 個待執行的遷移..."
            php artisan migrate --force
            echo "執行資料填充..."
            php artisan db:seed --force
        else
            echo "資料庫已是最新狀態"
        fi
    fi
}

# 檢查並設置目錄權限
setup_permissions() {
    echo "設置存儲目錄權限..."
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
}

# 主要執行流程
echo "開始容器初始化流程..."
check_and_install_composer
setup_permissions
check_and_migrate
echo "初始化完成"

# 執行傳入的命令（Dockerfile 中的 CMD 指令會在邊執行）
exec "$@"
