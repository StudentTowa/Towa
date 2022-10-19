    <?php
    $dsn = 'データベース名';
    $user = 'ユーザ名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    

    
$namevalue="";
$commentvalue="";
$edit_num="";


     if(!empty($_POST["edit_num"])){
        
            $id=$_POST["edit_num"];
            $sql = 'SELECT * FROM Testtable WHERE id='.$id;
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
        foreach ($results as $row){
            $edit_num=$_POST["edit_num"];
            if($edit_num=$row['id']){
                $namevalue=$row['name'];
                $commentvalue=$row['comment'];
                echo "現在".$row['id']."番のコメントを編集しています";
            }
            
        }
    }



?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1.php</title>
</head>
<body>





    <form action="" method="post">
        <input type="text" name="name" placeholder="名前" value= <?=$namevalue?>><br>
        <input type="text" name="comment" placeholder="コメント" value= <?=$commentvalue?>><br>
        <input type="password" name="pass"　placeholder="パスワード">
        <input type="hidden" name="edit_num_decide" placeholder="" value= <?=$edit_num?>><br>
        <input type="submit" name="submit">
    </form>
    
    <form action="" method="post">
        <input type="num" name="delete_num" placeholder="削除番号">
        <input type="password" name="pass"　placeholder="パスワード">
        <input type="submit" name="submit"  value="削除">
        
        
    </form>
    
    <form action="" method="post">
        <input type="num" name="edit_num" placeholder="編集番号">
        <input type="submit" name="submit"  value="編集">
        
        
    </form>
    
</body>
<?php


//投稿コード
    if(!empty($_POST["name"]) && !empty($_POST["comment"])&& $_POST["edit_num_decide"]==""){
    $sql = $pdo -> prepare("INSERT INTO Testtable (name, comment, pass) VALUES (:name, :comment, :pass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
   
    $name = $_POST["name"];
    $comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
    $pass= $_POST["pass"];
    
    $sql -> execute();
    echo "コメントを投稿しました<br><br><br>";
    }
    
    
    //削除コード
    if(!empty($_POST["delete_num"])){
        $delete_num=$_POST["delete_num"];
        $id = $delete_num;
        $pass_decide= $_POST["pass"];
        $sql = 'delete from Testtable where id=:id and pass=:pass';
        $stmt = $pdo->prepare($sql);

        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> bindParam(':pass', $pass_decide, PDO::PARAM_INT);


            $stmt->execute();                        //■■■　ここで削除が実行される　■■■
        
    }
    




//編集コード
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["edit_num_decide"])){
        $id = $_POST["edit_num_decide"]; //変更する投稿番号
        $name = $_POST["name"];
        $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
        $pass= $_POST["pass"];
        
        $sql = 'UPDATE Testtable SET name=:name,comment=:comment WHERE id=:id  and pass=:pass';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
        $stmt->execute();
    }


















//表示コード
    $sql = 'SELECT * FROM Testtable';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].'<br>';
        echo $row['name'].'<br>';
        echo $row['comment'].'<br>';


    echo "<hr>";
    }
    
    

?>






</html>