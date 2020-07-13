<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
        
    <h2>掲示板！</h2>

<?php

     //POSTで受け取る
        $name_in = $_POST["name"];
        $str_in = $_POST["str"];
     //deteteの番号
        $num_del = $_POST["num_del"];
    //editの番号
        $num_edit = $_POST["num_edit"];
    //now 編集番号
        $num_now = $_POST["num_now"];
    //passの読み込み
        $pass_id=$_POST['pass_in'];
        $pass_del=$_POST['pass_del'];
        $pass_edit=$_POST["pass_edit"];
        
    //現在時刻
        $date =date(DATE_ATOM);
        
        //echo $num_edit;

	// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//テーブル作成 mission_5  ...4-3で確認済
	$sql = "CREATE TABLE IF NOT EXISTS mission_5"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "time TEXT"
	.");";
	$stmt = $pdo->query($sql);
	
	
	//入力 4-5 Insert
    if($pass_id=='passward' && $name_in && $str_in && empty($num_now)){//passward
    	$sql = $pdo -> prepare("INSERT INTO mission_5 (name, comment, time) VALUES (:name, :comment, :time)");
        $name = $name_in;
    	$comment = $str_in; 
    	$time = $date;
        
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
    	
    	$sql -> execute();
    }
    //編集番号を入れたとき、入力フォームに表示
    if($num_edit && $pass_edit=='passward'){
        $id =$num_edit;
        $sql = 'SELECT * FROM mission_5 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
        	foreach ($results as $row){
        		//$rowの中にはテーブルのカラム名が入る
        		$num_now=$row['id'];
        		$name_edit=$row['name'];
        		$str_edit=$row['comment'];
        }
    }
    if($num_now && $pass_id=='passward' && $name_in && $str_in){
        $id = $num_now; //変更する投稿番号
	    $name = $name_in;
    	$comment = $str_in; 
    	$time = $date;
    	
    	$sql = 'UPDATE mission_5 SET name=:name,comment=:comment, time=:time WHERE id=:id';
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    	$stmt -> bindParam(':time', $time, PDO::PARAM_STR);
    	$stmt->execute();

    }
    
    
    
    //削除 4-8 
    if($pass_del=='passward' && $num_del){
        $id=$num_del;
        $sql ='delete from mission_5 where id=:id';
        $stmt =$pdo->prepare($sql);
        $stmt->bindParam(':id' , $id, PDO::PARAM_INT);
    	$stmt->execute();
    }
    	
	//全文表示 4-6
    	$sql = 'SELECT * FROM mission_5'.PHP_EOL;
    	$stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        echo "<hr size='20' >";
    	foreach ($results as $row ){
    		echo $row['id'].'   ';
    		echo $row['name'].'   ';
    		echo $row['comment'].'   ';
    		echo $row['time'].'<br>';
    	echo "<hr>";
    	}
    	echo "<hr size='20'>";

?>

        <form action="" method="post">
        <!--名前＆コメント-->
    --------------------------書き込みはこちら！-------------------------------------<br>
            <input type="hidden" name="num_now" placeholder='NOW' value ='<?php if($num_now){ echo $num_now;} ?>'>  
            <input type="text" name="name" placeholder='YOUR NAME' value ='<?php if($name_edit){ echo $name_edit;} ?>'>
            <input type="text" name="str" placeholder='comment'value ='<?php if($str_edit){echo $str_edit;} ?>'>
            <!--入力psss-->     
            <input type="text" name="pass_in" placeholder='passward'>
            <input type="submit" name="submit" value='SUBMIT'><br>
        <!--削除-->     
    ~~~~~~~~~~~~~~~~~~~~削除~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br>
            <input type="number" name="num_del" placeholder='delete_number'>
            <!--削除psss-->     
            <input type="text" name="pass_del" placeholder='passward'>
            <input type="submit" name="submit" value='DELETE'><br>
        <!--編集-->    
    ====================編集=============================<br>
            <input type="number" name="num_edit" placeholder='Edit'>
            <!--編集psss-->     
            <input type="text" name="pass_edit" placeholder='passward'>
            <input type="submit" name="submit" value='EDIT'><br>

        </form>

</body>
</html>