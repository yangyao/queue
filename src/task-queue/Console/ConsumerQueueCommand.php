<?php
namespace Illuminate\Queue\Console;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Yangyao\Queue\Queue;
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
     * @return void
     */
    public function fire()
    {
        $queue = $this->input->getOption('queue');
        if($message = Queue::instance()->get($queue)){
            Queue::instance()->run($message);
            Queue::instance()->ack($message);
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