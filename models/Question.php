<?php

namespace app\modules\quiz\models;

use Yii;
use yii\helpers\Html;
use app\models\User;
use yii\helpers\ArrayHelper;

/**
 * This template is modified by Anubhav 
 */
 
/**
 * This is the model class for table "{{%quiz_question}}".
 *
 * @property int $id
 * @property int $level_id
 * @property int $subject_id
 * @property string $question
 * @property string|null $hint
 * @property int|null $state_id
 * @property string $created_on
 * @property int $created_by_id
 * @property string $updated_on
 * @property int $updated_by_id
 *
 * @property User $createdBy
 * @property QuizLevel $level
 * @property QuizAnswer[] $quizAnswers
 * @property QuizCorrectAnswer[] $quizCorrectAnswers
 * @property QuizSubject $subject
 * @property User $updatedBy
 */
 
class Question extends \app\components\MActiveRecord
{
	const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 2;
    
    const STATE_DELETED = 3;
    
    const STATE_NEW = 4;
    
    public $option;
    
    public $correct_answer;
    
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
    
    public function getLevelOption(){
        return ArrayHelper::map(Level::find()->andWhere(['state_id' => self::STATE_ACTIVE])->all(), 'id', 'level');
    }
    
    public function getSubjectOption(){
        return ArrayHelper::map(Subject::find()->andWhere(['state_id' => self::STATE_ACTIVE])->all(), 'id', 'subject');
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quiz_question}}';
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
            [['level_id', 'subject_id', 'question', 'created_on', 'created_by_id', 'updated_on', 'updated_by_id', 'correct_answer'], 'required'],
            [['level_id', 'subject_id', 'state_id', 'created_by_id', 'updated_by_id'], 'integer'],
            [['question', 'hint'], 'string'],
            [['created_on', 'updated_on', 'option'], 'safe'],
            [['created_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by_id' => 'id']],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Level::className(), 'targetAttribute' => ['level_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
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
            'level_id' => Yii::t('app', 'Level'),
            'subject_id' => Yii::t('app', 'Subject'),
            'question' => Yii::t('app', 'Question'),
            'hint' => Yii::t('app', 'Hint'),
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
     * Gets query for [[Level]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Level::className(), ['id' => 'level_id']);
    }

    /**
     * Gets query for [[QuizAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }

    /**
     * Gets query for [[QuizCorrectAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorrectAnswers()
    {
        return $this->hasMany(CorrectAnswer::className(), ['question_id' => 'id']);
    }
    
    public function getCorrectAnswersData()
    {
        $data = CorrectAnswer::find()->andWhere(['question_id' => $this->id])->all();
        $values = '';
        foreach ($data as $value) {
            $values .= $value->answer . PHP_EOL; 
        }
        return $values;
    }

    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['question_id' => 'id']);
    }
    
    public function getOptionsData()
    {
        $data = Option::find()->andWhere(['question_id' => $this->id])->all();
        $values = '';
        $i = 'A';
//         echo '<pre>';print_r($data);die;
        foreach ($data as $value) {
            $values .= $i++ . ') ' . $value->option . "<br>";
        }
        return $values;
    }
    
    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
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
