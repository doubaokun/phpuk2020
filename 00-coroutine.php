<?php

Co\run(function() {

    $co1 = go(function() {
        echo "1\n";
        Co::yield();
        echo "2\n";
    });

    $co2 = go(function() {
        echo "3\n";
        Co::yield();
        echo "4\n";
    });

    echo "start\n";
    Co::resume($co1);
    Co::resume($co2);
});