<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Level */

$this->title = Yii::t('app', 'Update Level: {name}', [
    'name' => $model->level,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->level, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="level-update">
	
	<?=  HeaderBox::widget(['model' => $model]) ?>		

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
