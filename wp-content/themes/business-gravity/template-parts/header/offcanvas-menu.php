<?php
/** 
* Template for Off canvas Menu
* @since Business Gravity 1.0.0
*/
?>
<div id="offcanvas-menu" class="offcanvas-menu-wrap">
	<div class="close-offcanvas-menu">
		<a href="#" class="kfi kfi-close-alt2"></a>
	</div>
	<div class="offcanvas-menu-inner">
		<?php if(!business_gravity_get_option( 'disable_top_header' ) ): ?>
			<div class="header-search-wrap">
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
		<?php if( !business_gravity_get_option( 'disable_header_button' ) && !empty( business_gravity_get_option( 'header_button_text' )) ): ?>
			<?php get_template_part( 'template-parts/header/header', 'callback' ); ?>
		<?php endif; ?>
		<div id="primary-nav-offcanvas" class="offcanvas-navigation">
			<?php business_gravity_get_menu( 'primary' ); ?>
		</div>
		<?php if( !business_gravity_get_option( 'disable_top_header' ) && ( !empty( business_gravity_get_option( 'top_header_address' )) || !empty( business_gravity_get_option( 'top_header_email' )) || !empty( business_gravity_get_option( 'top_header_phone' ))) ): ?>
			<?php get_template_part( 'template-parts/header/header', 'contact' ); ?>
		<?php endif; ?>
		<?php if(!business_gravity_get_option( 'disable_top_header' ) ): ?>
			<div class="top-header-right">
				<div class="socialgroup">
					<?php business_gravity_get_menu( 'social' ); ?>
				</div>
				<?php get_template_part('template-parts/header/header', 'cart'); ?>
			</div>
		<?php endif; ?>
	</div>
</div>