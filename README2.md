Cài đặt redis, laravel-echo-server, socket.io:


- link cài redis : 
https://github.com/microsoftarchive/redis/releases?fbclid=IwAR1syvTfOrg0MZT2qxez4AEujYxwW8rthfNL6OFFmzWCDyaGdT34Drfb5yg 
bản .msi
- npm install
- npm install -g laravel-echo-server
- composer require predis/predis
- laravel-echo-server init
- npm install --save socket.io-client@2.3.0
- npm install --save laravel-echo
- npm install laravel-mix --save-dev
- npx mix hoặc npx mix watch

- Vào file .env sửa thành thế này
BROADCAST_DRIVER=redis
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

- Khởi động Laravel-echo-server: laravel-echo-server start
- Khởi động Redis server: redis-server --port 1000
-  không cần chạy : redis-cli -p 1000

- Để chạy các listener để xử lý các event này, bạn cần setup hệ thống job listener chạy để xử lý các sự kiện: -------  php artisan queue:work   ------
- Lưu ý rằng, chạy command này thì phần code xử lý sẽ được lưu vào bộ nhớ, do đó khi có sự thay đổi về code xử lý, bạn cần restart lại queue sử dụng command: ------ php artisan queue:restart  -----

