<?php
   session_start();

   if(isset($_GET['idEmployee'])){

         $idEmployee = $_GET['idEmployee'];     
   }

  $_SESSION['currentIdEmployee'] = $idEmployee ;


require_once "\htdocs\include\database.php";


//>> we select all tickets for idEmployeeSelected
$sql ="SELECT * FROM tickets
       WHERE id_employee = $idEmployee;";
             
$result = mysqli_query($conn,$sql);
                
$headTickets = mysqli_fetch_all($result, MYSQLI_ASSOC);

$arrayHeadTicket=[];
if(!empty($headTickets)){ 

   foreach ($headTickets as $headTicket){ 

         $idTicket = $headTicket['id_ticket'];
         $nrTicket = $headTicket['nr_ticket'];
      $totalTicket = $headTicket['total_ticket'];
        
      $elementHeadTicket = [  
            "idTicket" => $idTicket,
            "nrTicket" => $nrTicket,
         "totalTicket" => $totalTicket         
                           ];
      
      array_push($arrayHeadTicket,$elementHeadTicket); 

   }//foreach

   //>> Get firstName
   $sql="SELECT first_name AS firstName FROM employees 
         WHERE id_employee = $idEmployee;";
                    
   $result = mysqli_query($conn, $sql);

   $employee = mysqli_fetch_assoc($result);

   $firstName = $employee['firstName']; 
  
   $arrayInfo = [
                 "firstName" => $firstName //pour afficher le vendeur choisi             
                ];

   array_push($arrayHeadTicket,$arrayInfo); 

   print_r(json_encode($arrayHeadTicket));

}

