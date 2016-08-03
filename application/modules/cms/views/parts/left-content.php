<div id="leftSide" style="padding-top:30px;">
	<div class="sideProfile">
		<a href="#" title="" class="profileFace">
			<img width="40" src="<?php echo public_url('admin/images/user.png'); ?>" />
		</a>
		<span>Xin chào:</span>
		<span><?php if(isset($user_name) && $user_name) { echo $user_name; } ?></span>
		<div class="clear"></div>
	</div>
	<div class="sidebarSep"></div>
	<ul id="menu" class="nav">
		<li class="home">
			<a href="<?php echo site_url('cms'); ?>" <?php if(isset($menu_active) && $menu_active == "cms") : ?>class="active"<?php endif; ?>>
				<span>Bảng điều khiển</span>
				<strong></strong>
			</a>		
		</li>	
		<li class="tran">
			<a href="" class="exp <?php if(isset($menu_active) && $menu_active == "transaction") : ?>active<?php endif; ?>">
				<span>Quản lý bán hàng</span>
				<strong>2</strong>
			</a>
			<ul class="sub">
				<li <?php if(isset($submenu_active) && $submenu_active == "transaction") : ?>class="this"<?php endif; ?>>
					<a href="">Giao dịch</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "product_order") : ?>class="this"<?php endif; ?>>
					<a href="">Đơn hàng sản phẩm</a>
				</li>
			</ul>
		</li>
		<li class="product">
			<a href="javascript:void(0)" class="exp <?php if(isset($menu_active) && $menu_active == "product") : ?>active" id="current"<?php else : ?>"<?php endif; ?>>
				<span>Sản phẩm</span>
				<strong>3</strong>
			</a>
			<ul class="sub">
				<li <?php if(isset($submenu_active) && $submenu_active == "product") : ?>class="this"<?php endif; ?>>
					<a href="">Sản phẩm</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "categories") : ?>class="this"<?php endif; ?>>
					<a href="<?php echo site_url('cms/categories'); ?>">Danh mục</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "comment") : ?>class="this"<?php endif; ?>>
					<a href="">Phản hồi</a>
				</li>
			</ul>	
		</li>
		<li class="account">
			<a href="javascript:void(0)" class="exp <?php if(isset($menu_active) && $menu_active == "account") : ?>active" id="current"<?php else : ?>"<?php endif; ?>>
				<span>Tài khoản</span>
				<strong>3</strong>
			</a>
			<ul class="sub">
				<li <?php if(isset($submenu_active) && $submenu_active == "admin") : ?>class="this"<?php endif; ?>>
					<a href="">Ban quản trị</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "roles") : ?>class="this"<?php endif; ?>>
					<a href="<?php echo site_url('cms/user/roles'); ?>">Nhóm quản trị</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "user") : ?>class="this"<?php endif; ?>>
					<a href="<?php echo site_url('cms/user'); ?>">Thành viên</a>
				</li>
			</ul>	
		</li>
		<li class="support">
			<a href="admin/support.html" class="exp <?php if(isset($menu_active) && $menu_active == "support") : ?>active<?php endif; ?>">
				<span>Hỗ trợ và liên hệ</span>
				<strong>2</strong>
			</a>
			<ul class="sub">
				<li <?php if(isset($submenu_active) && $submenu_active == "support") : ?>class="this"<?php endif; ?>>
					<a href="">Hỗ trợ</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "contact") : ?>class="this"<?php endif; ?>>
					<a href="">Liên hệ</a>
				</li>
			</ul>		
		</li>
		<li class="content">
			<a href="admin/content.html" class="exp <?php if(isset($menu_active) && $menu_active == "content") : ?>active<?php endif; ?>">
				<span>Nội dung</span>
				<strong>4</strong>
			</a>
			<ul class="sub">
				<li <?php if(isset($submenu_active) && $submenu_active == "slide") : ?>class="this"<?php endif; ?>>
					<a href="">Slide</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "news") : ?>class="this"<?php endif; ?>>
					<a href="">Tin tức</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "info") : ?>class="this"<?php endif; ?>>
					<a href="">Trang thông tin</a>
				</li>
				<li <?php if(isset($submenu_active) && $submenu_active == "video") : ?>class="this"<?php endif; ?>>
					<a href="">Video</a>
				</li>
			</ul>	
		</li>
	</ul>
</div>
<div class="clear"></div>