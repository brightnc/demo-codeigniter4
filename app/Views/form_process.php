<?php
$data = $input_data;
$username = $data["username"];
$f_name = $data["f_name"];
$l_name = $data["l_name"];
$phone = $data["phone"];
$email = $data["email"];
$user_id = $data["user_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>process</title>
    <style>
        table,
        tr,
        td,
        th {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <table action="clear_session" method="POST" name="user_info" style="margin: 0 auto;width:350px;">
        <tr>
            <th style="text-align: center;">Label</th>
            <th style="text-align: center;">Input Data</th>
        </tr>
        <tr>
            <td style="text-align: right;">Username</td>
            <td><?php echo $username; ?></td>
        </tr>
        <tr>
            <td style="text-align: right;">Firstname</td>
            <td><?php echo $f_name; ?></td>
        </tr>
        <tr>
            <td style="text-align: right;">Lastname</td>
            <td> <?php echo $l_name; ?></td>
        </tr>
        <tr>
            <td style="text-align: right;">Phone</td>
            <td><?php echo $phone; ?></td>
        </tr>
        <tr>
            <td style="text-align: right;">Email</td>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
            <td style="text-align: right;">ID</td>
            <td> <?php echo $user_id; ?></td>
        </tr>

        <tr>
            <td></td>
            <td><input type="submit" value="clear_session"></td>
        </tr>
    </table>
</body>

</html>