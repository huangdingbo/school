<?php

namespace frontend\controllers;

use ciniran\excel\SaveExcel;
use frontend\models\FileImportForm;
use Yii;
use frontend\models\Student;
use frontend\models\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchCondition = Yii::$app->request->queryParams; //获得搜索参数

        if (isset($searchCondition["StudentSearch"]["isExport"]) && $searchCondition["StudentSearch"]["isExport"] == 1){

            $models = $dataProvider->getModels();

            $searchModel->dealExportData($models); //处理模型数据3

            $excel = new SaveExcel([

                'models' => $models,

                'fields' => ['name','student_id','test_id','sex','born_time','grade','banji','duty','home_address','admission_time','political_landscape', 'type'], //限制输出的列
            ]);

            $excel->modelsToExcel();
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchCondition' => $searchCondition,
        ]);
    }

    /**
     * Displays a single Student model.
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
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $model = new Student();
        $data = isset($data['Student']['pic']) ? $model->dealData($data) : $data;
        if ($model->load($data) && $model->save()) {
            return $this->redirect(['student/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Yii::$app->request->post();
        $data = isset($data['Student']['pic']) ? $model->dealData($data) : $data;
        if ($model->load($data) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Student model.
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
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImport(){
        $model = new FileImportForm();

        if(\Yii::$app->request->isPost){
            $model->load(\Yii::$app->request->post());
            //将属性封装成上传文件对象
            $model->uploader = UploadedFile::getInstance($model,'uploader');
            if ($model->validate()){
                //获取扩展名/baseName
                $baseName = $model->uploader->baseName;
                if ($baseName != '学生信息表'){
                    $model->addError('uploader','请勿修改模板');
                    return $this->render('import',['model'=>$model]);
                }
                $ext = $model->uploader->getExtension();
                $file = "/excel/".$baseName.'.'.$ext;
                $uploadRoot = \Yii::getAlias('@frontendExcelUpload');
                $fileName = $uploadRoot.$file;
                //保存文件
                $model->uploader->saveAs($fileName,false);
                $stuentModel = new Student();
                $dataModel = $stuentModel->importData($fileName);

                foreach ($dataModel as $key => $item){
                    if ($stuentModel->load($item) && $stuentModel->save(false)){
                        \Yii::$app->session->setFlash('success','导入成功');
                    }else{
                        \Yii::$app->session->setFlash('success','导入失败');
                    }
                }


//                return $this->redirect('student/index');
            }
        }

        return $this->render('import',['model'=>$model]);
    }
}
