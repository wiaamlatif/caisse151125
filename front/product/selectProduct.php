<?php
    session_start();

    if(isset($_GET['idProduct'])){
        $idProductSelected = $_GET['idProduct'];
        $_SESSION['idProductSelected']=$idProductSelected;
    }

    if(isset($_SESSION['idCategory'])){
      $idCategory = $_SESSION['idCategory'];
    }

  
    $toSend = [
                "idCategory" => $idCategory               
               ];

print_r(json_encode($toSend));