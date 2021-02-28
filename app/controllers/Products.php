<?php

class Products extends Controller{
    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    

    public function remove(){
        
        if($_GET['action'] == 'remove'){

        $id = $_GET['id'];
        

        for ($x = 0; $x < count($_SESSION['products_qty']); $x++){

            if($_SESSION['products_qty'][$x]['product']['id'] == $id){
                
                unset($_SESSION['products_qty'][$x]);
            }
          }
        }


        $count = 0;
        $products = $_SESSION['products_qty'];
        unset($_SESSION['products_qty']);

        foreach($products as $product){
            $_SESSION['products_qty'][$count] = $product;
            $count++; 
        }

        
        $this->view('products/shoppingCart');
    }

    public function delete(){
        $data = [
            'deleted' => '',
            'error' => '',
            'products' => '',
        ];

        if($_GET['action'] == 'delete'){

            $id = $_GET['id'];
            $product = $this->productModel->getProductById($id);
             $this->productModel->deleteById($id);
            $data['deleted'] =  $product->product_name . " is deleted";
        }
        
        $products = $this->productModel->getProducts();

        $data['products'] = $products;
        $this->view('products/editProducts', $data);
    }

    public function displayProducts(){
        $products = $this->productModel->getProducts();

        $data = [
            
            'products' => $products,
        ];

        $this->view('products/displayProducts', $data);
    }

    public function editProducts(){
        $products = $this->productModel->getProducts();

        $data = [
            'deleted' => '',
            'error' => '',
            'products' => $products,
        ];
        $this->view('products/editProducts', $data);
    }

    public function shoppingCart(){        
        $this->view('products/shoppingCart');
    }


    public function plus(){

        $data = [
            'availability' => ''
        ];

        $product = $this->productModel->getProductById($_GET['id']);

        for ($x = 0; $x < count($_SESSION['products_qty']); $x++){

            $id = $_GET['id'];

            if($_SESSION['products_qty'][$x]['product']['id'] == $id){

                if($_SESSION['products_qty'][$x]['product']['qty'] + 1 <= $product->product_stock){
                    $_SESSION['products_qty'][$x]['product']['qty'] += 1;
                    $data['availability']  = '<h3 class="validfeedback">' . $product->product_name . ' is increased by one </h3>';
                }else{
                    $data['availability']  = '<h3 class="invalidfeedback"> We have only ' . $product->product_stock . ' ' . $product->product_name.' in stock </h3>';
                }

                
            }
        }
        $this->view('products/shoppingCart',$data);
    }

    public function minus(){

        for ($x = 0; $x < count($_SESSION['products_qty']); $x++){

            $id = $_GET['id'];

            if($_SESSION['products_qty'][$x]['product']['id'] == $id){

                if($_SESSION['products_qty'][$x]['product']['qty'] > 1){

                    $_SESSION['products_qty'][$x]['product']['qty'] -= 1;
                }
            }
        }
        $this->view('products/shoppingCart');
    }

