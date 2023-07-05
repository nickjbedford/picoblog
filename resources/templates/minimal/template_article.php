<?php
	use Pico\Data\Document;
	
	include __DIR__ . '/header.php';
	
	/** @var Document $document */
?>
<article>
	<h1>
		<?= htmlentities($document->title) ?>
		<?php if ($document->subtitle): ?>
			<small><?= htmlentities($document->subtitle) ?></small>
		<?php endif; ?>
	</h1>
	<div class="">
		Published on <?= $document->date->format('jS F Y \\a\\t g:i a') ?> AEST by <?= $document->getHtmlForAuthors() ?>
	</div>
	<?= $document->renderedContent ?>
</article>
<?php include __DIR__ . '/footer.php'; ?>
