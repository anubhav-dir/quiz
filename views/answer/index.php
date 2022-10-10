<?php
use app\components\InfoBox;
use app\components\HeaderBox;
use app\modules\quiz\models\Answer;

use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\quiz\models\search\Answer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Answers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

	<?=  HeaderBox::widget() ?>
	
    <?php
    echo InfoBox::widget([
        'info' => [
            [
                'data' => Answer::find()->my()->count(),
                'label' => 'Answers',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-primary'
            ],
            [
                'data' => Answer::findActive(Answer::STATE_ACTIVE)->my()->count(),
                'label' => 'Active Answers',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-success'
            ],
            [
                'data' => Answer::findActive(Answer::STATE_NEW)->my()->count(),
                'label' => 'New Answers',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-secondary'
            ],
            [
                'data' => Answer::findActive(Answer::STATE_DELETED)->my()->count(),
                'label' => 'Deleted Answers',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-danger'
            ]
        ]
    ]);
    ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="p-2 card table-responsive">
    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],

            'id',
            [
                'attribute' => 'question_id',
                'value' => function ($model) {
                    return $model->question->question;
                }
            ],
            'answer',
            'time_taken:time',
            // 'created_on',
            // 'created_by_id',
            [
                'attribute' => 'state_id',
                'filter' => $searchModel->getStateOption(),
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getStateBadge();
                }
            ],
            [
                'attribute' => 'created_by_id',
                'visible' => true,
                'value' => function ($model) {
                    return $model->createdBy->full_name;
                }
            ],
            [
                'class' => 'app\components\MActionColumn',
                'template' => '{view}',
                'headerOptions' => [
                    'class' => 'action-column'
                ]
            ]
        ]
    ]);
    ?>
    </div>

    <?php Pjax::end(); ?>

</div>
