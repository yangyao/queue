<?php
namespace Yangyao\Queue\Message;
class MessageMysql extends AbstractMessage{
    private $__id = null;
    private $__params = null;
    private $__worker = null;
    
    function __construct($queue_data){
        $this->__id = $queue_data['id'];
        $this->__params = $queue_data['params'];
        $this->__worker = $queue_data['worker'];
    }

    function get_params(){
        return $this->__params;
    }

    function get_worker(){
        return $this->__worker;
    }
    
    function get_id() {
        return $this->__id;
    }
}
