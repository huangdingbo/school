<?php

namespace frontend\controllers;

use frontend\models\CaseProcess;
use frontend\models\CasesOverviewSearch;
use frontend\models\CasesOverviewSearchSearch;
use Yii;
use frontend\models\Cases;
use frontend\models\CasesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CasesController implements the CRUD actions for Cases model.
 */
class CasesController extends Controller
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
     * Lists all Cases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cases model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cases();

        $postData = Yii::$app->request->post();
//        var_dump($postData);exit;
        if ($model->load($postData)) {
            //添加其他信息
            $restult = $model->addOtherInfo();
            if ($restult){
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cases model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (($this->findModel($id))->create_id != Yii::$app->user->id){
            Yii::$app->session->setFlash('danger','不能删除指派给你的事件！！！');
            return $this->redirect(['index']);
        }

        $caseNum = ($this->findModel($id))->case_num;

        if ($this->findModel($id)->delete()){
            CaseProcess::deleteAll(['case_num' => $caseNum]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cases::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPoint($id){
        if ((Cases::findOne(['id' => $id]))->status == 2){
            Yii::$app->session->setFlash('warning','事件已解决，如需操作请先激活事件！！！');
        }
        $model = $this->findModel($id);
        $model->old_point_id = $model->point_id;
        $oldPointId = $model->old_point_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            /**
             * 添加流程
             */
            if ( $model -> addProcess($oldPointId)){
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('point',[
            'model' => $model
        ]);
    }

    public function actionSolve($id){
        if ((Cases::findOne(['id' => $id]))->status == 2){
            Yii::$app->session->setFlash('warning','事件已解决，如需操作请先激活事件！！！');
        }
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 2;

            if ($model->save()){
                /**
                 * 添加流程
                 */
                if ( $model->addSolveProcess()){
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->renderAjax('solve',[
            'model' => $model
        ]);
    }

    public function actionActivation($id){
        if ((Cases::findOne(['id' => $id]))->status == '1'){
            Yii::$app->session->setFlash('warning','事件正在处理中......');
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;

            if ($model->save()){
                /**
                 * 添加流程
                 */
                if ( $model->addSolveActivation()){
                    Yii::$app->session->setFlash('success','事件已激活！！！');
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->renderAjax('solve',[
            'model' => $model
        ]);
    }

    public function actionOverview(){
        $searchModel = new CasesOverviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('overview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
