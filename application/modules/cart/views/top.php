<style>
	table#cart {
		border-collapse: collapse;
	}
	table#cart td,
	table#cart th{
		padding: 10px;
		border: 1px solid;
	}
	table#cart input[type="text"] {
		text-align: right;
		padding: 2px;
	}
</style>
<div class="box-content">
	<div class="tittle-box-center">
		<h2>Thông tin giỏ hàng</h2>
	</div>
	<div class="box-content-center product">
	<?php if ($carts) : ?>
	<?php echo form_open("cart/update"); ?>
		<table id="cart">
			<thead>
				<tr>
					<th>STT</th>
					<th>Sản phẩm</th>
					<th>Giá bán</th>
					<th>Số lượng</th>
					<th>Thành tiền</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php $stt = 1; ?>
			<?php $total_amount = 0; ?>
			<?php foreach ($carts as $item) : ?>
				<?php $total_amount += $item["subtotal"]; ?>
				<tr>
					<td><?php echo $stt; ?></td>
					<td><?php echo $item["name"]; ?></td>
					<td><?php echo number_format($item["price"]); ?> đ</td>
					<td>
						<input type="text" name="qty_<?php echo $item["id"]; ?>" value="<?php echo $item["qty"]; ?>">
					</td>
					<td><?php echo number_format($item["subtotal"]); ?> đ</td>
					<td>
						<a href="<?php echo site_url("cart/del/".$item["rowid"]); ?>">Xóa</a>
					</td>
				</tr>
			<?php $stt++; ?>
			<?php endforeach; ?>
				<tr>
					<td colspan="6">Tổng số tiền cần thanh toán: <b style="color:red"><?php echo number_format($total_amount); ?> đ</b></td>
				</tr>
				<tr>
					<td colspan="6">
						<input type="submit" value="Cập nhật" class="button">
						<button><a href="<?php echo site_url("cart/del"); ?>">Xóa toàn bộ</a></button>
						<button><a href="<?php echo site_url("order/checkout"); ?>">Đặt hàng</a></button>
					</td>
				</tr>
			</tbody>
		</table>
	<?php echo form_close(); ?>
	<?php else : ?>
		Giỏ hàng trống.
	<?php endif; ?>
	</div>
</div>