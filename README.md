cp .env.example .env

```dotenv
#для контейнера БД
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=buckbeak
DB_USERNAME=buckbeak
DB_PASSWORD=buckbeak

#для работы пушера
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME="https"
PUSHER_APP_CLUSTER="eu"
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
```


запуск 

```shell
git clone ...
make start
```
