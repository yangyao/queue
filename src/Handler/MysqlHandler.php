<?php

namespace Yangyao\Queue\Handler;
use Yangyao\Queue\Connectors\MysqlConnector;
class MysqlHandler
{
    private $connector;

    private $table;

    function __construct($host, $port, $user, $pass,$table)
    {
        $this->table = $table;
        $this->connector = MysqlConnector::connect($host, $port, $user, $pass);
        $this->connector->exec('set SESSION autocommit=1;');
        $this->connector->exec('set @msgID = -1;');
    }

    /**
     * 获取一个队列任务信息
     *
     * @param string $queue_name 队列名称
     *
     * @return array $row
     */
    public function get($queue_name)
    {
        if ($this->connector->exec('UPDATE '.$this->table.' force index(PRIMARY) SET owner_thread_id=GREATEST(CONNECTION_ID() ,(@msgID:=id)*0),last_cosume_time=? WHERE queue_name=? and owner_thread_id=-1 order by id LIMIT 1;', [time(), $queue_name]))
        {
            $row = $this->connector->query('select id, worker, params from '.$this->table.' where id=@msgID')->fetchColumn();
            return $row;
        }

        return false;
    }

    /**
     * 清空一个队列的内容
     * todo pdo 并没有一个delete的函数，需要prepare 一条delete 语句，然后exec
     * @param string $queue_name
     *
     * @return bool
     */
    public function purge($queue_name){
        return $this->connector->delete(array('queue_name' => $queue_name));
    }

    /**
     * 队列任务是否执行完毕
     * todo pdo 并没有一个getRow的函数，需要prepare 一条query 语句，然后fetchColumn
     * @param string $queue_name
     *
     * @return bool
     */

    public function is_end($queue_name){
        
        return $this->connector->getRow('id', array('queue_name' => $queue_name, 'owner_thread_id' => -1));
    }
}


