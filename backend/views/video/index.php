<?php

use common\models\Video;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model Video */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Video', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'video_id',
                'content' => function($model) {
                    return $this->render('_video_item', ['model' => $model]);
                }
            ],
            [
                'attribute' => 'status',
                'content' => function($model) {
                    return $model->getStatusLabels()[$model->status];
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            //'tags',
            //'description:ntext',
            //'created_by',

            [
               'class' => 'yii\grid\ActionColumn',
//                'buttons' => [
//                        'delete' => function($url) {
//                            return Html::a('Delete', $url);
//                        }
//                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
