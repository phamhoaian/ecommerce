<?php 
$attributes = array(
	'class' => 'form',
	'name' => 'user'
);
$username = array(
	'name' => 'username',
	'id' => 'username',
	'value' => set_value("username", $user["username"])
);
$password = array(
	'name' => 'password',
	'id' => 'password'
);
$confirm_password = array(
	'name' => 'confirm_password',
	'id' => 'confirm_password'
);
$email = array(
	'name' => 'email',
	'id' => 'email',
	'value' => set_value("email", $user["email"])
);
$phone = array(
	'name' => 'phone',
	'id' => 'phone',
	'value' => set_value("phone", $user["phone"])
);
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5><?php echo $page_title; ?></h5>
			<span>Quản lý thành viên</span>
		</div>
		<div class="clear"></div>
	</div>
</div>
<!-- /titleArea -->
<div class="line"></div>
<div class="wrapper">
	<div class="widget">
		<?php echo form_open_multipart($this->uri->uri_string(), $attributes); ?>
		<div class="title">
			<img src="<?php echo public_url('admin/images/icons/dark/add.png'); ?>" class="titleIcon">
			<h6><?php echo $page_title; ?></h6>
		</div>
		<div class="formRow">
			<label class="formLeft" for="param_name">Tên thành viên:<span class="req">*</span></label>
			<div class="formRight">
				<span class="oneTwo">
					<?php echo form_input($username); ?>
				</span>
				<div name="name_error" class="clear error">
					<?php echo form_error($username["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft" for="param_name">Mật khẩu:</label>
			<div class="formRight">
				<span class="oneTwo">
					<?php echo form_input($password); ?>
				</span>
				<div name="name_error" class="clear error">
					<?php echo form_error($password["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft" for="param_name">Mật khẩu (nhập lại):</label>
			<div class="formRight">
				<span class="oneTwo">
					<?php echo form_input($confirm_password); ?>
				</span>
				<div name="name_error" class="clear error">
					<?php echo form_error($confirm_password["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft" for="param_name">Email:<span class="req">*</span></label>
			<div class="formRight">
				<span class="oneTwo">
					<?php echo form_input($email); ?>
				</span>
				<div name="name_error" class="clear error">
					<?php echo form_error($email["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft" for="param_name">Điện thoại:</label>
			<div class="formRight">
				<span class="oneTwo">
					<?php echo form_input($phone); ?>
				</span>
				<div name="name_error" class="clear error">
					<?php echo form_error($phone["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formSubmit">
   			<input type="submit" value="Thêm mới" class="redB">
   			<input type="reset" value="Hủy bỏ" class="basic">
   		</div>
   		<div class="clear"></div>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- /main-content -->