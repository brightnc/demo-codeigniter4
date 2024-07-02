<?php

namespace App\Controllers;

use App\Models\Mydev_model;
use DateTime;


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
    public function add_movie()
    {
        $movie_name = $_POST["movie_name"];
        $movie_start = $_POST["movie_start"];
        $movie_end = $_POST["movie_end"];
        $movie_duration = $_POST["movie_duration"];
        $movie_rate = $_POST["movie_rate"];
        $trim_movie_name = trim($movie_name);

        $sql = "INSERT INTO movies ( movie_name, start_date,end_date,rate_age,duration_min) VALUES (?, ?, ?,?,?)";
        $bindValue = array($trim_movie_name, $movie_start, $movie_end, $movie_rate, $movie_duration);
        $result = $this->mydev_model->execute_binding($sql, $bindValue);

        if ($result < 0) {
            echo "err";
        }

        echo "Success";
    }

    public function edit_movie_process()
    {
        $movie_id = $_POST["movie_id"];
        $movie_name = rawurldecode($_POST["movie_name"]);
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $duration_min = $_POST["duration_min"];
        $rate_age = $_POST["rate_age"];
        $trim_movie_name = trim($movie_name);

        $sql = "UPDATE movies SET movie_name = ?, start_date=?, end_date=?, rate_age=?, duration_min=? WHERE movie_id=?;";
        $bindValue = array($trim_movie_name, $start_date, $end_date, $rate_age, $duration_min, $movie_id);
        $result = $this->mydev_model->execute_binding($sql, $bindValue);
        if (!$result) {
            echo "error editing movie id : " . $movie_id;
            exit;
        }

        echo "แก้ไขสำเร็จ";
    }

    public function edit_movie_detail_process()
    {
        $movie_detail_id = $_POST["movie_detail_id"];
        $movie_start = $_POST["movie_start"];
        $movie_end = $_POST["movie_end"];
        $ticket_prices = $_POST["ticket_prices"];
        $ticket_discount = $_POST["ticket_discount"];

        $sql = "UPDATE movie_detail SET movie_start=?, movie_end=?,ticket_prices=?,ticket_discount=? WHERE movie_detail_id=?;";
        $bindValue = array($movie_start, $movie_end, $ticket_prices, $ticket_discount, $movie_detail_id);
        $result = $this->mydev_model->execute_binding($sql, $bindValue);
        if (!$result) {
            echo "error editing movie id : " . $movie_detail_id;
            exit;
        }

        echo "แก้ไขสำเร็จ";
    }

    public function edit_movie()
    {
        $movie_id = $_GET["movie_id"];
        $movie_name = rawurldecode($_GET["movie_name"]);
        $start_date = $_GET["start_date"];
        $end_date = $_GET["end_date"];
        $duration_min = $_GET["duration_min"];
        $rate_age = $_GET["rate_age"];
        $trim_movie_name = trim($movie_name);
        $data["movie_info"] = array("movie_id" => $movie_id, "movie_name" => $trim_movie_name, "start_date" => $start_date, "end_date" => $end_date,  "duration_min" => $duration_min,  "rate_age" => $rate_age);


        return view("edit_movie", $data);
    }



    public function edit_movie_detail()
    {
        $movie_detail_id = $_GET["movie_detail_id"];
        $movie_name = rawurldecode($_GET["movie_name"]);
        $movie_start = rawurldecode($_GET["movie_start"]);
        $movie_end = rawurldecode($_GET["movie_end"]);
        $duration_min = $_GET["duration_min"];
        $rate_age = $_GET["rate_age"];
        $ticket_prices = $_GET["ticket_prices"];
        $ticket_discount = $_GET["ticket_discount"];
        $trim_movie_name = trim($movie_name);
        $data["movie_info"] = array("movie_detail_id" => $movie_detail_id, "movie_name" => $trim_movie_name, "movie_start" => $movie_start, "movie_end" => $movie_end,  "duration_min" => $duration_min,  "rate_age" => $rate_age,  "ticket_prices" => $ticket_prices,  "ticket_discount" => $ticket_discount);


        return view("edit_movie_detail", $data);
    }

    public function del_movie_detail()
    {
        $movie_detail_id = $_GET["movie_detail_id"];
        $sql = "DELETE FROM movie_detail WHERE movie_detail_id=?;";
        $bindValue = array($movie_detail_id);
        $result = $this->mydev_model->execute_binding($sql, $bindValue);
        if (!$result) {
            echo "error delete movie_detail_id :" . $movie_detail_id;
            exit;
        }
        echo "Successfully deleted";
    }

    public function del_movie()
    {
        $movie_id = $_GET["movie_id"];

        $sql = "DELETE FROM movies WHERE movie_id=?;";
        $bindValue = array($movie_id);
        $result = $this->mydev_model->execute_binding($sql, $bindValue);
        if (!$result) {
            echo "error delete movie_id :" . $movie_id;
            exit;
        }
        echo "Successfully deleted";
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
        return redirect()->to("movie/login");
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
                    $birth_date = $result_login[0]->birth_date;

                    $birthDate = new DateTime($birth_date);
                    $currentDate = new DateTime();
                    $age = $currentDate->diff($birthDate);

                    $this->session->set("user_id", $user_id);
                    $this->session->set("role", $role);
                    $this->session->set("age", $age->y);
                    if ($role == 1) {
                        $data["user"] = $result_login;
                        //admin_movie
                        $sql_admin_movies = "SELECT movie_id,movie_name,duration_min,rate_age,start_date,end_date
                        FROM movies";
                        $result_admin_movies  = $this->mydev_model->select($sql_admin_movies);


                        //admin_movie_detail
                        $sql_admin_movie_detail  = "SELECT  d.movie_detail_id,d.movie_id,m.movie_name,m.duration_min,d.movie_start,d.movie_end,m.rate_age,d.ticket_prices,d.ticket_discount,m.start_date,m.end_date,(SELECT COUNT(*) FROM reservation WHERE reservation.movie_detail_id = d.movie_detail_id) AS reservation_count
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
                    WHERE r.user_id=? ORDER BY r.created_at DESC;";
                    $bindValue_reservation  = array($user_id);
                    $result_reservation  = $this->mydev_model->select_binding($sql_reservation, $bindValue_reservation);
                    $data["user_id"] = $user_id;
                    $data["user_age"] =  $age->y;
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
                    $birth_date = $result_login[0]->birth_date;

                    $birthDate = new DateTime($birth_date);
                    $currentDate = new DateTime();
                    $age = $currentDate->diff($birthDate);

                    $this->session->set("user_id", $user_id);
                    $this->session->set("role", $role);
                    $this->session->set("age", $age->y);

                    if ($role == 1) {
                        $data["user"] = $result_login;
                        //admin_movie
                        $sql_admin_movies = "SELECT movie_id,movie_name,duration_min,rate_age,start_date,end_date
                        FROM movies";
                        $result_admin_movies  = $this->mydev_model->select($sql_admin_movies);


                        //admin_movie_detail
                        $sql_admin_movie_detail  = "SELECT d.movie_detail_id,d.movie_id,m.movie_name,m.duration_min,d.movie_start,d.movie_end,m.rate_age,d.ticket_prices,d.ticket_discount,m.start_date,m.end_date,(SELECT COUNT(*) FROM reservation WHERE reservation.movie_detail_id = d.movie_detail_id) AS reservation_count
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
                    WHERE r.user_id=? ORDER BY r.created_at DESC;;";
                    $bindValue_reservation  = array($user_id);
                    $result_reservation  = $this->mydev_model->select_binding($sql_reservation, $bindValue_reservation);


                    // if (count($result_reservation) < 1) {
                    //     echo $user_id;
                    //     exit;
                    // }
                    $data["user_id"] = $user_id;
                    $data["user_age"] =  $age->y;
                    $data["user"] = $result_login;
                    $data["info"] = $result_reservation;

                    return view("user_profile", $data);
                } else {
                    echo "result error";
                    exit;
                }
            } else {
                $user_id = $this->session->get("user_id");
                echo "error please login";
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

                if ($result < 0) {
                    echo "err";
                }

                return redirect()->to("movie/login");
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

            $user_age = $this->session->get("age");
            $movie_detail_id = $_POST["movie_detail_id"];
            $user_id = $_POST["user_id"];
            $final_prices = $_POST["final_prices"];
            $rate_age = $_POST["rate_age"];

            if ($user_age < $rate_age) {
                echo "error The minimum rate age has not passed!!";
                exit;
            }

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

    public function movie_list()
    {
        $sql = "SELECT movie_id,movie_name,start_date,end_date,rate_age,duration_min FROM movies;";
        $result = $this->mydev_model->select($sql);

        if (count($result) < 1) {
            echo "error movie list";
        }

        $data["movie_list"] = $result;
        return view("movie_list", $data);
    }

    public function movie_showtime()
    {
        $movie_id = $_GET["movie_id"];
        $sql = "SELECT movie_start,movie_end,ticket_prices,ticket_discount FROM movie_detail;";
        $result = $this->mydev_model->select($sql);

        if (count($result) < 1) {
            echo "error movie list";
        }
    }
}
