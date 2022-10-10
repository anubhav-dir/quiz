<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Subject */

$this->title = Yii::t('app', 'Update Subject: {name}', [
    'name' => $model->subject,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="subject-update">
	
	<?=  HeaderBox::widget(['model' => $model]) ?>		

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
