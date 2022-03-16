<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Сделай Меня Элвисом - Отправь Электронное письмо</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<img src="blankface.jpg" width="161" height="350" alt="" style="float:right" />
<img name="elvislogo" src="elvislogo.gif" width="229" height="32" border="0" alt="Сделай Меня Элвисом" />
<p><strong>Частный:</strong>ТОЛЬКО для Элмера<br />
    Напишите и отправьте электронное письмо участникам списка рассылки.</p>

<?php
if (isset($_POST['submit'])) {
    $from = 'sergey,khaleev@gmail.com';
    $subject = $_POST['subject'];
    $text = $_POST['elvismail'];
    $output_form = false;

    if (empty($subject) && empty($text)) {
        // Мы знаем, что и $subject, И $text пусты
        echo 'Вы забыли тему письма и основной текст.<br />';
        $output_form = true;
    }

    if (empty($subject) && (!empty($text))) {
        echo 'Вы забыли тему письма.<br />';
        $output_form = true;
    }

    if ((!empty($subject)) && empty($text)) {
        echo 'Вы забыли основной текст электронного письма.<br />';
        $output_form = true;
    }
}
else {
    $output_form = true;
}

if ((!empty($subject)) && (!empty($text))) {
    $dbc = mysqli_connect('localhost','root','','elvis_store')
    or die('ошибка подключения mysql-сервера');

    $query = "SELECT * FROM email_list";
    $result = mysqli_query($dbc, $query)
    or die('ошибка подключения к базе данных');

    while ($row = mysqli_fetch_array($result)){
        $to = $row['email'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $msg = "Dear $first_name $last_name,\n$text";
        mail($to, $subject, $msg, 'From:' . $from);
        echo 'Электронное письмо, отправленное на: ' . $to . '<br />';
    }

    mysqli_close($dbc);
}

if ($output_form) {
    ?>

    <form action="sendemail.php" method="post">
        <label for="subject">Тема электронного письма:</label>
        <input type="text" id="subject" name="subject" ><br>
        <label for="elvismail">Содержание электронного письма:</label><br>
        <textarea id="elvismail" name="elvismail" rows="8" cols="60"></textarea><br>
        <input  type="submit" name="submit" value="отправить">
    </form>

    <?php
}
?>

</body>
</html>