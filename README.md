*We do not support any language other than Portuguese at the moment.*

**ATENÇÃO:** *Este projeto _não está pronto_ para ser usado. Seu código está disponível aqui apenas para tornar mais fácil que outros programadores acompanhem seu desenvolvimento.*

Para desenvolver este projeto, é necessário que seu sistema operacional tenha [npm](http://npmjs.com), [bower](http://bower.io), [grunt](http://gruntjs.com) e [Composer](https://getcomposer.org/).

### Dependências ###

Para instalar as dependências necessárias para o desenvolvimento, depois de instalar **npm**, **bower** e **composer**, use:

```sh
$ make install-dev
```

### Desenvolvimento ###

Para desenvolver, certifique-se de ter instalado **grunt** e as dependências acima, e use:

```sh
$ make dev
```

O Grunt vai checar modificações no diretório `src`, gerar arquivos correspondentes no diretório `build` e copiar esses arquivos para o diretório `/var/www/dolores/wp-content/themes/dolores` (contanto que essa pasta exista e seu usuário tenha permissão para escrever nela).

Para ver as modificações, basta instalar um [WordPress](http://wordpress.org/) em `/var/www/dolores/` e configurá-lo para usar o tema **Dolores**.

### Produção ###

Para colocar suas modificações em produção (se você tiver permissão para fazer isso), use:

```sh
$ make prod
$ make deploy
```

Isso vai rodar `grunt prod` para gerar arquivos minificados em `dist/` e `script/deploy.sh` para copiar os arquivos gerados para produção.
