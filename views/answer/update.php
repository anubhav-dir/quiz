<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Answer */

$this->title = Yii::t('app', 'Update Answer: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="answer-update">
	
	<?=  HeaderBox::widget(['model' => $model]) ?>		

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
