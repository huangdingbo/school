<?php

namespace frontend\controllers;

use ciniran\excel\SaveExcel;
use common\models\config;
use frontend\models\Student;
use Yii;
use frontend\models\Score;
use frontend\models\ScoreSearch;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScoreController implements the CRUD actions for Score model.
 */
class ScoreController extends Controller
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
     * Lists all Score models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('indexScore')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $searchCondition = Yii::$app->request->queryParams; //获得搜索参数

        $searchModel = new ScoreSearch();

        $dataProvider = $searchModel->search($searchCondition);

        if (isset($searchCondition["ScoreSearch"]["isExport"]) && $searchCondition["ScoreSearch"]["isExport"] == 1){
            if (!Yii::$app->user->can('exportScore')){
                throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
            }
            //导出不适应分页，把默认的20条改的很大
            $dataProvider->setPagination(new Pagination([
                'defaultPageSize' => 1000000,
                'pageSizeLimit' => [1, 1000000]
            ]));

            $models = $dataProvider->getModels();

            $searchModel->dealExportData($models); //处理模型数据

            $fields = $searchModel->type == 1 ? ['cand_id','name','test_name','grade','banji','chinese','math','english',
                                                'physics','chemistry','biology','total','class_rank','school_rank', 'type'] : ['cand_id','name','test_name','grade','banji','chinese','math','english',
                                                'politics','history','geography','total','class_rank','school_rank', 'type'
                                                ];

            $fileName = $searchCondition['ScoreSearch']['test_name'].'学生成绩表'.time();

            $excel = new SaveExcel([

                'models' => $models,

                'fields' => $fields,

                'fileName' => $fileName
            ]);

            $excel->modelsToExcel();
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $searchModel->type,
            'searchCondition' => $searchCondition,

        ]);
    }

    /**
     * Displays a single Score model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('viewScore')){
            return $this->renderAjax('/site/error',['name'=>'权限验证不通过','message'=>Yii::$app->params['perMessage']]);
        }
        $model = $this->findModel($id);

        $img = (Student::find()->where(['student_id'=>$model->student_id])->one())->pic;

        $model->img = $img;
        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Score model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id = Yii::$app->request->get('id');
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $per_page = 15;
        //接收成绩
        $list = Yii::$app->request->post();
        //更新成绩表
        $model = new Score();
        $model->insertScoreData($list);
        //更新总分、校名、班名
        $testNum = Yii::$app->request->get('test_num');
        $model->calculateRank($testNum);

        $url = Url::to(['test/entry','id'=>$id,'page'=>$page,'per-page'=>$per_page]);
        Yii::$app->session->setFlash('success','成绩插入成功！');
        return $this->redirect($url);
    }

    /**
     * Updates an existing Score model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateScore')){
            return $this->renderAjax('/site/error',['name'=>'权限验证不通过','message'=>Yii::$app->params['perMessage']]);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $img = (Student::find()->where(['student_id'=>$model->student_id])->one())->pic;

        $model->img = $img;

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Score model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteScore')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Score model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Score the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Score::findOne($id)) !== null) {
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