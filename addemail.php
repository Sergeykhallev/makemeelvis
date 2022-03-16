<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Сделай Меня Элвисом - Добавь электронную почту</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<img src="blankface.jpg" width="161" height="350" alt="" style="float:right" />
<img name="elvislogo" src="elvislogo.gif" width="229" height="32" border="0" alt="Сделай Меня Элвисом" />
<p>Введите свое имя, фамилию и адрес электронной почты, которые будут добавлены в список рассылки <strong>Сделай Меня Элвисом</strong></p>
<?php
if (isset($_POST['submit'])) {
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $output_form = 'no';

    if (empty($first_name) || empty($last_name) || empty($email)) {
        // Мы знаем, что по крайней мере одно из полей ввода пусто
        echo 'Пожалуйста, заполните всю информацию по электронной почте.<br />';
        $output_form = 'yes';
    }
}
else {
    $output_form = 'yes';
}

if (!empty($first_name) && !empty($last_name) && !empty($email)) {
    $dbc = mysqli_connect('localhost','root','','elvis_store')
    or die('ошибка подключения mysql-сервера');

    $query = "INSERT INTO email_list (first_name, last_name, email)  VALUES ('$first_name', '$last_name', '$email')";
    mysqli_query($dbc, $query)
    or die ('Данные не вставлены.');

    echo 'Добавленный клиент.';

    mysqli_close($dbc);
}

if ($output_form == 'yes') {
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
