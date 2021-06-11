<?php
/**
* Template Name: Home Page
*
* @package WordPress
* @subpackage Cloth Store
* @since Cloth Store
*/

get_header();
?>

<section class="main_banner">
	<?php echo do_shortcode('[avartanslider alias="homepage_slider"]'); ?>
</section>

<section class="content_wrapper">
	<div class="container">
		<div class="woocommerce_categories_products">
			<h3 class="category_title">
				What's New
			</h3>
			<?php echo do_shortcode('[products limit="4" columns="4" orderby="id" order="DESC" visibility="visible" class="new-products"]'); ?>
		</div>
		<div class="woocommerce_categories_products">
			<h3 class="category_title">
				Best Seller
			</h3>
			<?php echo do_shortcode('[products best_selling="true" limit="8" columns="4" orderby="popularity" class="best-seller"]'); ?>
		</div>
		<div class="blog_grid">
			<h3 class="section_title">
				Latest Blog
			</h3>
			
			<?php echo do_shortcode('[post_grid id="179"]');?>
			
		</div>
	</div>
</section>

<?php
get_footer();