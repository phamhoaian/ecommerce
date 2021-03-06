<div class='header'>
	<div class='top'>
		<div id="logo">
			<a  href="<?php echo site_url(); ?>">
				<img src="<?php echo public_url('site/images/logo.jpg'); ?>" alt="<?php echo SITE_NAME; ?>"/>
			</a>
		</div>
		<!-- /logo -->
		<div id="cart_expand" class="cart"> 
			<a href="<?php echo site_url("cart"); ?>" class="cart_link">
				Giỏ hàng <span id="in_cart"><?php echo $total_items; ?></span> sản phẩm
			</a> 
			<img alt="" src="<?php echo public_url('site/images/cart.png'); ?>"> 
		</div>
		<!-- /cart -->
		<div id="search">
			<form method="get" action="<?php echo site_url("product/search"); ?>">
				<input type="text" id="text-search" name="keyword" value="<?php if (isset($keyword) && $keyword) : echo $keyword; endif; ?>" placeholder="Tìm kiếm sản phẩm..." class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
				<input type="submit" id="but" value="">
			</form>
		</div>
		<!-- /search -->
		<div class='clear'></div><!-- clear float --> 
	</div>
	<!-- /top -->
	<div id="menu">
		<ul class="menu_top">
			<li class="<?php if(isset($menu_active) && $menu_active == "home") : ?>active index-li<?php endif; ?>"><a href="<?php echo site_url(); ?>">Trang chủ </a></li>
			<li class=""><a href="">Giới thiệu</a></li>
			<li class=""><a href="">Hướng dẫn</a></li>
			<li class="<?php if(isset($menu_active) && $menu_active == "product") : ?>active index-li<?php endif; ?>"><a href="<?php echo site_url("product"); ?>">Sản phẩm</a></li>
			<li class=""><a href="">Tin tức</a></li>
			<li class=""><a href="">Video</a></li>
			<li class=""><a href="">Liên hệ</a></li>
			<li class=""><a href="">Đăng ký</a></li>
			<li class=""><a href="">Đăng nhập</a></li>
		</ul>
	</div>
	<!-- /menu -->
</div>
<!-- /header -->