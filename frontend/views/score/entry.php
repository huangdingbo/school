<?php
use kartik\select2\Select2;
use yii\widgets\LinkPager;

$this->title = \frontend\models\Grade::findOne(['id'=>$testInfo->grade_num])->the.'届'.$testInfo->test_name.'成绩录入';
$this->params['breadcrumbs'][] = ['label' => '课程管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    td{
        text-align: center;
    }
    #input{
        text-align: center;
    }
</style>
<p></p>
<p></p>

<div class="table-responsive">

    <?php  echo $this->render('_search', ['model' => $searchModel,'testInfo' => $testInfo]); ?>

    <?php
        $page = Yii::$app->request->get('page') ? Yii::$app->request->get('page') : 1;
        $per_page = 15;
    ?>

<form class="form-group" action="index.php?r=score/create&test_num=<?=$testInfo->test_num;?>&id=<?=Yii::$app->request->get('id');?>&page=<?=$page?>&per-page=<?=$per_page?>" method="post" onkeydown="if(event.keyCode==13)return false">
    <table id="table" class="table">
        <tr class="active">
            <td>考号</td>
            <td>姓名</td>
            <td>届</td>
            <td>班级</td>
            <td>考场名</td>
            <td>考场位置</td>
            <td>座位号</td>
            <td>语文</td>
            <td>数学</td>
            <td>外语</td>
            <?= $testInfo->type == 1 ? "<td>物理</td><td>化学</td> <td>生物</td>" : "<td>政治</td><td>历史</td> <td>地理</td>";?>
        </tr>

        <?php foreach ($list as $key => $item){ ;?>
            <tr class=<?=$key%2 == 0 ? 'success' : 'info';?>>
                <td><input id="input" class="form-control" type="text" name="" autocomplete="off" value=<?=$item['cand_id'];?> readonly></td>
                <td><input id="input" class="form-control" type="text" name="" autocomplete="off" value=<?=$item['name'];?> readonly></td>
                <td><input id="input" class="form-control" type="text" name="" autocomplete="off" style="width: 70px" value=<?=$item['grade'];?> readonly></td>
                <td><input id="input" class="form-control" type="text" name="" autocomplete="off" style="width: 60px" value=<?=$item['banji'];?> readonly></td>
                <td><input id="input" class="form-control" type="text" name="" autocomplete="off" value=<?=$item['test_room'];?> readonly></td>
                <td><input id="input" class="form-control" type="text" name="" autocomplete="off"  style="width: 100px" value=<?=$item['location'];?> readonly></td>
                <td><input id="input" class="form-control" type="text" name="" autocomplete="off" style="width: 45px" value=<?=$item['seat_num'];?> readonly></td>
                <td><input id="input" class="form-control" type="text" name=<?=$item['id'].'_1_'.$testInfo->type?> autocomplete="off" value=<?= $item['chinese'] ? $item['chinese'] : ''?>></td>
                <td><input id="input" class="form-control" type="text" name=<?=$item['id'].'_2_'.$testInfo->type?> autocomplete="off" value=<?= $item['math'] ? $item['math'] : ''?>></td>
                <td><input id="input" class="form-control" type="text" name=<?=$item['id'].'_3_'.$testInfo->type?> autocomplete="off" value=<?= $item['english'] ? $item['english'] : ''?>></td>
                <td><input id="input" class="form-control" type="text" name=<?=$item['id'].'_4_'.$testInfo->type?> autocomplete="off" value=<?php
                    if ($testInfo->type == 1){
                        echo $item['physics'] ? $item['physics'] : '';
                    }else{
                        echo $item['politics'] ? $item['politics'] : '';
                    }
                    ;?>></td>
                <td><input id="input" class="form-control" type="text" name=<?=$item['id'].'_5_'.$testInfo->type?> autocomplete="off" value=<?php
                    if ($testInfo->type == 1){
                        echo $item['chemistry'] ? $item['chemistry'] : '';
                    }else{
                        echo $item['history'] ? $item['history'] : '';
                    }
                    ;?>></td>
                <td><input id="input" class="form-control" type="text" name=<?=$item['id'].'_6_'.$testInfo->type?> autocomplete="off" value=<?php
                    if ($testInfo->type == 1){
                        echo $item['biology'] ? $item['biology'] : '';
                    }else{
                        echo $item['geography'] ? $item['geography'] : '';
                    }
                    ;?>></td>
            </tr>
        <?php }?>
    </table>
    <p>
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination'=>$dataProvider->pagination,
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
        ]);
        ;?>
    </p>
    <p>
        <input type="submit" value="保 存" class="btn btn-success">
    </p>

 </form>
</div>
<?php
$js = <<<JS
 let tr = '',td = '';
    let tr_length = 16;      //tr长度
    let td_length = 13;      //td长度
    $('input').click(function(e){
        tr = $(this).parents('tr').index();
        td = $(this).parent('td').index();
    });

    $('input').keyup(function(e){
        if(e.keyCode == 39){
            td = td + 1;
            if(td == td_length){
                td = td_length-1
            }
            $('#table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }else if(e.keyCode == 37) {
            td = td - 1;
            if(td== -1){
                td = 0
            }
            $('#table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }else if(e.keyCode == 38){
            tr = tr - 1;
            if(tr == -1){
                tr = 0
            }
            $('#table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }else if(e.keyCode == 40){
            tr = tr + 1;
            if(tr == tr_length){
                tr = tr_length-1
            }
            $('#table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }

        if(e.keyCode == 13){
            tr = tr + 1;
            if(tr == tr_length){
                tr = tr_length-1
            }
            $('#table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }
    })
JS;
$this->registerJs($js);
;?>
