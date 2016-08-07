<?php 
$attributes = array(
	'class' => 'form',
	'name' => 'slide'
);
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5>Slide</h5>
			<span>Quản lý slide</span>
		</div>
		<div class="horControlB menu_action">
			<ul>
				<li>
					<a href="<?php echo site_url('cms/slide/form'); ?>">
						<img src="<?php echo public_url('admin/images/icons/control/16/add.png'); ?>">
						<span>Thêm mới</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>
<!-- /titleArea -->
<div class="line"></div>
<div class="wrapper" id="main_product">
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
		<div class="title">
			<span class="titleIcon">
				<div class="checker" id="uniform-titleCheck">
					<span>
						<input type="checkbox" id="titleCheck" name="titleCheck" style="opacity: 0;">
					</span>
				</div>
			</span>
			<h6>Danh sách slide</h6>
		 	<div class="num f12">Tổng số: <b><?php echo (int) $count; ?></b></div>
		</div>
		<?php echo form_open_multipart($this->uri->uri_string(), $attributes); ?>
		<div class="gallery">
			<?php if ($list_slide) : ?>
			<ul>
				<?php foreach ($list_slide as $slide) : ?>
				<li id="<?php echo $slide["id"]; ?>">
					<a class="lightbox cboxElement" title="<?php echo $slide["name"]; ?>" href="<?php echo upload_url('slide/'.$slide['image_link']); ?>">
				    	<img src="<?php echo upload_url('slide/'.$slide['image_link']); ?>" width="280px">
					</a>
					<div class="actions" style="display: none;">
						<a href="<?php echo site_url('cms/slide/form/'.$slide['id']); ?>" class="tipS" original-title="Chỉnh sửa">
							<img src="<?php echo public_url('admin/images/icons/color/edit.png'); ?>">
						</a>
						<a href="<?php echo site_url('cms/slide/del/'.$slide['id']); ?>" class="tipS verify_action" original-title="Xóa">
							<img src="<?php echo public_url('admin/images/icons/color/delete.png'); ?>">
						</a>
				 	</div>
				</li>
				<?php endforeach; ?>
            </ul>
        	<?php else : ?>
			<p>Không có dữ liệu.</p>
    		<?php endif; ?>
			<div class="clear" style="height:20px"></div>
        </div>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- /main-content -->