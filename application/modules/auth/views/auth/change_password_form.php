<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'		=> 'old_password',
	'size' 	=> 30,
	'value' => set_value('old_password')
);

$new_password = array(
	'name'	=> 'new_password',
	'id'		=> 'new_password',
	'size'	=> 30
);

$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'		=> 'confirm_new_password',
	'size' 	=> 30
);

?>
<div class="loginWrapper" style="top:45%;">
	<div class="widget" id="admin_login" style="height:auto; margin:auto;">
		<div class="title"><img src="<?php echo public_url('admin/images/icons/dark/laptop.png'); ?>" alt="" class="titleIcon" />
        	<h6>Đổi mật khẩu</h6>
        </div>
        <?php echo form_open($this->uri->uri_string(), "class='form' id='form'")?>
		<fieldset>
			<?php echo $this->dx_auth->get_auth_error(); ?>
			<div class="formRow">
				<?php echo form_label('Mật khẩu cũ (<span style="color:#FF0000"><strong>*</strong></span>):', $old_password['id']);?>
				<div class="loginInput">
					<?php echo form_password($old_password)?>
	            	<?php echo form_error($old_password['name']); ?>
				</div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
				<?php echo form_label('Mật khẩu mới (<span style="color:#FF0000"><strong>*</strong></span>):', $new_password['id']);?>
                <div class="loginInput">
	                <?php echo form_password($new_password)?>
	            	<?php echo form_error($new_password['name']); ?>
            	</div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
				<?php echo form_label('Mật khẩu mới (nhập lại) (<span style="color:#FF0000"><strong>*</strong></span>):', $confirm_new_password['id']);?>
            	<div class="loginInput">
	                <?php echo form_password($confirm_new_password)?>
	            	<?php echo form_error($confirm_new_password['name']); ?>
            	</div>
                <div class="clear"></div>
            </div>
            <div class="loginControl">
            	<input type="submit"  value="Đổi mật khẩu" class="dredB logMeIn" />
                <div class="clear"></div>
            </div>
		</fieldset>
        <?php echo form_close()?>
	</div>
</div>