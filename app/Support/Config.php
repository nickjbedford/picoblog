<?php
	
	namespace Pico\Support;
	
	class Config
	{
		private static array $config = [];
		
		static function load(): void
		{
			self::$config = [];
			
			foreach(glob(__DIR__ . '/../../config/*.php') as $path)
			{
				$key = pathinfo($path, PATHINFO_FILENAME);
				$result = require $path;
				self::$config[$key] = $result;
			}
		}
		
		static function get(string $name, mixed $default = null)
		{
			$path = explode('.', $name);
			$value = self::$config;
			foreach ($path as $key)
			{
				if (!isset($value[$key]))
					return $default;
				$value = $value[$key];
			}
			return $value;
		}
	}
