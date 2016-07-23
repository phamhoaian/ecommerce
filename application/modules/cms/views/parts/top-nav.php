<div class="topNav">
	<div class="wrapper">
		<div class="welcome">
			<span>Xin chào: <b><?php if(isset($user_name) && $user_name) { echo $user_name; } ?></b></span>
		</div>
		<div class="userNav">
			<ul>
				<li><a href="<?php echo site_url(); ?>" target="_blank">
					<img style="margin-top:7px;" src="<?php echo public_url('admin/images/icons/light/home.png'); ?>" />
					<span>Trang chủ</span>
				</a></li>
				<li><a href="<?php echo site_url('auth/logout'); ?>">
					<img src="<?php echo public_url('admin/images/icons/topnav/logout.png'); ?>" alt="" />
					<span>Đăng xuất</span>
				</a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>