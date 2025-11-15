<?php
        session_start();

        if(isset($_SESSION['idEmployeeSelected'])){        

          $idEmployee=$_SESSION['idEmployeeSelected'];

        } 

//**************************/
//* find the $lastNrTicket */
//**************************/
require_once "\htdocs\include\database.php";

$sql = "SELECT nr_ticket FROM `tickets` 
        ORDER BY  `id_ticket`DESC
        LIMIT 1;";

$result = mysqli_query($conn,$sql);

$ticket  =  $result -> fetch_assoc();

if(isset($ticket)){
    $lastNrTicket = $ticket['nr_ticket'];
} else {
    $lastNrTicket="0";
}

$lastNrTicket= (int) $lastNrTicket + 1;

//Put eight 0 at left of the numbre of tickets
$lastNrTicket = str_pad( $lastNrTicket, 8, '0', STR_PAD_LEFT);


//***************************************************/
//* Insert a new empty records in the table tickets */
//***************************************************/

$idZ      =  0; //Z not yet established 
$nrTicket = $lastNrTicket;
$totalTicket= 0;
$validated = 0 ;
$selected = 0;

require_once "\htdocs\include\database.php";

$sql= "INSERT INTO `tickets`
                 (`id_employee`,
                  `id_z`,
                  `nr_ticket`,
                  `total_ticket`,
                  `selected`,
                  `validated`)
          VALUES ('$idEmployee',
                  '$idZ',
                  '$nrTicket',
                  '$totalTicket',
                  '$selected',
                  '$validated');";
       
                       
$result = mysqli_query($conn,$sql);

if ($result){
  $last_id = $conn->insert_id;      
}

$_SESSION['idTicketSelected'] = $last_id;  

$toSend = [
           'idEmployee' => $idEmployee,
             'idTicket' => $last_id    
           ];

print_r(json_encode($toSend));


?>