<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blocksy
 */

?><!doctype html>
<html <?php language_attributes(); ?><?php echo blocksy_html_attr() ?>>
<head>
	<?php do_action('blocksy:head:start') ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<?php do_action('blocksy:head:end') ?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			if (!localStorage.getItem('cookieConsent')) {
				var consentBanner = document.createElement('div');
				consentBanner.innerHTML = `
					<div style="position:fixed;bottom:0;width:100%;background:#000;color:#fff;padding:10px;text-align:center;z-index:9999;">
						This website uses cookies to enhance your experience. 
						<a href="wordpress/privacy-policy" style="color:yellow;">Learn more</a>
						<button id="acceptCookies" style="margin-left:10px;padding:5px 10px;">Accept</button>
					</div>`;
				document.body.appendChild(consentBanner);

				document.getElementById('acceptCookies').onclick = function() {
					localStorage.setItem('cookieConsent', 'true');
					consentBanner.style.display = 'none';
				};
			}
		});
	</script>

</head>

<?php
	ob_start();
	blocksy_output_header();
	$global_header = ob_get_clean();
?>

<body <?php body_class(); ?> <?php echo blocksy_body_attr() ?>>

<?php
	if (function_exists('wp_body_open')) {
		wp_body_open();
	}
?>

<div id="main-container">
	<?php
		do_action('blocksy:header:before');

		echo $global_header;

		do_action('blocksy:header:after');
		do_action('blocksy:content:before');
	?>

	<main <?php echo blocksy_main_attr() ?>>

		<?php
			do_action('blocksy:content:top');
			blocksy_before_current_template();
		?>
