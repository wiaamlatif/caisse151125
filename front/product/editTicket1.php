<?php
    session_start();

    if(isset($_GET['idTicket'])){

        $idTicket = $_GET['idTicket']; 

    }

    if(isset($newIdTicket)){

        $oldIdTicket = $newIdTicket ;

        $newIdTicket = $idTicket ;      

    } else {
        
        $newIdTicket = 0;
    }



//=============================================
    require_once "\htdocs\include\database.php";
   
//=============(Table:lignes_ticket)================================

    //>> feed new items of the new ticket=cart
    $sql = "SELECT * FROM lignes_ticket
    INNER JOIN tickets       ON tickets.id_ticket  = lignes_ticket.id_ticket
    INNER JOIN products      ON products.id_product = lignes_ticket.id_product
    INNER JOIN categories    ON categories.id_category = products.id_category
    WHERE tickets.id_ticket  = $idTicket;";    
                
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

    } //if(!empty($detailTiket))

$newIdTicket =0;
$oldIdTicket =0;
 
//>> infoTicket
$infoTicket = [                    
                "totalTicket" => $totalTicket,
                   "nrTicket" => $nrTicket,
                "newIdTicket" => $newIdTicket,  
                "oldIdTicket" => $oldIdTicket
              ]; 

array_push($arrayTicket,$infoTicket);  

print_r(json_encode($arrayTicket));    




