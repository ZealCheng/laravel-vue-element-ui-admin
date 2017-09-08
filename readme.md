
# 基于laravel5.4的后台管理

### 安装说明


* 下载项目后 执行 sudo composer install
* copy .env.example 为 .env 设置数据配置 设置后台域名或者前缀 不能同时设置，未做处理
* php artisan key:generate 生成密钥
* 安装 sudo npm install
* sudo npm run dev
* php artisan migrate
* php artisan migrate:refresh --seed
