<?php
    //Use the Object $auth to add new rota
    $auth->post('/login', 'auth:login');
    $auth->post('/logout', 'auth:logout');