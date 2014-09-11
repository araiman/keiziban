<?php
    $url = parse_url(getenv("mysql://bd6be7d7aab25d:13741467@us-cdbr-iron-east-01.cleardb.net/heroku_cc3268ea0ea6074?reconnect=true"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);

    $link = mysqli_connect($server, $username, $password, $db);
    $result = mysqli_query($link, "select * from user");

    while($user = mysqli_fetch_array($result)) {
      echo $user['id'], " : ", $user['name'], "<br>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KEIBANTOP</title>
    </head>
    <body>
        <!--タイトル -->
        <h1>KEIZIBAN</h1>
        
            <!--スレ一覧 -->
            <h2>作品一覧</h2>
                <ol>
                    <li>
                        <h3>
                            <a href="thread.php">KEIZIBAN</a>
                        </h3>
                    </li>
                    
                </ol>
        
        
    </body>
</html>
