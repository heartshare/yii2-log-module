<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bariew\logModule\models\Item */

$this->title = Yii::t('app', 'View Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/log', 'Log list'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('modules/log', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('modules/log', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            \bariew\yii2Tools\helpers\GridHelper::listFormat($model, 'user_id'),
            \bariew\yii2Tools\helpers\GridHelper::listFormat($model, 'event'),
            'link:raw',
            'message:raw',
            'created_at:datetime',
        ],
    ]) ?>

</div>
