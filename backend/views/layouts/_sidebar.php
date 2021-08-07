<?php

use yii\bootstrap4\Nav;
?>
<aside class="shadow-sm">
<?php
echo Nav::widget([
    'options' => [
      'class' => 'd-flex flex-column nav-pills'
    ],
    'items' =>  [
        ['label' => 'Dashboard', 'url' => ['/site/index']],
        ['label' => 'Video', 'url' => ['/video/index']],
    ]
]);

?>
</aside>
