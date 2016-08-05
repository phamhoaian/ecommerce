<?php 
$attributes = array(
	'class' => 'form',
	'name' => 'product',
	'method' => 'get'
);
?>
<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5>Sản phẩm</h5>
			<span>Quản lý sản phẩm</span>
		</div>
		<div class="horControlB menu_action">
			<ul>
				<li>
					<a href="<?php echo site_url('cms/product/form'); ?>">
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
	<div class="widget">
		<div class="title">
			<span class="titleIcon">
				<div class="checker" id="uniform-titleCheck">
					<span>
						<input type="checkbox" id="titleCheck" name="titleCheck" style="opacity: 0;">
					</span>
				</div>
			</span>
			<h6>Danh sách sản phẩm</h6>
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
										<label for="filter_id">Tên</label>
									</td>
									<td class="item" style="width:155px;">
										<input name="name" value="<?php echo $this->input->get('name'); ?>" id="filter_iname" type="text" style="width:155px;">
									</td>
									<td class="label" style="width:60px;">
										<label for="filter_status">Thể loại</label>
									</td>
									<td class="item">
										<select name="categories" style="width:150px;">
											<option value="">-- Chọn danh mục --</option>
											<?php if ($list_categories) : ?>
											<?php foreach ($list_categories as $category) : ?>
								            <optgroup label="<?php echo $category["name"]; ?>">
								            	<?php if ($category["child"]) : ?>
												<?php foreach ($category["child"] as $child) : ?>
							                    <option value="<?php echo $child["id"] ?>" <?php if ($child["id"] == $this->input->get('categories')) : ?>selected<?php endif; ?>><?php echo $child["name"] ?></option>
							                    <?php endforeach; ?>
								        		<?php endif; ?>
								            </optgroup>
								        	<?php endforeach; ?>
								        	<?php endif; ?>
										</select>
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
					<td>Tên</td>
					<td>Danh mục</td>
					<td>Giá</td>
					<td style="width:100px;"></td>
				</tr>
			</thead>
			<tbody>
			<?php if ($list_product) { ?>
				<?php foreach ($list_product as $product) { ?>
				<tr class="row_<?php echo $product["id"]; ?>">
					<td>
						<div class="checker" id="uniform-undefined">
							<span>
								<input type="checkbox" name="id[]" value="<?php echo $product['id']; ?>" style="opacity: 0;">
							</span>
						</div>
					</td>
					<td class="textC"><?php echo $product['id']; ?></td>
					<td>
						<?php if ($product['image_link']) : ?>
						<div class="image_thumb">
							<img src="<?php echo upload_url('product/'.$product['image_link']); ?>"/>
							<div class="clear"></div>
						</div>
						<?php endif; ?>
						<a href="<?php echo site_url("cms/product/form/".$product["id"]); ?>" class="tipS" original-title="<?php echo $product['name']; ?>">
							<b><?php echo $product['name']; ?></b>
						</a>
						<div class="f11">
					  		Đã bán: <?php echo number_format($product['buyed']); ?> | Xem: <?php echo number_format($product['view']); ?>				
					  	</div>
					</td>
					<td class="textC"><?php echo $product['cat_name']; ?></td>
					<td class="textR">
						<?php if ($product['discount'] > 0) : ?>
						<span><?php echo number_format($product['price'] - $product['discount']); ?> đ</span>
						<p style="text-decoration:line-through"><?php echo number_format($product['price']); ?> đ</p>
						<?php else : ?>
						<span><?php echo number_format($product['price']); ?> đ</span>
						<?php endif; ?>
					</td>
					<td class="option textC">
						<a href="" target="_blank" class="tipS" title="Xem chi tiết sản phẩm">
							<img src="<?php echo public_url('admin/images/icons/color/view.png'); ?>">
						 </a>
					 	<a href="<?php echo site_url('cms/product/form/'.$product['id']); ?>" class="tipS " original-title="Chỉnh sửa">
							<img src="<?php echo public_url('admin/images/icons/color/edit.png'); ?>">
						</a>
						<a href="<?php echo site_url('cms/product/del/'.$product['id']); ?>" class="tipS verify_action" original-title="Xóa">
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
							<a href="#submit" id="submit" class="button blueB" url="<?php echo site_url('cms/product/del_all'); ?>">
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