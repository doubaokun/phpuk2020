<?php

Co\run(function() {

    go(function() {
        echo Co::getCid(). "\n";
        echo Co::getPcid(). "\n";

        go(function() {
            echo Co::getCid(). "\n";
            echo Co::getPcid(). "\n";
        });
    });

});
