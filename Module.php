<?php

namespace bariew\logModule;

class Module extends \yii\base\Module
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
                    'url' => ['/log/item/index']
                ],
                [
                    'label'    => 'Errors',
                    'url' => ['/log/error/index']
                ],
            ]
        ]
    ];

}
