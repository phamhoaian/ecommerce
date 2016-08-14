<div class="tittle-box-center">
<?php if (isset($keyword)) : ?>
	<h2>Kết quả tìm kiếm sản phẩm theo từ khóa "<?php echo $keyword; ?>"</h2>
<?php else : ?>
	<h2>Kết quả tìm kiếm sản phẩm theo giá từ <span style="color:red"><?php echo $price_from_value; ?> đ</span> đến <span style="color:red"><?php echo $price_to_value; ?> đ</span></h2>
<?php endif; ?>
</div>
<?php if ($list_product) : ?>
<div class="product">
	<?php foreach ($list_product as $product) : ?>
	<div class="product_item">
		<h3>
			<a href="<?php echo site_url("product/detail/".$product["id"]); ?>" title="<?php echo $product["name"]; ?>"><?php echo $product["name"]; ?></a>
		</h3>
		<div class="product_img">
			<a href="<?php echo site_url("product/detail/".$product["id"]); ?>" title="<?php echo $product["name"]; ?>">
				<img src="<?php echo upload_url("product/".$product["image_link"]); ?>" alt="<?php echo $product["name"]; ?>">
			</a>
		</div>
		<p class="price">
			<?php if ($product['discount'] > 0) : ?>
			<span><?php echo number_format($product['price'] - $product['discount']); ?> đ</span>
			<span class="price_old"><?php echo number_format($product['price']); ?> đ</span>
			<?php else : ?>
			<span><?php echo number_format($product['price']); ?> đ</span>
			<?php endif; ?>
		</p>
		<center>
			<div class='raty' style='margin:10px 0px' id='9' data-score='4'></div>
		</center>
		<div class="action">
			<p style="float:left;margin-left:10px">Lượt xem: <b><?php echo number_format($product["view"]); ?></b></p>
			<a class="button" href="<?php echo site_url("cart/add/".$product["id"]); ?>" title="Mua ngay">Mua ngay</a>
			<div class="clear"></div>
		</div>
	</div>
	<?php endforeach; ?>
</div>
<div class="clear"></div>
<div class="pagination"><?php echo $pagination; ?></div>
<?php else : ?>
<p>Không có sản phẩm nào.</p>
<?php endif; ?>