
<?php
  session_start();

  //echo $_SERVER['PHP_SELF'];
 
  $urlNav = array(
                   0 => "/index.php",
                   1 => "/front/category/index.php",
                   2 => "/front/product/index.php",
                   3 => "/include/inscription.php",
                   4 => "/include/connexion.php",
                   5 => "/include/deconnexion.php",
                   6 => "/front/category/panier.php",
                   7 => "/front/category/categorie.php",                       
                );

  for ($i=0; $i < count($urlNav) ; $i++) { 
    $coloredNav[$i]="";
  }
  
  $clickedNav=array_search($_SERVER['PHP_SELF'],$urlNav);

  //if(in_array($clickedNav,[1,7])){$clickedNav=1;}

  $coloredNav[$clickedNav]= "bg-primary text-white active";

  $countItems=0;

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">

  <div class="container-fluid">

      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link <?=$coloredNav[0]?>" href=<?=$urlNav[0]?>>Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?=$coloredNav[1]?>" href=<?=$urlNav[1]?> >Category</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?=$coloredNav[2]?>" href=<?=$urlNav[2]?>>Product</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?=$coloredNav[3]?>" href="#">Inscription</a>
        </li>

        <?php if(!isset($_SESSION['user'])) { ?> 

        <li class="nav-item">
          <a class="nav-link <?=$coloredNav[4]?>" href="#">Connexion</a>
        </li>

        <?php   } else {       ?>   

        <li class="nav-item">
          <a class="nav-link <?=$coloredNav[5]?>" href="#">Deconnexion</a>
        </li>

        <?php   }       ?>  

      </ul>
      
      

        <h3><span class="badge text-bg-success text-white" id="NameVendeur"></span>
        </h3>
      

      <?php
         if(isset($_SESSION['user']) && $_SESSION['user']['role']==3){
      ?>
      <a href="/admin/index.php" class="btn"><h3><span class="badge text-bg-dark text-white">Back side</span></h3></a>
      <?php
         }
      ?>

      <div class="d-flex mb-3 justify-content-right"> 
        <a class="btn <?=$coloredNav[6]?>" href=""><i class="fa-solid fa-cart-shopping mx-2"></i>Panier(<?=$countItems?>)</a>              
        <span id ="displayTime"class="badge text-bg-primary rounded-pill fw-bold fs-5"></span>
      </div>
      

  </div>
  
</nav>