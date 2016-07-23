<?php

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'maxlength'	=> 80,
	'size'	=> 30,
	'value' => set_value('login')
);

?>
<div class="loginWrapper" style="top:45%;">
	<div class="widget" id="admin_login" style="height:auto; margin:auto;">
		<div class="title"><img src="<?php echo public_url('admin/images/icons/dark/laptop.png'); ?>" alt="" class="titleIcon" />
        	<h6>Quên mật khẩu</h6>
        </div>
        <?php echo form_open($this->uri->uri_string(), "class='form' id='form'")?>
        <fieldset>
			<?php echo $this->dx_auth->get_auth_error(); ?>
			<div class="formRow">
				<?php echo form_label('Nhập địa chỉ email (<span style="color:#FF0000"><strong>*</strong></span>):', $login['id']);?>
            	<?php echo form_error($login['name']); ?>
                <div class="clear"></div>
            </div>
            <div class="loginControl">
            	<input type="submit"  value="Gửi" class="dredB logMeIn" />
                <div class="clear"></div>
            </div>
        </fieldset>
        <?php echo form_close()?>
	</div>
</div>