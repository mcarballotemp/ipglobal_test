phpstan:
	docker-compose exec phpfpm composer phpstan

csfix:
	docker-compose exec phpfpm composer csfix