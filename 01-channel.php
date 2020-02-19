<?php

$chan = new Swoole\Coroutine\Channel(1);
Co\run(function () use ($chan) {
    $cid = Swoole\Coroutine::getCid();
    $i = 0;
    while (1) {
        co::sleep(0.9);
        $chan->push(['rand' => rand(1000, 9999), 'index' => $i]);
        echo "[co $cid] - $i\n";
        $i++;
    }
});
Co\run(function () use ($chan) {
    $cid = Swoole\Coroutine::getCid();
    while(1) {
        $data = $chan->pop();
        echo "[co $cid]\n";
        print_r($data);
    }
});