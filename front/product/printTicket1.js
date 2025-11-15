        // Argument de la fonction (idTicket) doit etre transmis par adresse      
        function loadDataTicket(idTicket){

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
        if(idVendeurEl!=null){idVendeurEl.innerText=data1[0].idVendeur};
        
        var nameVendeurEl=document.getElementById('nameVendeur');
        if(nameVendeurEl!=null){nameVendeurEl.innerText=data1[0].nameVendeur};
        
        var idTotalTicketEl=document.getElementById('idTotalTicket');
        if(idTotalTicketEl!=null){idTotalTicketEl.innerText=data1[0].totalTicket};
                
        //Data datail ticket
        var data = data.slice(0,-1);

        document.getElementById('showDetailTicket').innerHTML="";    
        if (data.length > 0) {
                    
          data.forEach(element => {

          var nameProduct=element.name_product
          var quantity = element.quantity
          var price = element.price
          var totalItem = element.totalItem   
                    
          var datailTicket=`<tr class="d-flex justify-content-center border border-0"> 

                                <div class="d-flex justify-content-center border border-0">

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


//==============>>>>>>>>>>>>>>>>>>>>>        

            }//status==200

        }//xhr.onload 

        xhr.send();

        }//loadDataTicket
    
        //laisser un peu de temps à XMLHttpRequest() pour fiare son job !
        setTimeout(() => window.print(),25);

                                                <tr class="d-flex justify-content-start">                                                                                                        
                                                    <div class="border border-2 p-5 ms-4">
                                                        <td><span class="fs-5 fw-bold">TOTAL :</span></td>
                                                        <td><span class="fs-5 fw-bold" id="idTotalTicket"></span></td>                                                        
                                                    </div>                                                    
                                                </tr>          