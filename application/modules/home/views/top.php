<script type="text/javascript">
(function($)
{
	$(document).ready(function()
	{
		$("#HomeSlide").royalSlider({
			arrowsNav:true,
			loop:false,
			keyboardNavEnabled:true,
			controlsInside:false,
			imageScaleMode:"fill",
			arrowsNavAutoHide:false,
			autoScaleSlider:true,
			autoScaleSliderWidth:580,//chiều rộng slide
			autoScaleSliderHeight:205,//chiều cao slide
			controlNavigation:"bullets",
			thumbsFitInViewport:false,
			navigateByClick:true,
			startSlideId:0,
			autoPlay:{enabled:true, stopAtAction:false, pauseOnHover:true, delay:5000},
			transitionType:"move",
			slideshowEnabled:true,
			slideshowDelay:5000,
			slideshowPauseOnHover:true,
			slideshowAutoStart:true,
			globalCaption:false
		});
	});
})(jQuery);
</script>
<style>
#HomeSlide.royalSlider {
	width: 580px;	
	height: 205px;
    overflow:hidden;
}
</style>
<?php if (isset($list_slide) && $list_slide) : ?>
<div id='slide'>
	<div id="img-slide" class="sliderContainer" style='width:580px'>
		<div id="HomeSlide" class="royalSlider rsMinW">
		<?php foreach ($list_slide as $slide) : ?>
    		<a href="<?php echo $slide["link"]; ?>" target='_blank'>
    			<img src="<?php echo upload_url("slide/".$slide["image_link"]); ?>" />
			</a>
		<?php endforeach; ?>
  		</div>
	</div>
	<div class="clear"></div>
</div>
<!-- /slide -->
<div class="clear pb20"></div>
<?php endif; ?>
<?php if (isset($latest_product) && $latest_product) : ?>
<div class="box-center">
	<div class="tittle-box-center">
		<h2>Sản phẩm mới</h2>
	</div>
	<div class="box-content-center product">
	<?php foreach ($latest_product as $product) : ?>
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
		<div class="clear"></div>
	</div>
</div>
<!-- /latest_product -->
<?php endif; ?>
<?php if (isset($best_seller_product) && $best_seller_product) : ?>
<div class="box-center">
	<div class="tittle-box-center">
		<h2>Sản phẩm bán chạy</h2>
	</div>
	<div class="box-content-center product">
	<?php foreach ($best_seller_product as $product) : ?>
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
		<div class="clear"></div>
	</div>
</div>
<!-- /best_seller_product -->
<?php endif; ?>