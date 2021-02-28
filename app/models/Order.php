<?php

class Order{


    public function __construct()
    {
        $this->db = new Database;
    }

    public function makeOrderId(){
        $this->db->query("SELECT MAX(order_id) AS id FROM orders");
        $result = $this->db->single();

        return $result;
    }

    public function makeOrder($data){
        $date = date('Y-m-d H:i:s');
        $this->db->query("INSERT INTO orders (order_id, user_id, total,  order_date ) values (:order_id , :customer_id, :total , :order_date)");
        

        $this->db->bind(':order_id',$data['order_id']);
        $this->db->bind(':customer_id',$data['customer_id']);
        $this->db->bind(':total',$data['total']);
        $this->db->bind(':order_date',$date);


        // Execute function
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function makeOrderDetails($data){
        $this->db->query("INSERT INTO order_details (order_id, product_id, qty) values (:order_id , :product_id , :qty)");
        

        $this->db->bind(':order_id',$data['order_id']);
        $this->db->bind(':product_id',$data['product_id']);
        $this->db->bind(':qty',$data['qty']);


        // Execute function
        $this->db->execute();
    }


    public function getOrders($id){
        $this->db->query("SELECT * FROM orders WHERE user_id = :id");

        $this->db->bind(':id',$id);
        $this->db->execute();
        $result = $this->db->resultSet();

        return $result;
    }

    public function orderDetails($id){
        $this->db->query("SELECT order_details.Order_id, products.product_name, products.product_description , products.product_img , products.product_price , order_details.qty
        FROM order_details
        INNER JOIN products ON order_details.product_id=products.product_id
        WHERE order_id = :id;");

        $this->db->bind(':id',$id);
        $this->db->execute();
        $result = $this->db->resultSet();

        return $result;
    }

}