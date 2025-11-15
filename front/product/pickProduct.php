<?php
    session_start();

    if(isset($_GET['idProduct'])){

        $idProduct = $_GET['idProduct'];      
        $_SESSION['idProduct']=$idProduct;
    }

    if(isset($_SESSION['idTicketSelected'])){

        $idTicketSelected = $_SESSION['idTicketSelected'];

    }

    if(isset($_SESSION['idEmployee'])){
        $idEmployee=$_SESSION['idEmployee'];
    }

    require_once "\htdocs\include\database.php";

    $sql="SELECT COUNT(`id_product`) as countProduct FROM lignes_ticket     
           WHERE `id_ticket` = $idTicketSelected
             AND `id_product`= $idProduct;";
             
    $result = mysqli_query($conn, $sql);

    $countIdProduct = mysqli_fetch_assoc($result);

    $countProduct = $countIdProduct['countProduct'];
        
    if($countProduct>0){
       //   echo 'The product alrady exist !';
 
       $sql="SELECT id_ligne_ticket AS idLineSelected FROM lignes_ticket     
              WHERE `id_ticket` = $idTicketSelected
                AND `id_product`= $idProduct;";
         
        $result = mysqli_query($conn, $sql);

        $LineTicket = mysqli_fetch_assoc($result);

        //id_ligne_ticket for the picked product 
        $idLineSelected = $LineTicket['idLineSelected'];
      
        $_SESSION['idLineSelected']=$idLineSelected;
        $_SESSION['maxIdLineSelected']=0;

    } else {
        
        $sql= "INSERT INTO  `lignes_ticket`
                           (`id_ticket`,
                            `id_product`,
                            `quantity`)
                    VALUES('$idTicketSelected',
                           '$idProduct',
                           '1');";

        $result = mysqli_query($conn,$sql);

        $lastIdInserted = mysqli_insert_id($conn);

           $_SESSION['idLineSelected']=$lastIdInserted;
        $_SESSION['maxIdLineSelected']=$lastIdInserted;
      
//>> totalTicket

        $sql="SELECT SUM(products.price*lignes_ticket.quantity) as sumTicket FROM lignes_ticket
              INNER JOIN products ON lignes_ticket.id_product = products.id_product
                   WHERE lignes_ticket.id_ticket = $idTicketSelected;";
                 
        $result = mysqli_query($conn, $sql);

        $product = mysqli_fetch_assoc($result);
  
        $totalTicket=$product['sumTicket'];//$product['sumTicket'];
        
        $sql=" UPDATE  `tickets`
                  SET   total_ticket = $totalTicket 
                WHERE      id_ticket = $idTicketSelected;";

        $result = mysqli_query($conn, $sql); 

    }

    $data = ['idEmployee' => $idEmployee,
               'idTicket' => $idTicketSelected];

    print_r(json_encode($data));        
        //==================================    

/*
`lignes_ticket`
id_ligne_ticket
id_ticket
id_product
price
quantity
total_ligne	
*/
?>