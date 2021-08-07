<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="upload-icon text-center">
        <i class="fas fa-upload"></i>
    </div>
    <p class="mt-3"> Drag and drop video files to upload </p>
    <p class="text-muted"> Your videos will be private until you publish them. </p>
    <?php $form = ActiveForm::begin([
            'options' => [ 'enctype' => 'multipart/form-data' ]
    ]) ?>
    <?= $form->errorSummary($model) ?>
    <button class="btn btn-primary btn-file">
        Select files
        <input type="file" id="videoFile" name="video">
    </button>
    <?php ActiveForm::end() ?>
</div>

</div>
