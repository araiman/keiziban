<?php
    //データベースへの接続
    try{
        $dbh =new PDO('mysql:host=us-cdbr-iron-east-01.cleardb.ne;dbname=heroku_6eed521c7bf0f9d;charset=utf8','b483fab2394946:b6a0e0f8','b6a0e0f8');
     } catch (PDOException $e) {
        var_dump($e->getMessage());
        exit;
    }
    
    $stmt_add = $dbh->prepare("insert into thread (username,thname) values(?,?)");
    
    //table threadの、thnameを取ってきて、表示する処理
    $sql ="select * from thread";
    $stmt= $dbh->query($sql);
    
    $dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    $count_stmt = $dbh ->query($sql);
    $count_stmt->execute();
    $count=$count_stmt->rowCount();
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newthname']) ){
			$newthname = trim($_POST['newthname']);
			$newusername = trim($_POST['newusername']);
			if($newthname !== ""){
                            $newusername= ($newusername =="") ? "名無し" : $newusername;
                                
                            $stmt_add ->execute(array($newusername,$newthname));
				
                            header('Location: thread.php');
				
			
			}
    }
    
    
    
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KEIBANthread</title>
    </head>
    <body>
        <h1>KEIZIBAN</h1>
        <form action="" method="post">
            ThreadTitle:<input type="text" name="newthname" maxlength="50">
            Name:<input type="text" name="newusername" maxlength="30">
            <input type="submit" value="Build">
            
        </form>
        <h2>Index of thread (<?php echo $count; ?> items)</h2>
            <ol>
                <?php foreach ($stmt ->fetchAll(PDO::FETCH_ASSOC) as $user): ?>
                    <li>
                        <a href="response.php?id=<?php echo $user['id']; ?>">
                        <?php echo $user['thname'] ; ?>
                        <?php echo $user['username']; ?>
                        </a>
                    </li>    
                    
                <?php endforeach; ?>
                
            </ol>
    </body>
</html>
