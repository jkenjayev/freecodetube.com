<?php

/* @var $this  View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\web\View;
use common\widgets\Alert;

AppAsset::register($this);
$this->beginContent('@frontend/views/layouts/base.php');
?>
        <main class="d-flex">
            <div class="content-wrapper p-3">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </main>
<?php $this->endContent() ?>