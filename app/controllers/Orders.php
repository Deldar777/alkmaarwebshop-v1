<?php

class Orders extends Controller{

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
        $this->productModel = $this->model('Product');
    }

    public function makeOrder(){

        $data = [
            'order_id' => '',
            'customer_id' => '',
            'total' => '',
            'product_id' => '',
            'qty' => '',

            'successful' => '',
        ];


        try{

        if(isset($_SESSION['user_id'])){

            $order_id = $this->orderModel->makeOrderId()->id;
            $order_id += 1;

            $customer_id = $_SESSION['user_id'];

            if(!empty($order_id) && !empty($customer_id)){

                $data['order_id'] = $order_id;
                $data['customer_id'] = $customer_id;
                $data['total'] = $_GET['total'];

                // add alle products in the session to the order 
                if($this->orderModel->makeOrder($data)){

                    for ($x = 0; $x < count($_SESSION['products_qty']); $x++){

                        $data['product_id'] = $_SESSION['products_qty'][$x]['product']['id'];
                        $data['qty'] = $_SESSION['products_qty'][$x]['product']['qty'];

                        // subtract the ordered items from the stock
                        $product = $this->productModel->getProductById($data['product_id']);

                        $oldStock = $product->product_stock;
                        $newStock = $oldStock - $data['qty'];

                        // update stock
                        $this->productModel->updateStock($data['product_id'],$newStock);

                        $this->orderModel->makeOrderDetails($data);
                    }

                    header('location: ' . URLROOT . '/products/shoppingCart?action=successful');
                    unset($_SESSION['products_qty']);
                }   
            }

            }
            else{
            header('location: ' . URLROOT . '/users/login');
            }
        }catch(Exception $e){
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function getOrders(){
        
        $customer_id = $_SESSION['user_id'];

        $orders = $this->orderModel->getOrders($customer_id);

        $data = [
            
            'orders' => $orders,
        ];

        $this->view('orders/orders', $data);
    }

    public function orderDetails(){
        
        $order_id = $_GET['id'];
        $orders = $this->orderModel->orderDetails($order_id);

        $data = [
            
            'products' => $orders,
        ];

        $this->view('orders/orderDetails', $data);
    }
}