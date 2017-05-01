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
GET - *http://seuurl.com/v1/auth/users*
```php
$auth->get('/users', function () {
        return JSantos\Model\User::all();
    });
```
*Exemplo 02*.<br>
POST - *http://seuurl.com/v1/auth/users*
```php
$auth->post('/users', 'user:create');
```
*Exemplo 03*.<br>
GET - *http://seuurl.com/product/{slug}*<br>
POST - *http://seuurl.com/product/*
```php
$app->mount('/product', function ($product) use ($app) {
    //exe01-router
    $product->get('/{slug}', function ($slug) {
        return JSantos\Model\Product::find($slug);
    });
    //exe02-router
    $product->post('/', 'product:create');
    
    $product->before(function (Request $request) use ($app) {
        $token = $request->headers->get('Authorization');
        $token = trim(str_replace('Bearer ', '', $token));
    
        $jwt = $app['jwt'];
        $jwt->setApplication($app);
    
        if (!$jwt->validateToken($token)) {
            $response = new JsonResponse(['token invalid'],401);
            return $response;
        }
    });
});
```