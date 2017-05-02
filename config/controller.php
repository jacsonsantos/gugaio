<?php
$app['auth'] = function (Pimple\Container $app) {
	return new JSantos\Controller\AuthController($app);
};