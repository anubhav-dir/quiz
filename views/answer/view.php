<?php
use yii\widgets\DetailView;
use app\components\StatusBlock;
use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Answer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Answers'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="answer-view">
	
	<?=  HeaderBox::widget(['model' => $model]) ?>
	
	<div class="card table-responsive p-1">
    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'question_id',
                'value' => function ($model) {
                return $model->question->question;
                }
            ],
            'answer',
            'time_taken',
            'created_on:datetime',
            [
                'attribute' => 'created_by_id',
                'value' => function ($model) {
                    return $model->createdBy->full_name;
                }
            ]
        ]
    ])?>
	</div>
	<?= StatusBlock::widget(['model'=>$model]) ?>
</div>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("th").addClass("text-right pr-2");
    $("td").addClass("text-left pl-2");
});
</script>