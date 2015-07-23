help:
	@echo "See Makefile or documentation in https://github.com/tmadeira/dolores/"

clean:
	rm -rf build/
	rm -rf dist/

clean-all: clean clean-dev

clean-dev:
	rm -rf bower_components/
	rm -rf node_modules/

dev:
	grunt dev

deploy:
	script/deploy.sh dolores_rj seacidadefossenossa.com.br

install-dev: bower.json package.json
	npm install
	bower install

prod:
	grunt prod
