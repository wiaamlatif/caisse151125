<?php

session_start();


if(isset($_SESSION['idTicketSelected'])){

    $idTicket=$_SESSION['idTicketSelected'];
    
}

if(isset($_SESSION['idEmployeeSelected'])){

    $idEmployee=$_SESSION['idEmployeeSelected'];
    
}

require_once "\htdocs\include\database.php";

//>> Get produits       
$sql = "DELETE FROM `lignes_ticket` 
        WHERE `id_ticket`=$idTicket;";

$result = mysqli_query($conn, $sql);

$sql=" UPDATE  `tickets`
          SET   total_ticket = 0
        WHERE   id_ticket   = $idTicket;";

$result = mysqli_query($conn, $sql);


$toSend = [          
           "idEmployee" => $idEmployee,
             "idTicket" => $idTicket
          ];

print_r(json_encode($toSend));

?>                                        
