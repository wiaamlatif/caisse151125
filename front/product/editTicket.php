<?php

session_start();

if(isset($_GET['idTicket'])){

    $idTicket = $_GET['idTicket']; 

}

if(isset($_SESSION['newIdTicket'])){

    $_SESSION['oldIdTicket'] = $_SESSION['newIdTicket'];  
    $_SESSION['newIdTicket'] = $idTicket;
    
} else {

    $_SESSION['newIdTicket']=0;
    $_SESSION['oldIdTicket']=0;
}


$oldIdTicket = $_SESSION['oldIdTicket'];
$newIdTicket = $_SESSION['newIdTicket'];     


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

    $totalTicket = 0;
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
        
        $totalTicket+= $totalItem;
                    
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

    //mysqli_refresh($conn, MYSQLI_REFRESH_TABLES);

    //Find nr & total ticket Ticket========
    $sql =" SELECT  * FROM tickets 
            WHERE id_ticket = $idTicket;";
    
    $result = mysqli_query($conn, $sql);
  
    $currentTicket = mysqli_fetch_assoc($result);

    $totalTicket = $currentTicket["total_ticket"];
    $nrTicket    = $currentTicket["nr_ticket"];

    //MAJ Total ticket
    $sql=" UPDATE  `tickets`
              SET   total_ticket = $totalTicket               
            WHERE   id_ticket   = $idTicket;";

    $result = mysqli_query($conn, $sql);         

    //>> infoTicket ==================================
    $infoTicket = [                    
                    "totalTicket" => $totalTicket,
                       "nrTicket" => $nrTicket,
                    "newIdTicket" => $newIdTicket,  
                    "oldIdTicket" => $oldIdTicket
                  ]; 

    array_push($arrayTicket,$infoTicket);  

    print_r(json_encode($arrayTicket));    


