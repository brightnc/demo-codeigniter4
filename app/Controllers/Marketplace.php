<?php

namespace App\Controllers;

use App\Models\Mydev_model;
use DateTime;
use App\Libraries\curl;

class Marketplace extends BaseController
{
    public function __construct()
    {
        $this->config = new \Config\App();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->curl = new curl();
        $this->mydev_model = new Mydev_model();
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        if($this->session->get("token") !== null){
            $data["token"] = $this->session->get("token");
        }
        $res = $this->curl->get("http://localhost:3000/api/products");
        $dataBody = $res->body;
        $dataObj = json_decode($dataBody, true);

        $res_best_sell = $this->curl->get("http://localhost:3000/api/products/best-sell");
        $data_best_sell_body = $res_best_sell->body;
        $data_best_sell_arr = json_decode($data_best_sell_body, true);
        $data["sell_list"] = $dataObj;
        $data["best_sell"] = $data_best_sell_arr;


        return view("marketplace/market_HOME", $data);
    }

    public function login()
    {
        return view("marketplace/market_LOGIN");
    }

    public function logout()
    {
        $this->session->remove("token");
        return redirect()->to(base_url("Marketplace/index"));
    }
    public function login_process()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $url = "http://localhost:3000/api/login";
        $jsonBody = json_encode(["username" => $username, "password" => $password]);
       $response = $this->curl_post($url, $jsonBody);

        $dataObj = json_decode($response, true);
        if (isset($dataObj["token"])) {
            $this->session->set("token", $dataObj["token"]);
            echo "Successfully logged in";
        } else {
            echo "Failed to login";
        }
    }

    public function detail()
    {
        if (!isset($_GET["item_id"])) {
            echo "error: not found!";
            exit;
        }
        if($this->session->get("token") !== null){
            $data["token"] = $this->session->get("token");
        }
        $item_id = $_GET["item_id"];
        $res = $this->curl->get("http://localhost:3000/api/products/{$item_id}");
        $dataBody = $res->body;
        $dataObj = json_decode($dataBody, true);
        $data["item_detail"] = $dataObj;
        return view("marketplace/market_item_detail", $data);
    }

    public function profile(){
        if($this->session->get("token") == null){
            return redirect()->to(base_url("Marketplace/index"));
        }
        $data["token"] = $this->session->get("token");
        $res = $this->curl->get("http://localhost:3000/api/auth/me");
        $dataBody = $res->body;
        $dataObj = json_decode($dataBody, true);
        $data["item_detail"] = $dataObj;
        return view("marketplace/profile");
    }

    private function curl_post($url, $data){
         $ch = curl_init($url);

         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, [
             'Content-Type: application/json',
         ]);
 
         $response = curl_exec($ch);
         curl_close($ch);
         return $response;
    }
}