<?php

namespace frontend\controllers;

use ciniran\excel\SaveExcel;
use frontend\components\DealData;
use frontend\models\Diploma;
use frontend\models\Duty;
use frontend\models\FileImportForm;
use frontend\models\Political;
use frontend\models\Student;
use frontend\models\Title;
use QL\Dom\Query;
use Yii;
use frontend\models\Teacher;
use frontend\models\TeacherSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TeacherController implements the CRUD actions for Teacher model.
 */
class TeacherController extends Controller
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
     * Lists all Teacher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeacherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //导出功能
        $searchCondition = Yii::$app->request->queryParams; //获得搜索参数

        if (isset($searchCondition["TeacherSearch"]["isExport"]) && $searchCondition["TeacherSearch"]["isExport"] == 1){

            $data = Yii::$app->db->createCommand(Yii::$app->params['sql'])->queryAll();

            $searchModel->dealExportData($data); //处理数据

            $excel = new SaveExcel([
                'array' => $data,
                'headerDataArray' => ['教师编号','姓名','性别','出生日期','职务','学历','政治面貌','所在分组','电话号码','QQ','邮箱','职称'],
            ]);
            $excel->arrayToExcel();
        }
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'searchCondition' => $searchCondition,
            ]);

    }

    /**
     * Displays a single Teacher model.
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
     * Creates a new Teacher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $model = new Teacher();
        $data = isset($data['Teacher']['pic']) ? Student::dealPicData($data,'Teacher') : $data;
        if ($model->load($data) && $model->save(false)) {
            return $this->redirect(['teacher/index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Teacher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Yii::$app->request->post();
        $data = isset($data['Teacher']['pic']) ? Student::dealPicData($data,'Teacher') : $data;
        if ($model->load($data) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Teacher model.
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
     * Finds the Teacher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teacher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Teacher::findOne($id)) !== null) {
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
                if ($baseName != '教师信息表'){
                    $model->addError('uploader','请勿修改模板');
                    return $this->render('import',['model'=>$model]);
                }
                $ext = $model->uploader->getExtension();
                $file = "/excel/".$baseName.'.'.$ext;
                $uploadRoot = \Yii::getAlias('@frontendExcelUpload');
                $fileName = $uploadRoot.$file;
                //保存文件
                $model->uploader->saveAs($fileName,false);
                $teacherModel = new Teacher();
                $dataModel = $teacherModel->importData($fileName);

                foreach ($dataModel as $item){
                    if ($item['Teacher']['name'] == null){
                        continue;
                    }
                    $_model = clone $teacherModel; //克隆对象
                    if ($_model->load($item) && $_model->save(false)){
                        continue;
                    }else{
                        \Yii::$app->session->setFlash('warning','导入失败');
                        return $this->render('import',['model'=>$model]);
                    }
                }
                \Yii::$app->session->setFlash('success','导入成功');
                return $this->redirect(array('/teacher/index'));
            }
        }

        return $this->render('import',['model'=>$model]);
    }

    //模板下载
    public function actionDownload(){
        $file = \Yii::getAlias('@frontendDownload').'/excel'.'/'.'教师信息表.xlsx';
        if (!file_exists($file)){
            Yii::$app->session->setFlash('warning','文件不存在');
            return $this->redirect(array('/student/index'));
        }else{
            $wrstr = htmlspecialchars_decode(file_get_contents($file));
            $outfile='教师信息表.xlsx';
            header('Content-type: application/octet-stream; charset=utf8');
            Header("Accept-Ranges: bytes");
            header('Content-Disposition: attachment; filename='.$outfile);
            echo $wrstr;
            exit();
        }
    }
}
