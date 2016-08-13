<div class="tittle-box-center">
	<h2>Chi tiết sản phẩm</h2>
</div>
<div class="box-content-center product">
	<div class="product_view_img">
		<a href="<?php echo upload_url("product/".$product["image_link"]); ?>" class="jqzoom" rel="gal1" title="<?php echo $product["name"]; ?>">
			<img src="<?php echo upload_url("product/".$product["image_link"]); ?>" alt="<?php echo $product["name"]; ?>" style="width:280px !important">
		</a>
		<div class="clear" style="height:10px"></div>
		<div class="clearfix">
			<ul id="thumblist">
				<li>
					<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo upload_url("product/".$product["image_link"]); ?>',largeimage: '<?php echo upload_url("product/".$product["image_link"]); ?>'}">
						<img src="<?php echo upload_url("product/".$product["image_link"]); ?>">
					</a>
				</li>
			<?php if ($product["image_list"]) : ?>
				<?php $product["image_list"] = json_decode($product["image_list"], TRUE); ?>
				<?php foreach ($product["image_list"] as $image) : ?>
					<li>
						<a class="" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo upload_url("product/".$image); ?>',largeimage: '<?php echo upload_url("product/".$image); ?>'}">
							<img src="<?php echo upload_url("product/".$image); ?>">
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
			</ul>
		</div>
	</div>
	<div class="product_view_content">
		<h1><?php echo $product["name"]; ?></h1>
		<p class="option">
			Giá: <span class="product_price"><?php echo number_format($product["price"]); ?> đ</span> 
		</p>
		<p class="option">
			Danh mục: 
			<a href="<?php echo site_url("product/category/".$product["cat_id"]); ?>" title="<?php echo $product["cat_name"]; ?>">
				<b><?php echo $product["cat_name"]; ?></b>    
			</a>
		</p>
		<p class="option">Lượt xem: <b><?php echo $product["view"]; ?></b></p>
		<?php if ($product["warranty"]) : ?>
		<p class="option">Bảo hành: <b><?php echo $product["warranty"]; ?></b></p>
		<?php endif; ?>
		<?php if ($product["gifts"]) : ?>
		<p class="option">Tặng quà: <b><?php echo $product["gifts"]; ?></b></p>
		<?php endif; ?>
		<p class="option">
			Đánh giá &nbsp;
			<span class="raty_detailt" style="margin:5px" id="<?php echo $product["id"]; ?>" data-score="<?php echo $product["rate_count"] ?>"></span> 
			| Tổng số: <b class="rate_count"><?php echo $product["rate_total"] ?></b>
		</p>
		<div class="action">
			<a class="button" style="float:left;padding:8px 15px;font-size:16px" href="<?php echo site_url("cart/add/".$product["id"]); ?>" title="Mua ngay">Thêm vào giỏ hàng</a>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear" style="height:15px"></div>
	<center>
		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "19a4ed9e-bb0c-4fd0-8791-eea32fb55964", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
		<span class='st_facebook_hcount' displayText='Facebook'></span>
		<span class='st_fblike_hcount' displayText='Facebook Like'></span>
		<span class='st_googleplus_hcount' displayText='Google +'></span>
		<span class='st_twitter_hcount' displayText='Tweet'></span>
	</center>  
	<div class="clear" style="height:10px"></div>
	<table width="100%" cellspacing="0" cellpadding="3" border="0" class="tbsicons">
		<tbody>
			<tr>
				<td width="25%">
					<img alt="Phục vụ chu đáo" src="<?php echo public_url("site/images/icon-services.png"); ?>">
					<div>Phục vụ chu đáo</div>
				</td>
				<td width="25%">
					<img alt="Giao hàng đúng hẹn" src="<?php echo public_url("site/images/icon-shipping.png"); ?>">
					<div>Giao hàng đúng hẹn</div>
				</td>
				<td width="25%">
					<img alt="Đổi hàng trong 24h" src="<?php echo public_url("site/images/icon-delivery.png"); ?>">
					<div>Đổi hàng trong 24h</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="usual" id="usual1">
	<ul>
		<li><a title="Chi tiết sản phẩm" rel="tab2" href="javascript:void(0)" class="tab selected">Chi tiết sản phẩm</a></li>
		<li><a title="Video" rel="tab3" href="javascript:void(0)" class="tab">Video</a></li> 
		<li><a title="Hỏi đáp về sản phẩm" rel="tab4" href="javascript:void(0)" class="tab">Hỏi đáp về sản phẩm</a></li>         
	</ul>
