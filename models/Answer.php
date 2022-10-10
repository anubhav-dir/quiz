<?php

namespace app\modules\quiz\models;

use Yii;
use yii\helpers\Html;
use app\models\User;

/**
 * This template is modified by Anubhav 
 */
 
/**
 * This is the model class for table "{{%quiz_answer}}".
 *
 * @property int $id
 * @property int $question_id
 * @property string $answer
 * @property string $time_taken
 * @property int|null $state_id
 * @property string $created_on
 * @property int $created_by_id
 *
 * @property User $createdBy
 * @property QuizQuestion $question
 */
 
class Answer extends \app\components\MActiveRecord
{
	const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 2;
    
    const STATE_DELETED = 3;
    
    const STATE_NEW = 4;
    
    public function getStateOption($id = null)
    {
        $list = [
            self::STATE_NEW => 'New',
            self::STATE_ACTIVE => 'Active',
            self::STATE_INACTIVE => 'Inactive',
            self::STATE_DELETED => 'Deleted',
        ];
        if ($id == null)
        {
            return $list;
        }    
        return isset($list[$id]) ? $list[$id] : 'Not Define';
    }
    
    public function getState()
    {
        $role = $this->getStateOption($this->state_id);
        return $role;
    }
    
    public function getStateBadge()
    {
        $list = [
            self::STATE_INACTIVE => 'secondary',
            self::STATE_ACTIVE => 'success',
            self::STATE_DELETED => 'danger',
            self::STATE_NEW => 'secondary',
        ];

        return Html::tag('span', $this->getState(), [
            'class' => 'pl-2 pr-2 badge badge-' . $list[$this->state_id]
        ]);
    }
    
    public function getStatusBlockOption()
    {
        $list = [
            self::STATE_INACTIVE => ['label'=>'Inactive','class'=>'btn-secondary'],
            self::STATE_ACTIVE => ['label'=>'Active','class'=>'btn-success'],
            self::STATE_DELETED => ['label'=>'Deleted','class'=>'btn-danger'],
        ];
        return $list;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quiz_answer}}';
    }

	public function scenarios()
    {
        $scenarios = parent::scenarios();

        //$scenarios['add'] = [
        //    'created_by_id',
        //    'created_on',
        //    'state_id'
        //];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'answer', 'time_taken', 'created_on', 'created_by_id'], 'required'],
            [['question_id', 'state_id', 'created_by_id'], 'integer'],
            [['time_taken', 'created_on'], 'safe'],
            [['answer'], 'string', 'max' => 255],
            [['created_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'question_id' => Yii::t('app', 'Question'),
            'answer' => Yii::t('app', 'Answer'),
            'time_taken' => Yii::t('app', 'Time Taken'),
            'state_id' => Yii::t('app', 'State'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by_id' => Yii::t('app', 'Created By'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by_id']);
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (empty($this->created_on)) {
                $this->created_on = date('Y-m-d h:i:s');
            }
            if (empty($this->created_by_id)) {
                $this->created_by_id = User::getCurrentUser();
            }
            if (empty($this->state_id)) {
                $this->state_id = self::STATE_ACTIVE;
            }
        }
        return Parent::beforeValidate();
    }
    
    public function afterValidate()
    {
        return Parent::afterValidate();
    }
    
    public function beforeDelete()
    {
        return parent::beforeDelete();
    }
   
    public function isAllowed()
    {
        if (User::isAdmin()) {
            return true;
        }
        if ($this->hasAttribute('created_by_id') && $this->created_by_id == \Yii::$app->user->identity->id) {
            return true;
        }
        return false;
    }
}
