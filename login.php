<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
$_SESSION['token'] = uniqid();
$token = $_SESSION['token'];

if (!empty($_SESSION['login']))
{
    session_destroy();
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>

    <head>
        <title>Autorization</title>
    </head>
    <div class="Form">
        <form action="" method="post">
            Логин:<input name="login"/>
            Пароль:<input name="pass" type="password"/>
            <input type="submit" value="Войти" />
            <input type="hidden" name="token_del" <?php print "value = '$token'";?>>
        </form>
    </div>


    <?php
}
else {
    $user = 'u24095';
    $pass = '8452445';
    $db = new PDO('mysql:host=localhost;dbname=u24095', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    $login = $_POST['login'];
    $stmt = $db->prepare("SELECT * FROM users WHERE login LIKE ?");
    $stmt->execute([$login]);
    $flag=0;
    while($row = $stmt->fetch())
    {
        if(!strcasecmp($row['login'],$_POST['login'])&&password_verify($_POST['pass'],$row['hash']))
        {
            $flag=1;
            $user_id=$row['user_id'];
        }
    }
    if($flag) {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['uid'] = $user_id;
        header('Location: index.php');
    }
    else{
        header('Location: login.php');
    }
}
