<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
        
    <h2>自粛期間何をしていたか掲示板！</h2>
    <?php
            //初期値の設定
            $i =0;
            $j =0;
            $k =0;

            //POSTで受け取る
            $name = $_POST["name"];
            $str = $_POST["str"];
            //deteteの番号
            $num = $_POST["num"];
            //editの番号
            $num_ED = $_POST["num0"];
            //now 編集番号
            $num_now = $_POST["num1"];
            //passの読み込み
            $pass_in=$_POST['pass_in'];
            $pass_del=$_POST['pass_del'];
            $pass_edit=$_POST["pass_edit"];
            

            //下に更新時刻を表示
            $date =date(DATE_ATOM);
            echo '最終更新日時<br>';
            echo $date.'<br>';
            echo '---------------------------------------------<br>';
            
            //ファイルを作成    
            $filename="mission_3-5.txt";
            $fp = fopen($filename,"a");
            $cnt =count(file($filename));
            
            ////POSTが空でないときファイルに書き込む 新規   
            if($name && $str && !$num_now){
                if($pass_in =='passward'){//pass_inの一致
                    $cnt++;
                    $input =$cnt.'<>'.$name.'<>'.$str.'<>'.$date.PHP_EOL;
                    fwrite($fp , $input);+
                    fclose($fp);
                }
            }        
            //ファイルを1列ごとに配列変数に代入    
            if(file_exists($filename)){
                $lines = array (file($filename,FILE_IGNORE_NEW_LINES));
                foreach($lines as $line){
                }
            }         
            
            //ファイルの中身を削除
             if($num && $pass_del =='passward'){
                $filename="mission_3-5.txt";
                $fp = fopen($filename,"w");
                $cnt0 =count(file($filename));//上手くいかない
                
                $cnt0=20;
                //echo $cnt0;
             
                    for($k=0;$k<=$cnt;$k++){
                        $low =explode('<>',$line[$k]);

                        if($low[0]==$num){//対象の番号のとき
                           //何も表示しない
                        }else{
                            //読み込んだものをそのまま書く
                            $input = $low[0] .'<>'.$low[1].'<>'.$low[2].'<>'.$low[3].PHP_EOL;
                            fwrite($fp, $input);
                        }
                    
                    }
                fclose($fp); 
                unset($num_now); //空にする
               }
            
            //編集番号がinのときの入力
     
           
                if(($name && $str && $num_now) && $pass_in =='passward'){
                    $filename="mission_3-5.txt";
                    $fp = fopen($filename,"w");
                    $cnt0 =count(file($filename));//上手くいかない
                    
                    $cnt0=20;
                    //echo $cnt0;
      
                        while($j<=$cnt0){
                            //echo $line[$i].'<br>';
                            $row =explode('<>',$line[$j]);
                            //echo $low[2].'<br>';
                            if($row[0]==$num_now){//対象の番号のとき
                                $input =$num_now .'<>'.$name.'<>'.$str.'<>'.$date.PHP_EOL;
                                fwrite($fp , $input);
                            }else{//読み込んだものをそのまま書く
                                $input = $row[0] .'<>'.$row[1].'<>'.$row[2].'<>'.$row[3].PHP_EOL;
                                fwrite($fp, $input);
                            }
                            $j++;
                        }
                    fclose($fp); 
                    unset($num_now); //空にする
                }
            


            //画面表示
            while($i<=$cnt ){
                $form =explode('<>',$line[$i]);
                //echo $form[0];
                if($num_ED==$form[0] && $pass_edit =='passward') {
                    echo $pass_del;
                    //(empty($num_ED) or $i!=$form[0] 
                    echo $form[0].' '.$form[1].'  '.$form[2].'  '.$form[3].'<br>';
                    $num_now = $form[0]; //編集番号
                    $name_del = $form[1];
                    $str_del = $form[2];
               
                }else{                  // $form =explode('<>',$line[$i]);
                    echo $form[0].' '.$form[1].'  '.$form[2].'  '.$form[3].'<br>';

                    //編集番号と名前とコメントの変数
                  
                    
                    //stripslashes($_POST["name"]);
                }             
            $i++;
            }
        

        /*echo $name_del;
        echo $str_del;
        echo $num_edit;*/
    ?>
    --------------------------書き込みはこちら！-------------------------------------
    
        <form action="" method="post">
    <!--名前＆コメント-->   
        <input type="hidden" name="num1" placeholder='NOW' value ='<?php if($num_now){ echo $num_now;} ?>'>
        <input type="text" name="name" placeholder='YOUR NAME' value ='<?php if($name_del){ echo $name_del;} ?>'>
        <input type="text" name="str" placeholder='comment'value ='<?php if($str_del){echo $str_del;} ?>'>
        <!--入力psss-->     
    
        <input type="text" name="pass_in" placeholder='passward'>
        <input type="submit" name="submit" value='SUBMIT'><br>
    <!--削除-->     
    ~~~~~~~~~~~~~~~~~~~~削除~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br>
        <input type="number" name="num" placeholder='delete_number'>
        <!--削除psss-->     
        <input type="text" name="pass_del" placeholder='passward'>
        <input type="submit" name="submit" value='DELETE'><br>
    <!--編集-->    
    ====================編集=============================<br>
        <input type="number" name="num0" placeholder='Edit'>
        <!--編集psss-->     
        <input type="text" name="pass_edit" placeholder='passward'>
        <input type="submit" name="submit" value='EDIT'><br>
        </form>

</body>
</html>