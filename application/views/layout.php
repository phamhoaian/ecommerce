<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="favicon.ico" >
    <?php
    if(isset($title) && $title)
    {
    	print "<title>{$title} - ".SITE_NAME."</title>";
    }
    else
    {
    print "<title>".SITE_NAME."</title>";
    }
    if(isset($description) && $description)
    {
    	print "\n".'<meta name="description" content="'.$description.'">';
    }
    if(isset($keywords) && $keywords)
    {
    	print "\n".'<meta name="keywords" content="'.$keywords.'">';
    }
    if( isset($og_title) && $og_title )
    {
        print "\n".'<meta property="og:title" content="'.$og_title.'">';
    }
    else if(defined('SITE_NAME') && isset($title))
    {
        print "\n".'<meta property="og:title" content="'.SITE_NAME.'">';
    }
    if(isset($og_description) && $og_description)
    {
        print "\n".'<meta property="og:description" content="'.$og_description.'">';
    }
    else if(isset($description) && $description)
    {
        print "\n".'<meta property="og:description" content="'.$description.'">';
    }
    if( isset($og_image) && $og_image )
    {
        print "\n".'<meta property="og:image" content="'.base_url().'public/images/'.$og_image.'">';
    }
    if(current_url() == base_url())
    {
        print "\n".'<meta property="og:type" content="website">'."\n";
    }
    else
    {
        print "\n".'<meta property="og:type" content="article">'."\n";
    }
    ?>
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:locale" content="en_GB" />
    <link rel="stylesheet" href="<?php echo public_url('site/css/reset.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('site/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('site/css/menu.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('site/css/input.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('site/css/product.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('site/css/slide-flim.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('js/jquery/jquery-ui/custom-theme/jquery-ui-1.8.21.custom.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('js/jquery/autocomplete/css/smoothness/jquery-ui-1.8.16.custom.css'); ?>">
    <script src="<?php echo public_url('js/jquery/jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/jquery-ui.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('site/js/script.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('site/raty/jquery.raty.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/autocomplete/jquery-ui-1.8.16.custom.min.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $.fn.raty.defaults.path = '<?php echo public_url('site/raty/img'); ?>';
                $('.raty').raty({
                    score: function() {
                    return $(this).attr('data-score');
                },
                readOnly  : true,
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#back_to_top').click(function() {
                $('html, body').animate({scrollTop:0},"slow");
           });
           // go top
           $(window).scroll(function() {
                if($(window).scrollTop() != 0) {
                    $('#back_to_top').fadeIn();
                } else {
                    $('#back_to_top').fadeOut();
                }
           });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $( "#text-search" ).autocomplete({
                source: "",
            });
        });
    </script>
    <?php echo $css;?>
    <?php echo $js;?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <a href="#" id="back_to_top">
        <img src="<?php echo public_url('site/images/top.png'); ?>" />
    </a>
    <div class="wraper">
        <?php $this->load->view('parts/header');?>
        <div id="container">
            <?php $this->load->view('parts/left-col');?>
            <div class="content"> 
                <?php if (isset($position) and $position) { ?>
                <ul class="breadcrumb">
                    <?php echo $position; ?>
                </ul>
                <?php } ?>
                <?php echo $main;?>
            </div>
            <?php $this->load->view('parts/right-col');?>
            <div class="clear"></div>
        </div>
        <?php $this->load->view('parts/footer');?>
    </div>
    <?php echo $js_foot;?>
</body>
</html>