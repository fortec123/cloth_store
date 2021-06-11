<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cloth_Store
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<?php
if ( is_active_sidebar( 'footer_widget1' ) ) : ?>
    <div id="footer-widget-1" class="widget-area">
    <?php dynamic_sidebar( 'footer_widget1' ); ?>
    </div>		
<?php endif; ?>
			</div>
			<div class="col-md-3 col-sm-6">
				<?php
if ( is_active_sidebar( 'footer_widget2' ) ) : ?>
    <div id="footer-widget-2" class="widget-area">
    <?php dynamic_sidebar( 'footer_widget2' ); ?>
    </div>		
<?php endif; ?>
			</div>
			<div class="col-md-3 col-sm-6">
				<?php
if ( is_active_sidebar( 'footer_widget3' ) ) : ?>
    <div id="footer-widget-3" class="widget-area">
    <?php dynamic_sidebar( 'footer_widget3' ); ?>
    </div>		
<?php endif; ?>
			</div>
			<div class="col-md-3 col-sm-6">
				<?php
if ( is_active_sidebar( 'footer_widget4' ) ) : ?>
    <div id="footer-widget-4" class="widget-area">
    <?php dynamic_sidebar( 'footer_widget4' ); ?>
    </div>		
<?php endif; ?>
			</div>
		</div>
		</div>
		<div class="site-info">
			<div class="container">
			<div class="bottom_footer">
				<span>Copyright © 2017 Cloth-store. All Rights Reserved</span>
				<span>Designed by Solwin Infotech</span>
				</div>
		</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script>
	jQuery(document).ready(function(){
jQuery('.search_toggle').click(function(){
jQuery('#header-widget-area').toggleClass('active');
});
	});
</script>

</body>
</html>
