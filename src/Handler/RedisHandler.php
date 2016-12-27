<?php
/**
 * MIT licence
 *
 * todo 这里是一个mysql数据库的模型，封装数据库的crud 和 connect ?
 */
namespace Yangyao\Queue\Handler;
use Yangyao\Queue\Connectors\RedisConnector;
use Exception;
class RedisHandler
{
    private $connector;

    function __construct($host, $port)
    {
        $this->connector = RedisConnector::connect($host,$port);
    }


    /**
     * 调用redis的内置命令
     *
     * @param $method redis的方法
     * @param $parameters 调用参数
     * @return mixed
     */
    public function __call($method, $parameters){
        if(method_exists($this->connector,$method)){
            return $this->connector->$method($parameters);
        }
        throw new Exception("method dose not exists!");
    }
}


