<?php

if (isset($_SESSION["user_id"])) {
    echo "user id : " . $_SESSION["user_id"];
    echo "<br>";
    echo "status : " . $_SESSION["status"];
    echo "<br>";
    echo "<a href='logout' style='color:black;text-decoration: none; border:1px solid black; background-color:gray;'>logout</a>";
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Login</h1>
    <form action="login_process" method="post">

        <label for="username">Username</label>
        <input type="text" name="username">
        <label for="password">Password</label>
        <input type="text" name="password">
        <input type="submit" value="login">
    </form>
</body>

</html>