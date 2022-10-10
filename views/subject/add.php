<?php

use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Subject */

$this->title = Yii::t('app', 'Create Subject');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-create">

	<?=  HeaderBox::widget() ?>	

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
