**ATENÇÃO:** *Este projeto _não está pronto_ para ser usado. Seu código está disponível aqui apenas para tornar mais fácil que outros programadores acompanhem seu desenvolvimento.*

Para desenvolver este projeto, é necessário que seu sistema operacional tenha [npm](http://npmjs.com), [bower](http://bower.io) e [grunt](http://gruntjs.com).

### Dependências ###

Para instalar as dependências necessárias para o desenvolvimento, depois de instalar **npm** e **bower**, use:

```sh
$ npm install
$ bower install
```

### Desenvolvimento ###

Para desenvolver, certifique-se de ter instalado **grunt** e as dependências acima, e use:

```sh
$ grunt dev
```

O Grunt vai checar modificações no diretório `src`, gerar arquivos correspondentes no diretório `build` e copiar esses arquivos para o diretório `/var/www/dolores/wp-content/themes/dolores` (contanto que essa pasta exista e seu usuário tenha permissão para escrever nela).

Para ver as modificações, basta instalar um WordPress em `/var/www/dolores/` e configurá-lo para usar o tema *Dolores*.

### Produção ###

Em breve.
