<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php 
// Obtener el usuario actual 
$current_user = wp_get_current_user();
$slug = "";
?>
<script type="text/javascript">

	function getSlug(){
		$.ajax({
                    url: "/client-slug",
                    type: "get", //send it through get method
                    data: {
                        cliente: <?php echo $current_user->ID; ?>, 
                        ref: '<?php echo $current_user->user_pass; ?>', 
                    },
                    success: function(response) {
			    		document.getElementById('ref').href = "/cambiar-boletos/" + response; 
                    },
                    error: function(xhr) {
                        console.log(xhr)
                    }
			});
	}
	getSlug();
</script>

<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<li id="change_number" class="woocommerce-MyAccount-navigation-link">
			<a id="ref" href='/cambiar-boletos/'>Cambiar número de mis boletos</a>
		</li>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
