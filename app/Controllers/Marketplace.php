<?php

namespace App\Controllers;

use App\Models\Mydev_model;
use DateTime;

class Marketplace extends BaseController
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
        $sql_itemlist = "SELECT s.item_id,s.user_id as seller_id,u.username as seller_name,s.item_name,s.item_description,s.img_url,s.item_price,s.item_quantity,s.promotion_id,p.discount_price,p.start_time,p.end_time,p.status,pt.type_name,sc.subcategory_name,c.category_name 
        FROM sell_items as s 
        LEFT JOIN promotion as p on s.promotion_id=p.promotion_id 
        LEFT JOIN promotion_type as pt on p.promotion_type_id=pt.promotion_type_id 
        LEFT JOIN users as u on s.user_id=u.user_id 
        LEFT JOIN subcategory as sc on s.subcategory_id=sc.subcategory_id 
        LEFT JOIN category as c on sc.category_id=c.category_id;";
        $itemlistResult = $this->mydev_model->select($sql_itemlist);

        $sql_auctionlist = "SELECT a.auction_id,a.user_id as seller_id,u.username as seller_name,a.item_name,a.item_description,a.img_url,a.start_price,a.bid_minimum,a.start_time,a.end_time,sc.subcategory_name,c.category_name 
        FROM auction_items as a 
        LEFT JOIN users as u on a.user_id=u.user_id 
        LEFT JOIN subcategory as sc on a.subcategory_id=sc.subcategory_id 
        LEFT JOIN category as c on sc.category_id=c.category_id;";
        $auctionlistResult = $this->mydev_model->select($sql_auctionlist);

        // $sql_bestSeller = "SELECT s.item_id,s.user_id as seller_id,u.username as seller_name,s.item_name,s.item_description,s.img_url,s.item_price,s.item_quantity,s.promotion_id,p.discount_price,p.start_time,p.end_time,p.status,pt.type_name,sc.subcategory_name,c.category_name 
        // FROM sell_items as s 
        // LEFT JOIN promotion as p on s.promotion_id=p.promotion_id 
        // LEFT JOIN promotion_type as pt on p.promotion_type_id=pt.promotion_type_id 
        // LEFT JOIN users as u on s.user_id=u.user_id 
        // LEFT JOIN subcategory as sc on s.subcategory_id=sc.subcategory_id 
        // LEFT JOIN category as c on sc.category_id=c.category_id;";
        // $bestSellerResult = $this->mydev_model->select($sql_bestSeller);

        $data["sell_list"] = $itemlistResult;
        $data["auction_list"] = $auctionlistResult;

        return view("marketplace/market_HOME", $data);
    }

    public function detail()
    {
        if (!isset($_GET["item_id"])) {
            echo "error: not found!";
            exit;
        }
        $item_id = $_GET["item_id"];
        $sql_item = "SELECT s.item_id,s.user_id as seller_id,u.username as seller_name,s.item_name,s.item_description,s.img_url,s.item_price,s.item_quantity,s.promotion_id,p.discount_price,p.start_time,p.end_time,p.status,pt.type_name,sc.subcategory_name,c.category_name 
        FROM sell_items as s 
        LEFT JOIN promotion as p on s.promotion_id=p.promotion_id 
        LEFT JOIN promotion_type as pt on p.promotion_type_id=pt.promotion_type_id 
        LEFT JOIN users as u on s.user_id=u.user_id 
        LEFT JOIN subcategory as sc on s.subcategory_id=sc.subcategory_id 
        LEFT JOIN category as c on sc.category_id=c.category_id
        WHERE s.item_id=?;";
        $item_binding_values = array($item_id);
        $itemResult = $this->mydev_model->select_binding($sql_item, $item_binding_values);
        if (count($itemResult)  < 1) {
            echo json_encode("error : not found!");
            exit;
        }
        $data["item_detail"] = $itemResult;
        return view("marketplace/market_item_detail", $data);
    }
}
