<?php
namespace Illuminate\Queue\Console;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Yangyao\Queue\Queue;
use Illuminate\Config\Repository as Config;
class ConsumerQueueCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task-queue:consumer';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '消费一个queue';
    /**
     * Execute the console command.
     *
     * todo 这里的配置文件路径应该定义为一个常量
     * @return void
     */
    public function fire()
    {
        $queue = $this->input->getOption('queue');
        $config_file = require(__DIR__.'../../config/queue.php');
        $conf = new Config($config_file);
        if($message = Queue::instance($conf)->get($queue)){
            Queue::instance($conf)->run($message);
            Queue::instance($conf)->ack($message);
        }
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['queue', null, InputOption::VALUE_OPTIONAL, '需要消费的queue名称', null]
        ];
    }
}