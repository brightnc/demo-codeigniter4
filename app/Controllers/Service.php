<?php

namespace App\Controllers;

use App\Models\Mydev_model;
use App\Libraries\Jwt;

class Service extends BaseController
{

    public function __construct()
    {
        $this->config = new \Config\App();
        $this->mydev_model = new Mydev_model();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->jwt = new Jwt();
        date_default_timezone_set("Asia/Bangkok");
    }



    public function insert()
    {
        $event_id = $this->request->getGet("event_id");
        // $sql = "SELECT user_id FROM register WHERE status_approve=1;";
        $sql = "SELECT user_id,status_approve FROM register ;";
        $result = $this->mydev_model->select($sql);
        if (count($result) < 0) {
            echo "Error: can not get user_id from register !";
            exit;
        }
        print_r($result);
        echo "<hr>";
        $sql2 = "SELECT SUM(cash) as total_cash, user_id FROM user_game GROUP BY user_id ;";
        $result2 = $this->mydev_model->select($sql2);
        if (count($result2) < 0) {
            echo "Error: can not get user_id from user_game !";
            exit;
        }
        print_r($result2);
        echo "<hr>";
        $resultArr = [];
        for ($i = 0; $i < count($result); $i++) {
            for ($j = 0; $j < count($result2); $j++) {
                if ($result[$i]->user_id == $result2[$j]->user_id) {
                    $resultArr[$i]["user_id"] = $result[$i]->user_id;
                    $resultArr[$i]["total"] = $result2[$j]->total_cash;
                    $resultArr[$i]["type_user"] = $result[$i]->status_approve;
                }
            }
        }
        $keys = array_column($resultArr, 'total');
        array_multisort($keys, SORT_DESC, $resultArr);
        print_r($resultArr);
        echo "<hr>";


        $now = date("Y-m-d H:i:s");
        $countApprove = 1;
        $countUnApprove = 1;

        foreach ($resultArr as $val) {
            if ($val["type_user"] == 1) {
                $sql3 = "INSERT INTO user_event (no,event_id, user_id, date_time,value_sum,type_user) VALUES (?,?, ?, ?,?,?) ON DUPLICATE KEY UPDATE no=VALUES(no),event_id=VALUES(event_id),date_time=VALUES(date_time),value_sum=VALUES(value_sum) ;";
                $bindValue3 = array($countApprove, $event_id, $val["user_id"], $now, $val["total"], $val["type_user"]);
                $result3 = $this->mydev_model->execute_binding($sql3, $bindValue3);
                print_r($result3);
                $countApprove++;
                $sql4 = "UPDATE user_event SET type_user = ? WHERE user_id=?";
                $bindValue4 = array($val["type_user"], $val["user_id"]);
                $result4 = $this->mydev_model->execute_binding($sql4, $bindValue4);
                print_r($result4);
            } else {
                $sql3 = "INSERT INTO user_event (no,event_id, user_id, date_time,value_sum,type_user) VALUES (?,?, ?, ?,?,?) ON DUPLICATE KEY UPDATE no=VALUES(no),event_id=VALUES(event_id),date_time=VALUES(date_time),value_sum=VALUES(value_sum) ;";
                $bindValue3 = array($countUnApprove, $event_id, $val["user_id"], $now, $val["total"], $val["type_user"]);
                $result3 = $this->mydev_model->execute_binding($sql3, $bindValue3);
                print_r($result3);
                $countUnApprove++;
                $sql4 = "UPDATE user_event SET type_user = ? WHERE user_id=?";
                $bindValue4 = array($val["type_user"], $val["user_id"]);
                $result4 = $this->mydev_model->execute_binding($sql4, $bindValue4);
                print_r($result4);
            }
        }
        echo "Success insert";
    }


    public function getusers()
    {
        $userid = $this->request->getGet("userid");
        header('Content-Type: application/json; charset=utf-8');
        if ($userid !== null) {
            $sql = "SELECT * FROM register WHERE user_id=? ;";
            $result = $this->mydev_model->select_binding($sql, [$userid]);
            if (count($result) <= 0) {

                $jsonErr = json_encode(["error" => " can not get user from register"]);
                echo $jsonErr;
                exit;
            }
            $jsonBody = json_encode($result);
            echo $jsonBody;
            exit;
        }
        $sql = "SELECT * FROM register ;";
        $result = $this->mydev_model->select($sql);
        if (count($result) < 0) {
            echo "Error: can not get users from register !";
            exit;
        }
        $jsonBody = json_encode($result);
        echo $jsonBody;
    }

    public function postuser()
    {
        $userid = $this->request->getVar("userId");
        $headers = getallheaders();
        $reqTestHeader = $headers['test'];
        $valueHeader = "test1234";

        if ($reqTestHeader !==  $valueHeader) {
            $jsonErr = json_encode(["error" => " header value not match"]);
            echo $jsonErr;
            exit;
        }

        if ($userid !== null) {
            $sql = "SELECT * FROM register WHERE user_id=? ;";
            $result = $this->mydev_model->select_binding($sql, [$userid]);
            if (count($result) <= 0) {

                $jsonErr = json_encode(["error" => " can not get user from register"]);
                echo $jsonErr;
                exit;
            }
            $jsonBody = json_encode($result);
            echo $jsonBody;
            exit;
        }
        $jsonErr = json_encode(["error" => " can not get user from register"]);
        echo $jsonErr;
    }

    public  function demoJwt()
    {
        $key = "secretKey";
        $expirationTime = time() + (60 * 60);
        $data = array(
            'userid' => '344532',
            'cash' => '142536',
            'exp' => $expirationTime,
        );
        $jwt = Jwt::encode($data, $key);
        echo '<pre>';
        echo $jwt;

        $jwt_decoded = Jwt::decode($jwt, $key);
        echo "<br>";
        print_r($jwt_decoded);
    }
}
