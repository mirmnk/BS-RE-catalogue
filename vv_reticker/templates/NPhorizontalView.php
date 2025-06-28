<?php
/**
 * Example template for phpTemplateEngine.
 *
 * Edit this template to match your needs.
 * $entry is of type tx_lib_object and represents a single data row.
 */
?>

<?php if (!defined ('TYPO3_MODE'))      die ('Access denied.'); ?>

<?php if($this->isNotEmpty()) { ?>
	<h2 class="vvreticker-np-header">%%%vvreticker_np_header%%%</h2>
        <div>
<?php } ?>
<?php for($this->rewind(); $this->valid(); $this->next()) {
     $entry = $this->current();
?>
<div class="vvreticker-np-block1"><div class="vvreticker-np-block1-inner">
<?php $entry->printNPBlock(); ?>
</div></div>
<?php } ?>
<?php if($this->isNotEmpty()) { ?>
        </div>
<?php } ?>