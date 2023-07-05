<?php
	namespace Pico\Compilation;
	
	use League\CommonMark\Exception\CommonMarkException;
	use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
	use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
	use League\CommonMark\Extension\Table\TableExtension;
	use League\CommonMark\GithubFlavoredMarkdownConverter;
	use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
	use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
	
	class MarkdownRenderer
	{
		/**
		 * @throws CommonMarkException
		 */
		function render(string $markdown): string
		{
			$converter = new GithubFlavoredMarkdownConverter();
			
			$environment = $converter->getEnvironment();
			$environment->addExtension(new TableExtension());
			//$environment->addExtension(new AutolinkExtension());
			//$environment->addExtension(new CommonMarkCoreExtension());
			$environment->addRenderer(FencedCode::class, new FencedCodeRenderer());
			$environment->addRenderer(IndentedCode::class, new IndentedCodeRenderer());
			
			return $converter->convert($markdown);
		}
	}
