<?php

namespace frontend\controllers;

use ciniran\excel\SaveExcel;
use frontend\models\Class0;
use frontend\models\Course;
use frontend\models\Grade;
use Yii;
use frontend\models\GradeClass;
use frontend\models\GradeClassSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GradeClassController implements the CRUD actions for GradeClass model.
 */
class GradeClassController extends Controller
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
     * Lists all GradeClass models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GradeClassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GradeClass model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $info = $this->findModel($id);
        $model = new GradeClass();
        $data = $model->getCourseTable($info);
        return $this->renderAjax('view', [
            'data' => $data,
            'info' => $info
        ]);
    }

    /**
     * Creates a new GradeClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GradeClass();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GradeClass model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GradeClass model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GradeClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GradeClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GradeClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionArranging($id){
        $info = $this->findModel($id);
        $model = new GradeClass();
        $data = $model->getData();
        $value = $model->getValue($info);
        return $this->render('arranging',[
            'data' => $data,
            'info' => $info,
            'value' => $value
        ]);
    }
    //导出
    public function actionExport($id){
        $model = new GradeClass();
        $info = $this->findModel($id);
        $data = $model->getExportData($info);
        $excel = new SaveExcel([
            'array' => $data,
            'headerDataArray' => ['节数\周数','星期一','星期二','星期三','星期四','星期五','星期六','星期日'],
            'fileName' => (Grade::find()->where(['id'=>$info->grade])->one())->the.'届'.(Class0::find()->where(['id'=>$info->banji])->one())->name.'课表',
        ]);
        $excel->arrayToExcel();
    }

}
