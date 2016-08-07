<?php 
$js_back = "onClick=\"self.location.href='". site_url("cms/slide") ."'\"";
$attributes = array(
	'class' => 'form',
	'name' => 'slide',
	'id' => 'slide'
);
$hidden = array(
	'image_link_slide' => $slide["image_link"]
);
$name = array(
	'name' => 'name',
	'id' => 'name',
	'value' => set_value("name", $slide["name"])
);
$link = array(
	'name' => 'link',
	'id' => 'link',
	'value' => set_value("link", $slide["link"])
);
$sort_order = array(
	'name' => 'sort_order',
	'id' => 'sort_order',
	'value' => set_value("sort_order", $slide["sort_order"])
);
$image_name = array(
	'name' => 'image_name',
	'id' => 'image_name',
	'value' => set_value("image_name", $slide["image_name"])
);
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5><?php echo $page_title; ?></h5>
			<span>Quản lý slide</span>
		</div>
		<div class="clear"></div>
	</div>
</div>
<!-- /titleArea -->
<div class="line"></div>
<div class="wrapper">
	<?php if($this->session->flashdata("message")) { ?>
	<div class="nNote nInformation hideit">
		<p>
			<strong>Thông báo: </strong>
			<?php echo $this->session->flashdata("message"); ?>
		</p>
	</div>
	<?php } ?>
	<?php if($this->session->flashdata("error")) { ?>
	<div class="nNote nFailure hideit">
		<p>
			<strong>Lỗi: </strong>
			<?php echo $this->session->flashdata("error"); ?>
		</p>
	</div>
	<?php } ?>
	<div class="widget">
		<?php echo form_open_multipart($this->uri->uri_string(), $attributes, $hidden); ?>
		<div class="title">
			<img src="<?php echo public_url('admin/images/icons/dark/add.png'); ?>" class="titleIcon">
			<h6><?php echo $page_title; ?></h6>
		</div>
		<div class="formRow">
			<label class="formLeft" for="name">Tên slide:<span class="req">*</span></label>
			<div class="formRight">
				<span class="oneTwo"><?php echo form_input($name); ?></span>
				<span name="name_autocheck" class="autocheck"></span>
				<div name="name_error" class="clear error">
					<?php echo form_error($name["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft">Hình ảnh:</label>
			<div class="formRight">
				<div class="left">
					<?php if ($slide["image_link"]) : ?>
					<img src="<?php echo upload_url("slide/".$slide["image_link"]); ?>" alt="<?php echo $slide["name"]; ?>" width="200">
					<p class="textC">
						[<a href="<?php echo site_url('cms/slide/photo_del/'.$id); ?>">Xóa hình ảnh</a>]
					</p>
					<?php else : ?>
					<input type="file" id="image" name="image">
					<?php endif; ?>
				</div>
				<div name="image_error" class="clear error">

				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft" for="link">Link:</label>
			<div class="formRight">
				<span class="oneTwo"><?php echo form_input($link); ?></span>
				<span name="name_autocheck" class="autocheck"></span>
				<div name="name_error" class="clear error">
					<?php echo form_error($link["name"]); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label class="formLeft" for="sort_order">Thứ tự hiển thị:</label>
			<div class="formRight">
				<span class="oneTwo"><?php echo form_input($sort_order); ?></span>
				<span name="name_autocheck" class="autocheck"></span>
				<div name="name_error" class="clear error">
					<?php echo form_error($sort_order["name"]); ?>
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