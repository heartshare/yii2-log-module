<?php
/**
 * LogController class file.
 * @copyright (c) 2016, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\logModule\controllers;

use bariew\abstractModule\controllers\AbstractModelController;
use Yii;
use yii\filters\VerbFilter;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class LogController extends AbstractModelController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return array_intersect_key(parent::actions(), array_flip(['index', 'view', 'delete']));
    }
}
