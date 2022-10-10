<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Level */

$this->title = Yii::t('app', 'Create Level');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-create">

	<?=  HeaderBox::widget() ?>	

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
