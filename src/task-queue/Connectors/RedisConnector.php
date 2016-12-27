<?php
/*
 * todo : 这里使用了redis扩展，最好是使用predis为妙
 */
namespace Yangyao\Queue\Connectors;
use Exception;
class RedisConnector extends AbstractConnector{

    private static $instance = array();

    private static function key($host, $port) {
        return md5($host . ':' . $port);
    }

    public static function connect($host, $port){
        $key = self::key($host, $port);
        if (!isset(self::$instance[$key])) {
            $redis = new \Redis;
            $ret = $redis->pconnect($host, $port);
            if(!$ret) {
                throw new Exception(0, __METHOD__. "connect to redis failed, host={$host}, port={$port}");
            }
            self::$instance[$key] = $redis;
        }
        return self::$instance[$key];
    }

    public static function close($host, $port){
        $key = self::key($host, $port);
        try{
            self::$instance[$key]->close();
            unset(self::$instance[$key]);
        }catch(\Exception $e){}
    }

    public static function closeAll() {
        foreach(self::$instance as $k=>$v) {
            try {
                self::$instance[$k]->close();
            }catch(\Exception $e) {}
            unset(self::$instance[$k]);
        }
    }
}