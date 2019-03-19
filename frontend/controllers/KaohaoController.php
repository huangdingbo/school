<?php

namespace frontend\controllers;

use ciniran\excel\SaveExcel;
use Yii;
use frontend\models\Kaohao;
use frontend\models\KaohaoSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KaohaoController implements the CRUD actions for Kaohao model.
 */
class KaohaoController extends Controller
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
     * Lists all Kaohao models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('indexCand')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $searchModel = new KaohaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchCondition = Yii::$app->request->queryParams; //获得搜索参数

        if (isset($searchCondition["KaohaoSearch"]["isExport"]) && $searchCondition["KaohaoSearch"]["isExport"] == 1){
            if (!Yii::$app->user->can('exportCand')){
                throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
            }
            //导出不适应分页，把默认的20条改的很大
            $dataProvider->setPagination(new Pagination([
                'defaultPageSize' => 1000000,
                'pageSizeLimit' => [1, 1000000]
            ]));

            $models = $dataProvider->getModels();

            $searchModel->dealExportData($models); //处理模型数据


            $excel = new SaveExcel([

                'models' => $models,

                'fileName' => $models[0]->test_name.'-'.$models[0]->grade_name.'考号表',

                'fields' => ['test_num','student_id','cand_num','test_name','student_name','class_name','grade_name','exam_room','room_name','teachers','seat_num', 'type'], //限制输出的列
            ]);

            $excel->modelsToExcel();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchCondition' => $searchCondition
        ]);
    }

    /**
     * Displays a single Kaohao model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Kaohao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Kaohao();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing Kaohao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Deletes an existing Kaohao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteCand')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kaohao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kaohao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kaohao::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
