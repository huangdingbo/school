<?php
use kartik\select2\Select2;

$this->title = '排课：'.(\frontend\models\Grade::find()->where(['id'=>$info->grade])->one())->the.'届'.(\frontend\models\Class0::find()->where(['id'=>$info->banji])->one())->name;
$this->params['breadcrumbs'][] = ['label' => '课程管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    tr{
        text-align: center;
    }
    td{
        text-align: center;
    }
    .table-responsive{
        padding-top: 30px;
    }
</style>
<div class="table-responsive">
    <form action="index.php?r=course/create" method="post">
        <input type="hidden" name="grade"  value="<?=$info->grade ?>">
        <input type="hidden" name="banji"  value="<?=$info->banji ?>">
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
            <tr class="info">
                <td>第一节</td>
                <td><?=Select2::widget([
                        'name' => '1_1',
                        'data' => $data,
                        'value' => isset($value[11]) ? $value[11] :  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '2_1',
                        'data' => $data,
                        'value' => isset($value[21]) ? $value[21] :  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '3_1',
                        'data' => $data,
                        'value' => isset($value[31])  ?$value[31]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '4_1',
                        'data' => $data,
                        'value' => isset($value[41])  ?$value[41]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '5_1',
                        'data' => $data,
                        'value' => isset($value[51]) ?$value[51]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '6_1',
                        'data' => $data,
                        'value' => isset($value[61]) ?$value[61]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '7_1',
                        'data' => $data,
                        'value' => isset($value[71]) ?$value[71]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
            </tr>
            <tr class="success">
                <td>第二节</td>
                <td><?=Select2::widget([ 'name' => '1_2',
                        'data' => $data,
                        'value' => isset($value[12]) ?$value[12]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '2_2',
                        'data' => $data,
                        'value' => isset($value[22]) ?$value[22]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '3_2',
                        'data' => $data,
                        'value' => isset($value[32])  ?$value[32]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '4_2',
                        'data' => $data,
                        'value' => isset($value[42]) ?$value[42]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '5_2',
                        'data' => $data,
                        'value' => isset($value[52]) ?$value[52]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '6_2',
                        'data' => $data,
                        'value' => isset($value[62]) ?$value[62]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '7_2',
                        'data' => $data,
                        'value' => isset($value[72]) ?$value[72]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
            </tr>
            <tr class="info">
                <td>第三节</td>
                <td><?=Select2::widget([ 'name' => '1_3',
                        'data' => $data,
                        'value' => isset($value[13]) ?$value[13]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '2_3',
                        'data' => $data,
                        'value' => isset($value[23]) ?$value[23]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '3_3',
                        'data' => $data,
                        'value' => isset($value[33]) ?$value[33]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '4_3',
                        'data' => $data,
                        'value' => isset($value[43]) ?$value[43]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '5_3',
                        'data' => $data,
                        'value' => isset($value[53]) ?$value[53]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '6_3',
                        'data' => $data,
                        'value' => isset($value[63]) ?$value[63]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '7_3',
                        'data' => $data,
                        'value' => isset($value[73]) ?$value[73]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
            </tr>
            <tr class="success">
                <td>第四节</td>
                <td><?=Select2::widget([ 'name' => '1_4',
                        'data' => $data,
                        'value' => isset($value[14]) ?$value[14]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '2_4',
                        'data' => $data,
                        'value' => isset($value[24]) ?$value[24]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '3_4',
                        'data' => $data,
                        'value' => isset($value[34]) ?$value[34]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '4_4',
                        'data' => $data,
                        'value' => isset($value[44]) ?$value[44]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '5_4',
                        'data' => $data,
                        'value' => isset($value[54]) ?$value[54]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '6_4',
                        'data' => $data,
                        'value' => isset($value[64])  ?$value[64]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '7_4',
                        'data' => $data,
                        'value' => isset($value[74]) ?$value[74]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
            </tr>
            <tr class="info">
                <td>第五节</td>
                <td><?=Select2::widget([ 'name' => '1_5',
                        'data' => $data,
                        'value' => isset($value[15]) ?$value[15]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '2_5',
                        'data' => $data,
                        'value' => isset($value[25])  ?$value[25]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '3_5',
                        'data' => $data,
                        'value' => isset($value[35]) ?$value[35]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '4_5',
                        'data' => $data,
                        'value' => isset($value[45])  ?$value[45]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '5_5',
                        'data' => $data,
                        'value' => isset($value[55])  ?$value[55]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '6_5',
                        'data' => $data,
                        'value' => isset($value[65]) ?$value[65]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '7_5',
                        'data' => $data,
                        'value' => isset($value[75]) ?$value[75]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
            </tr>
            <tr class="success">
                <td>第六节</td>
                <td><?=Select2::widget([ 'name' => '1_6',
                        'data' => $data,
                        'value' => isset($value[16]) ?$value[16]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '2_6',
                        'data' => $data,
                        'value' => isset($value[26]) ?$value[26]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '3_6',
                        'data' => $data,
                        'value' => isset($value[36]) ?$value[36]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '4_6',
                        'data' => $data,
                        'value' => isset($value[46]) ?$value[46]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '5_6',
                        'data' => $data,
                        'value' => isset($value[56]) ?$value[56]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '6_6',
                        'data' => $data,
                        'value' => isset($value[66]) ?$value[66]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '7_6',
                        'data' => $data,
                        'value' => isset($value[76])  ?$value[76]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
            </tr>
            <tr class="info">
                <td>第七节</td>
                <td><?=Select2::widget([ 'name' => '1_7',
                        'data' => $data,
                        'value' => isset($value[17]) ?$value[17]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '2_7',
                        'data' => $data,
                        'value' => isset($value[27]) ?$value[27]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '3_7',
                        'data' => $data,
                        'value' => isset($value[37]) ?$value[37]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '4_7',
                        'data' => $data,
                        'value' => isset($value[47]) ?$value[47]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '5_7',
                        'data' => $data,
                        'value' => isset( $value[57]) ?$value[57]:  '',
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '6_7',
                        'data' => $data,
                        'value' => isset($value[67]) ?$value[67]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
                <td><?=Select2::widget([ 'name' => '7_7',
                        'data' => $data,
                        'value' => isset($value[77]) ?$value[77]:  '' ,
                        'options' => ['placeholder' => '请选择...']

                    ]);?>
                </td>
            </tr>
        </table>
        <button class="btn btn-success" type="submit">提交</button>
    </form>
</div>
