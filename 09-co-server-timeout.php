<?php
$server = new Swoole\HTTP\Server("0.0.0.0", 9501);

$server->on("start", function (Swoole\Http\Server $server) {
    echo "Swoole http server is started at http://0.0.0.0:9501\n";
});

$server->on("request", function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
    $max_execution_ms = 500;
    $timer = Swoole\Timer::after($max_execution_ms , function() use ($response, $max_execution_ms) {
        if(!$response->output) {
            $response->output = 1;
            $response->header("Content-Type", "text/plain");
            $response->end("Timeout after {$max_execution_ms}ms\n");
        }
    });

    // your application layer latency
    co::sleep(0.3);
    if(!$response->output) {
        $response->output = 1;
        $response->header("Content-Type", "text/plain");
        $response->end("Hello World\n");
    }

    Swoole\Timer::clear($timer);
});

$server->start();