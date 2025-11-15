function startTime() {
  const today = new Date();
  let h = today.getHours()-1;
  let m = today.getMinutes();
  let s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('displayTime').innerHTML =  h + ":" + m + ":" + s;
  setTimeout(startTime, 1000);
}

function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}

function ajouterTicket(){

  var xhr = new XMLHttpRequest();

  xhr.open('GET','iniTicket.php',true)

  xhr.onload = function() {

    if(xhr.status==200){

      var  data = JSON.parse(this.response);

      //console.log(data);
      
      displayHeadsTickets(data.idEmployee);
      editTicket(data.idTicket);
      
    }
  }

  xhr.send()
  
}

function deleteTicket(idTicket){
//  alert(idTicket);

  var xhr = new XMLHttpRequest();

  xhr.open('GET','deleteTicket.php?idTicket='+idTicket,true);

  xhr.onload = function() {

    if(xhr.status==200){

    var  data =  JSON.parse(this.response);

  //  console.log(data)

    displayHeadsTickets(data)

    }//status==200    

  }

  xhr.send()
 
}//deleteTicket

function pickProduct(idProduct){
 //alert(idProduct);

  // Add one line on the table lignes_ticket with quantity=1 (pickProduct.php)
 
  var xhr = new XMLHttpRequest();

  xhr.open('GET','pickProduct.php?idProduct='+idProduct,true);

  xhr.onload = function() {

    if(xhr.status==200){

    var  data =  JSON.parse(this.response);

    //data bring the id Ticket where the product will be added
   // console.log(data);
     
    displayHeadsTickets(data.idEmployee);
    displayDetailTicket(data.idTicket);
    // document.getElementById('totalTicket'+data.idTicket).innerHTML="ABC"

    }//status==200

  }//function

  xhr.send();
  
  
}//choisirProduit


function getQuantity(idLigneTicket,plusMinus){

 // console.log(idLigneTicket);
 // console.log(typeof(plusMinus));

  //Get quantity from lignes_ticket   
  //=====================================
  var xhr = new XMLHttpRequest();
    
  xhr.open('GET','getQuantity.php?idLigneTicket='+idLigneTicket+'&plusMinus='+plusMinus,true);

  xhr.onload = function() {

   if(xhr.status==200){

    var  data =  JSON.parse(this.response);
    
   // console.log(data);

    displayHeadsTickets(data.idEmployee);
    editTicket(data.idTicket);
        
   }//status==200 
    

  }//xhr.onload 

  xhr.send();
   
  }//getQuantity
  

function deleteItemTicket(idLigneTicket){

  var xhr = new XMLHttpRequest();

  xhr.open('GET','deleteItemTicket.php?idLigneTicket='+idLigneTicket,true);

  xhr.onload = function() {

    if(xhr.status==200){

      var  data =  JSON.parse(this.response);

      //idTicket
     // console.log(data);

      displayHeadsTickets(data.idEmployee);    
      editTicket(data.idTicket);

    }//status==200
  
  }//xhr.onload 

  xhr.send();

}//deleteItemTicket


function deleteItemsTicket(){

  var xhr = new XMLHttpRequest();
  
  xhr.open('GET','deleteItemsTicket.php',true);

  xhr.onload = function() {

    if(xhr.status==200){

      var  data =  JSON.parse(this.response);
      
      console.log(data);

      displayHeadsTickets(data.idEmployee);
      editTicket(data.idTicket)

    }//status==200
  
  }//xhr.onload 

  xhr.send();

}

