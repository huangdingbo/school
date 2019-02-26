<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="搜索..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => '智慧校园Demo', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    /*成绩管理模块*/
                    [
                        'label' => '成绩管理模块',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '学生成绩查询', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => '录入学生成绩', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    /*档案管理模块*/
                    [
                        'label' => '档案管理模块',
                        'icon' => 'share',
                        'class'=>'fa-clipboard',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => '学生档案管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '学生基本信息管理', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['student/index']),],
                                    [
                                        'label' => '学生数据表配置',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => '职务表', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['duty/index','type' => '1']),],
                                            ['label' => '政治面貌表', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['political/index','type' => '1']),],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'label' => '教师档案管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '教师基本信息管理', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['teacher/index']),],
                                    [
                                        'label' => '教师数据表配置',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => '学历表', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['diploma/index']),],
                                            ['label' => '职称表', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['title/index']),],
                                            ['label' => '职务表', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['duty/index','type' => '2']),],
                                            ['label' => '政治面貌表', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['political/index','type' => '2']),],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'label' => '班级档案管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '班级基本信息管理', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['class-message/index']),],
                                    [
                                        'label' => '班级表配置',
                                        'icon' => 'circle-o',
                                        'url' => \yii\helpers\Url::to(['class0/index']),
                                    ],
                                ],
                            ],
                            [
                                'label' => '其他数据表配置',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '年级表配置', 'icon' => 'circle-o', 'url' => \yii\helpers\Url::to(['grade/index']),],
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
                                    ['label' => '课程管理', 'icon' => 'circle-o', 'url' => '#',],
                                    ['label' => '排课', 'icon' => 'circle-o', 'url' => '#',],
                                    ['label' => '查看课表', 'icon' => 'circle-o', 'url' => '#',],
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
