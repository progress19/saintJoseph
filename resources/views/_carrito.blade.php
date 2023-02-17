
<div class="cd-cart cd-cart--empty js-cd-cart">

   <a href="#0" class="cd-cart__trigger text-replace">

      <ul class="cd-cart__count"> <!-- cart items count -->
         <li>0</li>
         <li>0</li>
      </ul> <!-- .cd-cart__count -->

   </a>

   <div class="cd-cart__content">
      <div class="cd-cart__layout">
         <header class="cd-cart__header">

            <h2><i class="fa fa-shopping-cart" style="font-size: 18px;"></i> Saint Joseph - Carrito de compras</h2>
            <span style="display: none;" class="cd-cart__undo">Item removed. <a href="#0">Undo</a></span>
         </header>

         <div class="cd-cart__body">
            <ul>
               
            </ul>
         </div>

         <footer class="cd-cart__footer">
            <a href="{{ url('checkout') }}" class="cd-cart__checkout" onclick="loadingCart()">
               <em>

                  <div class="container">

                     <div class="row">
                     
                        <div class="col pagar_carro"><i class="fa fa-arrow-right"></i><br>CONTINUAR</div>

                        <div class="col totales_carro" style="text-align:right; padding: 0">
                           <p style="font-size: 12px;">Sub-total:</p>
                           <p style="font-size: 12px;">Descuento:</p>
                           <p style="font-size: 14px;"><b>TOTAL:</b></p>
                        </div>

                        <div class="col div-corona" style="text-align:right; padding: 0">
                           <div id="ttsd" class="inline"> $<span id="total_sin_descuento">0</span> </div> 
                           <div id="total_descuento">-</div>   
                           <div id="tcd" >$<span id="total_con_descuento"></span></div>
                        </div>

                     </div>

                  </div>

                  <svg class="icon icon--sm" viewBox="0 0 24 24"><g fill="none" stroke="currentColor"><line stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x1="3" y1="12" x2="21" y2="12"/><polyline stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="15,6 21,12 15,18"/></g>
                  </svg>
               </em>
            </a>
         </footer>
      </div>
   </div> <!-- .cd-cart__content -->
</div> <!-- cd-cart -->

<script>

   function cambiarCantidad(id,cant) {

      var baseUrl = document.getElementById('baseUrl').value;

            $.ajax({
               type: "POST",
               url: baseUrl+'/cambiarCantidadAjax',
               data: 'id='+id+'&cant='+cant,
               //dataType : 'html',
               success: function(data) {

               $('#total_actividad'+id).html('$'+data);
               getTotalConDescuento(); //actualizo totales
         }                 
      })

   }

   function borrarActividad(id) {

      var baseUrl = document.getElementById('baseUrl').value;

      $.ajax({
         type: "POST",
         url: baseUrl+'/borrarActividadAjax',
         data: 'id='+id,
         success: function(data) {
            $('.bot_add_'+id).removeClass('disabled');    
            $('.bot_add_'+id).html('<i class="fa fa-shopping-cart"></i> <span>Agregar al carrito</span>'); 

         getTotalConDescuento(); //actualizo totales

         }
      })
   }

   function getTotalConDescuento() {

      //$('#total_sin_descuento').html('ssss');
     
      $.ajax({

         type: "POST", 
         url: baseUrl+'/getTotalConDescuento',

         success: function(value){

            var data = value.split(',');

            var total_sin_descuento = new Intl.NumberFormat('es-AR', {}).format( parseFloat( data[0] ).toFixed(0) );
            var total_descuento = new Intl.NumberFormat('es-AR', {}).format( parseFloat( data[1] ).toFixed(0) );
            var total_con_descuento = new Intl.NumberFormat('es-AR', {}).format( parseFloat( data[2] ).toFixed(0) );

            //$('#total_sin_descuento').html( parseFloat( data[0] ).toFixed(0) );
            //$('#total_descuento').html( parseFloat( data[1]).toFixed(0) );
            //$('#total_con_descuento').html( parseFloat( data[2]).toFixed(0) );
            
            $('#total_sin_descuento').html( total_sin_descuento );
            $('#total_descuento').html( '-' );
            $('#total_con_descuento').html( total_con_descuento );

         }

      });
   }

   
   function checkDiscount() {
      
      $.ajax({

         type: "POST", 
         url: baseUrl+'/checkDiscount',

         success: function(value){

            if (value == '1') {

               /*si encuentra*/

               //$('#codeDisc, #btnSendCode').addClass('displayNone'); 
               $('.text-codigo').addClass('displayNone');
               $('#msgCode').removeClass('displayNone');
               $('#msgCode').html('<p><i class="fa fa-check" aria-hidden="true"></i> DESCUENTO APLICADO POR CÓDIGO!!!</p>');

            } else {

                /*no encuentra*/
/*
                $('#codeDisc, #btnSendCode').addClass('displayNone'); 
                $('#msgCode').removeClass('displayNone');
                $('#msgCode').html('<p>CÓDIGO NO ENCONTRADO :(</p>');
/*
                setTimeout(
                  function() {
                     $('#msgCode').addClass('displayNone');
                     $('#codeDisc, #btnSendCode').removeClass('displayNone'); 

                  }, 1880);
                */

             }
         
         }

      });  
   }
   
   window.addEventListener('load', function() {
        checkDiscount();
   })
   

</script>   