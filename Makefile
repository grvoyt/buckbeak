build:
	npm i && npm run build && rm -rf node_modules && \
	composer i -q && php artisan migrate --seed  && \
	composer i --no-dev -o -q && \
	php artisan optimize -q

start:
	cp .env.example .env && \
	php artisan key:generate
	docker compose up -d && \
	docker compose exec app make build
