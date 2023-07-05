<?php
	
	namespace Pico\Data;
	
	readonly class Author
	{
		public function __construct(
			public string $name,
			public string $role = '',
			public string $url = '')
		{
		}
		
	}
