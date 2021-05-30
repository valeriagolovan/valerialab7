<?php

header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('<br/> <a style="color:#e6b333;" href="login.php">войти</a> в аккаунт<br/> Логин : <strong>%s</strong>
        <br/> Пароль : <strong>%s</strong> ',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
    }
    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['email']=!empty($_COOKIE['email_error']);
    $errors['sex']=!empty($_COOKIE['sex_error']);
    $errors['bio']=!empty($_COOKIE['bio_error']);
    $errors['check']=!empty($_COOKIE['check_error']);
    $errors['abil']=!empty($_COOKIE['abil_error']);
    $errors['year']=!empty($_COOKIE['year_error']);
    $errors['limb']=!empty($_COOKIE['limb_error']);

    if ($errors['fio']) {
        setcookie('fio_error', '', 100000);
        $messages[] = '<div>Заполните имя корректно.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = '<div>Заполните почту</div>';
    }
    if ($errors['sex']) {
        setcookie('sex_error', '', 100000);
        $messages[] = '<div>Выберите пол</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        $messages[] = '<div>Введите биографию</div>';
    }
    if ($errors['check']) {
        setcookie('check_error', '', 100000);
        $messages[] = '<div>Подтвердите согласие</div>';
    }
    if ($errors['abil']) {
        setcookie('abil_error', '', 100000);
        $messages[] = '<div>Выберите сверхспособность</div>';
    }
    if ($errors['year']) {
        setcookie('year_error', '', 100000);
        $messages[] = '<div>Корректно введите дату рождения</div>';
    }
    if ($errors['limb']) {
        setcookie('limb_error', '', 100000);
        $messages[] = '<div>Выберите количество конечностей</div>';
    }

    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['sex_value'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
    $values['bio_value'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['check_value'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];
    $values['abil_value'] = empty($_COOKIE['abil_value']) ? '' : $_COOKIE['abil_value'];
    $values['year_value'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
    $values['limb_value'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];

    $user = 'u24095';
    $pass = '8452445';
    $db = new PDO('mysql:host=localhost;dbname=u24095', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    $flag = 0;
    foreach($errors as $err){
        if($err==1)$flag=1;
    }
    if(session_start() && $_SESSION['token']!=$_POST['token_del']){
        exit();}
    if (!$flag&&!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {
        $login = $_SESSION['login'];

        $stmt = $db->prepare("SELECT user_id FROM users WHERE login = '$login'");
        $stmt->execute();
        $user_id='';
        while($row = $stmt->fetch())
        {
            $user_id=$row['user_id'];
        }

        $request = "SELECT fio,email,birth,sex,limb,about,checkbox FROM form WHERE user_id = '$user_id'";
        $result = $db -> prepare($request);
        $result ->execute();

        $data = $result->fetch(PDO::FETCH_ASSOC);

        $values['fio'] = strip_tags($data['fio']);
        $values['email'] = strip_tags($data['email']);
        $values['year_value'] = strip_tags($data['birth']);
        $values['sex_value'] = strip_tags($data['sex']);
        $values['limb_value'] = $data['limb'];
        $values['bio_value'] = strip_tags($data['about']);
        $values['check_value'] = strip_tags($data['checkbox']);

    }
    include('form.php');
}
else {
    $errors = FALSE;
    if (empty($_POST['fio']) || (preg_match("/^[a-z0-9_-]{2,20}$/i", $_POST['fio']))) {
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('fio_value', $_POST['fio'], time() + 365 * 24 * 60 * 60);
    }
    if (empty($_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 365 * 24 * 60 * 60);
    }
    if (!isset($_POST['radio2'])) {
        setcookie('sex_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('sex_value', $_POST['radio2'], time() + 365 * 24 * 60 * 60);
    }
    if (empty($_POST['textarea1'])) {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('bio_value', $_POST['textarea1'], time() + 365 * 24 * 60 * 60);
    }
    if (!isset($_POST['checkbox'])) {
        setcookie('check_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('check_value', $_POST['checkbox'], time() + 365 * 24 * 60 * 60);
    }
    $kek = 0;
    $myselect = $_POST['superpower'];
    for ($i = 0; $i < 5; $i++) {
        if ($myselect[$i] == NULL) {
            $myselect[$i] = 0;
        } else
            $kek = 1;
    }
    if (!$kek) {
        setcookie('abil_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('abil_value', $_POST['superpower'], time() + 365 * 24 * 60 * 60);
    }
    if (!isset($_POST['radio1'])) {
        setcookie('limb_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('limb_value', $_POST['radio1'], time() + 365 * 24 * 60 * 60);
    }
    if (empty($_POST['birthyear']) || $_POST['birthyear'] < 1886 || $_POST['birthyear'] > 2021) {
        setcookie('year_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('year_value', $_POST['birthyear'], time() + 365 * 24 * 60 * 60);
    }


    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        $user = 'u24095';
        $pass = '8452445';
        $db = new PDO('mysql:host=localhost;dbname=u24095', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

        // Удаляем Cookies с признаками ошибок.
        setcookie('fio_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('sex_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('check_error', '', 100000);
        setcookie('abil_error', '', 100000);
        setcookie('year_error', '', 100000);
        setcookie('limb_error', '', 100000);
        if (!empty($_COOKIE[session_name()]) &&
            session_start() && !empty($_SESSION['login']) && !empty($_SESSION['uid'])) {

            $fio = $_POST['fio'];
            $email = $_POST['email'];
            $birthyear = $_POST['birthyear'];
            $sex = $_POST['radio2'];
            $limb = $_POST['radio1'];
            $bio = $_POST['textarea1'];

            $login = $_SESSION['login'];

            $stmt = $db->prepare("SELECT user_id FROM users WHERE login = '$login'");
            $stmt->execute();
            $user_id = '';
            while ($row = $stmt->fetch()) {
                $user_id = $row['user_id'];
            }

            $sql = "UPDATE form SET fio='$fio',email='$email',birth='$birthyear',sex='$sex',limb='$limb',about='$bio' WHERE user_id='$user_id'";
            $stmt = $db->prepare($sql);
            $stmt->execute();


            $stmt = $db->prepare("DELETE FROM all_abilities WHERE user_id='$user_id'");
            $stmt->execute();
            $abilities = $_POST['superpower'];
            $ability_data = array('fly', 'immortality', 'telepathy', 'telekinesis', 'teleportation');
            $ability_insert = [];

            foreach ($abilities as $ability) {
                $ability_insert[$ability] = in_array($ability, $abilities) ? $ability : '0';
                if (in_array($ability, $ability_data)) {

                    $stmt = $db->prepare("INSERT INTO all_abilities(user_id,abil_value) VALUES(:id,:abil)");
                    $stmt->execute(array('id' => $user_id, 'abil' => $ability));
                }
            }
        } else {

            $user = 'u24095';
            $pass = '8452445';
            $db = new PDO('mysql:host=localhost;dbname=u24095', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

            $login = rand(1,10000);

            $pass = rand(1,100000);

            $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
            setcookie('login', $login);
            setcookie('pass', $pass);

            $stmt = $db->prepare("INSERT INTO users (login, hash) VALUES (:login,:hash)");
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':hash', $hash_pass);
            $stmt->execute();

            $stmt = $db->prepare("SELECT user_id FROM users WHERE login = '$login'");
            $stmt->execute();
            $user_id = '';
            while ($row = $stmt->fetch()) {
                $user_id = $row['user_id'];
            }

            $stmt = $db->prepare("INSERT INTO form (user_id,fio, birth,email,sex,limb,about,checkbox) VALUES (:user_id,:fio, :birth,:email,:sex,:limb,:about,:checkbox)");

            $stmt->bindParam(':fio', $_POST['fio']);
            $stmt->bindParam(':birth', $_POST['birthyear']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':sex', $_POST['radio2']);
            $stmt->bindParam(':limb', $_POST['radio1']);
            $stmt->bindParam(':about', $_POST['textarea1']);
            $stmt->bindParam(':checkbox', $_POST['checkbox']);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $abilities = $_POST['superpower'];
            $ability_data = array('fly', 'immortality', 'telepathy', 'telekinesis', 'teleportation');
            foreach ($abilities as $ability) {
                if (in_array($ability, $ability_data)) {

                    $stmt = $db->prepare("INSERT INTO all_abilities(user_id,abil_value) VALUES(:id,:abil)");
                    $stmt->execute(array('id' => $user_id, 'abil' => $ability));
                }
            }

        }

        setcookie('save', '1');
        header('Location: index.php');
    }
}
