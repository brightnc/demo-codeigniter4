<?php

namespace App\Controllers;

use App\Models\Mydev_model;

class Service extends BaseController
{

    public function __construct()
    {
        $this->config = new \Config\App();
        $this->mydev_model = new Mydev_model();
        $this->session = \Config\Services::session();
        $this->session->start();
        date_default_timezone_set("Asia/Bangkok");
    }

    public function insert()
    {
        $sql = "SELECT user_id FROM register WHERE status_approve=1;";
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
                    $resultArr[$result[$i]->user_id] = $result2[$j]->total_cash;
                }
            }
        }
        arsort($resultArr);
        print_r($resultArr);

        $now = date("Y-m-d H:i:s");
        $count = 1;
        foreach ($resultArr as $k => $v) {

            $sql3 = "INSERT INTO user_event (no,event_id, user_id, date_time,value_sum) VALUES (?,?, ?, ?,?)";
            $bindValue3 = array($count, 20242106, $k, $now, $v);
            $result3 = $this->mydev_model->execute_binding($sql3, $bindValue3);
            $count++;
            print_r($result3);
        }
        echo "Success insert";
    }
}
