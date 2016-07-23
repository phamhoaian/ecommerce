<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' =>  set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
	'value' => set_value('password')
);

$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'size'	=> 30,
	'value' => set_value('confirm_password')
);

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'maxlength'	=> 80,
	'size'	=> 30,
	'value'	=> set_value('email')
);

$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'value'	=> set_value('captcha')
);

?>
<div class="loginWrapper" style="top:45%;">
	<div class="widget" id="admin_login" style="height:auto; margin:auto;">
		<div class="title"><img src="<?php echo public_url('admin/images/icons/dark/laptop.png'); ?>" alt="" class="titleIcon" />
        	<h6>Đăng ký thành viên</h6>
        </div>
        <?php echo form_open($this->uri->uri_string(), "class='form' id='form'")?>
        <fieldset>
			<?php echo $this->dx_auth->get_auth_error(); ?>
			<div class="formRow">
				<?php echo form_label('Tên tài khoản (<span style="color:#FF0000"><strong>*</strong></span>):', $username['id']);?>
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
            <div class="formRow">
				<?php echo form_label('Mật khẩu xác nhận (<span style="color:#FF0000"><strong>*</strong></span>):', $confirm_password['id']);?>
				<div class="loginInput">
					<?php echo form_password($confirm_password)?>
            		<?php echo form_error($confirm_password['name']); ?>
				</div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
				<?php echo form_label('Email (<span style="color:#FF0000"><strong>*</strong></span>):', $email['id']);?>
				<div class="loginInput">
					<?php echo form_input($email)?>
            		<?php echo form_error($email['name']); ?>
				</div>
                <div class="clear"></div>
            </div>
            <?php if ($this->dx_auth->captcha_registration): ?>
            <div class="formRow">
				<?php echo form_label('Nhập kí tự trong hình (<span style="color:#FF0000"><strong>*</strong></span>):', $captcha['id']);?>
				<div class="loginInput">
					<?php echo $this->dx_auth->get_captcha_image(); ?>
					<?php echo form_input($captcha)?>
					<?php echo form_error($captcha['name']); ?>
				</div>
                <div class="clear"></div>
            </div>
            <?php endif; ?>
            <div class="loginControl">
            	<input type="submit"  value="Đăng ký" class="dredB logMeIn" />
                <div class="clear"></div>
            </div>
        </fieldset>
        <?php echo form_close()?>
	</div>
</div>