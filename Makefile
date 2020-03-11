.PHONY: qa
qa: vendor
	docker run --rm -it -v ${PWD}:/app:rw -w /app zdenekdrahos/phpqa:v1.23.3 phpqa

vendor: composer.json composer.lock
	docker run --rm -it -v ${PWD}:/app:rw -w /app composer:latest validate
	docker run --rm -it -v ${PWD}:/app:rw -w /app composer:latest install
	docker run --rm -it -v ${PWD}:/app:rw -w /app composer:latest normalize
