<?php

use backend\assets\TagsInputAsset;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\bootstrap4\ActiveForm */
TagsInputAsset::register($this);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="row">
        <div class="col-sm-8">
            <?= $form->errorSummary($model) ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <label><?php echo $model->getAttributeLabel('thumbnail')  ?></label>
                <div class="custom-file">
                    <input
                            type="file"
                            class="custom-file-input"
                            id="thumbnail"
                            name="thumbnail">
                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                </div>
            </div>

            <?= $form->field($model, 'tags', [
                    'inputOptions' => ['data-role' => 'tagsinput']
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <div class="embed-responsive embed-responsive-16by9">
                <video
                        class="embed-responsive-item"
                        src="<?= $model->getVideoLink() ?>"
                        controls
                        poster="<?= $model->getThumbnailLink() ?>"
                ></video>
            </div>
            <label class="mt-3 text-muted">Video Name:</label>
            <h5 class="mt-0"><?= $model->video_name ?></h5>
            <label class="text-muted">Video Link:</label>
            <br />
            <a href="<?= $model->getVideoLink() ?>">Open Video</a>
            <p class=""> <?= $form->field($model, 'status')->dropdownList($model->getStatusLabels()) ?> </p>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

