<?php

use common\models\Video;
use yii\helpers\Url;
/* @var $model Video */
?>
    <a href="<?= Url::to(['/video/like', 'id' => $model->video_id])?>"
       class="btn btn-sm btn-outline-primary"
       data-method="post"
       data-pjax="1"><i class="far fa-thumbs-up"> 9</i>
    </a>
    <button class="btn btn-sm btn-outline-primary"><i class="far fa-thumbs-down text-muted"> 3</i></button>