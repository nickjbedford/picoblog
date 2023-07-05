<?php
	use Pico\Support\Config;
	use Pico\Data\Document;
	
	/** @var Document $document */
	
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title><?= htmlentities($document->title) ?> &mdash; <?= Config::get('site.title') ?></title>
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link rel="stylesheet" href="/styles/templates/minimal/styles.css?ver<?= filemtime(PUBLIC_PATH . '/styles/templates/minimal/styles.css') ?>" />
	</head>
	<body>
