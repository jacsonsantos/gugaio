<?php
$app->on(
    'mailer',
    array(
        new JSantos\Listener\MailerListener($app),
        'onSend'
    )
);