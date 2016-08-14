<?php
$price_from = array();
$price_from_selected = '';
for ($i = 0; $i <= 10000000; $i = $i + 1000000)
{
	if (isset($price_from_value) && $price_from_value == $i) 
	{
		$price_from_selected = set_value("price_from", $price_from_value);
	}
	$price_from[$i] = number_format($i).' đ';
}
$price_to = array();
$price_to_selected = '';
for ($i = 1000000; $i <= 20000000; $i = $i + 1000000)
{
	if (isset($price_to_value) && $price_to_value == $i) 
	{
		$price_to_selected = set_value("price_to", $price_to_value);
	}
	$price_to[$i] = number_format($i).' đ';
}
?>
<div class='left'>
	<div class="box-left">
		<div class="title tittle-box-left">
			<h2> Tìm kiếm theo giá </h2>
		</div>
		<div class="content-box" >
			<form class="t-form form_action" method="get" style='padding:10px' action="<?php echo site_url("product/search_price"); ?>" name="search" >
				<div class="form-row">
					<label for="param_price_from" class="form-label" style='width:70px'>Giá từ:<span class="req">*</span></label>
					<div class="form-item"  style='width:90px'>
						<?php echo form_dropdown('price_from', $price_from, $price_from_selected, 'class="input" id="price_from"'); ?>
						<div class="clear"></div>
						<div class="error" id="price_from_error">
							<?php echo form_error('price_from'); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="form-row">
					<label for="param_price_from" class="form-label" style='width:70px'>Giá tới:<span class="req">*</span></label>
					<div class="form-item"  style='width:90px'>
						<?php echo form_dropdown('price_to', $price_to, $price_to_selected, 'class="input" id="price_to"'); ?>
						<div class="clear"></div>
						<div class="error" id="price_from_error">
							<?php echo form_error('price_to'); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="form-row">
					<label class="form-label">&nbsp;</label>
					<div class="form-item">
						<input type="submit" class="button" value="Tìm kiếm" style='height:30px !important;line-height:30px !important;padding:0px 10px !important'>
					</div>
					<div class="clear"></div>
				</div>
			</form>
		</div>
	</div>
	<div class="box-left">
		<div class="title tittle-box-left">
			<h2> Danh mục sản phẩm </h2>
		</div>
		<div class="content-box">
		<?php if (isset($list_categories) && $list_categories) : ?>
			<ul class="catalog-main">
			<?php foreach ($list_categories as $category) : ?>
				<li>
					<span>
						<a href="<?php echo site_url("product/category/".$category["id"]); ?>" title="<?php echo $category["name"]; ?>"><?php echo $category["name"]; ?></a>
					</span>
					<?php if (isset($category["sub"]) && $category["sub"]) : ?>
					<ul class="catalog-sub">
						<?php foreach ($category["sub"] as $sub) : ?>
						<li>
							<a href="<?php echo site_url("product/category/".$sub["id"]); ?>" title="<?php echo $sub["name"]; ?>"><?php echo $sub["name"]; ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>	 
		<?php endif; ?>   
		</div>
	</div>
</div>
<!-- /left -->