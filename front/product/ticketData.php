<?php 
  session_start();

        if(isset($_GET['idTicket'])){

         $idTicket = $_GET['idTicket'];

        } 

        require_once "\htdocs\include\database.php";
    
        //>> feed new items of the new ticket=cart
        $sql = "SELECT * FROM lignes_ticket
        INNER JOIN tickets       ON tickets.id_ticket  = lignes_ticket.id_ticket
        INNER JOIN products      ON products.id_product = lignes_ticket.id_product
        INNER JOIN categories    ON categories.id_category = products.id_category
        WHERE tickets.id_ticket  = $idTicket";    
                 
         $result = mysqli_query($conn, $sql);
                        
         $detailTiket = mysqli_fetch_all($result, MYSQLI_ASSOC);        
                 
         $arrayTicket=[];
         if(!empty($detailTiket)){ 

//>> Find detailTiket from lignes_ticket
            foreach ($detailTiket as $produit){ 
         
            $idLigneTicket=$produit['id_ligne_ticket'];
            $idProduct=$produit['id_product'];
            $idCategory=$produit['id_category'];  
            $imgSrc=$produit['imgSrc'];                      
            $nameProduct=$produit['name_product'];
            $quantity=$produit['quantity'];
            $price=$produit['price'];
            $totalItem=$quantity * $price; 
                        
            $elementTicket = [                                 
                              "id_ligne_ticket" => $idLigneTicket,
                                   "id_product" => $idProduct,
                                  "id_category" => $idCategory,
                                       "imgSrc" => $imgSrc,
                                 "name_product" => $nameProduct,
                                     "quantity" => $quantity,
                                        "price" => $price,
                                   "totalItem"  => $totalItem
                              ]; 


        array_push($arrayTicket,$elementTicket);  

        }//foreach

//>> Find totalTicket    
        //join table products to the table lignes_ticket to have the price of product 
        $sql="SELECT SUM(`price` * `quantity`) as sumTicket FROM `lignes_ticket`
              INNER JOIN products      ON products.id_product = lignes_ticket.id_product
                   WHERE `id_ticket`= $idTicket;";

       $result = mysqli_query($conn, $sql); 
       $totalCurrentTicket = mysqli_fetch_assoc($result);

       $totalTicket = $totalCurrentTicket['sumTicket'];
      
//>> Update totalticket in the table tickets
       $sql=" UPDATE  `tickets`
                 SET   total_ticket = $totalTicket 
               WHERE      id_ticket = $idTicket;";

       $result = mysqli_query($conn, $sql); 

//=====
//========
//==========

       } //if(!empty($detailTiket)){ 

       $idLineSelected = 0;
       if(isset($_SESSION['idLineSelected'])){

          $idLineSelected=$_SESSION['idLineSelected'];
       }
       array_push($arrayTicket,$idLineSelected); 

       $maxIdLineSelected = 0;
       if(isset($_SESSION['maxIdLineSelected'])){
 
       $maxIdLineSelected=$_SESSION['maxIdLineSelected'];
       }
      array_push($arrayTicket,$maxIdLineSelected); 

      print_r(json_encode($arrayTicket));    


//$arrayTicket :[ {
//                 id_ligne_ticket,
//                      id_product,
//                     id_category,
//                          imgSrc,
//                    name_product,
//                        quantity,
//                           price,
//                      totalItem
//                               },
//                     totalTicket,
//               ]  //9 varaibles to send

        ?>          