</div>
<div class="usual-content">
	<div id="tab2" style="display: block;"> 
		<p><?php echo $product["content"]; ?></p>
		<center>
			<div id="fb-root"></div>
			<script src="http://connect.facebook.net/en_US/all.js#appId=170796359666689&amp;xfbml=1"></script>
			<div class="fb-comments" data-href="<?php echo site_url("product/detail/".$product["id"]); ?>" data-num-posts="5" data-width="550" data-colorscheme="light"></div>
		</center>
	</div>
	<div id="tab3" style="display: none;">
	    <div id="mediaspace" style="margin:5px;"></div>
	</div>
	<div id="tab4" style="display: none;"> 
       <div class="box-show-product">
	       <div class="comments">
				<div class="title">
					<h3>THẢO LUẬN CỦA KHÁCH HÀNG <span class="yellow">(0)</span></h3>
					<h4>Ý kiến khách hàng về sản phẩm <?php echo $product["name"]; ?></h4>
				</div>
				<br class="break">
				<div class="reviews">
	        		<div class="content"></div>
				</div>
			</div>
			<div class="clear"></div>
			<style>
			.error{
				margin:15px 0px;
			}
			</style>
			<form name="send_comment" id="show_box_comment" class="t-form form_action" method="post" action="">
			     <table width="90%" cellspacing="0" cellpadding="0" border="0" style="margin:10px auto">
			          <tbody>
			              <tr>
				              <td style="width:210px;padding-right:15px;vertical-align:top">
				                   <input type="text" style="width:200px;" class="input" id="user_name" placeholder="Họ tên" value="" name="user_name">
							       <div name="user_name_error" class="error"></div>
							       <input type="text" style="width:200px;" id="user_email" class="input" placeholder="Email" value="" name="user_email">
			                       <div name="user_email_error" class="error"></div>								   
								   <input type="text" class="input" style="width:80px;" id="security_code" placeholder="Mã xác nhận" name="security_code">
								   <div name="security_code_error" class="error"></div>
				              </td>
				              <td>
				                    <textarea id="content_comment" cols="50" rows="3" style="width:320px" class="input" placeholder="Nội dung phản hồi" name="content">	                    </textarea>
			                        <div name="content_error" class="error"></div>
			                        <input type="hidden" name="product_id" value="9">
							        <input type="hidden" name="parent_id" id="comment_parent_id" value="">
							        <input type="submit" class="button button-border medium blue f" id="" value="Gửi" name="_submit">
							        <input type="reset" class="button button-border medium red f" value="Nhập lại">
							        <div class="clear"></div>
				              </td>
			              </tr>
			          </tbody>
			     </table>
			</form>
		</div>
	</div>
</div>
<?php if ($relatest_product) : ?>
<div class="box-center">
	<div class="tittle-box-center">
		<h2>Sản phẩm cùng danh mục</h2>
	</div>
	<div class="box-content-center product">
		<?php foreach ($relatest_product as $product) : ?>
		<div class="product_item">
			<h3>
				<a href="<?php echo site_url("product/detail/".$product["id"]); ?>" title="<?php echo $product["name"]; ?>"><?php echo $product["name"]; ?></a>
			</h3>
			<div class="product_img">
				<a href="<?php echo site_url("product/detail/".$product["id"]); ?>" title="<?php echo $product["name"]; ?>">
					<img src="<?php echo upload_url("product/".$product["image_link"]); ?>" alt="<?php echo $product["name"]; ?>">
				</a>
			</div>
			<p class="price"><?php echo number_format($product["price"]); ?> đ</p>
			<center>
				<div class="raty" style="margin: 10px 0px; width: 100px;" id="<?php echo $product["id"]; ?>" data-score="<?php echo $product["rate_count"]; ?>">
			</center>
			<div class="action">
				<p style="float:left;margin-left:10px">Lượt xem: <b><?php echo $product["view"]; ?></b></p>
				<a class="button" href="#" title="Mua ngay">Mua ngay</a>
				<div class="clear"></div>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="clear"></div>
	</div>
</div>
<?php endif; ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.jqzoom').jqzoom({
            zoomType: 'standard',
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
	//raty
	$('.raty_detailt').raty({
    	  score: function() {
    	    return $(this).attr('data-score');
    	  },
    	  half    : true,
    	  click: function(score, evt) {
        	  var rate_count = $('.rate_count');
        	  var rate_count_total = rate_count.text();
    		  $.ajax({
	  				url: 'http://localhost/webphp/product/raty.html',
	  				type: 'POST',
	  				data: {'id':'9','score':score},
	  				dataType: 'json',
	  				success: function(data)
	  				{
	  					if(data.complete)
	  					{
		  					var total = parseInt(rate_count_total)+1;
	  						rate_count.html(parseInt(total));
		  				}
	  					alert(data.msg);	
	  				} 
    		  });
  		  }
      });
});
</script>
<script type='text/javascript'>
jQuery('document').ready(function(){
	 jwplayer('mediaspace').setup({
    'flashplayer': '<?php echo site_url(); ?>/public/site/tivi/player.swf',
    'file': 'https://www.youtube.com/watch?v=zAEYQ6FDO5U',
    'controlbar': 'bottom',
    'width': '560',
    'height': '315',
    'autoplay' : true
  });
})
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('a.tab').click(function(){
    var an_di=$('a.selected').attr('rel');//lấy title của thẻ <a class='active'>
    $('div#'+an_di).hide();//ẩn thẻ <div id='an_di'>
    $('a.selected').removeClass('selected');
    $(this).addClass('selected');
    var hien_thi=$(this).attr('rel');//lấy title của thẻ <a> khi ta kick vào nó
    $('div#'+hien_thi).show();//hiện lên thẻ <div id='hien_thi'>
    });
});
</script>