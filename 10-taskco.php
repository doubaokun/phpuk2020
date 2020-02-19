<?php

$server = new Swoole\Http\Server("0.0.0.0", 9501, SWOOLE_BASE);

$server->set([
    'worker_num' => 1,
    'task_worker_num' => 2,
]);
$server->on('Request', function ($request, $response) use ($server) {
    $tasks[0] = ['time' => 0];
    $tasks[1] = ['data' => 'www.swoole.co.uk', 'code' => 200];
    $result = $server->taskCo($tasks, 1.5);
    $response->end('<pre>Task Result: '.var_export($result, true));
});
$server->on('Task', function (Swoole\Server $server, $task_id, $worker_id, $data) {
    if ($server->worker_id == 1) {
        sleep(1);
    }
    $data['done'] = time();
    $data['worker_id'] = $server->worker_id;
    return $data;
});

echo "Swoole http server is started at http://0.0.0.0:9501\n";
$server->start();