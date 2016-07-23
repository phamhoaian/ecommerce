<br>
<div style="text-align:center;"><?php echo $main; ?></div>
<br><br><br>

<?php if (defined('RETURN_URL')) { ?>
	<div style="text-align: center;"><a href="<?php echo RETURN_URL; ?>" class="btn btn-lg btn-success">&nbsp;戻る&nbsp;</a></div>
<?php } else { ?>
	<div style="text-align: center;"><a href="#" class="btn btn-lg btn-success" onClick="history.back(); return false;">&nbsp;戻る&nbsp;</a></div>
<?php } ?>