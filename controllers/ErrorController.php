<?php

namespace bariew\logModule\controllers;

use bariew\abstractModule\controllers\AbstractModelController;
use Yii;
use yii\filters\VerbFilter;

/**
 * ErrorController implements the CRUD actions for Error model.
 */
class ErrorController extends AbstractModelController
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
        return array_intersect_key(parent::actions(), array_flip(['delete', 'view', 'index',]));
    }

    public function actionDeleteAll()
    {
        $model = $this->findModel();
        $model->deleteAll(['id' => $model->search()->select('id')->column()]);
        return $this->redirect(['index']);
    }
}
