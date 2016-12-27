<?php
namespace Yangyao\Queue\Message;
class MessageRedis extends AbstractMessage {
    private $__id = null;
    private $__params = null;
    private $__worker = null;

    public function __construct($queueData)
    {
        $this->__queueData = $queueData;

        $queueData = json_decode($queueData, true);
        $this->__params = $queueData['params'];
        $this->__worker = $queueData['worker'];
        $this->__queueName = $queueData['queue_name'];
    }

    public function get_params()
    {
        return $this->__params;
    }

    public function get_worker()
    {
        return $this->__worker;
    }

    public function getQueueData()
    {
        return $this->__queueData;
    }

    public function getQueueName()
    {
        return $this->__queueName;
    }
}
