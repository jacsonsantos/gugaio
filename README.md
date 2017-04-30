# Gugaiô - Framework
O Gugaiô é um framework PHP, desenvolvido com Silex e outros componentes, o mesmo já tem disponivel o ORM Eloquent, assim facilitando a manipulado de dados.
O Gugaiô foi feito para facilitar o desenvolvimento de APIs, pois o mesmo já vem com autenticação JWT, assim aumentando a segunça a cada requisição.

##Iniciando
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
```
TOKEN:
    SECRET: 'yourSecret'
    ISS: ''
    JTI: '4f1g23a12aa'
    REMOTE: 'HMAC'
    EXPIRES: 3600
```
Configuração para gerar token. Por padrão já vem configurado, faltando apenas sua chave de segurança (assinatura) em *SECRET*.
<br>Para gerar token utilizamos a seguinte lib: *lcobucci/jwt* na versão 3.2. para mais informações acesse [lcobucci/jwt](https://github.com/lcobucci/jwt).
<br>Para gerar token use o seguinte provider:
```php
//Gerar Token
$token = $app['jwt']->generateToken();
```
```php
//Valida Token
$app['jwt']->validateToken($token);
```