<?php

namespace app\modules\quiz\controllers;

use app\modules\quiz\models\Answer;
use app\modules\quiz\models\search\Answer as AnswerSearch;
use app\components\MController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\filters\VerbFilter;
use app\models\User;
use yii\web\Response;
use app\components\ActiveForm;
use yii\web\HttpException;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends MController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::class
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'add',
                            'update',
                            'delete',
                            'view',
                            'change-state'
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return User::isAdmin();
                        }
                    ],
                    [
                        'actions' => [
                    		'index',
                    		'add',
                            'update',
                            'delete',
                            'view',
                            'change-state'
                        ],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return User::isUser();
                        }
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'POST'
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Answer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnswerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

		$this->getMenuActions();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Answer model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	$this->getMenuActions($model);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Answer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Answer();
		$post = \Yii::$app->request->post();
		
		if (\Yii::$app->request->isAjax && $model->load($post))
		{
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($this->request->isPost && $model->load($post)) 
        {
        	//$model->state_id = self::STATE_ACTIVE;
            if ($model->validate())
            {
              	if($model->save()) {
              		\Yii::$app->session->setFlash('success', 'Added Successfully');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        
		$this->getMenuActions();
        return $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Answer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$post = \Yii::$app->request->post();
		
		if (\Yii::$app->request->isAjax && $model->load($post))
		{
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($this->request->isPost && $model->load($post))
        {
        	//$model->state_id = self::STATE_ACTIVE;
            if ($model->validate())
            {
              	if($model->save()) {
              		\Yii::$app->session->setFlash('success', 'Updated Successfully');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

		$this->getMenuActions($model);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Answer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if($model->delete())
        {
	        \Yii::$app->session->setFlash('success', 'Deleted Successfully');
        	return $this->redirect(['index']);
		}
		\Yii::$app->session->setFlash('error', 'Not Deleted');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Answer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answer::findOne(['id' => $id])) !== null) {
           if ($model->isAllowed()) {
                return $model;
            }
            throw new HttpException(403, 'You are not allowed to access this page');
        }
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
    
    protected function getMenuActions($model = null)
    {
        $action = \Yii::$app->controller->action->id;
        switch ($action) {
            case "index":
                $this->menuActions = [
                    [
                        'url' => 'answer/add',
                        'label' => '',
                        'title' => 'Add',
                        'icon' => 'fa fa-plus',
                        'btn' => 'btn-success',
                        'class' => ''
                    ]
                ];
                break;
            case "add":
                $this->menuActions = [
                    [
                        'url' => 'answer/index',
                        'label' => 'Index',
                        'title' => 'Index',
                        'icon' => 'fa fa-tasks',
                        'btn' => 'btn-success',
                        'class' => ''
                    ]
                ];
                break;
            case "update":
                $this->menuActions = [
                    [
                        'url' => 'answer/index',
                        'label' => 'Index',
                        'title' => 'Index',
                        'icon' => 'fa fa-tasks',
                        'btn' => 'btn-success',
                        'class' => ''
                    ]
                ];
                if (! empty($model)) {
                    $menuActions = [
                        [
                            'url' => 'answer/view?id=' . $model->id,
                            'label' => '',
                            'title' => 'View',
                            'icon' => 'fas fa-eye',
                            'btn' => 'btn-primary',
                            'class' => ''
                        ]
                    ];
                    $this->menuActions = array_merge($this->menuActions, $menuActions);
                }
                break;
            case "view":
                $this->menuActions = [
                    [
                        'url' => 'answer/index',
                        'label' => 'Index ',
                        'title' => 'Index',
                        'icon' => 'fa fa-list',
                        'btn' => 'btn-success',
                        'class' => ''
                    ]
                ];
                if (! empty($model)) {
                    $menuActions = [
                        [
                            'url' => 'answer/update?id=' . $model->id,
                            'label' => '',
                            'title' => 'Update',
                            'icon' => 'fas fa-pencil-alt',
                            'btn' => 'btn-primary',
                            'class' => '',
                            'visible' => ($model->created_by_id == \Yii::$app->user->identity->id) ? true : false
                        ]
                    ];
                    $this->menuActions = array_merge($this->menuActions, $menuActions);
                }
                break;
            default:
                $this->menuActions = [
                    [
                        'url' => 'dashboard/index',
                        'label' => 'Index',
                        'title' => 'Index',
                        'icon' => 'fa fa-list',
                        'btn' => 'btn-success',
                        'class' => ''
                    ]
                ];
                break;
        }
    }
}
