<br><br><br>
<div style="text-align:center;"><?php echo $main; ?></div>
<br><br><br>

<?php if (defined('RETURN_URL')) { ?>
	<div style="text-align: center;"><a href="<?php echo RETURN_URL; ?>" class="button basic"><span>Quay lại</span></a></div>
<?php } else { ?>
	<div style="text-align: center;"><a href="#" class="button basic" onClick="history.back(); return false;"><span>Quay lại</span></a></div>
<?php } ?>