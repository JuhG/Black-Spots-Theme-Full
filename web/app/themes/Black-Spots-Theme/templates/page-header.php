<?php use Roots\Sage\Titles; ?>

<?php if ( $title = Titles\title() ): ?>
	<div class="page-header">
	  <h1><?php echo $title; ?></h1>
	</div>
<?php endif ?>
