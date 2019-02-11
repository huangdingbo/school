<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>成绩录入</title>

</head>
<body>
<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>

<form onkeydown="if(event.keyCode==13)return false">
    <table>
        <tr>
            <td><input type="text" name="lastname" autocomplete="off" value=""></td>
            <td><input type="text" name="lastname" autocomplete="off" value=""></td>
            <td><input type="text" name="firstname" autocomplete="off" value=""></td>
            <td><input type="text" name="firstname" autocomplete="off" value=""></td>
        </tr>
        <tr>
            <td><input type="text" name="lastname" autocomplete="off" value=""></td>
            <td><input type="text" name="lastname" autocomplete="off" value=""></td>
            <td><input type="text" name="lastname" autocomplete="off" value=""></td>
            <td><input type="text" name="lastname" autocomplete="off" value=""></td>
        </tr>
    </table>
    <input type="submit" value="Submit">
</form>
<script type="text/javascript">
    let tr = '',td = '';
    let tr_length = 2;      //tr长度
    let td_length = 4;      //td长度
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
            $('table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }else if(e.keyCode == 37) {
            td = td - 1;
            if(td== -1){
                td = 0
            }
            $('table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }else if(e.keyCode == 38){
            tr = tr - 1;
            if(tr == -1){
                tr = 0
            }
            $('table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }else if(e.keyCode == 40){
            tr = tr + 1;
            if(tr == tr_length){
                tr = tr_length-1
            }
            $('table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }

        if(e.keyCode == 13){
            tr = tr + 1;
            if(tr == tr_length){
                tr = tr_length-1
            }
            $('table').find('tr').eq(tr).find('td').eq(td).find('input').show().focus();
        }
    })

</script>

</body>
</html>