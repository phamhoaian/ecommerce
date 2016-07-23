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
    ?>
    <link rel="stylesheet" href="<?php echo public_url('admin/crown/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('admin/css/css.css'); ?>">
    <link rel="stylesheet" href="<?php echo public_url('js/jquery/colorbox/colorbox.css'); ?>">
    <script src="<?php echo public_url('js/jquery/jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/jquery-ui.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/spinner/jquery.mousewheel.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/forms/uniform.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/forms/jquery.tagsinput.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/forms/autogrowtextarea.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/forms/jquery.maskedinput.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/forms/jquery.inputlimiter.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/tables/datatable.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/tables/tablesort.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/tables/resizable.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.tipsy.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.collapsible.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.progress.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.timeentry.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.colorpicker.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.jgrowl.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.breadcrumbs.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/plugins/ui/jquery.sourcerer.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('admin/crown/js/custom.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/chosen/chosen.jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/scrollTo/jquery.scrollTo.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/number/jquery.number.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/zclip/jquery.zclip.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/formatCurrency/jquery.formatCurrency-1.4.0.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/jquery/colorbox/jquery.colorbox.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo public_url('js/custom_admin.js'); ?>" type="text/javascript"></script>
    <?php echo $css;?>
    <?php echo $js;?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nobg loginPage" style="min-height:100%;">
    <div class="wraper">
        <?php echo $main;?>
    </div>
    <?php echo $js_foot;?>
</body>
</html>