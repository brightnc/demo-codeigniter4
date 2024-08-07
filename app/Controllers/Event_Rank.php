<?php

namespace App\Controllers;

use App\Models\Mydev_model;
use DateTime;
use App\Libraries\Jwt;

class Event_Rank extends BaseController
{
    private $key = "sdgsgsbs#@fsfsdf%";
    public function __construct()
    {
        $this->config = new \Config\App();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->mydev_model = new Mydev_model();
        date_default_timezone_set("Asia/Bangkok");
        $this->jwt = new Jwt();
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

        $this->init_log();
        $this->write_log("func getEventDetail : incoming request GET ->" . json_encode($_GET));
        $this->write_log("func getEventDetail : incoming request POST ->" . json_encode($_POST));


        if (!isset($_GET["token"])) {
            echo json_encode(["error" => "missing token!"]);
            $this->write_log("func getEventDetail : error -> missing token!");
            exit;
        }

        if (!isset($_GET["user_id"])) {
            echo json_encode(["error" => "missing user_id!"]);

            $this->write_log("func getEventDetail : error -> missing user_id!");
            exit;
        }
        if (!isset($_GET["gen_date"])) {
            echo json_encode(["error" => "missing gen_date!"]);

            $this->write_log("func getEventDetail : error -> missing gen_date!");
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

            $this->write_log("func getEventDetail : error -> invalid token gen date!");
            exit;
        }
        if ($ts_diff >= 300) {
            // $min = round($ts_diff / 60);
            echo json_encode(["error" => "token expired "]);
            $this->write_log("func getEventDetail : error -> token expired !");
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
        $this->write_log("func getEventDetail : response -> " . $json_result);
        echo $json_result;
    }

    public function getEventDetail_JWT()
    {

        $this->init_log();
        $this->write_log("func getEventDetail_JWT : incoming request GET ->" . json_encode($_GET));
        $this->write_log("func getEventDetail_JWT : incoming request POST ->" . json_encode($_POST));


        if (!isset($_GET["token"])) {
            echo json_encode(["error" => "missing token!"]);
            $this->write_log("func getEventDetail_JWT : error -> missing token!");
            exit;
        }

        $secret = "fafaffasfaf@#%$%asf$%";
        $token_candidate = $_GET["token"];
        $payload = $this->test_decode_jwt($token_candidate);
        if (!$payload) {
            echo json_encode(["error" => "invalid JWT token!"]);
            $this->write_log("func getEventDetail_JWT : error -> invalid token key!");
            exit;
        }
        $this->write_log("func getEventDetail_JWT : JWT payload ->" . json_encode($payload));
        $user_id_candidate = $payload->value_data;
        $issue_candidate = $payload->ctime;
        $validate_key_candidate = $payload->validate_key;
        $issur_timestamp = strtotime($issue_candidate);

        $validate_key = md5($user_id_candidate . "|" . "$issue_candidate" . "|" . $secret);

        if ($validate_key_candidate !== $validate_key) {
            echo json_encode(["error" => "wrong validate_key!"]);
            $this->write_log("func getEventDetail_JWT : error -> wrong validate_key!: got -> " . $validate_key_candidate);
            exit;
        }

        $now = time();
        $ts_diff =   $now - $issur_timestamp;
        if ($ts_diff < 0) {
            echo json_encode(["error" => "invalid token gen date!"]);

            $this->write_log("func getEventDetail_JWT : error -> invalid token gen date!");
            exit;
        }
        if ($ts_diff >= 300) {
            // $min = round($ts_diff / 60);
            echo json_encode(["error" => "token expired "]);
            $this->write_log("func getEventDetail_JWT : error -> token expired !");
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
        $this->write_log("func getEventDetail_JWT : response -> " . $json_result);
        echo $json_result;
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

    function testApi()
    {
        $token = "be6bf10e2d30c020642d847604de0ad5";
        $url = "https://1de4-49-0-87-150.ngrok-free.app/Event_Rank/getEventDetail?token=" . $token . "&user_id=user001&gen_date=2024-07-09%2013:10:00";
        $res = $this->curlGet($url);
        echo json_encode($res);
    }

    function generate_jwt_token()
    {
        $secret_key = "fafaffasfaf@#%$%asf$%";
        $value_data = "user001";
        $date_generate = date("Y-m-d H:i:s");
        $validate_key = md5($value_data . "|" . "$date_generate" . "|" . $secret_key);
        $payload = array(
            "value_data" => $value_data,
            "validate_key" => $validate_key,
            "ctime" => $date_generate
        );
        $token = $this->jwt->encode(json_encode($payload), $this->key);
        echo json_encode(["token" => $token]);
    }

    function test_decode_jwt($token_input)
    {
        $token = $this->jwt->decode($token_input, $this->key);
        if (!$token) {
            return false;
        }
        return json_decode($token);
    }

    function curlGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $res_arr = json_decode($result, true);
        return $res_arr;
    }
}