    public function addToCart(){

        // set session product to add products to cart
        //unset($_SESSION['products_qty']);

        $data = [
            'products' => '',
            'availability' => '',
        ];

        try{

       

        $product = $this->productModel->getProductById($_GET['id']);

        if($product->product_stock > 0){


        $id = $product->product_id;
        $name = $product->product_name;
        $price = $product->product_price;
        $img = $product->product_img;

        $p = array(
            'name' => $name,
            'price' => $price,
            'img' => $img,
            'qty' => 1,
            'id' => $id,
        );

        if(isset($_SESSION['products_qty'])){

        $added = false;

        for ($x = 0; $x < count($_SESSION['products_qty']); $x++){

            $id = $_GET['id'];

            if($_SESSION['products_qty'][$x]['product']['id'] == $id){

                $added = true;
            }
        }


        if($added){
            for ($x = 0; $x < count($_SESSION['products_qty']); $x++){

            $id = $_GET['id'];

            if($_SESSION['products_qty'][$x]['product']['id'] == $id){

                if($_SESSION['products_qty'][$x]['product']['qty'] + 1 <= $product->product_stock){
                    $_SESSION['products_qty'][$x]['product']['qty'] += 1;
                }else{

                    $products = $this->productModel->getProducts();

                    $data = [
                        'products' => $products,
                        'availability' => '<h3 class="validfeedbackYellow">We have only ' .  $product->product_stock . ' ' .$product->product_name. ' in stock</h3>'
                    ];

                    $this->view('products/displayProducts', $data);
                }
            }
        }   
        }else{

            $count = count($_SESSION['products_qty']);

            $product_array = array(
                'product' => $p 
            );


            $_SESSION['products_qty'][$count] = $product_array;
        }

        }else{

            $product_array = array(
                'product' => $p 
            );

            $_SESSION['products_qty'][0] = $product_array;
        }

        
        $products = $this->productModel->getProducts();

        $data = [
            'products' => $products,
            'availability' => '<h3 class="validfeedback">' . $name . ' added to cart successfully</h3>'
        ];
    }else{

        $products = $this->productModel->getProducts();

        $data = [
            'products' => $products,
            'availability' => '<h3 class="invalidfeedback">Sorry for the inconveniences, this item is not available anymore</h3>'
        ];
    }

       $this->view('products/displayProducts', $data);

        }catch(Exception $e){
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function productDetails(){

        $data = [

            'id' => '',
            // old values
            'name' => '',
            'desc' => '',
            'price' => '',
            'stock' => '',
            'img' => '',

            
            'nameError' => '',
            'descError' => '',
            'priceError' => '',
            'stockError' => '',
            'imgError' => '',
        ];

        $data['id'] = $_GET['id'];
        $product = $this->productModel->getProductById($data['id']);

        $data['name'] = $product->product_name;
        $data['desc'] = $product->product_description;
        $data['price'] = $product->product_price;
        $data['stock'] = $product->product_stock;
        $data['img'] = $product->product_img;

        $this->view('products/productDetails', $data);
    }

    public function update(){


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            
            $data = [

            'id' => $_GET['id'],
            // old values
            'name' => trim($_POST['name']),
            'desc' => trim($_POST['desc']),
            'price' => trim($_POST['price']),
            'stock' => trim($_POST['stock']),
            'img' => trim($_POST['img']),

            
            'nameError' => '',
            'descError' => '',
            'priceError' => '',
            'stockError' => '',
            'imgError' => '',

            'updateStatus' => ''
        ];


            if(empty($_POST['name'])){
                $data['nameError'] = 'Please enter name';
            }

            if(empty($_POST['desc'])){
                $data['descError'] = 'Please enter description';
            }

            if(empty($_POST['img'])){
                $data['imgError'] = 'Please enter the name of image';
            }

            if(empty($_POST['price'])){
                $data['priceError'] = 'Please enter price';
            }else if(!preg_match(NUMBERVALIDATION, $data['price'])){
                $data['priceError'] = 'Price can only contains numbers';
            }

            if(empty($_POST['stock'])){
                $data['stockError'] = 'Please enter stock';
            }else if(!preg_match(NUMBERVALIDATION, $data['stock'])){
                $data['stockError'] = 'Stock can only contains numbers';
            }
        }


        if(empty($data['nameError']) && empty($data['descError']) && empty($data['priceError']) && empty($data['stockError']) && empty($data['imgError']) ){

            if($this->productModel->updateProduct($data)){
                $data['updateStatus'] = '' . $data['name'] . ' is updated successfully';
            }else{
                $data['updateStatusError'] = 'Something is went wrong! try agin later';
            }
        }

        $this->view('products/productDetails', $data);
    }


    public function addProduct(){

        $data = [
                

             // variables for eventual errors
            'nameError' => '',
            'descError' => '',
            'priceError' => '',
            'stockError' => '',
            'imgError' => '',
            ];


        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            

            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                // variables that user has typed
                'name' => trim($_POST['name']),
                'desc' => trim($_POST['desc']),
                'price' => trim($_POST['price']),
                'stock' => trim($_POST['stock']),
                'img' => trim($_POST['img']),

                // variables for eventual errors
                'nameError' => '',
                'descError' => '',
                'priceError' => '',
                'stockError' => '',
                'imgError' => '',
            ];


            if(empty($data['name'])){
                $data['nameError'] = 'Please enter name';
            }

            if(empty($data['desc'])){
                $data['descError'] = 'Please enter description';
            }

            if(empty($data['img'])){
                $data['imgError'] = 'Please enter the name of image';
            }

            if(empty($data['price'])){
                $data['priceError'] = 'Please enter price';
            }else if(!preg_match(NUMBERVALIDATION, $data['price'])){
                $data['priceError'] = 'Price can only contains numbers';
            }

            if(empty($data['stock'])){
                $data['stockError'] = 'Please enter stock';
            }else if(!preg_match(NUMBERVALIDATION, $data['stock'])){
                $data['stockError'] = 'Stock can only contains numbers';
            }

            if(empty($data['nameError']) && empty($data['descError']) && empty($data['priceError']) && empty($data['stockError']) && empty($data['imgError']) ){


                // Register product through model of the product
                if($this->productModel->createProduct($data)){
                    
                    header('location: ' . URLROOT . '/products/editProducts');
                }else{
                    die('Something went wrong.');
                }
            }
        }
        $this->view('products/addProduct', $data);
    }
}

?>