<?php

class Product{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function deleteById($id){
        $this->db->query("DELETE FROM products WHERE product_id = :id ");

        //Bind values param with the email variable
        $this->db->bind(':id',$id);
        $this->db->execute();
    }


    public function getProducts(){
        $this->db->query("SELECT * FROM products");
        $result = $this->db->resultSet();

        return $result;
    }



    public function getProductById($id){
        $this->db->query("SELECT * FROM products WHERE product_id = :id");

        $this->db->bind(':id',$id);
        $this->db->execute();
        $result = $this->db->single();

        return $result;
    }

    // create a new  a product
    public function createProduct($data){
        $this->db->query("INSERT INTO products (product_name, product_description, product_img, product_price, product_stock ) VALUES (:productName, :productDesc, :img, :price, :stock)");

        $this->db->bind(':productName',$data['name']);
        $this->db->bind(':productDesc',$data['desc']);
        $this->db->bind(':img',$data['img']);
        $this->db->bind(':price',$data['price']);
        $this->db->bind(':stock', $data['stock']);
        
        // Execute function
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    // update stock
    public function updateStock($id,$stock){
        $this->db->query("UPDATE products SET product_stock = :stock WHERE product_id = :id");

        $this->db->bind(':stock',$stock);
        $this->db->bind(':id',$id);

        $this->db->execute();
    }

    // update a product
    public function updateProduct($data){
        $this->db->query("UPDATE products SET  product_name = :productName , product_description = :productDesc , product_img = :img , product_price = :price , product_stock = :stock  WHERE product_id = :id");

        
        $this->db->bind(':productName',$data['name']);
        $this->db->bind(':productDesc',$data['desc']);
        $this->db->bind(':img',$data['img']);
        $this->db->bind(':price',$data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':id',$data['id']);
        
        // Execute function
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}
