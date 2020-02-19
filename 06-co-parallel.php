<?php

$domains = [
    'www.google.com',
    'www.facebook.com',
    'www.cnn.com',
    'katsanas.com',
    'kamerabayi.com',
    'gizgi.com',
    'getnetworth.com',
    'evcilavm.com',
    'normandale.edu',
    'norfolkpublicschools.org'
];

$scheduler = new Co\Scheduler;
$scheduler->parallel(10, function () use ($domains) {
    
    foreach($domains as $domain) {
        $ip = Swoole\Coroutine::dnsLookup($domain, 10);
        print_r([ $domain, $ip]);
    }
});

$scheduler->start();