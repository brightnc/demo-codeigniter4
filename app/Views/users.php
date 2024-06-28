<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
            text-align: center;
        }

        td {
            padding: 8px;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>id</th>
            <th>user_id</th>
            <th>username</th>
            <th>password</th>
            <th>created_at</th>
            <th>status</th>
            <th>status_approve</th>
        </tr>

        <?php
        $data_users = $users;
        for ($i = 0; $i < count($data_users); $i++) {
            if (isset($data_users[$i])) {
                $id = $data_users[$i]->id;
                $user_id = $data_users[$i]->user_id;
                $username = $data_users[$i]->username;
                $password = $data_users[$i]->password;
                $created_at = $data_users[$i]->created_at;
                $status = $data_users[$i]->status;
                $status_approve = $data_users[$i]->status_approve;
                echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>$user_id</td>";
                echo "<td >$username</td>";
                echo "<td>$password</td>";
                echo "<td>$created_at </td>";
                echo "<td>$status</td>";
                echo "<td>$status_approve</td>";
                echo "</tr>";
            } else {
                echo "No Data Found";
            }
        }
        ?>
    </table>

</body>

</html>