function editTicket(idTicket){

  var xhr = new XMLHttpRequest();

  xhr.open('GET','editTicket.php?idTicket='+idTicket,true);

  xhr.onload = function() {

    if(xhr.status==200){

      var  data =  JSON.parse(this.response);

      console.log(data);

        // The object data1 is the last element of the array data
        var data1 = data.slice(-1); 

        console.log(data1[0]);
        
        //Info Head ticket
        var displayNrTicketEl = document.getElementById('displayNrTicket');
        if(displayNrTicketEl!=null){displayNrTicketEl.innerText=data1[0].nrTicket};
         
        var totalHeadTicketEl=document.getElementById('totalHeadTicket');
        if(totalHeadTicketEl!=null){totalHeadTicketEl.innerText=data1[0].totalTicket};

        var totalFootTicketEl=document.getElementById('totalFootTicket');
        if(totalFootTicketEl!=null){totalFootTicketEl.innerText=data1[0].totalTicket};

        var oldIdTicket =  data1[0].oldIdTicket;
        var oldIdTicketEl = document.getElementById('trHeadTicket'+oldIdTicket);
        if(oldIdTicketEl!=null){oldIdTicketEl.classList.remove('table-info');}

        var newIdTicket =  data1[0].newIdTicket;
        var newIdTicketEl = document.getElementById('trHeadTicket'+newIdTicket);
        if(newIdTicketEl!=null){newIdTicketEl.classList.add('table-info');} 
        
        //============( Detail ticket )================================
        var data = data.slice(0,-1);
        
        document.getElementById('showDetailTicket').innerHTML="";    

        if (data.length > 0) {
                    
          data.forEach(element => {
                  
          //  console.log(element.id_ticket);  

          var idLigneTicket=element.id_ligne_ticket
          var idProduct=element.id_product
          var idCategory=element.id_category
          var imgSrc = element.imgSrc
          var nameProduct=element.name_product
          var quantity = element.quantity
          var price = element.price
          var totalItem = element.totalItem   
                    
          var datailTicket=`<tr id="trDetailTicket`+idLigneTicket+`" class="border border-dark fw-bold">
                              <div class="container">
                                <td>
                                <img class="img img-fluid" src="/uploads/products/`+imgSrc+`" width="70px" alt="`+`">`+
                                `</td>

                                <td><span class="display: block">`+nameProduct+`</span></td>

                                <td><!---Quantity------> 
                    
                                <div class="d-flex border-top border-bottom border-dark">
                                    <button id="supItemCart`+idLigneTicket+`" class="supItemCart btn btn-danger btn-sm"
                                    onclick="deleteItemTicket(`+idLigneTicket+`)">
                                    <i class="fa-solid fa-trash-can"></i>
                                    </button>               
                                    <button id="decrementQuantity`+idLigneTicket+`" class="decrementQuantity btn btn-primary"
                                    onclick="getQuantity(`+idLigneTicket+`,`+0+`)">
                                    -
                                    </button>
                                    <span id="quantity`+idLigneTicket+`" class="quantity">`+quantity+`</span>
                                    <button id="incrementQuantity`+idLigneTicket+`" class="incrementQuantity btn btn-primary"
                                    onclick="getQuantity(`+idLigneTicket+`,`+1+`)">
                                    +
                                    </button> 
                                  </div>
                                </td>

                                <td>`+price+`</td>

                                <td>`+totalItem+`</td>
                              </div>
                            </tr>`; 
                                
            document.getElementById('showDetailTicket').innerHTML+=datailTicket; 
          
          });//forEach          

        } //if (data.length > 0) {

         //==============>>>>>>>>>>>>>>>>>>>>>        

    }//status==200
  
  }//xhr.onload 

  xhr.send();

}//editTicket

