<?php
namespace Yangyao\Queue\Facades;
use Illuminate\Support\Facades\Facade;
class Queue extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Queue';
    }
}