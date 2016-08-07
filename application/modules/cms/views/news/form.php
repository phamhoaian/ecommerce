<?php 
$js_back = "onClick=\"self.location.href='". site_url("cms/news") ."'\"";
$attributes = array(
	'class' => 'form',
	'name' => 'news',
	'id' => 'news'
);
$hidden = array(
	'image_link_news' => $news["image_link"]
);
$title = array(
	'name' => 'title',
	'id' => 'title',
	'value' => set_value("title", $news["title"])
);
$intro = array(
	'name' => 'intro',
	'id' => 'intro',
	'value' => set_value("intro", $news["intro"])
);
$meta_desc = array(
	'name' => 'meta_desc',
	'id' => 'meta_desc',
	'value' => set_value("meta_desc", $news["meta_desc"])
);
$meta_key = array(
	'name' => 'meta_key',
	'id' => 'meta_key',
	'value' => set_value("meta_key", $news["meta_key"])
);
$content = array(
	'name' => 'content',
	'id' => 'content',
	'class' => 'editor',
	'value' => set_value("content", $news["content"])
);
?>
<script type="text/javascript">
(function($)
{
	$(document).ready(function()
	{
		var main = $('#news');
		
		// Tabs
		main.contentTabs();
	});
})(jQuery);
</script>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5><?php echo $page_title; ?></h5>
			<span>Quản lý tin tức</span>
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
		<ul class="tabs">
            <li class="activeTab"><a href="#tab1">Thông tin chung</a></li>
            <li class=""><a href="#tab2">SEO Onpage</a></li>
            <li class=""><a href="#tab3">Bài viết</a></li>
		</ul>
		<div class="tab_container">
			<div id="tab1" class="tab_content pd0">
		        <div class="formRow">
					<label class="formLeft" for="title">Title:<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo"><?php echo form_input($title); ?></span>
						<span name="name_autocheck" class="autocheck"></span>
						<div name="name_error" class="clear error">
							<?php echo form_error($title["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft">Hình ảnh:</label>
					<div class="formRight">
						<div class="left">
							<?php if ($news["image_link"]) : ?>
							<img src="<?php echo upload_url("news/".$news["image_link"]); ?>" alt="<?php echo $news["title"]; ?>" width="200">
							<p class="textC">
								[<a href="<?php echo site_url('cms/news/photo_del/'.$id); ?>">Xóa hình ảnh</a>]
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
					<label class="formLeft" for="intro">Mô tả ngắn:</label>
					<div class="formRight">
						<span class="oneTwo">
							<?php echo form_textarea($intro); ?>
						</span>
						<span name="sale_autocheck" class="autocheck"></span>
						<div name="sale_error" class="clear error">
							<?php echo form_error($intro["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow hide"></div>
			</div>
			<div id="tab2" class="tab_content pd0">
				<div class="formRow">
					<label class="formLeft" for="meta_desc">Meta description:</label>
					<div class="formRight">
						<span class="oneTwo">
							<?php echo form_textarea($meta_desc); ?>
						</span>
						<span name="meta_desc_autocheck" class="autocheck"></span>
						<div name="meta_desc_error" class="clear error">
							<?php echo form_error($meta_desc["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="meta_key">Meta keywords:</label>
					<div class="formRight">
						<span class="oneTwo">
							<?php echo form_textarea($meta_key); ?>
						</span>
						<span name="meta_key_autocheck" class="autocheck"></span>
						<div name="meta_key_error" class="clear error">
							<?php echo form_error($meta_key["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			    <div class="formRow hide"></div>
			</div>
			<div id='tab3' class="tab_content pd0">
			    <div class="formRow">
					<label class="formLeft">Nội dung:</label>
					<div class="formRight">
						<?php echo form_textarea($content); ?>
						<div name="content_error" class="clear error">
							<?php echo form_error($content["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			    <div class="formRow hide"></div>
			</div>
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