<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Question */

$this->title = Yii::t('app', 'Create Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

	<?=  HeaderBox::widget() ?>	

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
