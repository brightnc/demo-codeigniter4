<?php

namespace App\Controllers;

use App\Models\Mydev_model;
use DateTime;

class Event_Rank extends BaseController
{
    public function __construct()
    {
        $this->config = new \Config\App();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->mydev_model = new Mydev_model();
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $url = "https://takeme.la/tikky_training/tikky_api";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res_arr = json_decode($result, true);

        $data["data"] =  $res_arr;


        return view("event_rank", $data);
    }
    public function live_event()
    {
        $url = "https://takeme.la/manual_info/list_rank_training/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res_arr = json_decode($result, true);

        $data["data"] =  $res_arr;

        if (isset($_GET['lang'])) {
            if ($_GET['lang'] == "eng") {
                return view("live_event_eng", $data);
            }
        }


        return view("live_event", $data);
    }

    private function curl_event($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return  $result;
    }

    public function love_heart_event()
    {
        $url = "https://takeme.la/tikky_training/tikky_api";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res_arr = json_decode($result, true);

        $data["data"] =  $res_arr;

        if (isset($_GET['lang'])) {
            if ($_GET['lang'] == "eng") {
                return view("love_heart_event_eng", $data);
            }
        }


        return view("love_heart_event", $data);
    }

    public function hot_code_event()
    {
        $url = "https://cffe-49-0-87-150.ngrok-free.app/Event_Rank/getEventDetail";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res_arr = json_decode($result, true);

        $data["data"] =  $res_arr;

        if (isset($_GET['lang'])) {
            if ($_GET['lang'] == "eng") {
                return view("hot_code_event_eng", $data);
            }
        }


        return view("hot_code_event", $data);
    }

    public function insertEvent()
    {
        $url = "https://takeme.la/manual_info/list_rank_training/";
        $result = json_decode($this->curl_event($url), true);

        $data = $result["more_data"];

        $isDataExist = "SELECT COUNT(*) as row FROM event_detail;";
        $result_isDataExist  = $this->mydev_model->select($isDataExist);
        $row = $result_isDataExist[0]->row;
        if ($row > 0) {
            $sqlDel = " DELETE FROM event_detail where event_id = 1;";
            $this->mydev_model->execute($sqlDel);
        }


        $sql_event = "SELECT event_start,event_end FROM event_master WHERE event_id = 1;";
        $result_event  = $this->mydev_model->select($sql_event);
        $start_time = strtotime($result_event[0]->event_start);
        $end_time = strtotime($result_event[0]->event_end);
        $now = time();
        $update_time = date("Y-m-d H:i:s");

        if ($now < $start_time) {
            echo "event not start yet!";
            exit;
        } elseif ($now > $end_time) {
            echo "event end!";
            exit;
        }

        $sql = "INSERT INTO event_detail (user_id, event_id,user_name, user_logo,count_gift,updatetime) VALUES";
        $values = array();
        foreach ($data as $v) {
            $user_name = addslashes($v['user_name']);
            array_push($values, "('{$v['user_id']}',1,'{$user_name}','{$v['user_logo']}','{$v['count_gift']}','{$update_time}')");
        }

        $sqlResult = $sql . join(",", $values);
        $result = $this->mydev_model->execute($sqlResult);
        if ($result == false) {
            echo "error insert";
        }

        echo "success insert";
    }


    public function getEventDetail()
    {


        if (!isset($_GET["token"])) {
            echo "missing token!";
            exit;
        }
        if (!isset($_GET["user_id"])) {
            echo "missing user_id!";
            exit;
        }
        if (!isset($_GET["gen_date"])) {
            echo "missing gen_date!";
            exit;
        }
        $secret = "dddxxxddd";
        $token_candidate = $_GET["token"];
        $user_id_candidate = $_GET["user_id"];
        $issue_candidate = urldecode($_GET["gen_date"]);
        $issur_timestamp = strtotime($issue_candidate);


        $token = md5($user_id_candidate . "|" . "$issue_candidate" . "|" . $secret);

        if ($token_candidate !== $token) {
            echo json_encode(["error" => "wrong token!"]);
            exit;
        }

        $now = time();
        $ts_diff =   $now - $issur_timestamp;
        if ($ts_diff < 0) {
            echo json_encode(["error" => "invalid token gen date!"]);
            exit;
        }
        if ($ts_diff >= 3600) {
            $min = round($ts_diff / 60);
            echo json_encode(["error" => "token expired more than $min mins"]);
            exit;
        }


        $result = array("code" => "101", "status" => "success");
        $result["more_data"] = [];

        $sql_event_detail = "SELECT user_id,user_name,user_logo,count_gift FROM event_detail WHERE event_id = 1;";
        $result_event_detail  = $this->mydev_model->select($sql_event_detail);
        if (count($result_event_detail) < 1) {
            echo json_encode(["error" => "cant get event detail data"]);
            exit;
        }

        for ($i = 0; $i < count($result_event_detail); $i++) {
            array_push($result["more_data"], $result_event_detail[$i]);
        }


        $sql_event = "SELECT nm.event_id,nm.event_name,em.event_start,em.event_end,lang.lang_name FROM event_name_master as nm LEFT JOIN event_master as em on nm.event_id=em.event_id LEFT JOIN event_lang_master as lang  on nm.lang_id=lang.lang_id WHERE nm.event_id=1 ;";
        $result_event  = $this->mydev_model->select($sql_event);
        if (count($result_event) < 1) {
            echo json_encode(["error" => "cant get event data"]);
            exit;
        }


        $result["group"] = [];
        $start_time = $result_event[0]->event_start;
        $end_time = $result_event[0]->event_end;
        $event_id = $result_event[0]->event_id;
        $event_name = $result_event[0]->event_name;


        for ($i = 0; $i < count($result_event); $i++) {
            $lang_name = $result_event[$i]->lang_name;
            $event_name = $result_event[$i]->event_name;
            if ($lang_name == "Thailand") {
                $result["group"]["th-lang"] = $event_name;
            } elseif ($lang_name == "English") {
                $result["group"]["en-lang"] = $event_name;
            }
        }

        $result["group"]["start_date"] = $start_time;
        $result["group"]["end_date"] = $end_time;
        $result["group"]["event_id"] = $event_id;

        $json_result = json_encode($result);
        echo $json_result;
    }
}
