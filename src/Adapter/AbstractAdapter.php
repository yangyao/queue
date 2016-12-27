<?php
namespace Yangyao\Queue\Adapter;

class AbstractAdapter {
    /**
     * 添加一个队列任务
     *
     * @return bool
     */
    public function publish(){}

    /**
     * 返回一条队列消息
     *
     * @return Yangyao\Queue\Message\AbstractMessage
     */
    public function get(){}
    /**
     * 删除一个队列任务
     *
     * @return bool
     */
	public function ack(){}
    /**
     * 清空一个队列任务
     *
     * @return bool
     */
	public function purge(){}

    /**
     * 是否到队列的尾部
     *
     * @return bool
     */
	public function is_end(){}

}