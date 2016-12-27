<?php
namespace Illuminate\Queue\Console;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
class ListQueueCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task-queue:list';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'echo配置文件中所有的queue给shell脚本调用';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $config_file = require(__DIR__.'../../config/queue.php');
        $conf = new Config($config_file);
        $queues = $conf->get('queue.queues');
        $list = array_keys($queues);
        echo @implode(' ', $list);
    }
}