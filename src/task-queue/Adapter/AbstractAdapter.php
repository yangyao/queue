<?php
namespace Yangyao\Queue\Adapter;

class AbstractAdapter {

    public function publish(){}

    /**
     * 返回一条队列消息
     *
     * @return Yangyao\Queue\Message\AbstractMessage
     */
    public function get(){}

	public function ack(){}

	public function purge(){}

    /**
     * 是否到队列的尾部
     *
     * @return bool
     */
	public function is_end(){}

}