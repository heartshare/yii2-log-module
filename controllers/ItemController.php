<?php

namespace bariew\logModule\controllers;

use bariew\abstractModule\controllers\AbstractModelController;
use Yii;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends AbstractModelController
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
