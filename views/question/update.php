<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Question */

$this->title = Yii::t('app', 'Update Question: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="question-update">
	
	<?=  HeaderBox::widget(['model' => $model]) ?>		

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
