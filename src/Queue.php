<?php

namespace Yangyao\Queue;
use Yangyao\Queue\Adapter\AbstractAdapter;
use Yangyao\Queue\Adapter\AdapterMysql;
use Yangyao\Queue\Message\AbstractMessage;
use Yangyao\Queue\Contracts\Task;
use Illuminate\Contracts\Config\Repository as Config;

class Queue{

    static private $__instance = null;

    static private $__config = null;

    private $__adapter = null;

    static public function instance(Config $config){
        if (!isset(self::$__instance)) {
            self::$__config = $config;
            self::$__instance = new self(self::$__config);
        }
        return self::$__instance;
    }

    private function __construct(Config $config){
        $adapter = $config->get('queue.default', AdapterMysql::class);
        if ($adapter instanceof AbstractAdapter) {
            $this->__adapter = $adapter;
        }else{
            throw new \Exception('this instance must extends AbstractAdapter');
        }
    }

    public function publish($exchange_name, $worker, $params=array()){
        $queues = self::$__config->get('bindings')[$exchange_name];
        if (!isset($queues)){
            $queues = array(self::$__config->get('queue.default_publish_queue'));
        }
        foreach($queues as $queue_name){
            $queue_data = array(
                'queue_name' => $queue_name,
                'worker' => $worker,
                'params' => $params,
            );
            $this->__adapter->publish($queue_name, $queue_data);
        }
        return true;
    }

    public function get($queue_name){
        $message = $this->__adapter->get($queue_name);
        if ($message instanceof AbstractMessage){
            return $message;
        }
        return false;
    }

    public function ack($queue_message){
        $this->__adapter->ack($queue_message);
    }

    public function run(AbstractMessage $message){
        $worker = $message->get_worker();
        $params = $message->get_params();
        $obj_task = new $worker();
        if ($obj_task instanceof Task) {
            call_user_func_array(array($obj_task, 'exec'), array($params));
        }
        return true;
    }

    public function purge($queue_name){
        $this->__adapter->purge($queue_name);
    }

    public function is_end($queue_name){
        return $this->__adapter->is_end($queue_name);
    }
}
