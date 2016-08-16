<?php 
$email = array(
	'class' => 'input',
	'name' => 'email',
	'id' => 'email',
	'value' => set_value('email')
);
$name = array(
	'class' => 'input',
	'name' => 'name',
	'id' => 'name',
	'value' => set_value('name')
);
$phone = array(
	'class' => 'input',
	'name' => 'phone',
	'id' => 'phone',
	'value' => set_value('phone')
);
$message = array(
	'class' => 'input',
	'name' => 'message',
	'id' => 'message',
	'value' => set_value('message')
);
?>
<div class="box-center">
	<div class="tittle-box-center">
		<h2>Thông tin đặt hàng</h2>
	</div>
	<div class="box-content-center register">
		<form enctype="multipart/form-data" action="<?php echo site_url("order/checkout"); ?>" method="post" class="t-form form_action">
			<div class="form-row">
				<label class="form-label" for="param_email">Email:<span class="req">*</span></label>
				<div class="form-item">
					<?php echo form_input($email); ?>
					<div class="clear"></div>
					<div id="email_error" class="error">
						<?php echo form_error($email["name"]); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label class="form-label" for="param_email">Tên:<span class="req">*</span></label>
				<div class="form-item">
					<?php echo form_input($name); ?>
					<div class="clear"></div>
					<div id="email_error" class="error">
						<?php echo form_error($name["name"]); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label class="form-label" for="param_email">SĐT:<span class="req">*</span></label>
				<div class="form-item">
					<?php echo form_input($phone); ?>
					<div class="clear"></div>
					<div id="email_error" class="error">
						<?php echo form_error($phone["name"]); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label class="form-label" for="param_email">Phương thức thanh toán:<span class="req">*</span></label>
				<div class="form-item">
					<select name="payment" id="payment">
						<option value="">-- Chọn phương thức --</option>
						<option value="nganluong">Ngân lượng</option>
						<option value="baokim">Bảo kim</option>
						<option value="dathang">Thanh toán khi nhận hàng</option>
					</select>
					<div class="clear"></div>
					<div id="email_error" class="error">
						<?php echo form_error("payment"); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label class="form-label" for="param_email">Ghi chú:</label>
				<div class="form-item">
					<?php echo form_textarea($message); ?>
					<div class="clear"></div>
					<div id="email_error" class="error">
						<?php echo form_error($message["name"]); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label class="form-label">&nbsp;</label>
				<div class="form-item">
					<input type="submit" name="submit" value="Đặt hàng" class="button">
				</div>
			</div>
		</form>
	</div>
</div>