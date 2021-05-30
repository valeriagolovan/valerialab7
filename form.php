<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bek 6</title>
    <style>
        .error {
            border: 2px solid red;
        }
        .error-radio
        {
            border: 2px solid red;
        }
        .error-bio
        {
            border: 2px solid #ff0000;
            width: 250px;
            height: 16px;
        }
        .error-check
        {
            border: 2px solid red;
            width: 350px;
        }
        .error-abil
        {
            border: 2px solid red;
            width: 200px;
            height: 70px;
        }
        .error-radio-limb
        {
            border: 2px solid red;
            width: 250px;
            height:35px;
        }
    </style>
</head>

<div class="modal" data-modal="1">
    <?php
    if (!empty($messages)) {
        print('<div id="messages">');
        foreach ($messages as $message) {
            print($message);
        }
        print('</div>');
    }
    ?>
    <body>
    <button onclick="document.location='login.php'">Авторизация</button><br/>
    <button onclick="document.location='admin.php'">Админ</button>
    </body>
    <form action="index.php" id="my-formcarry" accept-charset="UTF-8" class="main" method="POST">
        <input style="margin-bottom : 1em" id="formname" type="text" name="fio" placeholder="Введите имя"
            <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>">
        <input style="margin-bottom : 1em;margin-top : 1em" id="formmail" type="email" name="email"
               placeholder="Введите почту"
            <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>">
        <label><br/>
            <input <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year_value']; ?>" id="dr" name="birthyear" value="" type="number" placeholder="Год рождения"/>
        </label><br/><br/>


        Выберите пол:<br/>
        <label <?php if($errors['sex']){print 'class="error-radio"';}?>>
            <input <?php if($values['sex_value']=="man"){print 'checked';}?> type="radio"
                                                                             name="radio2" value="man"/>
            Мужской</label>
        <label <?php if($errors['sex']){print 'class="error-radio"';}?>> <input <?php if($values['sex_value']=="woman"){print 'checked';}?> type="radio"
                                                                                                                                            name="radio2" value="woman"/>
            Женский</label>
        <br/>
        <div <?php if($errors['limb']){print 'class="error-radio-limb"';}?>>
            Сколько у вас конечностей :<br/>
            <label><input
                    <?php if($values['limb_value']=="3"){print 'checked';}?>
                    type="radio"
                    name="radio1" value="3"/>
                3</label>
            <label><input
                    <?php if($values['limb_value']=="4"){print 'checked';}?>
                    type="radio"
                    name="radio1" value="4"/>
                4</label>
            <br>
        </div>
        <label>
            Ваши сверхспособности:
            <br/>
            <div <?php if ($errors['abil']) {print 'class="error-abil"';} ?>> <select id="sp" name="superpower[]"
                                                                                      multiple="multiple">
                    <option <?php if($values['abil_value']=="1"){print 'selected';}?> value="fly">Не спать и не уставать</option>
                    <option <?php if($values['abil_value']=="1"){print 'selected';}?> value="immortality" >Вставать к первой паре и чувствовать себя нормально</option>
                    <option <?php if($values['abil_value']=="1"){print 'selected';}?> value="telepathy">Читать мысли</option>
                    <option <?php if($values['abil_value']=="1"){print 'selected';}?> value="telekinesis">Понимать женщин</option>
                    <option <?php if($values['abil_value']=="1"){print 'selected';}?> value="teleportation">Иметь красивый почерк</option>

                </select> </div>
        </label><br/>

        <label <?php if ($errors['bio']) {print 'class="error-bio"';} ?>>
            Напишите про себя: <br/>
            <textarea id="biog" name="textarea1" placeholder="Напиши что-нибудь)"><?php print $values['bio_value'];?></textarea>
        </label><br/>

        <div <?php if ($errors['check']) {print 'class="error-check"';} ?>><label><input <?php if($values['check_value']=="1"){print 'checked';}?> style="margin-bottom : 1em;margin-top : 1em;" id="formcheck" type="checkbox" name="checkbox"
                                                                                                                                                   value="1">Согласие на обработку персональных данных</label></div>

        <input type="submit" style="margin-bottom : -1em" id="formsend" class="buttonform" value="Отправить">
    </form>
</div>
