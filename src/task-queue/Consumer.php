<?php


namespace Yangyao\Queue;
use Yangyao\Queue\Contracts\IConsumer;
use Exception;
class Consumer{
    
    private static $__instance = NULL;
    private $__consumer = NULL;
    
    
    function __construct($mode = 'proc'){
        $class = 'Yangyao\\Consumer\\'.ucfirst($mode);
        $consumer = new $class;
        if($consumer instanceof IConsumer){
            $this->__consumer = &$consumer;
        }else{
            throw new Exception("The consumer must implements system_interface_queue_IConsumer!");
        }
    }
    
    /**
     * 如果没有定义QUEUE_CONSUMER常量，默认使用fork方式，如果系统不支持fork，可以使用proc模式
     * 
     * @param string $mode 消费者的模式，可选值：fork/proc
     * 
     * @return mixed 消费者对象
     */
    public static function instance($mode=NULL){
        if(empty($mode)){
            if(defined("QUEUE_CONSUMER") && constant("QUEUE_CONSUMER")){
                $mode = QUEUE_CONSUMER;
            }else{
                $mode = 'fork';
            }
        }
        
        if(!isset(self::$__instance[$mode])){
            if($instance = new self($mode)){
                self::$__instance[$mode] = $instance;
                return self::$__instance[$mode];
            }else{
                return false;
            }
        }else{
            return self::$__instance[$mode];
        }
    }
    
    /**
     * 执行具体的任务
     * 
     * @param string $queue_name 队列名称
     * @param int $max 最大可开启的进程数
     * @param String $phpExec PHP脚本路径
     */
    public function exec($queue_name,$max=5,$phpExec=''){
        $this->__consumer->exec($queue_name,$max,$phpExec);
    }
}
