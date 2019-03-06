<?php

namespace frontend\controllers;

use frontend\models\Grade;
use frontend\models\Kaohao;
use frontend\models\Score;
use frontend\models\ScoreSearch;
use frontend\models\TestForm;
use Yii;
use frontend\models\Test;
use frontend\models\TestSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
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
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('indexTest')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
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
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createTest')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $model = new Test();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateTest')){
            return $this->renderAjax('/site/error',['name'=>'权限验证不通过','message'=>Yii::$app->params['perMessage']]);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteTest')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCandidate($id){
        if (!Yii::$app->user->can('createTestNum')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }

        $testInfo = Test::findOne(['id'=>$id]);

        $grade = $testInfo->grade_num;

        $model = new TestForm();

        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $model->validate()){
            Kaohao::deleteAll(['test_num'=>$testInfo->test_num]);
            $modelTest = new Test();
            if ($model->test_num == 0){
                $list = $modelTest->getCandData($testInfo);
                if ($list == false){
                    Yii::$app->session->setFlash('warning','没有足够的考场，请添加考场！');
                    $url = Url::to(['test/candidate','id'=>$id]);
                    return $this->redirect($url);
                }

               if ($modelTest->insertCandData($list,$testInfo->test_num)){
                   Yii::$app->session->setFlash('success','考号生成成功');
                   return $this->redirect(['kaohao/index']);
               }
            }else{
                //查询考号表有无本次考试考号
                $isTrue = Kaohao::find()->where(['test_num' => $model->test_num])->one();
                if ($isTrue == null){
                    Yii::$app->session->setFlash('warning','《'.$model->test_num.'》'.'考号未生成');
                    $url = Url::to(['test/candidate','id'=>$id]);
                    return $this->redirect($url);
                }else{
                    //有就查询插入考号表
                    $kaohaoList = Kaohao::find()->where(['test_num'=>$model->test_num,'type'=>$testInfo->type])->orderBy('order asc')->asArray()->all();
                    $data = $modelTest -> dealKaohao($kaohaoList,$testInfo);
                    if ($data == false){
                        Yii::$app->session->setFlash('warning','没有足够的考场，请添加考场！');
                        $url = Url::to(['test/candidate','id'=>$id]);
                        return $this->redirect($url);
                    }
                    if ($modelTest->insertCandData($data,$testInfo->test_num)){
                        Yii::$app->session->setFlash('success','考号生成成功');
                        return $this->redirect(['kaohao/index']);
                    }
                }
            }
        }
      return $this->render('cnad',[
          'model' => $model,
          'grade' => $grade

      ]);

    }

    public function actionAudit($id){
        if (!Yii::$app->user->can('endTest')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $model = Test::find()->where(['id' => $id])->one();
        $model->status = 2;
        if (!$model->save()){
            throw new ForbiddenHttpException('操作失败，原因未知');
        }
       return $this->redirect(['index']);
    }

    public function actionEntry($id){
        if (!Yii::$app->user->can('entryTestScore')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $queryParams = Yii::$app->request->queryParams;
        //选择录入成绩，先根据考试信息插入成绩表基本信息
        $searchModel = new ScoreSearch();
        //考试信息
        $testInfo = $searchModel->getTeatInfo($id);
        //学生信息
        $studentList = $searchModel->getStudentList($testInfo);
        if ((Score::findOne(['test_num' => $testInfo->test_num] ))){

//            Yii::$app->session->setFlash('warning','本次考试学生基本信息已存在，请在下方录入！');

        }else{
            //插入成绩表学生基础信息
            $searchModel->insertBaseData($studentList,$testInfo->type);
        }

        $queryParams['ScoreSearch']['test_num'] = $testInfo->test_num;

        $dataProvider = $searchModel->search($queryParams);
        $list = $dataProvider->getModels();
        return $this->render('/score/entry',[
            'searchModel' => $searchModel,
            'list' => $list,
            'testInfo' => $testInfo,
            'dataProvider' => $dataProvider
        ]);
    }

}