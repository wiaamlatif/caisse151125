  function displayTicket(idTicket){

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

            }//status==200

        }//xhr.onload 

        xhr.send();

        }//loadDataTicket
    
        

        
