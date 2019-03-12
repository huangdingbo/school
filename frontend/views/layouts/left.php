<?php
$userId = Yii::$app->user->id;
$userModel = \frontend\models\Adminuser::findOne(['id'=>$userId]);
$userName = isset($userModel) ? $userModel->username : '';
$nickName = isset($userModel) ? $userModel->nickname : '';
$lastLogin = isset($userModel) ? $userModel->last_login : '';
$pic = isset($userModel) ? $userModel->pic : Yii::$app->request->getHostInfo().'/school/frontend'. Yii::$app->params['defaultImg'];
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel" style="padding:10px 10px 0">
            <div class="pull-left image" style="margin-top: 10px">
                <img src="<?= $pic ?>" class="img-circle" alt="User Image"/>
            </div>

            <div class="pull-left info" style="position: relative;left: 10px">
                <p><?= $userName.'('.$nickName.')' ?></p>
                <?php
                    if ($userId){
                        echo "<a href=\"#\"><i class=\"fa fa-circle text-success\"></i> 在线</a>";
                    }else{
                        echo "<a href=\"#\"><i class=\"fa fa-circle text-default\"></i> 离线</a>";
                    }
                ?>

            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control"  style="height: 25px" placeholder="搜索..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat" style="height: 25px;
    line-height: 0;"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => Yii::$app->params['appName'], 'options' => ['class' => 'header']],
//                    ['label' => '系统管理', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => '系统管理',
                        'icon' => 'cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => '管理员', 'icon' => 'user', 'url' => ['adminuser/index'],],
                            ['label' => '用户', 'icon' => 'user-plus', 'url' => ['/debug'],],
                        ],
                    ],
                    /*OA系统*/
                    [
                        'label' => 'OA系统模块',
                        'icon' => 'cogs',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => '校园事件管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '我的工作台', 'icon' => 'user', 'url' => ['cases/index'],],
                                    ['label' => '校园事件概览', 'icon' => 'user', 'url' => ['cases/overview'],],
                                ],
                            ],

                            ['label' => '教职工办公', 'icon' => 'user-plus', 'url' => ['/debug'],],
                        ],
                    ],
                    /*成绩管理模块*/
                    [
                        'label' => '成绩管理模块',
                        'icon' => 'tachometer',
                        'url' => '#',
                        'items' => [
                            ['label' => '学生成绩查询', 'icon' => 'search-plus', 'url' => ['score/index'],],
                            ['label' => '录入学生成绩', 'icon' => 'pencil-square-o', 'url' => ['test/index'],],
                            [
                                'label' => '其他待配置',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '其他待配置', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => '其他待配置',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => '其他待配置', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => '其他待配置', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    /*档案管理模块*/
                    [
                        'label' => '档案管理模块',
                        'icon' => 'folder-open',
                        'class'=>'fa-clipboard',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => '学生档案管理',
                                'icon' => 'graduation-cap',
                                'url' => '#',
                                'items' => [
                                    ['label' => '学生基本信息管理', 'icon' => 'hand-o-right ', 'url' => ['student/index'],],
                                    [
                                        'label' => '学生数据表配置',
                                        'icon' => 'table',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => '职务表', 'icon' => 'hand-o-right ', 'url' => ['duty/index','type' => '1'],],
                                            ['label' => '政治面貌表', 'icon' => 'hand-o-right ', 'url' => ['political/index','type' => '1'],],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'label' => '教师档案管理',
                                'icon' => 'address-book-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '教师基本信息管理', 'icon' => 'circle-o', 'url' => ['teacher/index'],],
                                    [
                                        'label' => '教师数据表配置',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => '学历表', 'icon' => 'circle-o', 'url' => ['diploma/index'],],
                                            ['label' => '职称表', 'icon' => 'circle-o', 'url' => ['title/index'],],
                                            ['label' => '职务表', 'icon' => 'circle-o', 'url' => ['duty/index','type' => '2'],],
                                            ['label' => '政治面貌表', 'icon' => 'circle-o', 'url' => ['political/index','type' => '2'],],

                                        ],
                                    ],
                                ],
                            ],
                            [
                                'label' => '班级档案管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '班级基本信息管理', 'icon' => 'circle-o', 'url' => ['class-message/index'],],
                                    [
                                        'label' => '班级表配置',
                                        'icon' => 'circle-o',
                                        'url' => ['class0/index'],
                                    ],
                                ],
                            ],
                            [
                                'label' => '其他数据表配置',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '年级表配置', 'icon' => 'circle-o', 'url' => ['grade/index'],],
                                ],
                            ],


                        ],
                    ],
                    /*教学管理模块*/
                    [
                        'label' => '教学管理模块',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
//                            ['label' => '学生成绩查询', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                            ['label' => '录入学生成绩', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => '课程管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '课程信息管理', 'icon' => 'circle-o', 'url' => ['grade-class/index'],],
                                    [
                                        'label' => '其他待配置',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => '其他待配置', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => '其他待配置', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],

                            [
                                'label' => '考试管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '考试信息管理', 'icon' => 'circle-o', 'url' => ['test/index'],],
                                    ['label' => '考场设置', 'icon' => 'circle-o', 'url' => ['room/index'],],
                                    ['label' => '考号管理', 'icon' => 'circle-o', 'url' => ['kaohao/index'],],
                                    [
                                        'label' => '其他待配置',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => '其他待配置', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => '其他待配置', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],

                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
