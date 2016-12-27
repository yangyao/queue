<?php


namespace Yangyao\Queue\Contracts;
interface Message{
    public function get_worker();
    public function get_params();
}
