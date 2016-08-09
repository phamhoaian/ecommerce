<div class='right'>
	<div class="box-right">
	    <div class="title tittle-box-right">
	        <h2> Hỗ trợ trực tuyến </h2>
	    </div>
	    <div class="content-box">
	        <!-- goi ra phuong thuc hien thi danh sach ho tro -->
    		<div class='support'>
		        <strong>Phạm Ân</strong>				
				<a rel="nofollow" href="ymsgr:sendIM?tuyenht90">
					<img src="http://opi.yahoo.com/online?u=tuyenht90&amp;m=g&amp;t=2">
				</a>
				<p>
					<img style="margin-bottom:-3px" src="<?php echo public_url('site/images/phone.png'); ?>"> 01264244466
				</p>
				<p>
					<a rel="nofollow" href="mailto:phamhoaian005@gmail.com">
					    <img style="margin-bottom:-3px" src="<?php echo public_url('site/images/email.png'); ?>"> Email: phamhoaian005@gmail.com
					</a>
				</p>
				<p>
					<a rel="nofollow" href="skype:tuyencnt90">
				    	<img style="margin-bottom:-3px" src="<?php echo public_url('site/images/skype.png'); ?>"> Skype: pham.an91
			    	</a>
				</p>	
			</div>			        
		</div>
	</div>
	<!-- /support -->
  	<div class="box-right">
        <div class="title tittle-box-right">
	        <h2> Bài viết mới </h2>
	    </div>
	    <div class="content-box">
	    <?php if (isset($latest_news) && $latest_news) : ?>
	       	<ul class='news'>
	       	<?php foreach ($latest_news as $news) : ?>
	            <li>
	                <a href="<?php echo site_url("news/detail/".$news["id"]); ?>" title="<?php echo $news["title"]; ?>">
	                	<img src="<?php echo public_url('site/images/li.png'); ?>">
		                <?php echo $news["title"]; ?>
	                </a>
                </li>
            <?php endforeach; ?>
         	</ul>
     	<?php endif; ?>
	    </div>
   	</div>		
   	<!-- /news -->
   	<div class="box-right">
        <div class="title tittle-box-right">
	        <h2> Quảng cáo </h2>
	    </div>
	    <div class="content-box">
	        <a href="">
			     <img  src="<?php echo public_url('site/images/ads.png'); ?>">
			</a>
	    </div>
   </div>
	<!-- /ads -->
   <div class="box-right">
        <div class="title tittle-box-right">
	        <h2> Fanpage </h2>
	    </div>
	    <div class="content-box">
	         <iframe src="http://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/nobitacnt&amp;width=190&amp;height=250&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:190px; height:300px;" allowTransparency="true">
             </iframe>
           
	    </div>
   </div>
	<!-- /fanpage -->
</div>
<!-- /right -->