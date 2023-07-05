<?php
	
	use Pico\Compilation\MarkdownRenderer;
	use Pico\Data\Document;
	use Pico\Support\Config;
	
	$uri = str_replace('..', '', trim($_SERVER['REQUEST_URI'], '/'));
	$pagePath = realpath(__DIR__ . "/$uri.html");
	
	if (file_exists($pagePath))
	{
		header('Content-Type: text/html');
		header('Cache-Control: max-age=3600');
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
		readfile($pagePath);
		exit;
	}

	require_once __DIR__ . '/../vendor/autoload.php';
	
	Config::load();
	
	define('PUBLIC_PATH', __DIR__ . '/../public');

	$document = Document::load(file_get_contents(__DIR__ . '/../documents/articles/2023-07-05-test-article.md'));
	$document->resolveAuthors(Config::get('authors', []));
	$document->renderedContent = (new MarkdownRenderer())->render($document->content);
	

	ob_start();
	include __DIR__ . '/../resources/templates/minimal/template_article.php';
	$html = ob_get_clean();
	
	$outputPath = __DIR__ . "/articles/$document->slug.html";
	$dirName = dirname($outputPath);
	if (!file_exists($dirName))
		mkdir($dirName, 0777, true);
	
	file_put_contents($outputPath, $html, LOCK_EX);
