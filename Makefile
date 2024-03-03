phpstan:
	docker-compose exec phpfpm composer phpstan

csfix:
	docker-compose exec phpfpm composer csfix

test:
	docker-compose exec phpfpm composer test

testunit:
	docker-compose exec phpfpm composer test-unit

testfunc:
	docker-compose exec phpfpm composer test-func