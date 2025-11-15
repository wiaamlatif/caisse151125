<?php
if(isset($_GET['idTicket'])){

    $idTicket = $_GET['idTicket'];     
}
//=====================================================================
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
    $totalTicket=0;
    if(!empty($detailTiket)){ 

        //>> Find detailTiket from lignes_ticket
        foreach ($detailTiket as $produit){ 
                
            $nameProduct=$produit['name_product'];
            $quantity=$produit['quantity'];
            $price=$produit['price'];
            $totalItem=$quantity * $price; 
                        
            $elementTicket = [                                                             
                              "name_product" => $nameProduct,
                                  "quantity" => $quantity,
                                     "price" => $price,
                                 "totalItem" => $totalItem
                           ]; 

        $totalTicket+=$totalItem;
        array_push($arrayTicket,$elementTicket);  

    }//foreach


    } //if(!empty($detailTiket)){ 


   //>> Get nrTicketSelected
     $sql = "SELECT * FROM  tickets
             INNER JOIN employees       ON tickets.id_employee  = employees.id_employee 
             WHERE tickets.id_ticket  = $idTicket";    
            
   $result = mysqli_query($conn, $sql);

   $theTicket = mysqli_fetch_assoc($result);

   if($theTicket!=null ){
            $nrTicket = $theTicket['nr_ticket'];        
         $nameVendeur = $theTicket['first_name'];         
           $idVendeur = $theTicket['id_employee']; 
   } 


//>> infoTicket
$infoTicket = [  "idVendeur" => $idVendeur,
               "nameVendeur" => $nameVendeur,
                  "nrTicket" => $nrTicket,
               "totalTicket" => $totalTicket                      
               ]; 

array_push($arrayTicket,$infoTicket);  

print_r(json_encode($arrayTicket));    

?>