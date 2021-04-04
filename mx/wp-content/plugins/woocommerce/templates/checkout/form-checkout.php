<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<?php 
	//Arreglo para almacenar los elemntos del carrito
	$myArray = array();

	// Obtner los elementos del carrito 
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		// Crear objeto
		$object = new stdClass();
	   	$object->nombre = $_product->get_name();
	   	$object->cantidad = $cart_item['quantity'];
	   	$object->id = $cart_item['product_id'];

   		array_push($myArray, $object);
	}

?>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
			<!-- Referencia para colocar archivos -->
			<span id="prueba"></span>
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>


<button id ="modal_btn" type="button" class="checkout-button button alt wc-forward" data-toggle="modal" data-target="#exampleModal">
  Información sobre metodos de pago
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Información sobre metodos de pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
        	
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<script>

// Boton modal 
let boton_nmodal = document.getElementById('modal_btn');
boton_nmodal.hidden = true;
document.getElementById('prueba').appendChild(boton_nmodal);
boton_nmodal.hidden = false;



let boletosDisponibles;
let token;


function getToken(){
	$.ajax({
		url: "/getToken",
		type: "get", 
		success: function(response) {
		    	console.log(response)
		    	token = response;
		  	},
		  	error: function(xhr) {
			    //Do Something to handle error
			    console.log(xhr)
		  	}
	});
}


// Peticion ajax para obtener lugares
function get(){
	$.ajax({
	  	url: "/obtener-disponibles",
	  	type: "get", //send it through get method
	  	data: { 
		    carrito: <?php echo json_encode($myArray) ?>, 
	  	},
	  success: function(response) {
	    console.log("exito en la peticion")
	    boletosDisponibles = response;

	    console.log(response)

	    let cadena = "";
	    response.forEach( function(valor) {
    		cadena += 'Boleto # ['+ valor.numero + '] para rifa de "' + valor.nombre +'", ';
		});


	    document.getElementById('order_comments').value = cadena;

		let data = sessionStorage.getItem('vendor');
		console.log(data);
		if(data != undefined){
			let temptext = document.getElementById('order_comments').value;
		  	document.getElementById('order_comments').value = "";
		  	document.getElementById('order_comments').value = "vendedor:" + data + ", " +  temptext;
		  	document.getElementById("custom_field_name").value = data;
		}

	    let g = document.createElement('div');
		g.setAttribute("id", "Div1");

		document.getElementsByClassName('woocommerce-additional-fields__field-wrapper')[0].appendChild(g);

		let name = `<table>
					  <tr>
					    <th>índice</th>
					    <th>Rifa</th>
					    <th>Núm boleto</th>
					  </tr>`;

		response.forEach( function(valor,indice) {
    		name += "<tr><td>"+ (indice + 1) + "</td><td>"+ valor.nombre + "</td><td> #"+ valor.numero + "</td></tr>";
		});
		name += "</table>"

		let e1 = document.getElementById('Div1');
		e1.innerHTML = name; // con peligro, la alerta ahora si es mostrada

	  },
	  error: function(xhr) {
	    //Do Something to handle error
	    console.log(xhr)
	  }
	});
}

// Ejecutar la funcion 
  get();
  getToken();


// Variable para almacenar el vendedor
let tempVendor = ""; 

// Colocar el input para subir archivos en el lugar adecuado
document.getElementById('alg_checkout_files_upload_form_1').hidden = true;

let dr = document.getElementById('alg_checkout_files_upload_form_1');

function myFunction_cod(){
	console.log("clic en cod");
	document.getElementById('1cod').appendChild(dr);
	dr.hidden = false;
	document.getElementsByTagName('label')[13].innerHTML = 'Por favor seleccione el archivo para cargar';
	document.getElementById('alg_checkout_files_upload_button_1').value = "Seleccionar archivo"
}

function myFunction_ppec_paypal(){
	console.log("ppec_paypal")
}


//Cambiar el campo nuevo del vendedor
let t = document.getElementById('custom_checkout_field');
document.getElementsByClassName('woocommerce-billing-fields')[0].appendChild(t);

// Bloquear boton si no hay un archivo arrriba onmouseover del boton 
function show_function(){
	let test = document.getElementById('1cod').style.display; 
	if(test == ''){
		let x = document.getElementById('alg_checkout_files_upload_button_1').style.display;
		if(x !== "none"){
			let h = document.getElementById("place_order").disabled = true;
		}else{
			console.log("arch");
		}
	}
	
}

// Onmouseout del boton de realizar pedido
function myScript(){
	document.getElementById("place_order").disabled = false;
}

// Funcion al dar clic en realizar pedido
function myFunction5(){
	console.log("Enviando");

	let clienteVar = document.getElementById('billing_email').value;
	let vendedorVar = document.getElementById("custom_field_name").value;

	$.ajax({
		url: "/llenar-disponibles",
		type: "post", //send it through get method
		headers: {'X-CSRF-TOKEN': token},
		data: {
			vendedor: vendedorVar, 
			boletos: JSON.stringify(boletosDisponibles), 
			cliente: clienteVar
		},
		success: function(response) {
			console.log("exito en la peticion")
			console.log(response)			    	
		},
		error: function(xhr) {
			//Do Something to handle error
			console.log(xhr)
		}
	});

}

// Deshabilitar la escritura del campo nota del vendedo
  document.getElementById('order_comments').hidden = true;


document.getElementById("custom_field_name").onchange = function() {cambiarVendedor()};

function cambiarVendedor() {
  var x = document.getElementById("custom_field_name");
  console.log(x.value);
  tempVendor = x.value;
  let temptext = document.getElementById('order_comments').value;
  document.getElementById('order_comments').value = "";
  document.getElementById('order_comments').value = "vendedor:(" + x.value + "), " +  temptext;
}


;


</script>




<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>





