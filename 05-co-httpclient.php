<?php

Co\run(function() {
    go(function() {
        $cli = new Co\Http\Client('www.swoole.co.uk', 443, true);
        $cli->get('/');
        var_dump($cli->statusCode);
        $cli->close();
    });
    go(function() {
        $cli = new Co\Http\Client('www.google.com', 443, true);
        $cli->get('/');
        var_dump($cli->statusCode);
        $cli->close();
    });
});