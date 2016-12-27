#!/usr/bin/env php
<?php


$root_dir = realpath(dirname(__FILE__).'/../../');
$script_dir = $root_dir.'/script';
require_once($script_dir."/lib/runtime.php");

$queues = config::get('queue.queues', array());

$list = array_keys($queues);

echo @implode(' ', $list);
