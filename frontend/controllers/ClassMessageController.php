<?php

namespace frontend\controllers;

use frontend\models\Student;
use Yii;
use frontend\models\ClassMessage;
use frontend\models\ClassMessageSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClassMessageController implements the CRUD actions for ClassMessage model.
 */
class ClassMessageController extends Controller
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
     * Lists all ClassMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('indexClassDoc')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $searchModel = new ClassMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/classMessage/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClassMessage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('viewClassDoc')){
            return $this->renderAjax('/site/error',['name'=>'权限验证不通过','message'=>Yii::$app->params['perMessage']]);
        }
        return $this->renderAjax('/classMessage/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClassMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createClassDoc')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $model = new ClassMessage();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        }

        return $this->render('/classMessage/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClassMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateClassDoc')){
            return $this->renderAjax('/site/error',['name'=>'权限验证不通过','message'=>Yii::$app->params['perMessage']]);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->renderAjax('/classMessage/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClassMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteClassDoc')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClassMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClassMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClassMessage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //更新班级人数信息
    public function actionUpdateMessage(){
        if (!Yii::$app->user->can('updateClassNumDoc')){
            throw new ForbiddenHttpException(Yii::$app->params['perMessage']);
        }
        $list  = ClassMessage::find()->select('id,name,grade')->all();
        foreach ($list as $item){
            $num = Student::find()->where(['banji'=>$item->name,'grade'=>$item->grade])
                ->count();

            $update = (new Query())->createCommand()->update('class_message',[
                    'num' => $num,
                    'update_time' => date('Y-m-d H:i:s',time())
            ],['id' => $item->id])->execute();

            if ($update){
               continue;
            }else{
                \Yii::$app->session->setFlash('warning','更新失败');
                return $this->redirect(array('index'));
            }
        }
        \Yii::$app->session->setFlash('success','更新成功');
        return $this->redirect(array('index'));
    }
}
