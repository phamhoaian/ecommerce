<?php 
$attributes = array(
	'class' => 'form',
	'name' => 'user'
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
			<label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
			<div class="formRight">
				<span class="oneTwo"><input name="name" id="param_name" _autocheck="true" type="text"></span>
				<span name="name_autocheck" class="autocheck"></span>
				<div name="name_error" class="clear error"></div>
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