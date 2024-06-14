# 1.  composer install --ignore-platform-reqs
# 2.  cp .env.example .env
# 3.  chmod 777 -R .env storage
# 4.  Задать параметры подключения к бд в .env
# 5.  vendor/bin/sail up -d
# 6.  vendor/bin/sail artisan migrate --seed
# 7.  vendor/bin/sail artisan api:create user
# 8.  Скопировать token из терминала
# 9.  vendor/bin/sail artisan cities:parse
# 10. Открыть localhost в браузере
# 11. Проверить api методы, используя полученный на шаге 7 токен