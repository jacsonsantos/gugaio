![gugaio](http://oi63.tinypic.com/ab1en7.jpg)
# Gugaiô - Framework
O Gugaiô é um framework PHP, desenvolvido com Silex e outros componentes, o mesmo já tem disponivel o ORM Eloquent, assim facilitando a manipulado de dados.
O Gugaiô foi feito para facilitar o desenvolvimento de APIs, pois o mesmo já vem com autenticação JWT, assim aumentando a segunça a cada requisição.

## Sobre
O Gugaiô foi desenvolvido com [Silex](https://silex.sensiolabs.org) na versão 2.0. Então você pode trabalhar tranquilamente com todas funcionalidades do mesmo no Gugaiô.
O ORM utilizado no Gugaiô é o [Eloquent](https://github.com/illuminate/database), assim facilitando a manipulação de dados igual ao [Laravel](https://laravel.com).

## Sumario
* Iniciando
* Configurando
* Token
* Email
* Banco de Dados
* Rotas
* Model
* Controller
* Views
* Comandos gugaio

## Iniciando
```
git clone https://github.com/jacsonsantos/gugaio.git
cd gugaio
composer install
```

## Configurando
Primeiro execute o seguinte comando:
```
php gugaio make:config
```
Após executar o comando anterior, será gerado o seguinte arquivo **config.yml**, agora já podemos configurar a aplicação.
<br>Abrir *config.yml*.
```
DEBUG: true
```
O campo *DEBUG* habilita o Debug da aplicação
```
VERSION: v1
```
Versão da API

## Token
```
TOKEN:
    SECRET: 'yourSecret'
    ISS: ''
    JTI: '4f1g23a12aa'
    REMOTE: 'HMAC'
    EXPIRES: 3600
```
Configuração para gerar token. Por padrão já vem configurado, faltando apenas sua chave de segurança (assinatura) em *SECRET*.
<br>Para gerar token utilizamos a seguinte lib: *lcobucci/jwt* na versão 3.2. Para mais informações acesse [lcobucci/jwt](https://github.com/lcobucci/jwt).
<br>Para gerar token use o seguinte provider:
```php
//Gerar Token
$token = $app['jwt']->generateToken();
```
```php
//Valida Token
$app['jwt']->validateToken($token);
```

## Email
Para trabalhar com envio e recebimento de e-mails, informe as credenciais do mesmo.
```
USER:
    USERNAME: ''
    PASSWORD: ''
```
Para envio de email foi utilizado a seguinte lib: *swiftmailer/swiftmailer* na versão 5.4. Para mais informações acesse [swiftmailer/swiftmailer](http://swiftmailer.org/docs/introduction.html).
<br>Registrando Serviço de Email:
```
php gugaio register:mailer
```
Instale o SwiftMailer antes de usar o serviço *mailer*
```
composer require swiftmailer/swiftmailer
```
<br>Como enviar e-mails:
```php
$message = \Swift_Message::newInstance();
$app['mailer']->send($message);
```
Saiba mais [aqui](http://swiftmailer.org/docs/introduction.html).

Para receber de email foi utilizado a seguinte lib: *ddeboer/imap* na versão 0.5.2. Para mais informações acesse [ddeboer/imap](https://github.com/ddeboer/imap).
É necessario baixar o ddeboer/imap, para isso use:
```
composer require ddeboer/imap
```
Depois registre:
```
php gugaio register:imap
```
Como usar:
```php
$mailbox = $app['imap.connection']->getMailbox('INBOX');
```
Saiba mais [aqui](https://github.com/ddeboer/imap).

## Banco de Dados
Informe os dados necessarios de seus banco.
```
DB:
    DRIVE: 'mysql'
    HOST: 127.0.0.1
    DBNAME: ''
    PORT: 3306
    USERNAME: ''
    PASSWORD: ''
    CHARSET: 'utf8'
    COLLATION: 'utf8_unicode_ci'
    PREFIX: ''
```
Como usar o provider de conexão.
```php
$prepare = $app['connection']->prepare($sql);
$prepare->execute();
```
Trabalhando com Model usando Eloquent ORM.<br>
Para criar um novo Model use:
```
php gugaio make:model MyNewModel
```
Saiba mais [aqui](https://laravel.com/docs/5.4/eloquent#eloquent-model-conventions).

## Rotas
Todas as rotas estão centralizadas no diretorio *src/Router*.<br>
No diretorio Router possui dois arquivos, *Router* e *RouterAuth*.<br>

#### Router
O arquivo *Router.php* fica todas as rotas sem validação de Token.<br>
**Como adicionar uma nova Rota** <br>
*Exemplo 01*. http://seuurl.com/v1/users
```php
$router->get('/users', function () {
        return JSantos\Model\User::all();
    });
```
*Exemplo 02*.http://seuurl.com/v1/users
```php
$router->get('/users', 'user:index');
```
*Exemplo 03*.http://seuurl.com/users/{id}
```php
$app->mount('/users', function ($users) use ($app) {
    //exe01
    $users->get('/{id}', function ($id) {
        return JSantos\Model\User::find($id);
    });
    //exe02
    $users->get('/{id}', 'user:index');
});
```
#### RouterAuth
O arquivo *RouterAuth.php* fica todas as rotas com validação de Token por requisição.<br>
**Como adicionar uma nova Rota** <br>
*Exemplo 01*.<br>
GET - *http://seuurl.com/v1/api/users*
```php
$auth->get('/users', function () {
        return JSantos\Model\User::all();
    });
```
*Exemplo 02*.<br>
POST - *http://seuurl.com/v1/api/users*
```php
$auth->get('/users', 'user:read');
$auth->post('/users', 'user:create');
$auth->put('/users', 'user:update');
$auth->delete('/users', 'user:delete');
```
### Criando Rotas por Comandos
Com *make:router* você pode criar um grupo de rotas para o serviço de um Controller<br>
*--service* recebe o nome do serviço registrado para seu Controller.<br>
<br>**Exemplo:**
```
php gugaio make:router product --service=product
```
**Resultado:**<br>
Em: /src/Router/Router.php
```php
$app->mount($app['api_version'], function ($router) use ($app) {
	$router->get('/product', 'product:read');
	$router->get('/product/{id}', 'product:get');
	$router->post('/product', 'product:create');
	$router->put('/product', 'product:update');
	$router->delete('/product/{id}', 'product:delete');
});
```
Você tambem pode passar o nome do grupo de rotas, usando *--group*.
```
php gugaio make:router product --service=product --group=products
```
**Resultado:**<br>
Em: /src/Router/Router.php
```php
$app->mount($app['api_version'].'/products', function ($products) use ($app) {
    $products->get('/product', 'product:read');
    $products->get('/product/{id}', 'product:get');
    $products->post('/product', 'product:create');
    $products->put('/product', 'product:update');
    $products->delete('/product/{id}', 'product:delete');
});
```
Para criar apenas um rota simples com um metodo HTTP, use:
```
php gugaio make:router product --method=get
```
*Resultado:*<br>
Em /src/Router/Router.php
```php
$app->get($app['api_version'].'/product', function() use ($app) {
 
});
```
**Para Criar Rotas com Autenticação JWT use --auth=true:**
```
php gugaio make:router product --service=product --auth=true
```
Resultado:<br>
Em: /src/Router/RouterAuth.php
```php
    $auth->get('/product', 'product:read');
    $auth->get('/product/{id}', 'product:get');
    $auth->post('/product', 'product:create');
    $auth->put('/product', 'product:update');
    $auth->delete('/product/{id}', 'product:delete');
```
**Rotas simple com JWT**
```
php gugaio make:router product --method=post --auth=true
```
Resultado:<br>
Em: /src/Router/RouterAuth.php
```php
    $auth->post($app['api_version'].'/product', function() use ($app) {
    
    });
```
## Model
Para Trabalhar com Model no Gugaiô é muito facil, o mesmo possui Eloquent ORM.<br>
Para criar um novo Model use:
```
php gugaio make:model MyNewModel
```
Saiba mais [aqui](https://laravel.com/docs/5.4/eloquent#eloquent-model-conventions).
<br>
Caso não goste de usar ORM, você pode usar o serviço *$app['connection']*, onde o mesmo te entrega uma instancia PDO.<br>
Você tambem pode fazer um *CRUD* facilmente extendendo a classe *Repository* ou usando:
```
php gugaio make:repo MyRepository
```
## Controller
Para criar um Controller use:
```
php gugaio make:controller MyController
```
Resultado:<br>
*src/Controller/MyController.php*
```php
<?php
namespace JSantos\Controller;
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
 
class MyController extends Controller
{
    
}
```
Você pode trabalhar com o Controller como um serviço, mas primeiro deve registrar o mesmo.<br>
**Registrando Controller como Serviço**
 ```
 php gugaio register:controller MyController --name=my
 ```
 Caso não informe a opção *--name*, o serviço terá o mesmo nome do Controller em letra minuscula.
 
 ## Views
 Você pode tambem trabalhar com views no Gugaio, por padrão está configurado para trabalhar com [Twig](https://twig.sensiolabs.org/).
 Como trabalhar com views no Gugaiô:
 ```
 php gugaio make:view
 ```
 Cria o diretorio *Views* na pasta *src*. Agora use:
 ```
 php gugaio register:twig
 ```
 Depois de registrar o serviço do Twig, será necessario baixar o mesmo.
 ```
 composer require twig/twig
 ```
 Pronto! Você já pode começar a criar suas views, saiba mais [aqui](https://twig.sensiolabs.org/doc/2.x/).
 
 ## Comandos gugaio
 #### make
 * **php gugaio make:config** - Cria o arquivo principal de configuração de sua aplicação.
 * **php gugaio make:controller** - Cria um novo *Controller*.
 * **php gugaio make:model** - Cria um novo *Model*.
 * **php gugaio make:repo** - Cria um novo *File Repository* com *CRUD* pronto.
 * **php gugaio make:view** - Cria o diretorio *Views* dentro de *src* para trabalhar com views do Twig.
 * **php gugaio make:router** - Cria rotas para sua aplicação com ou sem Auth JWT.
 #### register
 * **php gugaio register:controller** - Registra seu Controller como serviço, use *--name* para definir o nome do serviço.
 * **php gugaio register:imap** - Registra o serviço para recebimento de e-mails.
 * **php gugaio register:mailer** - Registra o serviço para envio de e-mails.
 * **php gugaio register:twig** - Registra o serviço do Twig para trabalhar com views.