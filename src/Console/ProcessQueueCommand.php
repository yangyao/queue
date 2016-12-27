<?php
namespace Yangyao\Queue\Console;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Yangyao\Queue\Consumer;
use Illuminate\Config\Repository as Config;
class ProcessQueueCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'task-queue:process';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '开启一个queue进程';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $queue = $this->input->getOption('queue');
        $config_file = require(__DIR__.'../../config/queue.php');
        $conf = new Config($config_file);
        $queues = $conf->get('queue.queues');
        if ($num = (int)$queues[$queue]['thread']) {
            with(new Consumer())->exec($queue, $num);
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