<?php

namespace App\Controllers;



class Event_Rank extends BaseController
{
    public function __construct()
    {
        $this->config = new \Config\App();
        $this->session = \Config\Services::session();
        $this->session->start();
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
    public function gift_event()
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


        return view("event_gift", $data);
    }
}
