<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Answer */

$this->title = Yii::t('app', 'Create Answer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Answers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-create">

	<?=  HeaderBox::widget() ?>	

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
