<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Duty;
use frontend\models\DutySearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DutyController implements the CRUD actions for Duty model.
 */
class DutyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Duty models.
     * @return mixed
     */
    public function actionIndex()
    {
        //学生档案管理数据表配置权限检查
        if (Yii::$app->request->queryParams['type'] == 1){
            if (!Yii::$app->user->can('studentTable')){
                throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
            }
        }elseif (Yii::$app->request->queryParams['type'] == 2){
            if (!Yii::$app->user->can('teacherTable')){
                throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
            }
        }
        $searchModel = new DutySearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Duty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Duty();
        $type = (Yii::$app->request->get())['type'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index','type' => $type]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Duty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $type = (Yii::$app->request->get())['type'];
            return $this->redirect(['index','type'=>$type]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Duty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $type = (Yii::$app->request->get())['type'];
        return $this->redirect(['index','type'=>$type]);
    }

    /**
     * Finds the Duty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Duty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Duty::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
