help:
	@echo "See Makefile or documentation in https://github.com/tmadeira/dolores/"

clean:
	rm -rf build/
	rm -rf dist/

clean-all: clean clean-dev

clean-dev:
	rm -rf bower_components/
	rm -rf node_modules/
	rm -rf composer.lock vendor/

dev:
	grunt dev

deploy-scfn:
	script/deploy.sh scfn seacidadefossenossa.com.br

install-dev: bower.json package.json
	npm install
	bower install
	composer install

prod:
	grunt prod
