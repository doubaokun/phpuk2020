<?php

$table = new Swoole\Table(1024, 0.5);

$table->column('id', Swoole\Table::TYPE_INT, 8);
$table->column('name', Swoole\Table::TYPE_STRING, 32);

$table->create();

$table->set('key1', ['id' => 1, 'name' => 'foo']);
$table->set('key2', ['id' => 2, 'name' => 'bar']);

var_dump($table->get('key1', 'name'));
var_dump($table->memorySize);

foreach ($table as $key => $row) {
    print_r($row);
}