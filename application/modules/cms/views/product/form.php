<?php 
$js_back = "onClick=\"self.location.href='". site_url("cms/product") ."'\"";
$attributes = array(
	'class' => 'form',
	'name' => 'product',
	'id' => 'product'
);
$name = array(
	'name' => 'name',
	'id' => 'name',
	'value' => set_value("name", $product["name"])
);
$price = array(
	'name' => 'price',
	'id' => 'price',
	'class' => 'format_number',
	'value' => set_value("price", $product["price"]),
	'style' => 'width:100px'
);
$discount = array(
	'name' => 'discount',
	'id' => 'discount',
	'class' => 'format_number',
	'value' => set_value("discount", $product["discount"]),
	'style' => 'width:100px'
);
$warranty = array(
	'name' => 'warranty',
	'id' => 'warranty',
	'value' => set_value("warranty", $product["warranty"])
);
$gifts = array(
	'name' => 'gifts',
	'id' => 'gifts',
	'value' => set_value("gifts", $product["gifts"])
);
$site_title = array(
	'name' => 'site_title',
	'id' => 'site_title',
	'value' => set_value("site_title", $product["site_title"])
);
$meta_desc = array(
	'name' => 'meta_desc',
	'id' => 'meta_desc',
	'value' => set_value("meta_desc", $product["meta_desc"])
);
$meta_key = array(
	'name' => 'meta_key',
	'id' => 'meta_key',
	'value' => set_value("meta_key", $product["meta_key"])
);
$content = array(
	'name' => 'content',
	'id' => 'content',
	'class' => 'editor',
	'value' => set_value("content", $product["content"])
);
?>
<script type="text/javascript">
(function($)
{
	$(document).ready(function()
	{
		var main = $('#product');
		
		// Tabs
		main.contentTabs();
	});
})(jQuery);
</script>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5><?php echo $page_title; ?></h5>
			<span>Quản lý sản phẩm</span>
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
		<ul class="tabs">
            <li class="activeTab"><a href="#tab1">Thông tin chung</a></li>
            <li class=""><a href="#tab2">SEO Onpage</a></li>
            <li class=""><a href="#tab3">Bài viết</a></li>
		</ul>
		<div class="tab_container">
			<div id="tab1" class="tab_content pd0">
		        <div class="formRow">
					<label class="formLeft" for="name">Tên:<span class="req">*</span></label>
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
					<label class="formLeft">Hình ảnh:<span class="req">*</span></label>
					<div class="formRight">
						<div class="left">
							<input type="file" id="image" name="image">
						</div>
						<div name="image_error" class="clear error">

						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft">Ảnh kèm theo:</label>
					<div class="formRight">
						<div class="left">
							<input type="file" id="image_list" name="image_list[]" multiple="">
						</div>
						<div name="image_list_error" class="clear error">

						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="price">Giá :<span class="req">*</span></label>
					<div class="formRight">
						<span class="oneTwo">
							<?php echo form_input($price); ?>
							<img class="tipS" style="margin-bottom:-8px" src="<?php echo public_url('admin/crown/images/icons/notifications/information.png'); ?>" original-title="Giá bán sử dụng để giao dịch">
						</span>
						<span name="price_autocheck" class="autocheck"></span>
						<div name="price_error" class="clear error">
							<?php echo form_error($price["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="discount">Giảm giá (VNĐ):</label>
					<div class="formRight">
						<span>
							<?php echo form_input($discount); ?>
							<img class="tipS" style="margin-bottom:-8px" src="<?php echo public_url('admin/crown/images/icons/notifications/information.png'); ?>" original-title="Số tiền giảm giá">
						</span>
						<span name="discount_autocheck" class="autocheck"></span>
						<div name="discount_error" class="clear error">
							<?php echo form_error($discount["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="cat_id">Thể loại:<span class="req">*</span></label>
					<div class="formRight">
						<select name="cat_id" _autocheck="true" id="cat_id" class="left">
							<option value="">Lựa chọn danh mục</option>
				       		<?php if ($list_categories) : ?>
							<?php foreach ($list_categories as $category) : ?>
				            <optgroup label="<?php echo $category["name"]; ?>">
				            	<?php if ($category["child"]) : ?>
								<?php foreach ($category["child"] as $child) : ?>
			                    <option value="<?php echo $child["id"] ?>" <?php if ($child["id"] == $product["cat_id"]) : ?>selected<?php endif; ?>><?php echo $child["name"] ?></option>
			                    <?php endforeach; ?>
				        		<?php endif; ?>
				            </optgroup>
				        	<?php endforeach; ?>
				        	<?php endif; ?>
						</select>
						<span name="cat_autocheck" class="autocheck"></span>
						<div name="cat_error" class="clear error">
							<?php echo form_error("cat_id"); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="warranty">
						Bảo hành :
					</label>
					<div class="formRight">
						<span class="oneFour">
							<?php echo form_input($warranty); ?>
						</span>
						<span name="warranty_autocheck" class="autocheck"></span>
						<div name="warranty_error" class="clear error">
							<?php echo form_error($warranty["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow">
					<label class="formLeft" for="gifts">Tặng quà:</label>
					<div class="formRight">
						<span class="oneTwo">
							<?php echo form_textarea($gifts); ?>
						</span>
						<span name="sale_autocheck" class="autocheck"></span>
						<div name="sale_error" class="clear error">
							<?php echo form_error($gifts["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="formRow hide"></div>
			</div>
			<div id="tab2" class="tab_content pd0">
				<div class="formRow">
					<label class="formLeft" for="site_title">Title:</label>
					<div class="formRight">
						<span class="oneTwo">
							<?php echo form_textarea($site_title); ?>
						</span>
						<span name="site_title_autocheck" class="autocheck"></span>
						<div name="site_title_error" class="clear error">
							<?php echo form_error($site_title["name"]); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
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