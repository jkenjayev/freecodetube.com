<?php

use common\models\Video;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $model Video */
?>
<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9 mb-3">
            <video class="embed-responsive-item"
                   src="<?= $model->getVideoLink() ?>"
                   poster="<?= $model->getThumbnailLink() ?>"
                    controls
            ></video>
        </div>
        <h6><?= $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <?= $model->getViews()->count() ?> view • <?= Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <?php Pjax::begin() ?>
                    <?= $this->render('_buttons', ['model' => $model]) ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
</div>
