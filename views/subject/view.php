<?php
use yii\widgets\DetailView;
use app\components\StatusBlock;
use app\components\HeaderBox;

/* @var $this yii\web\View */
/* @var $model app\modules\quiz\models\Subject */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Subjects'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="subject-view">
	
	<?=  HeaderBox::widget(['model' => $model]) ?>
	
	<div class="card table-responsive p-1">
    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'subject',
            'description:ntext',
            'created_on:datetime',
            'updated_on:datetime',
            [
                'attribute' => 'created_by_id',
                'value' => function ($model) {
                    return $model->createdBy->full_name;
                }
            ],
            [
                'attribute' => 'updated_by_id',
                'value' => function ($model) {
                    return $model->updatedBy->full_name;
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