<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\GradeClass */

$this->title = '查看课表：'.(\frontend\models\Grade::find()->where(['id'=>$info->grade])->one())->the.'届'.(\frontend\models\Class0::find()->where(['id'=>$info->banji])->one())->name;
$this->params['breadcrumbs'][] = ['label' => 'Grade Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="grade-class-view">

    <div class="table-responsive">
        <table class="table">
            <tr class="active success">
                <td>节数\周数</td>
                <td>星期一</td>
                <td>星期二</td>
                <td>星期三</td>
                <td>星期四</td>
                <td>星期五</td>
                <td>星期六</td>
                <td>星期日</td>
            </tr>
            <?php
                for ($i=1;$i<8;$i++){
                    if ($i%2 == 0){
                        $tr = "<tr class='success'>";
                    }else{
                        $tr = "<tr class='info'>";
                    }
                    echo $tr;
                        for ($j=0;$j<8;$j++){
                            if ($j == 0){
                                $jie = \common\models\config::$sectionConfig[$i];
                                echo "<td>$jie</td>";
                            }else{
                                echo "<td>";
                                $key = $j.$i;
                                echo  isset($data[$key]) ? $data[$key] : '';
                                echo "</td>";
                            }

                        }

                    echo "</tr>";
                }
            ?>
        </table>
    </div>


</div>
