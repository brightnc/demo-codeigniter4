<?php

namespace App\Controllers;

use App\Models\Mydev_model;

class Demo extends BaseController
{
    public function __construct()
    {
        $this->config = new \Config\App();
        $this->mydev_model = new Mydev_model();
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function index()
    {
        $this->session->set("Password", md5("pwd"));
        $data["user_data"] = ["user_id" => "001"];
        print_r($_SESSION);
        echo "<hr>";
        return view('demo', $data);
    }

    public function login()
    {
        print_r($_SESSION);
        echo "<br>";
        return view('login');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('demo/login');
    }

    public function member()
    {
        $sql = "SELECT user_id, cash, FROM user_detail WHERE user_id=?;";
        $bindValue = array();
        $result = $this->mydev_model->select_binding($sql, $bindValue);
        if (count($result) > 0) {
            $this->session->set("user_id", $result[0]->user_id);
            $data["user_data"] = $result;
            return view("member", $data);
        } else {
            echo "result error";
        }
    }

    public function login_process()
    {
        if (!$this->session->userId) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $this->request->getPost("username");
                $password = $this->request->getPost("password");
                $passwordHashed = md5($password);

                $sql = "SELECT user_id, username,created_at,status FROM register WHERE username=? AND password=?;";
                $bindValue = array($username, $passwordHashed);
                $result = $this->mydev_model->select_binding($sql, $bindValue);


                $sql2 = "SELECT cash FROM user_detail WHERE user_id=?;";
                $bindValue2 = array($result[0]->user_id);
                $result2 = $this->mydev_model->select_binding($sql2, $bindValue2);


                $sql3 = "SELECT game_id,cash FROM user_game WHERE user_id=?;";
                $bindValue3 = array($result[0]->user_id);
                $result3 = $this->mydev_model->select_binding($sql3, $bindValue3);

                $sql4 = "SELECT game_id,game_name,rate_cal FROM game_info";
                $result4 = $this->mydev_model->select($sql4);

                $sql5 = "SELECT name,acc_type FROM account_info WHERE user_id=?;";
                $bindValue5 = array($result[0]->user_id);
                $result5 = $this->mydev_model->select_binding($sql5, $bindValue5);


                if (count($result) > 0 && count($result2) > 0 && count($result3) > 0 && count($result4) > 0 && count($result5) > 0) {
                    $this->session->set("user_id", $result[0]->user_id);
                    $this->session->set("status", $result[0]->status);
                    $data["user_data"] = $result;
                    $data["user_detail"] = $result2;
                    $data["user_game"] = $result3;
                    $data["game_info"] = $result4;
                    $data["acc_info"] = $result5;
                    return view("user_info2", $data);
                } else {
                    echo "result error";
                }
            } else {
                echo "error";
            }
        }
    }

    public function register()
    {
        return view('demo_form');
    }

    public function register_process()
    {
        if (!$this->session->userid) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $this->request->getPost("username");
                $password = $this->request->getPost("password");
                $unique_id = mt_rand();
                echo "<br>";
                echo "unique_id = " . $unique_id;
                $passwordHashed = md5($password);
                echo "<br>";
                echo "passwordHashed = " . $passwordHashed;
                $now = date("Y-m-d H:i:s");
                echo "<br>";
                echo "now = " . $now;
                $sql = "INSERT INTO register (user_id, username, password,created_at) VALUES (?, ?, ?,?)";
                $bindValue = array($unique_id, $username, $passwordHashed, $now);
                $result = $this->mydev_model->execute_binding($sql, $bindValue);
                echo "<br>";
                echo "success insert";
                echo "<br>";
                print_r($result);
            } else {
                echo "error";
            }
        }
    }
}
