<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Сделай Меня Элвисом - удали электронную почту</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<img src="blankface.jpg" width="161" height="350" alt="" style="float:right" />
<img name="elvislogo" src="elvislogo.gif" width="229" height="32" border="0" alt="Сделай Меня Элвисом" />
<p>Пожалуйста, выберите адреса электронной почты для удаления из списка адресов электронной почты и нажмите Удалить.</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <?php
    $dbc = mysqli_connect('localhost','root','','elvis_store')
    or die('ошибка подключения mysql-сервера');

    // Удалить строки клиента (только в том случае, если форма была отправлена)
    if (isset($_POST['submit'])) {
        foreach ($_POST['todelete'] as $delete_id) {
            $query = "DELETE FROM email_list WHERE id = $delete_id";
            mysqli_query($dbc, $query)
            or die('ошибка подключения к базе данных.');
        }

        echo 'Клиент(ы) удален(ы).<br />';
    }

    // Отображение строк клиентов с флажками для удаления
    $query = "SELECT * FROM email_list";
    $result = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<input type="checkbox" value="' . $row['id'] . '" name="todelete[]" />';
        echo $row['first_name'];
        echo ' ' . $row['last_name'];
        echo ' ' . $row['email'];
        echo '<br />';
    }

    mysqli_close($dbc);
    ?>

    <input type="submit" name="submit" value="Remove" />
</form>
</body>
</html>