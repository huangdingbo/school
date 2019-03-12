<?php
return [
    'defaultImg' =>'/uploads/images/warning1.png',
    'adminEmail' => 'admin@example.com',
    'appName' => '智慧校园管理后台',
    'version' => 'demo-1.0',
    'perMessage' => '对不起，你没有执行该操作的权限，请联系管理员！！！',
    'ICP' => "<a href='http://www.miitbeian.gov.cn'>蜀ICP备18036906号</a>",
    // 图片服务器的域名设置，拼接保存在数据库中的相对地址，可通过web进行展示
    'domain' => 'http://huangdingbo.work/school/frontend',
    'webuploader' => [
        // 后端处理图片的地址，value 是相对的地址
        'uploadUrl' => 'image/upload',
        // 多文件分隔符
        'delimiter' => ',',
        // 基本配置
        'baseConfig' => [
            'defaultImage' => 'http://img1.imgtn.bdimg.com/it/u=2056478505,162569476&fm=26&gp=0.jpg',
            'disableGlobalDnd' => true,
            'accept' => [
                'title' => 'Images',
                'extensions' => 'gif,jpg,jpeg,bmp,png',
                'mimeTypes' => 'image/*',
            ],
            'pick' => [
                'multiple' => false,
            ],
        ],
    ],
    'imageUploadRelativePath' => '../uploads/images/', // 图片默认上传的目录
    'imageUploadSuccessPath' => '/uploads/images/', // 图片上传成功后，路径前缀
    'groupConfig' => [
        1 => '语文组',
        2 => '数学组',
        3 => '外语组',
        4 => '物理组',
        5 => '化学组',
        6 => '生物组',
        7 => '政治组',
        8 => '历史组',
        9 => '地理组',
    ],
    'sql' => '',
];