function editTicket1(idTicket){
        
    var xhr = new XMLHttpRequest();
  
  xhr.open('GET','editTicket.php?idTicket='+idTicket,true);

  xhr.onload = function() {

      if(xhr.status==200){

        var  data =  JSON.parse(this.response);

        console.log(data);

      /*
        // The object data1 is the last element of the array data
        var data1 = data.slice(-1); 

        console.log(data1[0]);
        
        var displayNrTicketEl = document.getElementById('displayNrTicket');
        if(displayNrTicketEl!=null){displayNrTicketEl.innerText=data1[0].nrTicket};
         
        var totalHeadTicketEl=document.getElementById('totalHeadTicket');
        if(totalHeadTicketEl!=null){totalHeadTicketEl.innerText=data1[0].totalTicket};

        var totalFootTicketEl=document.getElementById('totalFootTicket');
        if(totalFootTicketEl!=null){totalFootTicketEl.innerText=data1[0].totalTicket};

        var oldIdTicket =  data1[0].oldIdTicket;
        var oldIdTicketEl = document.getElementById('trHeadTicket'+oldIdTicket);
        if(oldIdTicketEl!=null){oldIdTicketEl.classList.remove('table-info');}

        var newIdTicket =  data1[0].newIdTicket;
        var newIdTicketEl = document.getElementById('trHeadTicket'+newIdTicket);
        if(newIdTicketEl!=null){newIdTicketEl.classList.add('table-info');}


        var data = data.slice(0,-1);
//==============>>>>>>>>>>>>>>>>>>>>>

        document.getElementById('showDetailTicket').innerHTML="";    

        if (data.length > 0) {
                    
          data.forEach(element => {
                  
          //  console.log(element.id_ticket);  

          var idLigneTicket=element.id_ligne_ticket
          var idProduct=element.id_product
          var idCategory=element.id_category
          var imgSrc = element.imgSrc
          var nameProduct=element.name_product
          var quantity = element.quantity
          var price = element.price
          var totalItem = element.totalItem   
                    
          var datailTicket=`<tr id="trDetailTicket`+idLigneTicket+`" class="border border-dark fw-bold">
                              <td id="tdIdTicket">`+idLigneTicket+`</td>
                              <td>`+idProduct+`</td>

                              <td>`+idCategory+`</td>

                              <td>`+
                              `<img class="img img-fluid" src="/uploads/products/`+imgSrc+`" width="70px" alt="`+`">`+
                              `</td>

                              <td>`+nameProduct+`</td>

                              <td><!---Quantity------> 
                   
                              <div class="d-flex border-top border-bottom border-dark">
                                  <button id="supItemCart`+idLigneTicket+`" class="supItemCart btn btn-danger btn-sm"
                                  onclick="deleteItemTicket(`+idLigneTicket+`)">
                                  <i class="fa-solid fa-trash-can"></i>
                                  </button>               
                                  <button id="decrementQuantity`+idLigneTicket+`" class="decrementQuantity btn btn-primary"
                                  onclick="getQuantity(`+idLigneTicket+`,`+0+`)">
                                  -
                                  </button>
                                  <span id="quantity`+idLigneTicket+`" class="quantity">`+quantity+`</span>
                                  <button id="incrementQuantity`+idLigneTicket+`" class="incrementQuantity btn btn-primary"
                                  onclick="getQuantity(`+idLigneTicket+`,`+1+`)">
                                  +
                                  </button> 
                                </div>
                              </td>

                              <td>`+price+`</td>

                              <td>`+totalItem+`</td>
                            </tr>`; 
                                
            document.getElementById('showDetailTicket').innerHTML+=datailTicket; 
          
          });//forEach          

        } //if (data.length > 0) {

//==============>>>>>>>>>>>>>>>>>>>>>
       */

      }//status==200

  }// onload function

  xhr.send()
   
}//editTicket

function printTicket(idTicket,idEmployee){

  alert(idTicket+"---"+idEmployee);
  
 // window.location.href = 'printTicket.php?idTicket='+idTicket+'&idEmployee='+idEmployee;

  //laisser un peu de temps à XMLHttpRequest() pour fiare son job !
  // setTimeout(() => {window.print(); return false;},30);

  ajouterTicket();
}

