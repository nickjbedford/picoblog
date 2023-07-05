<?php
	
	namespace Pico\Support;
	
	use Traversable;
	
	class Arr
	{
		static function make(mixed $value, bool $emptyOnNull = true): array
		{
			if (is_array($value))
				return $value;
			
			if ($value instanceof Traversable)
				return iterator_to_array($value);
			
			if ($value === null)
				return [];
			
			return [ $value ];
		}
		
		static function naturalJoin(array $values, string $delimiter = ', ', string $finalDelimiter = ' and '): string
		{
			if (count($values) <= 2)
				return join($finalDelimiter, $values);
			
			$last = array_pop($values);
			return implode($delimiter, $values) . $finalDelimiter . $last;
		}
	}
