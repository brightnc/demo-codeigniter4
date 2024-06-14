<?php
$data = $user_data;
// $username = $data["username"];
// echo "<pre>";
// print_r($data);

// for ($i = 0; $i < count($data); $i++) {
//         if (isset($data[$i])) {
//                 $username = $data[$i]->username;
//                 $email = $data[$i]->email;;
//                 echo "username : " . $username;
//                 echo "<br>";
//                 echo "email : " . $email;
//                 echo "<hr>";
//                 // .... and so on
//                 // then you can do whatever you want with the data
//         } else {
//                 echo "No Data Found";
//         }
// }


?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>users</title>
        <style>
                table,
                th,
                td {
                        border: 1px solid;
                        text-align: center;
                }
        </style>
</head>

<body>
        <table style="margin: 0 auto;">
                <tr>
                        <th style="text-align: center;">no.</th>
                        <th style="text-align: center;">username</th>
                        <th style="text-align: center;">firstname</th>
                        <th style="text-align: center;">lastname</th>
                        <th style="text-align: center;">email</th>
                        <th style="text-align: center;">id_card</th>
                        <th style="text-align: center;">phone_number</th>
                        <th style="text-align: center;">created_at</th>
                        <th style="text-align: center;">updated_at</th>
                        <th style="text-align: center;">status</th>
                </tr>
                <?php
                for ($i = 0; $i < count($data); $i++) {
                        if (isset($data[$i])) {
                                $username = $data[$i]->username;
                                $first_name = $data[$i]->fname;
                                $last_name = $data[$i]->lname;
                                $email = $data[$i]->email;
                                $id_card = $data[$i]->id_card;
                                $phone_number = $data[$i]->phone_number;
                                $created_at = $data[$i]->created_at;
                                $updated_at = $data[$i]->updated_at;
                                $status = $data[$i]->status;
                                $count_row = $i + 1;
                                echo "<tr>";
                                echo "<td>{$count_row}</td>";
                                echo "<td>{$username}</td>";
                                echo "<td>{$first_name}</td>";
                                echo "<td>{$last_name}</td>";
                                echo "<td>{$email}</td>";
                                echo "<td>{$id_card}</td>";
                                echo "<td>{$phone_number}</td>";
                                echo "<td>{$created_at}</td>";
                                echo "<td>{$updated_at}</td>";
                                if ($status == 1) {
                                        echo "<td>active</td>";
                                } else {
                                        echo "<td>inactive</td>";
                                }

                                echo "</tr>";
                        } else {
                                echo "No Data Found";
                        }
                }
                ?>
        </table>
</body>

</html>