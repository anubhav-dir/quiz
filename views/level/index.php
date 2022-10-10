<?php

use app\components\InfoBox;
use app\components\HeaderBox;
use app\modules\quiz\models\Level;

use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\quiz\models\search\Level */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Levels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-index">

	<?=  HeaderBox::widget() ?>
	
    <?php 
    echo InfoBox::widget([
        'info' => [
            [
                'data' => Level::find()->my()->count(),
                'label' => 'Levels',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-primary'
            ],
            [
                'data' => Level::findActive(Level::STATE_ACTIVE)->my()->count(),
                'label' => 'Active Levels',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-success'
            ],
            [
                'data' => Level::findActive(Level::STATE_NEW)->my()->count(),
                'label' => 'New Levels',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-secondary'
            ],
            [
                'data' => Level::findActive(Level::STATE_DELETED)->my()->count(),
                'label' => 'Deleted Levels',
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
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'level',
            //'description:ntext',
            'created_on:datetime',
            //'created_by_id',
            //'updated_on:datetime',
            //'updated_by_id',
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
                'value'=>function ($model) {
                	return  $model->createdBy->full_name;
                },
            ],
            [
            	'class' => 'app\components\MActionColumn',
                'template'=> '{view}',
                'headerOptions' => [
                    'class' => 'action-column'
                ]
            ],
        ],
    ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>
