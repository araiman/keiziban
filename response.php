<?php
    //データベースへの接続
    try{
        $dbh =new PDO('mysql:host=us-cdbr-iron-east-01.cleardb.ne;dbname=heroku_6eed521c7bf0f9d;charset=utf8','b483fab2394946:b6a0e0f8','b6a0e0f8');
     } catch (Exception $e) {
        var_dump($e->getMessage());
        exit;
    }
    
    $id = $_GET['id'];
    
    $stmt_add = $dbh->prepare("insert into response (id,username,contents) values(?,?,?)");
     
    //responseから同一idのデータを取ってくる
    $sql ="select username,contents from response where id =" .$id;
    $stmt = $dbh->query($sql);
    
    //threadからthnameを取ってくる
    $sql_get_thname = "select thname,username from thread where id =" .$id;
    $stmt_thname= $dbh->query($sql_get_thname);
    
    //レスの件数を数える
    
    $dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $count_stmt = $dbh ->query($sql);
    $count_stmt->execute();
    $count=$count_stmt->rowCount();
    
    


    
    //投稿されたら、表示する
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newcon']) ){
			$newcon = trim($_POST['newcon']);
			$newusername = trim($_POST['newusername']);
			if($newcon !== ""){
                            $newusername= ($newusername =="") ? "名無し" : $newusername;
                                
                            $stmt_add ->execute(array($id,$newusername,$newcon));
				
                            header("Location: response.php?id={$id}");
				
			
			}
    }

    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KEIBANresponse</title>
    </head>
    <body>
        <h1>
            <?php 
                foreach($stmt_thname ->fetchAll(PDO::FETCH_ASSOC) as $sh_thname){
                echo $sh_thname['thname'];
                echo " ". "by" ." ";
                echo $sh_thname['username'];
                }
            ?>
            
            
        </h1>
        <form action="" method="post">
            <p>Name</p>
            <input type="text" name="newusername" maxlength="30">
            <p>Contents</p>
            <input type="text" name="newcon" size="100">
            <br><br>
            <input type="submit" value="Submit">
            
        </form>
            <h2>Index of response (<?php echo $count ?>items)</h2>
            <ol>
                <?php foreach($stmt ->fetchAll(PDO::FETCH_ASSOC) as $user): ?>
                    <li>
                        <?php echo $user['username'] ; ?>
                        <?php echo $user['contents']; ?>
                    </li>    
                    
                <?php endforeach; ?>
            </ol>
    </body>
</html>
