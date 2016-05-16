*We do not support any language other than Portuguese at the moment.*

**ATENÇÃO:** *Este projeto está em _constante desenvolvimento_, no momento focado no [Se a cidade fosse nossa](http://seacidadefossenossa.com.br/) (scfn) e no [Compartilhe a mudança](https://compartilheamudanca.com.br/).*

Para desenvolver este projeto, é necessário que seu sistema operacional tenha [npm](http://npmjs.com), [bower](http://bower.io), [grunt](http://gruntjs.com), [Compass](http://compass-style.org/) e [Composer](https://getcomposer.org/).

### Dependências ###

Para instalar as dependências necessárias para o desenvolvimento, depois de instalar **npm**, **bower** e **composer**, use:

```sh
$ make install-dev
```

### Desenvolvimento ###

Para desenvolver, certifique-se de ter instalado **grunt**, **Compass** e as dependências acima, e use:

```sh
$ make dev
```

O Grunt vai checar modificações no diretório `src`, gerar arquivos correspondentes no diretório `build` e copiar esses arquivos para o diretório `/var/www/dolores/wp-content/themes/dolores` (contanto que essa pasta exista e seu usuário tenha permissão para escrever nela).

Para ver as modificações, basta instalar um [WordPress](http://wordpress.org/) em `/var/www/dolores/` e configurá-lo para usar o tema **Dolores**.

### Configuração ###

- Para que os usuários cadastrados sejam sincronizados com uma lista do Mailchimp, as constantes `MAILCHIMP_API_KEY` e `MAILCHIMP_LIST_ID` devem estar definidas em `wp-config.php`.
- Para habilitar login via Facebook, as constantes `FACEBOOK_APP_ID` e `FACEBOOK_APP_SECRET` devem estar definidas em `wp-config.php`.
- Para habilitar login via Google, as constantes `GOOGLE_CLIENT_ID` e `GOOGLE_CLIENT_SECRET` devem estar definidas em `wp-config.php`.
- Para ativar debates para localizações que tenham apenas mais do que um determinado número de usuários, defina a constante `DOLORES_ACTIVE_LOCATION_THRESHOLD`.
- Para ativar posts relacionados, você deve instalar o plugin YARPP (Yet Another Related Posts Plugin).
- Para usar o template do **Compartilhe a mudança**, deve-se ainda definir a constante `DOLORES_TEMPLATE` com o valor `cam`.

### Versão do WordPress ###

A partir da versão 4.4.0, o WordPress suporta [metadados para taxonomias](https://core.trac.wordpress.org/ticket/10142). Se você usa uma versão >= 4.4.0, não é preciso instalar nenhum plugin para fazer o tema funcionar.

Se você usa versões mais antigas, este tema requer o plugin [Taxonomy Metadata](https://wordpress.org/plugins/taxonomy-metadata/).

### Produção ###

Para colocar suas modificações em produção (se você tiver permissão para fazer isso), use:

```sh
$ make prod
$ make deploy-scfn
```

Isso vai rodar `grunt prod` para gerar arquivos minificados em `dist/` e `script/deploy.sh` para copiar os arquivos gerados para produção.

### Screenshot ###

![Se a cidade fosse nossa](https://raw.githubusercontent.com/tmadeira/dolores/master/static/images/scfn/screenshot.png)
