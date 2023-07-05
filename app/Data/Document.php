<?php
	namespace Pico\Data;
	
	use Carbon\Carbon;
	use Exception;
	use Pico\Support\Arr;
	use Throwable;
	use function yaml_parse;
	
	class Document
	{
		public string $title;
		public string $subtitle = '';
		public string $excerpt = '';
		public string $content = '';
		public ?string $renderedContent = null;
		public string $slug = '';
		public Carbon $date;
		
		/** @var Author[]|string[] $authors */
		public array $authors = [];
		
		/** @var string[] $tags */
		public array $tags = [];
		
		/**
		 * @throws Exception
		 */
		static function load(string $fileContents): self
		{
			$fileContents = str_replace("\r\n", "\n", $fileContents);
			$parts = explode("---\n", $fileContents, 3);
			if (trim($parts[0]) == '')
			{
				unset($parts[0]);
				$parts = array_values($parts);
			}
			
			if (count($parts) !== 2)
				throw new Exception('Document does not contain necessary sections.');
			
			$document = new self();
			$document->content = trim($parts[1]);
			$document->parseMetadata($document, $parts[0]);
			return $document;
		}
		
		private function parseMetadata(Document $document, string $yaml): void
		{
			try
			{
				$meta = yaml_parse($yaml);
				$document->title = $meta['title'];
				$document->authors = Arr::make($meta['authors'] ?? []);
				$document->tags = Arr::make($meta['tags'] ?? []);
				$document->slug = $meta['slug'] ?? '';
				$document->excerpt = $meta['excerpt'] ?? '';
				$document->subtitle = $meta['subtitle'] ?? '';
				$document->date = Carbon::parse($meta['date'] ?? 'now');
			}
			catch(Throwable $exception)
			{
				throw $exception;
			}
		}
		
		/**
		 * @param Author[]|string[] $authors
		 * @return void
		 */
		function resolveAuthors(array $authors): void
		{
			$this->authors = array_map(function($author)
			{
				if (isset($authors[$author]))
					$author = $authors[$author];
				
				if (!($author instanceof Author))
					return new Author($author);
				
				return $author;
			}, $authors);
		}
		
		function getHtmlForAuthors(): string
		{
			return Arr::naturalJoin(array_map(function(Author $author)
			{
				$nameEscaped = htmlentities($author->name);
				
				if ($author->role)
				{
					$parts = [ $nameEscaped, htmlentities($author->role) ];
					$title = 'title="' . join(' &mdash; ', $parts) . '"';
				}
				else
					$title = '';
				
				if ($author->url)
					return "<a href=\"$author->url\" target=\"_blank\" $title>$nameEscaped</a>";
				
				return $nameEscaped;
			}, $this->authors));
		}
	}
