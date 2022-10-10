<?php

namespace app\modules\quiz\models;

use Yii;
use yii\helpers\Html;
use app\models\User;

/**
 * This template is modified by Anubhav 
 */
 
/**
 * This is the model class for table "{{%quiz_subject}}".
 *
 * @property int $id
 * @property string|null $subject
 * @property string|null $description
 * @property int|null $state_id
 * @property string $created_on
 * @property int $created_by_id
 * @property string $updated_on
 * @property int $updated_by_id
 *
 * @property User $createdBy
 * @property QuizQuestion[] $quizQuestions
 * @property User $updatedBy
 */
 
class Subject extends \app\components\MActiveRecord
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
        return '{{%quiz_subject}}';
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
            [['description'], 'string'],
            [['state_id', 'created_by_id', 'updated_by_id'], 'integer'],
            [['created_on', 'created_by_id', 'updated_on', 'updated_by_id', 'subject'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['subject'], 'string', 'max' => 64],
            [['created_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by_id' => 'id']],
            [['updated_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'subject' => Yii::t('app', 'Subject'),
            'description' => Yii::t('app', 'Description'),
            'state_id' => Yii::t('app', 'State'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by_id' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'updated_by_id' => Yii::t('app', 'Updated By'),
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
     * Gets query for [[QuizQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuizQuestions()
    {
        return $this->hasMany(Question::className(), ['subject_id' => 'id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by_id']);
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
            if (empty($this->updated_on)) {
                $this->updated_on = date('Y-m-d h:i:s');
            }
            if (empty($this->updated_by_id)) {
                $this->updated_by_id = User::getCurrentUser();
            }
            if (empty($this->state_id)) {
                $this->state_id = self::STATE_NEW;
            }
        }else {
            $this->updated_on = date('Y-m-d h:i:s');
            $this->updated_by_id = User::getCurrentUser();
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
