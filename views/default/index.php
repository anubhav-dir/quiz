<?php
use app\components\HeaderBox;
use app\components\InfoBox;
use app\modules\quiz\models\Question;

$this->title = Yii::t('app', 'Home');
?>

<div class="quiz-default-index">

	<?=  HeaderBox::widget() ?>
	
    <?php 
    echo InfoBox::widget([
        'info' => [
            [
                'data' => Question::find()->my()->count(),
                'label' => 'TODOs',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-primary'
            ],
            [
                'data' => Question::findActive(Question::STATE_ACTIVE)->my()->count(),
                'label' => 'Ongoning Questions',
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
                'label' => 'Deleted Question',
                'url' => '#',
                'icon' => 'list',
                'class' => 'bg-danger'
            ]
        ]
    ]);
    ?>
		
</div>
