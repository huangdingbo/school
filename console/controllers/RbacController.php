<?php
/**
 * Created by PhpStorm.
 * User: 黄定波
 * Date: 2019/3/3
 * Time: 14:09
 */

namespace console\controllers;

use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit(){
        $auth = \Yii::$app->authManager;

        //档案管理模块

        //学生档案管理首页权限
        $indexStudentDoc = $auth->createPermission('indexStudentDoc');
        $indexStudentDoc->description = '学生档案管理首页权限';
        $auth->add($indexStudentDoc);

        //学生档案管理创建权限
        $creatStudentDoc = $auth->createPermission('createStudentDoc');
        $creatStudentDoc->description = '学生档案管理创建权限';
        $auth->add($creatStudentDoc);

        //学生档案管理查看权限
        $viewStudentDoc = $auth->createPermission('viewStudentDoc');
        $viewStudentDoc->description = '学生档案管理查看权限';
        $auth->add($viewStudentDoc);

        //学生档案管理更新权限
        $updateStudentDoc = $auth->createPermission('updateStudentDoc');
        $updateStudentDoc->description = '学生档案管理更新权限';
        $auth->add($updateStudentDoc);

        //学生档案管理删除权限
        $deleteStudentDoc = $auth->createPermission('deleteStudentDoc');
        $deleteStudentDoc->description = '学生档案管理删除权限';
        $auth->add($deleteStudentDoc);

        //学生档案管理导入权限
        $importStudentDoc = $auth->createPermission('importStudentDoc');
        $importStudentDoc->description = '学生档案管理导入权限';
        $auth->add($importStudentDoc);

        //学生档案管理导出权限
        $exportStudentDoc = $auth->createPermission('exportStudentDoc');
        $exportStudentDoc->description = '学生档案管理导出权限';
        $auth->add($exportStudentDoc);

        //学生档案管理模板下载权限
        $downloadStudentDoc = $auth->createPermission('downloadStudentDoc');
        $downloadStudentDoc->description = '学生档案管理模板下载权限';
        $auth->add($downloadStudentDoc);

        //学生数据表配置权限
        $studentTable = $auth->createPermission('studentTable');
        $studentTable->description = '学生数据表配置权限';
        $auth->add($studentTable);

        //创建角色-学生档案管理角色
        $studentDocManager = $auth->createRole('studentDocManager');
        $studentDocManager->description = '学生档案管理员';
        $auth->add($studentDocManager);
        $auth->addChild($studentDocManager,$creatStudentDoc);
        $auth->addChild($studentDocManager,$viewStudentDoc);
        $auth->addChild($studentDocManager,$updateStudentDoc);
        $auth->addChild($studentDocManager,$deleteStudentDoc);
        $auth->addChild($studentDocManager,$importStudentDoc);
        $auth->addChild($studentDocManager,$exportStudentDoc);
        $auth->addChild($studentDocManager,$downloadStudentDoc);
        $auth->addChild($studentDocManager,$indexStudentDoc);
        $auth->addChild($studentDocManager,$studentTable);
        /***************************************************************************************************/
        //教师档案管理首页权限
        $indexTeacherDoc = $auth->createPermission('indexTeacherDoc');
        $indexTeacherDoc->description = '教师档案管理首页权限';
        $auth->add($indexTeacherDoc);

        //教师档案管理创建权限
        $createTeacherDoc = $auth->createPermission('createTeacherDoc');
        $createTeacherDoc->description = '教师档案管理创建权限';
        $auth->add($createTeacherDoc);

        //教师档案管理查看权限
        $viewTeacherDoc = $auth->createPermission('viewTeacherDoc');
        $viewTeacherDoc->description = '教师档案管理查看权限';
        $auth->add($viewTeacherDoc);

        //教师档案管理更新权限
        $updateTeacherDoc = $auth->createPermission('updateTeacherDoc');
        $updateTeacherDoc->description = '教师档案管理更新权限';
        $auth->add($updateTeacherDoc);

        //教师档案管理删除权限
        $deleteTeacherDoc = $auth->createPermission('deleteTeacherDoc');
        $deleteTeacherDoc->description = '教师档案管理删除权限';
        $auth->add($deleteTeacherDoc);

        //教师档案管理导入权限
        $importTeacherDoc = $auth->createPermission('importTeacherDoc');
        $importTeacherDoc->description = '教师档案管理导入权限';
        $auth->add($importTeacherDoc);

        //教师档案管理导出权限
        $exportTeacherDoc = $auth->createPermission('exportTeacherDoc');
        $exportTeacherDoc->description = '教师档案管理导出权限';
        $auth->add($exportTeacherDoc);

        //教师档案管理模板下载权限
        $downloadTeacherDoc = $auth->createPermission('downloadTeacherDoc');
        $downloadTeacherDoc->description = '教师档案管理模板下载权限';
        $auth->add($downloadTeacherDoc);

        //教师数据表配置权限
        $teacherTable = $auth->createPermission('teacherTable');
        $teacherTable->description = '教师数据表配置权限';
        $auth->add($teacherTable);

        //创建角色-教师档案管理角色
        $TeacherDocManager = $auth->createRole('TeacherDocManager');
        $TeacherDocManager->description = '教师档案管理员';
        $auth->add($TeacherDocManager);
        $auth->addChild($TeacherDocManager,$createTeacherDoc);
        $auth->addChild($TeacherDocManager,$viewTeacherDoc);
        $auth->addChild($TeacherDocManager,$updateTeacherDoc);
        $auth->addChild($TeacherDocManager,$deleteTeacherDoc);
        $auth->addChild($TeacherDocManager,$importTeacherDoc);
        $auth->addChild($TeacherDocManager,$exportTeacherDoc);
        $auth->addChild($TeacherDocManager,$downloadTeacherDoc);
        $auth->addChild($TeacherDocManager,$indexTeacherDoc);
        $auth->addChild($TeacherDocManager,$teacherTable);

        /*******************************************************************************************/
        // 班级档案管理查看权限
        $viewClassDoc = $auth->createPermission('viewClassDoc');
        $viewClassDoc->description = '班级档案管理查看权限';
        $auth->add($viewClassDoc);

        // 班级档案管理首页权限
        $indexClassDoc = $auth->createPermission('indexClassDoc');
        $indexClassDoc->description = '班级档案管理首页权限';
        $auth->add($indexClassDoc);

        // 班级档案管理修改权限
        $updateClassDoc = $auth->createPermission('updateClassDoc');
        $updateClassDoc->description = '班级档案管理修改权限';
        $auth->add($updateClassDoc);

        // 班级档案管理删除权限
        $deleteClassDoc = $auth->createPermission('deleteClassDoc');
        $deleteClassDoc->description = '班级档案管理删除权限';
        $auth->add($deleteClassDoc);

        // 班级档案管理创建权限
        $createClassDoc = $auth->createPermission('createClassDoc');
        $createClassDoc->description = '班级档案管理创建权限';
        $auth->add($createClassDoc);

        //更新班级人数权限
        $updateClassNumDoc = $auth->createPermission('updateClassNumDoc');
        $updateClassNumDoc->description = '更新班级人数权限';
        $auth->add($updateClassNumDoc);

        // 班级数据表配置权限
        $classTable = $auth->createPermission('classTable');
        $classTable->description = '班级数据表配置权限';
        $auth->add($classTable);

        //创建角色-班级档案管理员
        $classDocManager = $auth->createRole('classDocManager');
        $classDocManager->description = '班级档案管理员';
        $auth->add($classDocManager);
        $auth->addChild($classDocManager,$viewClassDoc);
        $auth->addChild($classDocManager,$indexClassDoc);
        $auth->addChild($classDocManager,$updateClassDoc);
        $auth->addChild($classDocManager,$deleteClassDoc);
        $auth->addChild($classDocManager,$classTable);
        $auth->addChild($classDocManager,$updateClassNumDoc);
        $auth->addChild($classDocManager,$createClassDoc);

        /******************************************************************************/
        //档案管理其他数据表配置权限
        $docOtherTable = $auth->createPermission('docOtherTable');
        $docOtherTable->description = '档案管理其他数据表配置权限';
        $auth->add($docOtherTable);

        //创建角色-档案管理其他数据表配置角色
        $docOtherTableManager = $auth->createRole('docOtherTableManager');
        $docOtherTableManager->description = '档案管理相关数据表管理员';
        $auth->add($docOtherTableManager);
        $auth->addChild($docOtherTableManager,$docOtherTable);

        /***************************************************************************************/
        /***************************************************************************************/
        /***************************************************************************************/
        /***************************************************************************************/
        /***************************************************************************************/
        /***************************************************************************************/
        //教学管理模块
        //课程管理
        // 课程创建权限
        $createCourse = $auth->createPermission('createCourse');
        $createCourse->description = '课程创建权限';
        $auth->add($createCourse);

        // 排课权限
        $arrangingCourse = $auth->createPermission('arrangingCourse');
        $arrangingCourse->description = '排课权限';
        $auth->add($arrangingCourse);

        // 导出课表权限
        $exportCourse = $auth->createPermission('exportCourse');
        $exportCourse->description = '导出课表权限';
        $auth->add($exportCourse);

        // 课程删除权限
        $deleteCourse = $auth->createPermission('deleteCourse');
        $deleteCourse->description = '课程删除权限';
        $auth->add($deleteCourse);

        // 课程首页权限
        $indexCourse = $auth->createPermission('indexCourse');
        $indexCourse->description = '课程删除权限';
        $auth->add($indexCourse);

        // 课程查看权限
        $viewCourse = $auth->createPermission('viewCourse');
        $viewCourse->description = '课程查看权限';
        $auth->add($viewCourse);

        //创建角色-课程管理员
        $courseManager = $auth->createRole('courseManager');
        $courseManager->description = '课程管理员';
        $auth->add($courseManager);
        $auth->addChild($courseManager,$createCourse);
        $auth->addChild($courseManager,$arrangingCourse);
        $auth->addChild($courseManager,$exportCourse);
        $auth->addChild($courseManager,$deleteCourse);
        $auth->addChild($courseManager,$indexCourse);
        $auth->addChild($courseManager,$viewCourse);

        /*********************************************************************************************/
        //考试管理
        // 考试信息管理首页权限
        $indexTest = $auth->createPermission('indexTest');
        $indexTest->description = '考试信息管理首页权限';
        $auth->add($indexTest);

        // 考试信息管理生成考号权限
        $createTestNum = $auth->createPermission('createTestNum');
        $createTestNum->description = '考试信息管理生成考号权限';
        $auth->add($createTestNum);

        // 考试信息管理录入成绩权限
        $entryTestScore = $auth->createPermission('entryTestScore');
        $entryTestScore->description = '考试信息管理录入成绩权限';
        $auth->add($entryTestScore);

        // 考试信息管理结束考试权限
        $endTest = $auth->createPermission('endTest');
        $endTest->description = '考试信息管理结束考试权限';
        $auth->add($endTest);

        // 考试信息管理删除考试权限
        $deleteTest = $auth->createPermission('deleteTest');
        $deleteTest->description = '考试信息管理删除考试权限';
        $auth->add($deleteTest);

        // 考试信息管理发布考试权限
        $createTest = $auth->createPermission('createTest');
        $createTest->description = '考试信息管理发布考试权限';
        $auth->add($createTest);

        // 考试信息管理修改考试权限
        $updateTest = $auth->createPermission('updateTest');
        $updateTest->description = '考试信息管理修改考试权限';
        $auth->add($updateTest);

        //创建角色-考试信息管理员
        $testMessageManager = $auth->createRole('testMessageManager');
        $testMessageManager->description = '考试信息管理员';
        $auth->add($testMessageManager);
        $auth->addChild($testMessageManager,$indexTest);
        $auth->addChild($testMessageManager,$createTestNum);
        $auth->addChild($testMessageManager,$entryTestScore);
        $auth->addChild($testMessageManager,$endTest);
        $auth->addChild($testMessageManager,$deleteTest);
        $auth->addChild($testMessageManager,$createTest);
        $auth->addChild($testMessageManager,$updateTest);

        /*******************************************************************************************************/
        //考场管理员
        // 考场管理首页权限
        $indexRoom = $auth->createPermission('indexRoom');
        $indexRoom->description = '考场管理首页权限';
        $auth->add($indexRoom);

        // 考场管理修改权限
        $updateRoom = $auth->createPermission('updateRoom');
        $updateRoom->description = '考场管理修改权限';
        $auth->add($updateRoom);

        // 考场管理删除权限
        $deleteRoom = $auth->createPermission('deleteRoom');
        $deleteRoom->description = '考场管理删除权限';
        $auth->add($deleteRoom);

        // 考场管理创建权限
        $createRoom = $auth->createPermission('createRoom');
        $createRoom->description = '考场管理创建权限';
        $auth->add($createRoom);

        //创建角色-考场管理员
        $roomManager = $auth->createRole('roomManager');
        $roomManager->description = '考场管理员';
        $auth->add($roomManager);
        $auth->addChild($roomManager,$indexRoom);
        $auth->addChild($roomManager,$updateRoom);
        $auth->addChild($roomManager,$deleteRoom);
        $auth->addChild($roomManager,$createRoom);

        /*******************************************************************************************/
        // 考号管理首页权限
        $indexCand = $auth->createPermission('indexCand');
        $indexCand->description = '考号管理首页权限';
        $auth->add($indexCand);

        // 考号管理删除权限
        $deleteCand = $auth->createPermission('deleteCand');
        $deleteCand->description = '考号管理删除权限';
        $auth->add($deleteCand);

        // 考号管理导出权限
        $exportCand = $auth->createPermission('exportCand');
        $exportCand->description = '考号管理导出权限';
        $auth->add($exportCand);

        //创建角色-考号管理员
        $candManager = $auth->createRole('candManager');
        $candManager->description = '考号管理员';
        $auth->add($candManager);
        $auth->addChild($candManager,$indexCand);
        $auth->addChild($candManager,$deleteCand);
        $auth->addChild($candManager,$exportCand);

        /****************************************************************************************/
        /****************************************************************************************/
        /****************************************************************************************/
        /****************************************************************************************/
        /****************************************************************************************/
        /****************************************************************************************/
        /****************************************************************************************/
        //成绩管理模块
        //学生成绩查询
        // 学生成绩查询首页权限
        $indexScore = $auth->createPermission('indexScore');
        $indexScore->description = '学生成绩查询首页权限';
        $auth->add($indexScore);

        // 学生成绩查看权限
        $viewScore = $auth->createPermission('viewScore');
        $viewScore->description = '学生成绩查看权限';
        $auth->add($viewScore);

        // 学生成绩修改权限
        $updateScore = $auth->createPermission('updateScore');
        $updateScore->description = '学生成绩修改权限';
        $auth->add($updateScore);

        // 学生成绩删除权限
        $deleteScore = $auth->createPermission('deleteScore');
        $deleteScore->description = '学生成绩删除权限';
        $auth->add($deleteScore);

        // 学生成绩导出权限
        $exportScore = $auth->createPermission('exportScore');
        $exportScore->description = '学生成绩删除权限';
        $auth->add($exportScore);

        //创建角色-学生成绩管理员
        $scoreManager = $auth->createRole('scoreManager');
        $scoreManager->description = '学生成绩管理员';
        $auth->add($scoreManager);
        $auth->addChild($scoreManager,$indexScore);
        $auth->addChild($scoreManager,$viewScore);
        $auth->addChild($scoreManager,$updateScore);
        $auth->addChild($scoreManager,$deleteScore);
        $auth->addChild($scoreManager,$exportScore);




        //创建超级管理员
        $admin = $auth->createRole('admin');
        $admin->description = '系统管理员';
        $auth->add($admin);
        $auth->addChild($admin,$studentDocManager);
        $auth->addChild($admin,$TeacherDocManager);
        $auth->addChild($admin,$docOtherTableManager);
        $auth->addChild($admin,$classDocManager);
        $auth->addChild($admin,$courseManager);
        $auth->addChild($admin,$testMessageManager);
        $auth->addChild($admin,$roomManager);
        $auth->addChild($admin,$candManager);
        $auth->addChild($admin,$scoreManager);

        //用户分配角色
        $auth->assign($admin,1);
     }


}