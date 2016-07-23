<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);

?>
<div class="loginWrapper" style="top:45%;">
	<div class="widget" id="admin_login" style="height:auto; margin:auto;">
		<div class="title"><img src="<?php echo public_url('admin/images/icons/dark/laptop.png'); ?>" alt="" class="titleIcon" />
        	<h6>Đăng nhập</h6>
        </div>
		<?php echo form_open($this->uri->uri_string(), "class='form' id='form'")?>
		<fieldset>
			<?php echo $this->dx_auth->get_auth_error(); ?>
			<div class="formRow">
				<?php echo form_label('Địa chỉ email (<span style="color:#FF0000"><strong>*</strong></span>):', $username['id']);?>
                <div class="loginInput">
                	<?php echo form_input($username)?>
                	<?php echo form_error($username['name']); ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
            	<?php echo form_label('Mật khẩu (<span style="color:#FF0000"><strong>*</strong></span>):', $password['id']);?>
                <div class="loginInput">
                	<?php echo form_password($password)?>
                	<?php echo form_error($password['name']); ?>
                </div>
                <div class="clear"></div>
            </div>
            <?php if ($show_captcha): ?>
            <div class="formRow">
            	<?php echo form_label('Mã xác nhận (<span style="color:#FF0000"><strong>*</strong></span>):', $confirmation_code['id']);?>
                <div class="loginInput">
                	<?php echo $this->dx_auth->get_captcha_image(); ?>
                	<?php echo form_password($confirmation_code)?>
                	<?php echo form_error($confirmation_code['name']); ?>
                </div>
                <div class="clear"></div>
            </div>
            <?php endif; ?>
            <div class="loginControl">
            	<?php echo form_checkbox($remember);?>&nbsp;&nbsp;<?php echo form_label('Nhớ tài khoản', $remember['id']);?>
                <input type='hidden' name="submit" value='1'/>
                <input type="submit"  value="Đăng nhập" class="dredB logMeIn" />
                <div class="clear"></div>
            </div>
		</fieldset>
		<?php echo form_close()?>
	</div>
	<div class="formRow">
		<?php echo anchor($this->dx_auth->forgot_password_uri, 'Quên mật khẩu');?>
		<?php
			if ($this->dx_auth->allow_registration) {
				echo anchor($this->dx_auth->register_uri, 'Đăng ký', 'style="float:right;"');
			};
		?>
		<div class="clear"></div>
	</div>
</div>