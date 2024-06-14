<?php

namespace App\Controllers;

use App\Models\Mydev_model;




class Home extends BaseController
{

    public function __construct()
    {
        $this->config = new \Config\App();
        $this->mydev_model = new Mydev_model();
    }

    public function index()
    {
        // return view('welcome_message');
        echo "Hello ci";
    }

    public function index2()
    {
        echo "Hello ci this is index 2";
    }

    public function fans($input1, $input2)
    {
        echo "Hello ci this is fans 1 " . $input1;
        echo "<br>";
        echo "Hello ci this is fans 2 " . $input2;
    }

    public function test_view($input1 = "", $input2 = "")
    {
        $dataGET = $_GET["data1"];
        // $dataPOST = $_POST["data2"];
        $data["input_data"] = array("input1" => $input1, "input2" => $input2, "dataGET" => $dataGET);
        return view('my_view', $data);
    }

    public function testConfigVal()
    {
        echo $this->config->token_key;
    }

    public function testConMysql()
    {
        $sql = "SELECT * FROM user_info ORDER BY created_at DESC;";
        $result = $this->mydev_model->select($sql);


        if (count($result) > 0) {
            $data["user_data"] = $result;
            return view("users_info", $data);
        }
        echo "error fetching Data!";
    }

    public function form()
    {
        return view('form');
    }

    public function form_process()
    {
        $input_username  = $_POST["username"]; // a-z,0-9
        $input_password = $_POST["password"];
        $input_confirm_password = $_POST["confirm_password"];
        $input_f_name = $_POST["f_name"];
        $input_l_name = $_POST["l_name"];
        $input_phone = $_POST["phone"]; //0-9
        $input_email = $_POST["email"];
        $input_user_id = $_POST["user_id"];
        // echo "<pre>";
        // print_r($_POST);

        $username_regex = "/^[a-zA-Z0-9]{4,12}$/";
        $password_regex = "/[a-zA-Z0-9]{6}/";
        $character_regex = "/^[a-zA-Z]+$/";
        $number_regex = "/^[0-9]+$/";
        $email_regex = "/^[a-zA-Z0-9]+@/";
        $user_id_regex = "/^[0-9]{13}$/";



        if (!preg_match($username_regex, $input_username)) {
            echo "username : " . $input_username;
            echo "<br>";
            echo "wrong username format";
            exit;
        }

        if (!preg_match($password_regex, $input_password) || !preg_match($password_regex, $input_confirm_password)) {
            echo "password : " . $input_password;
            echo "<br>";
            echo "c_password : " . $input_confirm_password;
            echo "<br>";
            echo "wrong password format";
            exit;
        }

        if (!preg_match($character_regex, $input_f_name) || !preg_match($character_regex, $input_l_name)) {
            echo "f_name : " . $input_f_name;
            echo "<br>";
            echo "l_name : " . $input_l_name;
            echo "<br>";
            echo "wrong name format";
            exit;
        }

        if (!preg_match($number_regex, $input_phone)) {
            echo "phone : " . $input_phone;
            echo "<br>";
            echo "wrong phone number format";
            exit;
        }

        if (!preg_match($email_regex, $input_email)) {
            echo "email : " . $input_email;
            echo "<br>";
            echo "wrong email format";
            exit;
        }

        if (!preg_match($user_id_regex, $input_user_id)) {
            echo "user_id : " . $input_user_id;
            echo "<br>";
            echo "wrong user id format";
            exit;
        }

        if (strcmp($input_password, $input_confirm_password) != 0) {
            echo $input_password;
            echo "<br>";
            echo var_dump($input_password);
            echo "<br>";
            echo $input_confirm_password;
            echo "<br>";
            echo "password not match";
            exit;
        }

        $data["input_data"] = array("username" => $input_username, "f_name" => $input_f_name, "l_name" => $input_l_name, "phone" => $input_phone, "email" => $input_email, "user_id" => $input_user_id);
        return view("form_process", $data);
    }
}
