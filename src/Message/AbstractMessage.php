<?php
namespace Yangyao\Queue\Message;
class AbstractMessage {

    /**
     * 获取队列参数
     *
     * @return array
     */
    public function get_params(){}
    /**
     * 获取队列worker
     *
     * @return Yangyao\Queue\Contracts\Task
     */
	public function get_worker(){}
}