function displayHeadsTickets(idEmployee){

  var xhr = new XMLHttpRequest();

  xhr.open('GET','displayHeadsTickets.php?idEmployee='+idEmployee,true);

  xhr.onload = function() {

    if(xhr.status==200){

      var  data =  JSON.parse(this.response);

      console.log(data);

      //===========(Display Name Vendeur)========================

      //Select the last element of the array data -> data.slice(-1)
      var data1 = data.slice(-1);        
      var firstName = data1[0].firstName ;
      document.getElementById('btnVendeur').innerText=firstName;


      //===========(show Heads Tickets table)========================

      var data = data.slice(0,-1);

      console.log(data);
      
      document.getElementById('showHeadsTickets').innerHTML="";
      
      var somTickets = 0;

      data.forEach(element => {  

        var       idTicket = element.idTicket ;
        var       nrTicket = element.nrTicket ;
        var    totalTicket = element.totalTicket;        

        var headTickets = `<tr id="trHeadTicket`+idTicket+`" class="border border-dark fw-bold `+idTicket+`">
                              <td>`+idTicket+`</td>
                              <td>`+nrTicket+`</td>
                              <td id="totalTicket`+idTicket+`">`+totalTicket+`</td>
                              <td>
                                <div class="d-flex">

                                  <button class="btn btn-danger btn-sm"
                                  onclick="deleteTicket(`+idTicket+`)">
                                  <i class="fa-solid fa-trash-can"></i>
                                  </button>
                                                          
                                  <button class="btn btn-success btn-sm"
                                  onclick="editTicket(`+idTicket+`);">
                                  <i class="fa-solid fa-pencil"></i>
                                  </button>

                                </div>
                              </td>
                            </tr>`;
        
          document.getElementById('showHeadsTickets').innerHTML+=headTickets; 

          somTickets += parseInt(totalTicket); 
                    
      });//forEach 

      document.getElementById('totalTickets').innerText=somTickets.toFixed(2);      
     

    }//status==200
  
  }//xhr.onload 

  xhr.send();

}//displayHeadsTickets


function displayProductsCategory(idCategory){
 //alert(idCategory)

var xhr = new XMLHttpRequest();

  xhr.open('GET','productsData.php?idCategory='+idCategory,true);

  xhr.onload = function() {

      if(xhr.status==200){

        var  data =  JSON.parse(this.response);

//*********************************/        
//*********************************/
//*********************************/       
  //   console.log(data);//*******/
//*********************************/
//*********************************/
//*********************************/  

        var idProductSelected = data.pop(); 
     
        if (data.length > 0) {

          document.getElementById('displayProducts').innerHTML="";    

          data.forEach(element => {

          var   idProduct = element.idProduct
          var  idCategory = element.idCategory 
          var  nameCategory = element.nameCategory 
          var      imgsrc = element.imgsrc
          var nameProduct = element.nameProduct
          var       price = element.price
                    
          var datailProduct=`<tr id="trDetailProduct`+idProduct+`" class="border border-dark fw-bold">            
                                <td class="idProduct">`+idProduct+`</td>
                                <td class="idCategory">`+idCategory+`</td>

                                <td id="imgProduct">            
                                <img class="img img-fluid imgProduct" src="/uploads/products/`+imgsrc+`" width="70px" onclick="selectProduct(`+idProduct+`)">
                                </td>

                                <td>`+nameProduct+`</td>
                                <td class="price">`+price+`</td>            
                             </tr>            
                            `

          document.getElementById('displayProducts').innerHTML+=datailProduct; 

          document.getElementById('btnCategory').innerText=nameCategory;

          });

         var trDetailProductEl = document.getElementById("trDetailProduct"+idProductSelected);

         if(trDetailProductEl!=null){
          trDetailProductEl.classList.add('table-info');
         }
          
        }//if (data.length > 0)

      }//status==200

  }//onload

  xhr.send();

}

//This function for opening a session with idProductSelected 
function selectProduct(idProduct){

  var xhr = new XMLHttpRequest();
  
  xhr.open('GET','selectProduct.php?idProduct='+idProduct,true);

  xhr.onload = function() {

    if(xhr.status==200){

      var  data =  JSON.parse(this.response);

      //*********************************/        
      //*********************************/
      //*********************************/       
       //   console.log(data.idCategory);//*******/
      //*********************************/
      //*********************************/
      //*********************************/  


      pickProduct(idProduct);
      displayProductsCategory(data.idCategory);
     

    }//status==200
  
  }//xhr.onload 

  xhr.send();
   
}

