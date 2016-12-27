<?php
return array(

	'adapter' => Yangyao\Queue\Adapter\AdapterMysql::class,

	//可以为Task配置不同的queue 这个配置需要适当的修改，要提供一些demo task

    'default_publish_queue' => 'normal',

    //todo 这还能把一个人物丢到多个队列的，不怕多次执行产生脏数据？？意味着worker必须是幂等性的，多次执行也不会带来意外的影响。

	'bindings' => array(
        'crontab:site_tasks_createsitemaps' => array('slow'),
        'crontab:ectools_tasks_statistic_day' => array('slow'),
        'crontab:ectools_tasks_statistic_hour' => array('slow'),
        'crontab:base_tasks_cleankvstore' => array('slow'),
        'crontab:apiactionlog_tasks_cleanexpiredapilog' => array('slow'),

        'desktop_tasks_runimport' => array('normal'),
        'desktop_tasks_turntosdf' => array('normal'),
        'emailbus_tasks_sendemail' => array('slow'),
        'image_tasks_imagerebuild' => array('normal'),
        'recommended_tasks_update' => array('slow'),
        'importexport_tasks_runexport'=>array('slow'),
        'importexport_tasks_runimport'=>array('slow'),
        'aftersales_tasks_archive_returnProduct' => array('slow'), 
        'system_tasks_events' => array('quick'),
        'other' => array('other'),
    ),

    'queues' => array(
        'slow' => array(
            'title' => 'slow queue',
            'thread' => 3,
        ),
        'quick' => array(
            'title' => 'quick queue',
            'thread' => 5,
        ),
        'normal' => array(
            'title' => 'normal queue',
            'thread' => 3,
        )
    ),

);