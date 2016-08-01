<?php 
$js_back = "onClick=\"self.location.href='". site_url("cms/user/roles") ."'\"";
$attributes = array(
	'class' => 'form',
	'name' => 'user'
);
$name = array(
	'name' => 'name',
	'id' => 'name',
	'value' => set_value("name", $role["name"])
);
$parent = array();
$parent[] = "Chọn nhóm cha";
$parent_selected = "";
foreach ($roles as $item) {
	if($item["id"] == $role["parent_id"])
	{
		$parent_selected = set_value("parent", $role["parent_id"]);
	}
	$parent[$item["id"]] = $item["name"];
}
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
			<label class="formLeft" for="name">Tên nhóm quản trị:<span class="req">*</span></label>
			<div class="formRight">
				<span class="oneTwo">
					<?php echo form_input($name); ?>
				</span>
				<div name="name_error" class="clear error">
					<?php echo form_error($name["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft" for="parent">Nhóm cha:</label>
			<div class="formRight">
				<span class="oneTwo">
					<?php echo form_dropdown('parent', $parent, $parent_selected, 'id="parent"'); ?>
				</span>
				<div name="name_error" class="clear error">
					<?php echo form_error('parent'); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formSubmit">
   			<input type="submit" value="<?php if ($id) : ?>Cập nhật<?php else : ?>Thêm mới<?php endif; ?>" class="dblueB">
   			<input type="reset" value="Hủy bỏ" class="greyishB">
   			<input type="button" value="Quay lại" class="basic" <?php echo $js_back; ?>>
   		</div>
   		<div class="clear"></div>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- /main-content -->