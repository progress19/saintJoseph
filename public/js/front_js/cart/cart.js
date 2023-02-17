

function loadingCart() {
	
	$('.cd-cart__checkout').hide();
	$('.cd-cart__trigger').hide();
	$('.cd-cart__footer').html('<div class="conteLoadingCart"><div class="cssload-loading"><i></i><i></i><i></i><i></i></div></div>');

}

function mostrarBotonCancelar() {

 	$('#cambioPago').html('<button onclick="displayOpcionesPago()" id="botonCancelar" type="button" class="btn btn-success" style="width: 100%" > CANCELAR</button>');

}

function displayOpcionesPago() {

	$('#loadingOpcionesPago').hide();
	$('#conteOpcionesPago').fadeIn();
    
}

function getChargeUpdate() {

	var checkoutId = $('#checkoutId').val();

	var baseUrl = document.getElementById('baseUrl').value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    })

    $.ajax({
        type: 'POST',
        url: baseUrl+'/getChargeUpdate',
        contentType: 'application/x-www-form-urlencoded',
        processData: true,
        //dataType: "json",
        data: 'checkoutId='+checkoutId,
        success: function(response){

        	console.log(response.status);

        	// colForm . colResumen . cambioPago

        	if ( response.status === 'CREATED') { 	}

        	if ( response.status === 'PENDING') {

				$('#botonCancelar').fadeOut();
        		$('#colForm').fadeOut();
        		$('#colResumen').removeClass('col-md-6');
        		$('#colResumen').addClass('col-md-12');
        		
        	}

        	if ( response.status === 'CONFIRMED') {

        		$('#loadingOpcionesPago').fadeOut();
        		$('#conteOpcionesPago').html('<div class="conteGracias" ><img src="'+baseUrl+'/images/check-icon.png" ><h3>GRACIAS!</h3><h4>Hemos registrado el pago exitosamente.</h4><h4>Te enviamos un email con los detalles de la reserva.</h4></div>');
        		$('#conteOpcionesPago').fadeIn();

        	}

        	 //console.log(data.domain);

/*
        	if ( response === 'WAITING') {console.log('aguarde...');}
        	if ( response === 'CREATED') {console.log('creado...');}
        	if ( response === 'PENDING') {console.log('pendiee...');}
        	if ( response === 'CONFIRMED') {console.log('siiiiii...');}
*/
        	
            
        }
    });

}

function clicOpcionPago(opcionPago) { // 1 - MP / 2 - Coinbase
	
	$('#opcionPago').val(opcionPago);
	//setTimeout( $('#frmReserva').submit(), 1000 );
	$('#frmReserva').submit();
	
}

/* ························ TIENDA ..................................   */
//var opcionPago = '1';

