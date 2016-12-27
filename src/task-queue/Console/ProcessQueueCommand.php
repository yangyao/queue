<?php
namespace Yangyao\Queue\Console;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Yangyao\Queue\Queue;
use Yangyao\Queue\Consumer;
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
        $queues = Queue::instance()->get_config('queues');
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