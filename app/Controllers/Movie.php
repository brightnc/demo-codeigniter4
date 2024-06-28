<?php

namespace App\Controllers;

use App\Models\Mydev_model;


class Movie extends BaseController
{
    public function __construct()
    {
        $this->config = new \Config\App();
        $this->mydev_model = new Mydev_model();
        $this->session = \Config\Services::session();
        $this->session->start();
        date_default_timezone_set("Asia/Bangkok");
    }

    public function add_showtime()
    {
        $date = $_POST["date"];
        $time = $_POST["time"];
        $movie_id = $_POST["movie_id"];
        $movie_duration = $_POST["movie_duration"];
        $price = $_POST["price"];
        $promotion = $_POST["promotion"];
        $start_time = "$date {$time}:00";
        $start_ts = strtotime($start_time);
        $movie_sec = $movie_duration * 60;
        $end_time = date('Y-m-d H:i:s', $start_ts + $movie_sec);


        $sql = "INSERT INTO movie_detail ( movie_id, movie_start,movie_end,ticket_prices,ticket_discount) VALUES (?, ?, ?,?,?)";
        $bindValue = array($movie_id, $start_time, $end_time, $price, $promotion);
        $result = $this->mydev_model->execute_binding($sql, $bindValue);

        if ($result < 0) {
            echo "err";
        }

        echo "Success";
    }

    public function login()
    {
        return view('login_movie');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('movie/login');
    }

    public function register()
    {
        return view('register');
    }

    public function login_process()
    {
        if (!$this->session->userId) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $this->request->getPost("username");
                $password = $this->request->getPost("password");
                $passwordHashed = md5($password);


                $sql_login = "SELECT user_id, username,birth_date,role FROM users WHERE username=? AND password=?;";
                $bindValue_login  = array($username, $passwordHashed);
                $result_login  = $this->mydev_model->select_binding($sql_login, $bindValue_login);

                if (count($result_login) > 0) {
                    $user_id = $result_login[0]->user_id;
                    $role = $result_login[0]->role;
                    $this->session->set("user_id", $user_id);
                    $this->session->set("role", $role);
                    if ($role == 1) {
                        $data["user"] = $result_login;
                        //admin_movie
                        $sql_admin_movies = "SELECT movie_id,movie_name,duration_min,rate_age,start_date,end_date
                        FROM movies";
                        $result_admin_movies  = $this->mydev_model->select($sql_admin_movies);


                        //admin_movie_detail
                        $sql_admin_movie_detail  = "SELECT d.movie_id,m.movie_name,m.duration_min,d.movie_start,d.movie_end,m.rate_age,d.ticket_prices,d.ticket_discount,m.start_date,m.end_date
                        FROM movie_detail AS d
                        LEFT JOIN movies AS m ON d.movie_id=m.movie_id;";
                        $result_admin_movie_detail  = $this->mydev_model->select($sql_admin_movie_detail);

                        $data["admin_movies"] = $result_admin_movies;
                        $data["movie_detail"] = $result_admin_movie_detail;
                        return view("dashboard", $data);
                    }

                    $sql_reservation = "SELECT m.movie_name,m.duration_min,d.movie_start,d.movie_end,m.rate_age,r.total_price
                    FROM reservation AS r 
                    LEFT JOIN users AS u ON r.user_id=u.user_id
                    LEFT JOIN movie_detail AS d ON r.movie_detail_id=d.movie_detail_id
                    LEFT JOIN movies AS m ON d.movie_id=m.movie_id
                    WHERE r.user_id=? GROUP  BY d.movie_start;";
                    $bindValue_reservation  = array($user_id);
                    $result_reservation  = $this->mydev_model->select_binding($sql_reservation, $bindValue_reservation);


                    if (count($result_reservation) < 1) {
                        echo $user_id;
                        exit;
                    }
                    $data["user"] = $result_login;
                    $data["info"] = $result_reservation;

                    return view("user_profile", $data);
                } else {
                    echo "result error";
                    exit;
                }
            } elseif ($this->session->get("user_id")) {
                $user_id = $this->session->get("user_id");

                $sql_login = "SELECT user_id, username,birth_date,role FROM users WHERE user_id=?;";
                $bindValue_login  = array($user_id);
                $result_login  = $this->mydev_model->select_binding($sql_login, $bindValue_login);

                if (count($result_login) > 0) {
                    $user_id = $result_login[0]->user_id;
                    $role = $result_login[0]->role;
                    $this->session->set("user_id", $user_id);
                    $this->session->set("role", $role);
                    if ($role == 1) {
                        # code...
                        return view("dashboard");
                    }

                    $sql_reservation = "SELECT m.movie_name,m.duration_min,d.movie_start,d.movie_end,m.rate_age,r.total_price
                    FROM reservation AS r 
                    LEFT JOIN users AS u ON r.user_id=u.user_id
                    LEFT JOIN movie_detail AS d ON r.movie_detail_id=d.movie_detail_id
                    LEFT JOIN movies AS m ON d.movie_id=m.movie_id
                    WHERE r.user_id=? GROUP  BY d.movie_start;";
                    $bindValue_reservation  = array($user_id);
                    $result_reservation  = $this->mydev_model->select_binding($sql_reservation, $bindValue_reservation);


                    if (count($result_reservation) < 1) {
                        echo $user_id;
                        exit;
                    }
                    $data["user"] = $result_login;
                    $data["info"] = $result_reservation;

                    return view("user_profile", $data);
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

    public function register_process()
    {
        if (!$this->session->userid) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {

                $username = $this->request->getPost("username");
                $password = $this->request->getPost("password");
                $passwordHashed = md5($password);
                $date_of_birth = $this->request->getPost("date_of_birth");
                $sql = "INSERT INTO users ( username, password,birth_date) VALUES (?, ?, ?)";
                $bindValue = array($username, $passwordHashed, $date_of_birth);
                $result = $this->mydev_model->execute_binding($sql, $bindValue);
                print_r($result);
            }
        }
    }

    public function reservation()
    {
        $user_id = $this->session->get("user_id");
        $sql_movie = "SELECT d.movie_detail_id,m.movie_name,m.duration_min,d.movie_start,d.movie_end,m.rate_age,d.ticket_prices,d.ticket_discount
                    FROM movie_detail  AS d
                    LEFT JOIN movies AS m ON d.movie_id=m.movie_id
                    ORDER  BY d.movie_start;";
        $result_movie = $this->mydev_model->select($sql_movie);
        if (count($result_movie) < 1) {
            echo "error";
            exit;
        }

        $data["user_id"] = $user_id;

        $data["movies"] = $result_movie;
        return view("reservation", $data);
    }

    public function reservation_process()
    {
        if (isset($_POST["user_id"]) && isset($_POST["movie_detail_id"])) {
            $movie_detail_id = $_POST["movie_detail_id"];
            $user_id = $_POST["user_id"];
            $final_prices = $_POST["final_prices"];

            $sql = "INSERT INTO reservation ( user_id, movie_detail_id,total_price) VALUES (?, ?, ?)";
            $bindValue = array($user_id, $movie_detail_id,  $final_prices);
            $result = $this->mydev_model->execute_binding($sql, $bindValue);

            if ($result != true) {
                echo "error booking!";
                exit;
            }

            echo "จองสำเร็จ";
        }
    }
}
