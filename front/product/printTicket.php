<?php
     if(isset($_GET['idTicket'])){
       $idTicket = $_GET['idTicket'];
       echo "idTicket :".$idTicket;
     } 

     if(isset($_GET['idEmployee'])){
       $idEmployee = $_GET['idEmployee'];
       echo "idEmployee :".$idEmployee;
     }      

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">  
    <link rel="stylesheet" href="/asset/css/style.css" media="print">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title></title>

</head>
<body>        
        <div class="container text-center">

            <div class="row align-items-start">

                <div class="col border border-0">

                    <div class="justify-content-center">

                        <!--------------------------------->
                        <span class="fs-1">CAFE LA PASSERELLE</span>
                        <br>               
                        <span class="fs-5">En face clinique Badr-Bourgogne</span>
                        <br>

                        <span class="fs-5">Casablanca</span>
                        <br>
                    
                        <!--------------------------------->
                        <hr>
                        <div class="justify-content-center">                            
                                <div class="d-flex justify-content-center">
                                    <span class="fs-5">Vendeur :</span>
                                    <span id="idVendeur"class="fs-5"></span>
                                    <span class="fs-5">-</span>
                                    <span id="nameVendeur" class="fs-5"></span>
                                </div>
                            <hr>
                            <br>
                            <!--------------->
                            <div class="row">
                                <div class="col-3 border border-0"></div>
                                <div class="col-6 border border-0">
                                    
                                    <table class="table table-sm table-borderless">
                                            <thead>

                                            </thead>
                                            
                                            <tbody id="showDetailTicket">

                                            </tbody>

                                            <tfoot id="showFootTicket">
                                                
                                            </tfoot>

                                    </table>                                    


                                </div>
                                <div class="col-3 border border-0"></div>
                            </div>
                            <!--------------->
                        </div>
                        
    
                    </div>
                          
                </div>

            </div>
        </div>
    <script>        
        setTimeout(() => {viewTicket(idTicket);},100);
    </script>       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>     
</body>
</html>





