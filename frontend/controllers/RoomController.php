<?php

namespace frontend\controllers;

use common\models\config;
use vendor\project\StatusTest;
use Yii;
use frontend\models\Room;
use frontend\models\RoomSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoomController implements the CRUD actions for Room model.
 */
class RoomController extends Controller
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
     * Lists all Room models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('indexRoom')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $searchModel = new RoomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $locationMap = config::getLocationMap();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'locationMap' => $locationMap,
        ]);
    }

    /**
     * Displays a single Room model.
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
     * Creates a new Room model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createRoom')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $model = new Room();
        $postData = Yii::$app->request->post();
        if ($postData){
            $postData['Room']['teachers'] = json_encode($postData['Room']['teachers'],JSON_UNESCAPED_UNICODE);
        }
        if ($model->load($postData) && $model->save()) {
            return $this->redirect(['index']);
        }

        $locationMap = config::getLocationMap();
        $data = config::getData('name');

        return $this->render('create', [
            'model' => $model,
            'locationMap' => $locationMap,
            'data' => $data
        ]);
    }

    /**
     * Updates an existing Room model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateRoom')){
            return $this->renderAjax('/site/error',['name'=>'权限验证不通过','message'=>Yii::$app->params['perMessage']]);
        }
        $model = $this->findModel($id);

        $postData = Yii::$app->request->post();
        if ($postData){
            if (is_array($postData['Room']['teachers'])){
                $postData['Room']['teachers'] = json_encode($postData['Room']['teachers'],JSON_UNESCAPED_UNICODE);
            }else{
                $postData['Room']['teachers'] = $model->teachers;
            }

        }

        if ($model->load($postData) && $model->save()) {
            return $this->redirect(['index']);
        }

        $locationMap = config::getLocationMap();
        $data = config::getData('name');

        return $this->renderAjax('update', [
            'model' => $model,
            'locationMap' => $locationMap,
            'data' => $data,
        ]);
    }

    /**
     * Deletes an existing Room model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteRoom')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Room model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Room the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Room::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