$("#frmReserva").validate({

    event: "blur",
    rules: {
        'fecha': "required",
        'nombre': "required",
        'email': "required email",
        'telefono': "required",
    },
    messages: {
        'fecha': "Por favor ingresá fecha.",
        'nombre': "Por favor ingresá tu nombre.",
        'email': "Ingrese un e-mail válido.",
        'telefono': "Por favor ingresá tu teléfono.",
        /*'emailRep': "Error : los emails no coinciden.",*/
    },
    debug: true,
    errorElement: "label",
    submitHandler: function(form){

    	var baseUrl = document.getElementById('baseUrl').value;

    	$('#conteOpcionesPago').hide();
    	$('#loadingOpcionesPago').fadeIn();
 	  	$('#loadingOpcionesPago').html('<div class="cssload-loading"><i></i><i></i><i></i><i></i></div><br><p style="text-align: center">Procesando el pago...</p><div id="cambioPago"></div>');
 	 
        //$("#frmReservaPro").hide();
        //$("#mensaje").show();
        //$('html,body').animate({scrollTop: $("#mensaje").offset().top}, 1000);
        //$("#mensaje").html("<span class='col-md-12' style='text-align:center; top:10px;' ><img src='"+baseUrl+"/images/logo_chico.png' style='padding: 30px;'><br><img src='"+baseUrl+"/images/loading.gif'></div></span>");
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        })

		var opcionPago = document.getElementById('opcionPago').value;        

    	$.ajax({
            type: "POST",
            url: baseUrl+"/enviarReserva",
            contentType: "application/x-www-form-urlencoded",
            processData: true,
            dataType: "json",
            data: $("#frmReserva").serialize(),
            success: function() {

            	 if ( opcionPago == 1 ) { // MercadoPago
            	 	$(".mercadopago-button").trigger("click")   
            	 }

            	 if ( opcionPago == 2 ) { // Coinbase
            	 	$('.coinbase-button')[0].click();
            	 }

            	 setTimeout('mostrarBotonCancelar()', 20000);
            	 setInterval('getChargeUpdate()', 5000);
            }
        });
    }
});  

  // Add to Cart Interaction - by CodyHouse.co
  
  var cart = document.getElementsByClassName('js-cd-cart');
  
  if(cart.length > 0) {
  	//alert(cart.length);
  	var cartAddBtns = document.getElementsByClassName('js-cd-add-to-cart'),
  		cartBody = cart[0].getElementsByClassName('cd-cart__body')[0],
  		cartList = cartBody.getElementsByTagName('ul')[0],
  		cartListItems = cartList.getElementsByClassName('cd-cart__product'),
  		cartTotal = cart[0].getElementsByClassName('cd-cart__checkout')[0].getElementsByTagName('span')[0],
  		cartCount = cart[0].getElementsByClassName('cd-cart__count')[0],
  		cartCountItems = cartCount.getElementsByTagName('li'),
  		cartUndo = cart[0].getElementsByClassName('cd-cart__undo')[0],
  		productId = 0, //this is a placeholder -> use your real product ids instead
  		cartTimeoutId = false,
  		animatingQuantity = false;

  		//console.log(cartCount);
  		
        //alert('hola');

    var cookies = ("cookie" in document && (document.cookie.length > 0 ||
        (document.cookie = "test").indexOf.call(document.cookie, "test") > -1));

    //alert(cookies);

  	 if (cookies==true) {

	        var baseUrl = document.getElementById('baseUrl').value;
    
	        $.ajaxSetup({
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
	            }
	        });

            $.ajax({
               
                type: "POST", 
				url: baseUrl+'/checkCarro',
                               
                //data: 'id='+id,
                //dataType:"json",
                success: function(data){
                    
                    if (data) {//show cart
                        Util.removeClass(cart[0], 'cd-cart--empty');
                    }
                    
                    //lleno el carrito
                    cartList.insertAdjacentHTML('beforeend', data);

                    // calculo cantidad
                    $.ajax({
                        type: "POST",
                        url: baseUrl+'/checkCantidad',
                        
                        success: function(cant){

                            updateCartCount(0,+cant);
                            quickUpdateCart(); 
                        
                        }   
                    })

                    getTotalConDescuento();

            }   
            
        });

    	initCartEvents();

    }

	else { $('#modalCookies').modal(); //alert('cookies desahbilitadas'); 

}


	function initCartEvents() {
			// add products to cart
			for(var i = 0; i < cartAddBtns.length; i++) {(function(i){
				cartAddBtns[i].addEventListener('click', addToCart);
			})(i);}

			// open/close cart
			cart[0].getElementsByClassName('cd-cart__trigger')[0].addEventListener('click', function(event){
				event.preventDefault();
				toggleCart();
			});
			
			cart[0].addEventListener('click', function(event) {
				if(event.target == cart[0]) { // close cart when clicking on bg layer
					toggleCart(true);
				} else if (event.target.closest('.cd-cart__delete-item')) { // remove product from cart
					event.preventDefault();
					removeProduct(event.target.closest('.cd-cart__product'));
				}
			});

			// update product quantity inside cart
			cart[0].addEventListener('change', function(event) {
				
				const element_a = document.querySelector('#ttsd');
				const element_b = document.querySelector('#tcd');
				element_a.classList.add('animate__animated', 'animate__fadeOut');
				element_b.classList.add('animate__animated', 'animate__fadeOut');


				element_a.addEventListener('animationend', () => {
					element_a.classList.add('animate__animated', 'animate__fadeIn');
					element_a.classList.remove('animate__animated', 'animate__fadeOut');
				});

				element_b.addEventListener('animationend', () => {
					element_b.classList.add('animate__animated', 'animate__fadeIn');
					element_b.classList.remove('animate__animated', 'animate__fadeOut');
				});

				if(event.target.tagName.toLowerCase() == 'select') quickUpdateCart();

			});

			//reinsert product deleted from the cart
			cartUndo.addEventListener('click', function(event) {
				if(event.target.tagName.toLowerCase() == 'a') {
					event.preventDefault();
					if(cartTimeoutId) clearInterval(cartTimeoutId);
					// reinsert deleted product
					var deletedProduct = cartList.getElementsByClassName('cd-cart__product--deleted')[0];
					Util.addClass(deletedProduct, 'cd-cart__product--undo');
					deletedProduct.addEventListener('animationend', function cb(){
						deletedProduct.removeEventListener('animationend', cb);
						Util.removeClass(deletedProduct, 'cd-cart__product--deleted cd-cart__product--undo');
						deletedProduct.removeAttribute('style');
						quickUpdateCart();
					});
					Util.removeClass(cartUndo, 'cd-cart__undo--visible');
				}
			});
		};


		function toggleCart(bool) { // toggle cart visibility
			var cartIsOpen = ( typeof bool === 'undefined' ) ? Util.hasClass(cart[0], 'cd-cart--open') : bool;
		
			if( cartIsOpen ) {
				Util.removeClass(cart[0], 'cd-cart--open');
				//reset undo
				if(cartTimeoutId) clearInterval(cartTimeoutId);
				Util.removeClass(cartUndo, 'cd-cart__undo--visible');
				removePreviousProduct(); // if a product was deleted, remove it definitively from the cart

				setTimeout(function(){
					cartBody.scrollTop = 0;
					//check if cart empty to hide it
					if( Number(cartCountItems[0].innerText) == 0) Util.addClass(cart[0], 'cd-cart--empty');
				}, 500);
			} else {
				Util.addClass(cart[0], 'cd-cart--open');
			}
		};

		function addToCart(event) {

			//alert('asd');

			event.preventDefault();
			if(animatingQuantity) return;
			var cartIsEmpty = Util.hasClass(cart[0], 'cd-cart--empty');
			
			var id = this.getAttribute('data-id');
			var precio = this.getAttribute('data-precio');

            //alert(this.getAttribute('data-price'));

			//update cart product list
			addProduct(this,id,precio);

			//update number of items 
			updateCartCount(cartIsEmpty);
			//update total price
			updateCartTotal(this.getAttribute('data-price'), true);
			//alert(this.getAttribute('data-price'));
			//show cart
			Util.removeClass(cart[0], 'cd-cart--empty');
		};


		function addProduct(target,id,precio) {
			// this is just a product placeholder
			// you should insert an item with the selected product info
			// replace productId, productName, price and url with your real product info
			// you should also check if the product was already in the cart -> if it is, just update the quantity
			
			//busco actividad
			//
			//alert(id+precio);
           $.ajax({
                type: "POST",
                url: baseUrl+'/addActividadCarro',
                data: {id: id , precio: precio},
                //dataType:"json",
                success: function(data){

                	$('.bot_add_'+id+precio).addClass('disabled');
                	$('.bot_add_'+id+precio).html('<i class="fa fa-shopping-cart"></i> <span>En carrito</span>');
					cartList.insertAdjacentHTML('beforeend', data);

					getTotalConDescuento();

                }
            });

		};


		function removeProduct(product) {
			
			if(cartTimeoutId) clearInterval(cartTimeoutId);
			removePreviousProduct(); // prduct previously deleted -> definitively remove it from the cart
			
			var topPosition = product.offsetTop,
				productQuantity = Number(product.getElementsByTagName('select')[0].value),
				productTotPrice = Number((product.getElementsByClassName('cd-cart__price')[0].innerText).replace('$', '')) * productQuantity;

			product.style.top = topPosition+'px';
			Util.addClass(product, 'cd-cart__product--deleted');

			//update items count + total price
			updateCartTotal(productTotPrice, false);
			updateCartCount(true, -productQuantity);
			Util.addClass(cartUndo, 'cd-cart__undo--visible');

			//wait 8sec before completely remove the item
			cartTimeoutId = setTimeout(function(){
				Util.removeClass(cartUndo, 'cd-cart__undo--visible');
				removePreviousProduct();
			}, 8000);
		
			var actuale = Number(cartCountItems[0].innerText);
			if (actuale==0) {toggleCart(true);} 

		};

		function removePreviousProduct() { // definitively removed a product from the cart (undo not possible anymore)
			var deletedProduct = cartList.getElementsByClassName('cd-cart__product--deleted');
			if(deletedProduct.length > 0 ) deletedProduct[0].remove();
		};

		function updateCartCount(emptyCart, quantity) {

			//alert(quantity);

			if( typeof quantity === 'undefined' ) {
				var actual = Number(cartCountItems[0].innerText) + 1;
				var next = actual + 1;
				
				if( emptyCart ) {
					cartCountItems[0].innerText = actual;
					cartCountItems[1].innerText = next;
					animatingQuantity = false;
				} else {
					Util.addClass(cartCount, 'cd-cart__count--update');

					setTimeout(function() {
						cartCountItems[0].innerText = actual;
					}, 150);

					setTimeout(function() {
						Util.removeClass(cartCount, 'cd-cart__count--update');
					}, 200);

					setTimeout(function() {
						cartCountItems[1].innerText = next;
						animatingQuantity = false;
					}, 230);
				}
			} else {
				var actual = Number(cartCountItems[0].innerText) + quantity;
				var next = actual + 1;
				
				cartCountItems[0].innerText = actual;
				cartCountItems[1].innerText = next;
				animatingQuantity = false;
			}
		};

		function updateCartTotal(price, bool) {
			//alert(price);
			cartTotal.innerText = bool ? (Number(cartTotal.innerText) + Number(price)).toFixed(0) : (Number(cartTotal.innerText) - Number(price)).toFixed(0);
		};

		function quickUpdateCart() {

			//$('.div-corona').html('ssss');

			var quantity = 0;
			var price = 0;

			for(var i = 0; i < cartListItems.length; i++) {
				if( !Util.hasClass(cartListItems[i], 'cd-cart__product--deleted') ) {
					var singleQuantity = Number(cartListItems[i].getElementsByTagName('select')[0].value);
					quantity = quantity + singleQuantity;
					//alert(singleQuantity);
					price = price + singleQuantity*Number((cartListItems[i].getElementsByClassName('cd-cart__price')[0].innerText).replace('$', ''));
				}
			}

			//cartTotal.innerText = price.toFixed(0);
			cartCountItems[0].innerText = quantity;
			cartCountItems[1].innerText = quantity+1;
		};

}