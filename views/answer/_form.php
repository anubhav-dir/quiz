<?php

use yii\helpers\Html;
use app\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Answer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-form card p-2">
    <div class="row">
    	<div class="col-sm-6">
    	<?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'question_id')->textInput() ?>

    <?= $form->field($model, 'answer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_taken')->textInput() ?>

        </div>
    </div>	
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
