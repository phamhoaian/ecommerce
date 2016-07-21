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
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/common/reset.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/common/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/common/font-awesome.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/common/animate.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/js/common/bootstrap.js"></script>
    <?php echo $css;?>
    <?php echo $js;?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php $this->load->view('parts/header');?>
    <div class="container main">
        <?php if (isset($position) and $position) { ?>
        <ul class="breadcrumb">
            <?php echo $position; ?>
        </ul>
        <?php } ?>
        <div class="main-content">
            <?php echo $main;?>
        </div>
    </div>
    <?php $this->load->view('parts/footer');?>
    <?php echo $js_foot;?>
</body>
</html>