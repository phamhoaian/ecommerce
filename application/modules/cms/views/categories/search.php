<?php 
$attributes = array(
	'class' => 'form',
	'name' => 'filter'
);
$hidden = array(
    "boxChecked" => 0
);
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5>Danh mục</h5>
			<span>Quản lý danh mục</span>
		</div>
		<div class="horControlB menu_action">
			<ul>
				<li>
					<a href="<?php echo site_url('cms/categories/form'); ?>">
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
<div class="wrapper">
	<?php if($this->session->flashdata("message")) { ?>
	<div class="nNote nInformation hideit">
		<p>
			<strong>Thông báo: </strong>
			<?php echo $this->session->flashdata("message"); ?>
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
			<h6>Danh sách danh mục</h6>
		 	<div class="num f12">Tổng số: <b><?php echo (int) $count; ?></b></div>
		</div>
		<?php echo form_open_multipart($this->uri->uri_string(), $attributes, $hidden); ?>
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
			<thead>
				<tr>
					<td style="width:10px;"><img src="<?php echo public_url('admin/images/icons/tableArrows.png'); ?>"></td>
					<td style="width:80px;">ID</td>
					<td>Tên</td>
					<td>Danh mục cha</td>
					<td>Thứ tự hiển thị</td>
					<td style="width:100px;"></td>
				</tr>
			</thead>
			<tbody>
			<?php if ($categories) { ?>
				<?php foreach ($categories as $category) { ?>
				<tr class="row_<?php echo $category["id"]; ?>">
					<td>
						<div class="checker" id="uniform-undefined">
							<span>
								<input type="checkbox" name="id[]" value="<?php echo $category['id']; ?>" style="opacity: 0;">
							</span>
						</div>
					</td>
					<td class="textC"><?php echo $category['id']; ?></td>
					<td>
						<span class="tipS" original-title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></span>
					</td>
					<td class="textC"><?php if ($category['parent_id']) : echo $category['parent_name']; endif; ?></td>
					<td class="textC"><?php echo $category['sort_order']; ?></td>
					<td class="option">
					 	<a href="<?php echo site_url('cms/categories/form/'.$category['id']); ?>" class="tipS " original-title="Chỉnh sửa">
							<img src="<?php echo public_url('admin/images/icons/color/edit.png'); ?>">
						</a>
						<a href="<?php echo site_url('cms/categories/del/'.$category['id']); ?>" class="tipS verify_action" original-title="Xóa">
						    <img src="<?php echo public_url('admin/images/icons/color/delete.png'); ?>">
						</a>
					</td>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="10">Không có dữ liệu.</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="10">
				     	<div class="list_action itemActions">
							<a href="#submit" id="submit" class="button blueB" url="<?php echo site_url('cms/categories/del_all'); ?>">
								<span style="color:white;">Xóa hết</span>
							</a>
					 	</div>
					     <div class="pagination"><?php echo $pagination; ?></div>
					</td>
				</tr>
			</tfoot>
		</table>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- /main-content -->