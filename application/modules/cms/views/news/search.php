<?php 
$attributes = array(
	'class' => 'form',
	'name' => 'news',
	'method' => 'get'
);
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5>Tin tức</h5>
			<span>Quản lý tin tức</span>
		</div>
		<div class="horControlB menu_action">
			<ul>
				<li>
					<a href="<?php echo site_url('cms/news/form'); ?>">
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
			<h6>Danh sách tin tức</h6>
		 	<div class="num f12">Tổng số: <b><?php echo (int) $count; ?></b></div>
		</div>
		<?php echo form_open_multipart($this->uri->uri_string(), $attributes); ?>
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
			<thead class="filter">
				<tr>
					<td colspan="6">
						<form class="list_filter form" action="index.php/admin/product.html" method="get">
							<table cellpadding="0" cellspacing="0" width="80%"><tbody>
								<tr>
									<td class="label" style="width:40px;">
										<label for="filter_id">Mã số</label>
									</td>
									<td class="item">
										<input name="id" value="<?php echo $this->input->get('id'); ?>" id="filter_id" type="text" style="width:55px;">
									</td>
									<td class="label" style="width:40px;">
										<label for="filter_id">Tiêu đề</label>
									</td>
									<td class="item" style="width:155px;">
										<input name="title" value="<?php echo $this->input->get('title'); ?>" id="filter_title" type="text" style="width:155px;">
									</td>
									<td style="width:150px">
										<input type="submit" class="button blueB" value="Lọc">
										<input type="reset" class="basic" value="Reset" onclick="window.location.href = '<?php echo site_url('cms/product'); ?>'; ">
									</td>
								</tr>
							</tbody></table>
						</form>
					</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td style="width:10px;"><img src="<?php echo public_url('admin/images/icons/tableArrows.png'); ?>"></td>
					<td style="width:80px;">Mã số</td>
					<td>Tiêu đề</td>
					<td>Ngày tạo</td>
					<td style="width:100px;"></td>
				</tr>
			</thead>
			<tbody>
			<?php if ($list_news) { ?>
				<?php foreach ($list_news as $news) { ?>
				<tr class="row_<?php echo $news["id"]; ?>">
					<td>
						<div class="checker" id="uniform-undefined">
							<span>
								<input type="checkbox" name="id[]" value="<?php echo $news['id']; ?>" style="opacity: 0;">
							</span>
						</div>
					</td>
					<td class="textC"><?php echo $news['id']; ?></td>
					<td>
						<?php if ($news['image_link']) : ?>
						<div class="image_thumb">
							<img src="<?php echo upload_url('news/'.$news['image_link']); ?>"/>
							<div class="clear"></div>
						</div>
						<?php endif; ?>
						<a href="<?php echo site_url("cms/news/form/".$news["id"]); ?>" class="tipS" original-title="<?php echo $news['title']; ?>">
							<b><?php echo $news['title']; ?></b>
						</a>
						<div class="f11">
					  		Lượt xem: <?php echo number_format($news['count_view']); ?>				
					  	</div>
					</td>
					<td class="textC"><?php echo date('d/m/Y H:i:s', strtotime($news['created'])); ?></td>
					<td class="option textC">
					 	<a href="<?php echo site_url('cms/news/form/'.$news['id']); ?>" class="tipS " original-title="Chỉnh sửa">
							<img src="<?php echo public_url('admin/images/icons/color/edit.png'); ?>">
						</a>
						<a href="<?php echo site_url('cms/news/del/'.$news['id']); ?>" class="tipS verify_action" original-title="Xóa">
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
							<a href="#submit" id="submit" class="button blueB" url="<?php echo site_url('cms/news/del_all'); ?>">
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