<?php

use yii\helpers\Html;
use app\components\ActiveForm;
use unclead\multipleinput\MultipleInput;


/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form card p-2">
    <div class="row">
    	<div class="col-sm-6">
    	<?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'level_id')->dropDownList($model->getLevelOption(), ['prompt' => 'Select Level...']) ?>
        
            <?= $form->field($model, 'subject_id')->dropDownList($model->getSubjectOption(), ['prompt' => 'Select Subject...']) ?>
        
            <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

	    	<?= $form->field($model, 'hint')->textarea(['rows' => 2]) ?>
	    	
		</div>
    	<div class="col-sm-6">

	    	<?php
                echo $form->field($model, 'option')->widget(MultipleInput::className(), [
                    'max'               => 5,
                    'min'               => 5,
                    'iconSource' => 'fa',
                ])
                ->label();
            ?>
            <?= $form->field($model, 'correct_answer')->textInput() ?>

        </div>
    </div>	
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
