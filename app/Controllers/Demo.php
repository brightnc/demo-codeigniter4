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
        date_default_timezone_set("Asia/Bangkok");
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

    public function reward()
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $sql = "UPDATE user_event SET value_reward = 1 WHERE user_id=?;";
            $bindValue = array($id);
            $result = $this->mydev_model->execute_binding($sql, $bindValue);
        }
        if ($result < 0) {
            echo "error update reward!";
            exit;
        }

        echo "รับรางวัลสำเร็จ";
    }

    public function update_username()
    {
        if (isset($_POST["id"]) && isset($_POST["username"])) {
            $username = $_POST["username"];
            $id = $_POST["id"];

            $sql = "UPDATE register SET username = ? WHERE user_id = ?;";
            $bindValue = array($username, $id);
            $result = $this->mydev_model->execute_binding($sql, $bindValue);
            if ($result < 0) {
                echo "error update username!";
                $this->init_log();
                $this->write_log("func -> update_user_cash()  msg : error update username!");
                exit;
            }
            $this->init_log();
            $this->write_log("Successfully update username -> user_id : $id");
            echo "Successfully updated";
        }
    }

    public function delete_user()
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $sql = "DELETE FROM register WHERE user_id=?;";
            $bindValue = array($id);
            $result = $this->mydev_model->execute_binding($sql, $bindValue);
            if ($result < 0) {
                echo "error delete user!";
                $this->init_log();
                $this->write_log("func -> update_user_cash()  msg : error delete user!");
                exit;
            }
            $this->init_log();
            $this->write_log("Successfully deleted -> user_id : $id");
            echo "Successfully deleted";
        }
    }

    public function update_user_cash()
    {
        if (isset($_POST["add_form"])) {
            $cash = $_POST["cash"];
            $user_id = $_POST["user_id"];
            $types = $_POST["types"];
            $now = date("Y-m-d H:i:s");
            //Start Transaction
            $this->mydev_model->db_group_name->transStart();
            // Select user current cash
            $sql = "SELECT cash FROM user_detail WHERE user_id=?;";
            $bindValue = array($user_id);
            $result = $this->mydev_model->select_binding($sql, $bindValue);
            if ($result < 0) {
                echo "error get user cash!";
                $this->init_log();
                $this->write_log("func -> update_user_cash()  msg : error get user cash!");
                exit;
            }

            // Add cash to user
            $current_cash = $result[0]->cash;
            $after_cash = 0;
            switch ($types) {
                case 1:
                    $after_cash = $current_cash + $cash;
                    break;

                case 2:
                    if ($current_cash < $cash) {
                        echo "ยอดเงินไม่พอ";
                        $this->init_log();
                        $this->write_log("func -> update_user_cash()  msg : ยอดเงินไม่พอ");
                        exit;
                    }
                    $after_cash = $current_cash - $cash;
                    break;
            }

            $sql2 = "UPDATE user_detail SET cash = ? WHERE user_id = ?;";
            $bindValue2 = array($after_cash, $user_id);
            $result2 = $this->mydev_model->execute_binding($sql2, $bindValue2);

            if ($result2 < 0) {
                echo "error add user cash!";
                $this->init_log();
                $this->write_log("func -> update_user_cash()  msg : error add user cash!");
                exit;
            }
            // Add logs
            $sql3 = "INSERT INTO user_log_cash (user_id, before_cash,after_cash, cash,type_cash,create_time) VALUES (?, ?, ?,?,?,?)";
            $bindValue3 = array($user_id, $current_cash, $after_cash, $cash, $types, $now);
            $result3 = $this->mydev_model->execute_binding($sql3, $bindValue3);
            if ($result3 < 0) {
                echo "error add user logs!";
                $this->init_log();
                $this->write_log("func -> update_user_cash()  msg : error add user logs!");
                exit;
            }
            //End Transaction
            $this->mydev_model->db_group_name->transComplete();

            $this->init_log();
            $this->write_log("Success add user_log_cash -> user_id : $user_id, before_cash : $current_cash, after_cash : $after_cash, cash : $cash, type_cash : $types, timestamp : $now");

            return redirect()->to('demo/login_process');
        }
    }

    public function login_process()
    {
        if (!$this->session->userId) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $this->request->getPost("username");
                $password = $this->request->getPost("password");
                $passwordHashed = md5($password);


                $sql_login = "SELECT user_id, username,created_at,status,status_approve FROM register WHERE username=? AND password=?;";
                $bindValue_login  = array($username, $passwordHashed);
                $result_login  = $this->mydev_model->select_binding($sql_login, $bindValue_login);


                $sql2 = "SELECT cash FROM user_detail WHERE user_id=?;";
                $bindValue2 = array($result_login[0]->user_id);
                $result2 = $this->mydev_model->select_binding($sql2, $bindValue2);


                $sql3 = "SELECT game_id,cash FROM user_game WHERE user_id=?;";
                $bindValue3 = array($result_login[0]->user_id);
                $result3 = $this->mydev_model->select_binding($sql3, $bindValue3);

                $sql4 = "SELECT game_id,game_name,rate_cal FROM game_info";
                $result4 = $this->mydev_model->select($sql4);

                $sql5 = "SELECT name,acc_type FROM account_info WHERE user_id=?;";
                $bindValue5 = array($result_login[0]->user_id);
                $result5 = $this->mydev_model->select_binding($sql5, $bindValue5);


                if ($result5[0]->acc_type == 1) {
                    $sql6 = "SELECT username,user_id FROM register WHERE NOT user_id=?;";
                    $bindValue6 = array($result_login[0]->user_id);
                    $result6 = $this->mydev_model->select_binding($sql6, $bindValue6);
                    $data["users"] = $result6;
                }

                $sql7 = "SELECT user_event.no,user_event.event_id,register.username,user_event.date_time,user_event.value_sum,user_event.type_user FROM user_event LEFT JOIN register ON user_event.user_id=register.user_id WHERE user_event.type_user=1  ORDER BY user_event.no;";
                $result7 = $this->mydev_model->select($sql7);

                if ($result7 < 1) {
                    echo "error join";
                }

                $data["user_event_type_1"] = $result7;

                $sql8 = "SELECT user_event.no,user_event.event_id,register.username,user_event.date_time,user_event.value_sum,user_event.type_user FROM user_event LEFT JOIN register ON user_event.user_id=register.user_id WHERE user_event.type_user=0  ORDER BY user_event.no;";
                $result8 = $this->mydev_model->select($sql8);

                if ($result8 < 1) {
                    echo "error join";
                }

                $data["user_event_type_0"] = $result8;

                $sql9 = "SELECT value_reward FROM user_event WHERE user_id=?;";
                $bindValue9 = array($result_login[0]->user_id);
                $result9 = $this->mydev_model->select_binding($sql9, $bindValue9);

                if ($result9 < 1) {
                    echo "error result 9";
                }

                $data["reward_status"] = $result9;

                if (count($result_login) > 0 && count($result2) > 0 && count($result3) > 0 && count($result4) > 0 && count($result5) > 0) {
                    $this->session->set("user_id", $result_login[0]->user_id);
                    $this->session->set("status", $result_login[0]->status);
                    $data["user_data"] = $result_login;
                    $data["user_detail"] = $result2;
                    $data["user_game"] = $result3;
                    $data["game_info"] = $result4;
                    $data["acc_info"] = $result5;
                    return view("user_info2", $data);
                } else {
                    echo "result error";
                    exit;
                }
            } elseif ($this->session->get("user_id")) {
                $user_id = $this->session->get("user_id");
                $event_id = $this->request->getGet("event_id");

                $data["event_id"] = $event_id;
                $sql = "SELECT user_id, username,created_at,status,status_approve  FROM register WHERE user_id=?;";
                $bindValue = array($user_id);
                $result = $this->mydev_model->select_binding($sql, $bindValue);


                $sql2 = "SELECT cash FROM user_detail WHERE user_id=?;";
                $bindValue2 = array($user_id);
                $result2 = $this->mydev_model->select_binding($sql2, $bindValue2);


                $sql3 = "SELECT game_id,cash FROM user_game WHERE user_id=?;";
                $bindValue3 = array($user_id);
                $result3 = $this->mydev_model->select_binding($sql3, $bindValue3);

                $sql4 = "SELECT game_id,game_name,rate_cal FROM game_info";
                $result4 = $this->mydev_model->select($sql4);

                $sql5 = "SELECT name,acc_type FROM account_info WHERE user_id=?;";
                $bindValue5 = array($user_id);
                $result5 = $this->mydev_model->select_binding($sql5, $bindValue5);

                if ($result5[0]->acc_type == 1) {
                    $sql6 = "SELECT username,user_id FROM register WHERE NOT user_id=?;";
                    $bindValue6 = array($user_id);
                    $result6 = $this->mydev_model->select_binding($sql6, $bindValue6);
                    $data["users"] = $result6;
                }

                $sql7 = "SELECT user_event.no,user_event.event_id,register.username,user_event.date_time,user_event.value_sum,user_event.type_user FROM user_event LEFT JOIN register ON user_event.user_id=register.user_id WHERE user_event.type_user=1 ORDER BY user_event.no;";
                $result7 = $this->mydev_model->select($sql7);

                if ($result7 < 1) {
                    echo "error join";
                }

                $data["user_event_type_1"] = $result7;

                $sql8 = "SELECT user_event.no,user_event.event_id,register.username,user_event.date_time,user_event.value_sum,user_event.type_user FROM user_event LEFT JOIN register ON user_event.user_id=register.user_id WHERE user_event.type_user=0  ORDER BY user_event.no;";
                $result8 = $this->mydev_model->select($sql8);

                if ($result8 < 1) {
                    echo "error join";
                }

                $data["user_event_type_0"] = $result8;



                if (count($result) > 0 && count($result2) > 0 && count($result3) > 0 && count($result4) > 0 && count($result5) > 0) {
                    $data["user_data"] = $result;
                    $data["user_detail"] = $result2;
                    $data["user_game"] = $result3;
                    $data["game_info"] = $result4;
                    $data["acc_info"] = $result5;
                    return view("user_info2", $data);
                } else {
                    echo "result error";
                    exit;
                }
            } else {
                echo "error";
                exit;
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


    public function init_log()
    {
        $logger = service("logger");
        $logger->info("==================================================================================");
        $logger->info("Start Time : \t" . date("Y-m-d H:i:s"));
    }

    public function write_log($message)
    {
        $logger = service("logger");
        $logger->info($message);
        $logger->info("==================================================================================");
    }
}
