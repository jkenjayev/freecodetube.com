<?php

/* @var $this  View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\web\View;
use common\widgets\Alert;

$this->beginContent('@frontend/views/layouts/base.php');
?>
    <main class="d-flex">
        <?php echo $this->render('_sidebar'); ?>

        <div class="content-wrapper p-3">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
<?php $this->endContent() ?>