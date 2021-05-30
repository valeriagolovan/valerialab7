<?php
header('Content-Type: text/html; charset=UTF-8');
$user = 'u24095';
$pass = '8452445';
$db = new PDO('mysql:host=localhost;dbname=u24095', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

session_start();
$id = $_POST['change'];
$stmt = $db->prepare("SELECT login FROM users WHERE user_id = '$id'");
$stmt->execute();
$user_login='';
while($row = $stmt->fetch())
{
    $user_login=$row['login'];
}

$request = "SELECT * FROM form where user_id='$id'";
$sth = $db->prepare($request);
$sth->execute();
$data = $sth->fetch(PDO::FETCH_ASSOC);
if($data==false){
    header('Location:admin.php');
    exit();
}
$_SESSION['login'] = $user_login;
$_SESSION['uid'] = $id;

setcookie('admin','1');
header('Location: index.php');
