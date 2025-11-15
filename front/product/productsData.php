<?php  
       session_start();

       if(isset($_GET['idCategory'])){
       $idCategory = $_GET['idCategory'];
       $_SESSION['idCategory']=$idCategory;
       } 

       $idProductSelected=0;
       if (isset($_SESSION['idProductSelected'])){

          $idProductSelected = $_SESSION['idProductSelected'];
       }
     
       require_once "\htdocs\include\database.php";

       //>> Get produits       
       $sql ="SELECT * FROM products
              INNER JOIN categories 
              ON products.id_category = categories.id_category
              WHERE products.id_category = $idCategory;";
            //  WHERE products.id_category = $idCategory or $idCategory=1;";
              
              
       $result = mysqli_query($conn, $sql);
                     
       $produits = mysqli_fetch_all($result, MYSQLI_ASSOC);

       $arrayProducts = [];
       foreach ($produits as $product) {

                $idProduct = $product['id_product'];
               $idCategory = $product['id_category'];
             $nameCategory = $product['name_category'];
              $nameProduct = $product['name_product'];
                    $price = $product['price'];
                   $imgsrc = $product['imgSrc'];

              $elementProduct =  [
                       "idProduct" => $idProduct,
                      "idCategory" => $idCategory,
                    "nameCategory" => $nameCategory,
                     "nameProduct" => $nameProduct,
                           "price" => $price,
                          "imgsrc" => $imgsrc
              ];

              array_push($arrayProducts,$elementProduct); 

       } //foreach

       array_push($arrayProducts,$idProductSelected);

       print_r(json_encode($arrayProducts));

   /* id_product name_product id_category	description	price	imgSrc	date_product */
   /* id_category	name_category	date_category	*/
   
   
   