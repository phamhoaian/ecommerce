<?php
$password = array(
	'name'	=> 'password',
	'id'		=> 'password',
	'size' 	=> 30
);

?>
<div class="loginWrapper" style="top:45%;">
	<div class="widget" id="admin_login" style="height:auto; margin:auto;">
		<div class="title"><img src="<?php echo public_url('admin/images/icons/dark/laptop.png'); ?>" alt="" class="titleIcon" />
        	<h6>Hủy tài khoản</h6>
        </div>
        <?php echo form_open($this->uri->uri_string(), "class='form' id='form'")?>
		<fieldset>
			<?php echo $this->dx_auth->get_auth_error(); ?>
			<div class="formRow">
				<?php echo form_label('Mật khẩu (<span style="color:#FF0000"><strong>*</strong></span>):', $password['id']);?>
				<div class="loginInput">
					<?php echo form_password($password)?>
	            	<?php echo form_error($password['name']); ?>
				</div>
                <div class="clear"></div>
            </div>
            <div class="loginControl">
            	<input type="submit"  value="Hủy tài khoản" class="dredB logMeIn" />
                <div class="clear"></div>
            </div>
		</fieldset>
        <?php echo form_close(); ?>
	</div>
</div>