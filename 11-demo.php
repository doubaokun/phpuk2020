<?php
$server = new Swoole\Websocket\Server("0.0.0.0", 9501, SWOOLE_BASE);

$server->set([
    'document_root' => '/app/',
    'enable_static_handler' => true,
]);

$buffer = '';
$timers = [];
$server->on('workerStart', function($server) {
    Swoole\Timer::tick(1000, function() use ($server) {
        global $buffer;
        // echo | htop | aha --line-fix  > /tmp/htop.out
        $ret = Swoole\Coroutine\System::exec('export TERM=xterm-color; export COLUMNS=200; /bin/echo | /usr/bin/htop | /usr/bin/aha --black --line-fix');
        $buffer = $ret['output'];
    });
});

$server->on('open', function(Swoole\WebSocket\Server $server, Swoole\Http\Request $request) {
    echo "connection open: {$request->fd}\n";
    $tid = Swoole\Timer::tick(1000, function() use ($server, $request) {
        global $buffer;
        global $timers;
        $server->push($request->fd, json_encode(["output" => 1, 'id' => $request->fd, "data" => $buffer, 'total' => count($timers)]));
    });
    global $timers;
    $timers[$request->fd] = $tid;
});

$server->on('request', function($request, $response) {
    $response->redirect('/ws.html');
});

$server->on('message', function($server, $frame) {
    echo "received message: {$frame->data}\n";
    
});

$server->on('close', function($server, $fd) {
    echo "connection close: {$fd}\n";
    global $timers;
    Swoole\Timer::clear($timers[$fd]);
    unset($timers[$fd]);
});

$server->start();