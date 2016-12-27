<?php

namespace Yangyao\Queue\Adapter;
use Yangyao\Queue\Handler\MysqlHandler;
use Yangyao\Queue\Message\MessageMysql;
class AdapterMysql extends AbstractAdapter{

    private $__handler;

    function __construct(MysqlHandler $handler){

        $this->__handler = $handler;
    }

    /**
     * 添加一个队列任务
     *
     * @param string $queue
     * @param array $queue_data todo $queue_data 如果是一个对象那么会好很多。
     *
     * @return bool
     */
    public function publish($queue_name,$queue_data){
        $time = time();
        $data = array('queue_name' => $queue_data['queue_name'],
                      'worker' => $queue_data['worker'],
                      'params' => serialize((array)$queue_data['params']),
                      'create_time' => $time);

        return $this->__handler->insert($data);
    }

    /**
     * 获取一个队列任务ID
     * @param string $queue 队列名称
     *
     * @return mixed 队列任务数据
     */
    public function get($queue_name){
        if (($row = $this->__handler->get($queue_name))){
            $queue_data = array(
                'id' => $row['id'],
                'params' => unserialize($row['params']),
                'worker' => $row['worker']);
            return new MessageMysql($queue_data);
        }
        return false;
    }

    /**
     * 删除一个队列任务
     * @param MessageMysql $queue_message
     *
     * @return mixed 队列任务数据
     */
    public function ack(MessageMysql $queue_message){
        $queue_id = $queue_message->get_id();
        return $this->__handler->delete(array('id'=>$queue_id));
    }


    /**
     * 清空一个队列
     *
     * @param string $queue
     */
    public function purge($queue_name){
        return $this->__handler->purge($queue_name);
    }

    public function is_end($queue_name){
        return $this->__handler->is_end($queue_name);
    }

    public function consume($queue_name){
    }

}

