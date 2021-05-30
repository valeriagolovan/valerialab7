<?php
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW'])) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="back6"');
    print('<h1>Нет доступа</h1>');
    exit();
}
$user = 'u24095';
$pass = '8452445';
$db = new PDO('mysql:host=localhost;dbname=u24095', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

$request = "SELECT * from admin";
$result = $db->prepare($request);
$result->execute();
$flag=0;
while($data=$result->fetch()){
    if($data['login']==$_SERVER['PHP_AUTH_USER'] && password_verify($_SERVER['PHP_AUTH_PW'],$data['hash'])){
        $flag=1;
    }
}
if($flag==0){
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="back6"');
    print('<h1>401 Нет доступа<</h1>');
    exit();
}
print('Панель администратора');
?>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Панель администратора</title>
    <link rel="stylesheet" media="all" href="style_admin.css"/>

</head>
<body>
<form action="delete.php" method="post" accept-charset="UTF-8">
    <label>
        <input type="number" name="delete">
    </label>
    <input type="submit" style="margin-bottom : -1em"  class="buttonform" value="Удалить запись по ID">
</form>
<form action="change.php" method="post" accept-charset="UTF-8">
    <label>
        <input type="number" name="change">
    </label>
    <input type="submit" style="margin-bottom : -1em"  class="buttonform" value="Изменить запись по ID">
</form>
<?php

$request = "SELECT * from form JOIN all_abilities on form.user_id=all_abilities.user_id
join users on all_abilities.user_id=users.user_id";
$result = $db ->prepare($request);
$result->execute();
print '<table class="table">';
print '<tr><th>ID</th><th>Имя</th><th>E-Mail</th><th>Дата рождения</th><th>Пол</th><th>Кол-во конечностей</th>
    <th>Биография</th><th>Логин</th><th>Хэш пароля</th><th>Способность</th></tr>';
while($data = $result->fetch()){
    print '<tr><td>';
    print $data['user_id'];
    print '</td><td>';
    print $data['fio'];
    print '</td><td>';
    print $data['email'];
    print '</td><td>';
    print $data['birth'];
    print '</td><td>';
    print $data['sex'];
    print '</td><td>';
    print $data['limb'];
    print '</td><td>';
    print $data['about'];
    print '</td><td>';
    print $data['login'];
    print '</td><td>';
    print $data['hash'];
    print '</td><td>';
    print $data['abil_value'];
    print '</td></tr>';
}
print '</table>';

$request = "SELECT COUNT(abil_value) FROM all_abilities where abil_value='fly' group by abil_value";
$result = $db ->prepare($request);
$result->execute();
$data_fl = $result->fetch()[0];
$request = "SELECT COUNT(abil_value) FROM all_abilities where abil_value='immortality' group by abil_value";
$result = $db ->prepare($request);
$result->execute();
$data_im = $result->fetch()[0];
$request = "SELECT COUNT(abil_value) FROM all_abilities where abil_value='telepathy' group by abil_value";
$result = $db ->prepare($request);
$result->execute();
$data_tp = $result->fetch()[0];
$request = "SELECT COUNT(abil_value) FROM all_abilities where abil_value='telekinesis' group by abil_value";
$result = $db ->prepare($request);
$result->execute();
$data_tl = $result->fetch()[0];
$request = "SELECT COUNT(abil_value) FROM all_abilities where abil_value='teleportation' group by abil_value";
$result = $db ->prepare($request);
$result->execute();
$data_tep = $result->fetch()[0];
print '<h2>Статистика по сверхспособностям:</h2>';
print '<table class="table">';
print '<tr><th>Не спать и не уставать</th><th>Вставать к первой паре и чувствовать себя нормально</th><th>Читать мысли</th><th>Понимать женщин</th><th>Иметь красивый почерк</th></tr>';
print '<tr><td>';
print $data_fl;
print '</td><td>';
print $data_im;
print '</td><td>';
print $data_tp;
print '</td><td>';
print $data_tl;
print '</td><td>';
print '</td><td>';
print $data_tep;
print '</td></tr>';
print '</table>';
?>
</body>
