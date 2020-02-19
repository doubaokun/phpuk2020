<?php

$id = Swoole\Timer::tick(100, function () {
    echo "⚙️ Do something...\n";
});
Swoole\Timer::after(500, function () use ($id) {
    Swoole\Timer::clear($id);
    echo "⏰ Done\n";
});
Swoole\Timer::after(1000, function () use ($id) {
    if (!Swoole\Timer::exists($id)) {
        echo "✅ All right!\n";
    }
});
