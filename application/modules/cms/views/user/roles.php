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
			<h5>Nhóm quản trị</h5>
			<span>Quản lý thành viên</span>
		</div>
		<div class="horControlB menu_action">
			<ul>
				<li>
					<a href="<?php echo site_url('cms/user/form_role'); ?>">
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
			<h6>Danh sách nhóm quản trị</h6>
		 	<div class="num f12">Tổng số: <b><?php echo (int) $count; ?></b></div>
		</div>
		<?php echo form_open_multipart($this->uri->uri_string(), $attributes, $hidden); ?>
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
			<thead>
				<tr>
					<td style="width:10px;"><img src="<?php echo public_url('admin/images/icons/tableArrows.png'); ?>"></td>
					<td style="width:80px;">ID</td>
					<td>Tên nhóm</td>
					<td>Nhóm cha</td>
					<td style="width:100px;"></td>
				</tr>
			</thead>
			<tbody>
			<?php if ($list_roles) { ?>
				<?php foreach ($list_roles as $role) { ?>
				<tr class="row_<?php echo $role["id"]; ?>">
					<td>
						<div class="checker" id="uniform-undefined">
							<span>
								<input type="checkbox" name="id[]" value="<?php echo $role['id']; ?>">
							</span>
						</div>
					</td>
					<td class="textC"><?php echo $role['id']; ?></td>
					<td>
						<span class="tipS" original-title="<?php echo $role['name']; ?>"><?php echo $role['name']; ?></span>
					</td>
					<td>
						<?php if ( $role["parent_id"] ) : ?>
						<span class="tipS" original-title="<?php echo $role['parent_id']; ?>"><?php echo $role['parent_id']; ?></span>
						<?php endif; ?>
					</td>
					<td class="option">
					 	<a href="<?php echo site_url('cms/user/form_role/'.$role['id']); ?>" class="tipS " original-title="Chỉnh sửa">
							<img src="<?php echo public_url('admin/images/icons/color/edit.png'); ?>">
						</a>
						<a href="<?php echo site_url('cms/user/del_role/'.$role['id']); ?>" class="tipS verify_action" original-title="Xóa">
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
							<a href="#submit" id="submit" class="button blueB" url="<?php echo site_url('cms/user/del_role_all'); ?>">
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