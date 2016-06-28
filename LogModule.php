<?php

namespace bariew\logModule;

class LogModule extends \yii\base\Module
{
    /**
     * @var array for menu auto generation
     */
    public $params = [
        'menu'  => [
            'label'    => 'Logs',
            'items' => [
                [
                    'label'    => 'List',
                    'url' => ['/log/log/index']
                ],
                [
                    'label'    => 'Errors',
                    'url' => ['/log/error/index']
                ],
            ]
        ]
    ];

}