function viewTicket(idTicket){

        var xhr = new XMLHttpRequest();

        xhr.open('GET','loadDataTicket.php?idTicket='+idTicket,true);

            xhr.onload = function() {

            if(xhr.status==200){

                var  data =  JSON.parse(this.response);

                console.log(data);

        //Data entete ticket
        var data1 = data.slice(-1); 

        console.log(data1[0]);

        var idVendeurEl=document.getElementById('idVendeur');
        var idVendeur = data1[0].idVendeur;
        if(idVendeurEl!=null){idVendeurEl.innerText=idVendeur};
        
        var nameVendeurEl=document.getElementById('nameVendeur');
        if(nameVendeurEl!=null){nameVendeurEl.innerText=data1[0].nameVendeur};
                
        var totalTicket=data1[0].totalTicket;
        
        //Data datail ticket
        var data = data.slice(0,-1);

        document.getElementById('showDetailTicket').innerHTML="";
        document.getElementById('showFootTicket').innerHTML=`<hr>`;

        if (data.length > 0) {
                    
          data.forEach(element => {

          var nameProduct=element.name_product
          var quantity = element.quantity
          var price = element.price
          var totalItem = element.totalItem   
                    
          var datailTicket=`<tr class="d-flex justify-content-start border border-0"> 

                                <div class="d-flex justify-content-start border border-0">

                                    <td class="border border-0"><span class="fs-6">`+quantity+`</span></td>

                                    <td class="border border-0"><span class="fs-6">`+"X"+`</span></td>

                                    <td class="border border-0"><span class="fs-6">`+price+`</span></td>

                                    <td class="border border-0"><span class="fs-6">`+nameProduct+`</span></td>
                                    
                                    <td class="border border-0"><span class="fs-6">`+totalItem+`</span></td>

                                </div>

                            </tr>`; 
                                
            document.getElementById('showDetailTicket').innerHTML+=datailTicket; 
          
          });//forEach          

        } //if (data.length > 0) {
        
        var footTicket=`<tr class="d-flex justify-content-start border-0">                          
                            <td border-0><span class="fs-5 fw-bold ms-5">TOTAL :</span></td>
                            <td border-0><span class="fs-5 fw-bold">`+totalTicket+`</span></td>                          
                        </tr>`;
         
        document.getElementById('showFootTicket').innerHTML+=footTicket;


        displayHeadsTickets(idEmployee);

            }//status==200

        }//xhr.onload 

        xhr.send();

        }//viewTicket

// Functions :
// function startTime
// function ajouterTicket()
// function deleteTicket()
// function deleteItemTicket()
// function deleteItemsTicket()
// function pickProduct()
// function getQuantity()
// function displayHeadsTickets()
// function displayProductsCategory
// function editTicket(idTicket){

//===================================

//C:\htdocs\front\product\deleteItemsTicket.php---------------------OK
//C:\htdocs\front\product\deleteItemTicket.php----------------------OK
//C:\htdocs\front\product\deleteTicket.php--------------------------OK
//C:\htdocs\front\product\dataHeadsTickets.php----------------------OK
//C:\htdocs\front\product\dataHeadTicket.php-----------------------OK
//C:\htdocs\front\product\dropDownCategory.php----->productsTable---OK
//C:\htdocs\front\product\dropDownVendeur.php------>numTable--------OK
//C:\htdocs\front\product\getQuantity.php---------------------------OK
//C:\htdocs\front\product\index.php---------------------------------OK
//C:\htdocs\front\product\iniTicket.php-----------------------------OK
//C:\htdocs\front\product\numTable.php-----------index--------------OK
//C:\htdocs\front\product\pickProduct.php---------------------------OK
//C:\htdocs\front\product\productsData.php--------------------------OK
//C:\htdocs\front\product\productsTable.php------index--------------OK
//C:\htdocs\front\product\ticketData.php----------------------------OK
//C:\htdocs\front\product\ticketTable.php--------index--------------OK
//===================================

/*

window.location.href = "printTicket.php";


window.print();


function returnData(){

  var xhr = new XMLHttpRequest();

  xhr.open('GET','returnData.php',true);

  xhr.onload = function() {

    if(xhr.status==200){

      var  data =  JSON.parse(this.response);

      //console.log(data);


     

    }//status==200
  
  }//xhr.onload 

  xhr.send();

}//returnData


onclick="window.location.href='printTicket.php?idTicket='+<?=$idTicket?>"

*/




