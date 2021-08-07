<?php

use common\models\Video;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $model Video */

?>
<div class="media">
    <a href="<?= Url::to(['video/update', 'id' => $model->video_id]) ?>">
        <div class="embed-responsive embed-responsive-16by9"
             style="width: 120px">
            <video
                    class="embed-responsive-item"
                    src="<?= $model->getVideoLink() ?>"
                    poster="<?= $model->getThumbnailLink() ?>"
            ></video>
        </div>
    </a>
    <div class="media-body">
        <h6 class="mt-0"><?= $model->title ?></h6>
        <p> <?= StringHelper::truncateWords($model->description, 10) ?> </p>
    </div>
</div>
