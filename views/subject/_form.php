<?php

use yii\helpers\Html;
use app\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Subject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subject-form card p-2">
    <div class="row">
    	<div class="col-sm-6">
    	<?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        </div>
    </div>	
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
