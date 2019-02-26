<?php

namespace frontend\controllers;

use frontend\models\GradeClass;
use frontend\models\GradeClassSearch;
use Yii;
use frontend\models\Course;
use frontend\models\CourseSearch;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Course model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();
        $postData = Yii::$app->request->post();
        $grade = $postData['grade'];
        $banji = $postData['banji'];
        unset($postData['grade']);
        unset($postData['banji']);

        Course::deleteAll(['grade'=>$grade,'banji'=>$banji]);

        foreach ($postData as $key => $item){
            $data = $model->getData($item,$key,$grade,$banji);
            $newmodel = clone $model;

            if ($newmodel->load($data) && $newmodel->save(false)) {
                continue;
            }else{
                throw new ForbiddenHttpException('插入或更新失败');
            }
        }

        $status = GradeClass::find()->where(['grade'=>$grade,'banji' => $banji])->one();
        $status->status = 1;
        $status->save();


        return $this->redirect(['grade-class/index']);
    }

    /**
     * Updates an existing Course model.
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
     * Deletes an existing Course model.
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
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function beforeAction($action) {

        $currentaction = $action->id;

        $novalidactions = ['create'];

        if(in_array($currentaction,$novalidactions)) {

            $action->controller->enableCsrfValidation = false;
        }
        parent::beforeAction($action);

        return true;
    }

}
