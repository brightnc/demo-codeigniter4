<?php

namespace App\Controllers;

use App\Models\Mydev_model;
use App\Libraries\curl;
use App\Libraries\aescrypt;

class Marketplace extends BaseController
{
    public function __construct()
    {
        $this->config = new \Config\App();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->aes = new aescrypt();
        $this->curl = new curl();
        $this->key = "secret";
        $this->mydev_model = new Mydev_model();
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        if ($this->session->get("token") !== null) {
            $data["token"] = $this->session->get("token");
        }


        $res = $this->curl->get("http://localhost:3000/api/products");
        $dataBody = $res->body;
        $dataObj = json_decode($dataBody, true);

        $res_best_sell = $this->curl->get("http://localhost:3000/api/products/best-sell");
        $data_best_sell_body = $res_best_sell->body;
        $data_best_sell_arr = json_decode($data_best_sell_body, true);

        $res_categories = $this->curl->get("http://localhost:3000/api/products/categories");
        $data_categories_body = $res_categories->body;
        $data_categories_arr = json_decode($data_categories_body, true);
        $data["categories"] = $data_categories_arr;
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
            $payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $dataObj["token"])[1]))));
            $this->session->set("user_id", $payload->user_id);
            echo "Successfully logged in";
        } else {
            echo "Failed to login";
        }
    }

    public function auction_detail()
    {
        $auction_id = $this->request->getGet("auction_id");
        if (!isset($auction_id)) {
            echo "error: not found!";
            exit;
        }

        if ($this->session->get("user_id") !== null) {
            $user_id = $this->session->get("user_id");
            $user_id_encrypted = $this->aes->Encrypt($user_id, $this->key);
            $data["user_encrypted_id"] = $user_id_encrypted;
            $data["user_id"] = $user_id;
        }
        $sql_auction_item = "SELECT ai.item_name,u.username,ai.img_url,ai.start_price,ai.bid_minimum,ai.start_time,ai.end_time 
        FROM auction_items as ai 
        LEFT JOIN users as u on ai.user_id=u.user_id 
        WHERE ai.auction_id=?";
        $binding_auction_item = array($auction_id);
        $result_auction_item = $this->mydev_model->select_binding($sql_auction_item, $binding_auction_item);

        $sql_auction_history = "SELECT u.username,ah.bid_price
        FROM auction_history as ah
        LEFT JOIN users as u on ah.user_id=u.user_id
        WHERE ah.auction_id=?
        ORDER BY ah.bid_price DESC";
        $binding_auction_history = array($auction_id);
        $result_auction_history = $this->mydev_model->select_binding($sql_auction_history, $binding_auction_history);

        $data["auction_id"] = $this->request->getGet("auction_id");
        $data["auction_detail"] = $result_auction_item;
        $data["auction_history"] = $result_auction_history;
        return view("marketplace/market_auction_item_detail ", $data);
    }

    public function auction_process()
    {
        $auction_id = $this->request->getPost("auction_id");
        $user_id = $this->request->getPost("user_id");
        $bid_price = $this->request->getPost("bid_price");
        $checksum = $this->request->getPost("checksum");
        print_r($auction_id);
    }

    public function detail()
    {
        if (!isset($_GET["item_id"])) {
            echo "error: not found!";
            exit;
        }
        if ($this->session->get("token") !== null) {
            $data["token"] = $this->session->get("token");
        }
        $item_id = $_GET["item_id"];
        $res = $this->curl->get("http://localhost:3000/api/products/{$item_id}");
        $dataBody = $res->body;
        $dataObj = json_decode($dataBody, true);
        $data["item_detail"] = $dataObj;
        return view("marketplace/market_item_detail", $data);
    }

    public function profile()
    {
        if ($this->session->get("token") == null) {
            return redirect()->to(base_url("Marketplace/login"));
        }
        $token = $this->session->get("token");
        $data["token"] =  $token;
        $res_user_info = $this->curl->get("http://localhost:3000/api/me", ["Authorization: Bearer " . $token]);
        $data_body_user_info = $res_user_info->body;
        $data_user_info = json_decode($data_body_user_info, true);
        if ($data_user_info["code"] !== 200) {
            echo $data_user_info["message"];
            exit;
        }

        $res_user_orders = $this->curl->get("http://localhost:3000/api/me/orders", ["Authorization: Bearer " . $token]);
        $data_user_orders_body = $res_user_orders->body;
        $data_user_orders = json_decode($data_user_orders_body, true);
        if ($data_user_orders["code"] !== 200) {
            echo $data_user_orders["message"];
            exit;
        }


        $data["user_orders"] = $data_user_orders["data"];
        $data["user_info"] = $data_user_info["data"];
        return view("marketplace/profile", $data);
    }

    public function auction()
    {
        $sql = "SELECT ai.auction_id,ai.item_name,u.username,ai.img_url,ai.start_price,ai.bid_minimum,ai.start_time,ai.end_time FROM auction_items as ai LEFT JOIN users as u on ai.user_id=u.user_id";
        $result = $this->mydev_model->select($sql);

        $data["auction_list"] = $result;
        return view("marketplace/auction", $data);
    }

    private function curl_post($url, $data)
    {
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
