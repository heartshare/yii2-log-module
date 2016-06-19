<?php

use yii\helpers\Html;
use yii\grid\GridView;
use bariew\yii2Tools\helpers\GridHelper;

/* @var $this yii\web\View */
/* @var $searchModel bariew\logModule\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('modules/log', 'Log list');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'link:raw',
            GridHelper::dateFormat($searchModel, 'created_at', ['format'=> 'datetime']),
            GridHelper::listFormat($searchModel, 'user_id'),
            'event',
            'message:raw',
//            'message' => [
//                'format' => 'raw',
//                'value' => function($data) {
//                    $diff = new \cogpowered\FineDiff\Diff();
//                    $result = $diff->render(
//                        preg_replace(['#[\s\n]*\)#', '#Array[\s\n]*\(#'], ['', ''], print_r(['a'=> 'asd sdf fgh','b' => 2, 'c' => 3], true)),
//                        preg_replace(['#[\s\n]*\)#', '#Array[\s\n]*\(#'], ['', ''], print_r(['a' => 'asd 111 fgh','d' => 4], true))
//                    );
//                    return '<pre>'.$result.'</pre>';
//                }
//            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
        ],
    ]); ?>

</div>
