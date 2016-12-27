<?php

namespace Yangyao\Queue\Contracts;
interface Task
{
	//执行计划任务的方法
    function exec($params=null);
}
