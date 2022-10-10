<?php
use app\components\InfoBox;
use app\components\HeaderBox;
use app\modules\quiz\models\Question;

use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\quiz\models\search\Question */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

	<?=  HeaderBox::widget() ?>
	
    <?php
    echo InfoBox::widget([
        'info' => [
            [
                'data' => Question::find()->my()->count(),
                'label' => 'Questions',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-primary'
            ],
            [
                'data' => Question::findActive(Question::STATE_ACTIVE)->my()->count(),
                'label' => 'Active Questions',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-success'
            ],
            [
                'data' => Question::findActive(Question::STATE_NEW)->my()->count(),
                'label' => 'New Questions',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-secondary'
            ],
            [
                'data' => Question::findActive(Question::STATE_DELETED)->my()->count(),
                'label' => 'Deleted Questions',
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
                'attribute' => 'level_id',
                'value' => function ($model) {
                    return $model->level->level;
                }
            ],
            [
                'attribute' => 'subject_id',
                'value' => function ($model) {
                    return $model->subject->subject;
                }
            ],
            'question:ntext',
            // 'hint:ntext',
            // 'state_id',
            // 'created_on',
            // 'created_by_id',
            // 'updated_on',
            // 'updated_by_id',
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
