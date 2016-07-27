<?php 
$attributes = array(
	'class' => 'form',
	'name' => 'filter'
);
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5>Thành viên</h5>
			<span>Quản lý thành viên</span>
		</div>
		<div class="horControlB menu_action">
			<ul>
				<li>
					<a href="<?php echo site_url('cms/user/form'); ?>">
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
	<div class="alert alert-success">
		<?php echo $this->session->flashdata("message"); ?>
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
			<h6>Danh sách Thành viên</h6>
		 	<div class="num f12">Tổng số: <b><?php echo (int) $count; ?></b></div>
		</div>
		<?php echo form_open_multipart($this->uri->uri_string(), $attributes); ?>
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
			<thead>
				<tr>
					<td style="width:10px;"><img src="<?php echo public_url('admin/images/icons/tableArrows.png'); ?>"></td>
					<td style="width:80px;">ID</td>
					<td>Tên</td>
					<td>Email</td>
					<td>Điện thoại</td>
					<td style="width:100px;"></td>
				</tr>
			</thead>
			<tbody>
			<?php if ($list_user) { ?>
				<?php foreach ($list_user as $user) { ?>
				<tr class="row_<?php echo $user["id"]; ?>">
					<td>
						<div class="checker" id="uniform-undefined">
							<span>
								<input type="checkbox" name="id[]" value="<?php echo $user['id']; ?>" style="opacity: 0;">
							</span>
						</div>
					</td>
					<td class="textC"><?php echo $user['id']; ?></td>
					<td>
						<span class="tipS" original-title="<?php echo $user['username']; ?>"><?php echo $user['username']; ?></span>
					</td>
					<td>
						<span class="tipS" original-title="<?php echo $user['email']; ?>"><?php echo $user['email']; ?></span>
					</td>
					<td><?php echo $user['phone']; ?></td>
					<td class="option">
					 	<a href="<?php echo site_url('cms/user/form/'.$user['id']); ?>" class="tipS " original-title="Chỉnh sửa">
							<img src="<?php echo public_url('admin/images/icons/color/edit.png'); ?>">
						</a>
						<a href="<?php echo site_url('cms/user/del/'.$user['id']); ?>" class="tipS verify_action" original-title="Xóa">
						    <img src="<?php echo public_url('admin/images/icons/color/delete.png'); ?>">
						</a>
					</td>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="7">Không có dữ liệu.</td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
				     	<div class="list_action itemActions">
							<a href="#submit" id="submit" class="button blueB" url="<?php echo site_url('cms/user/del_all'); ?>">
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