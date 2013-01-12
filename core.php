<?php
namespace ComicRank;

// Environment setup
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

// Load constants
require_once(__DIR__.'/config.php');

// Autoloader for ComicRank classes
spl_autoload_register(function ($classname) {
	$classname = strtolower($classname);
	if (substr($classname, 0, 10) == 'comicrank\\') {
		include(PATH_BASE.'/'.str_replace('\\', '/', substr($classname, 10)).'.php');
	}
});

/**
 * Lazy-connect to the database and return handle
 * @return PDO Handle to the MySQL database
 */
function dbHandle() {
	static $h;
	
	if (!$h) {
		$h = new \PDO(
			'mysql:dbname='.MYSQL_DATABASE.';host='.MYSQL_HOST,
			MYSQL_USER,
			MYSQL_PASSWORD,
			array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
		);
		$h->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);  
	}
	
	return $h;
}

/**
 * Prepare and execute an SQL statement on the database
 * @param  string       $sql  SQL to run
 * @param  mixed[mixed] $bind Input parameters to bind to the SQL
 * @return PDOStatement       Pre-executed PDO statement
 */
function dbQuery($sql, Array $bind=null) {
	$h = dbHandle();
	$s = $h->prepare($sql);
	$s->execute($bind);
	return $s;
}

/**
 * Format a value
 * @param  mixed $value   Value to format
 * @param  string $format Format function to apply to the value, multiple
 *                        formats can be piped together in one string
 * @return mixed          Formatted version of the input value
 */
function fmt($value, $format) {
	// Allow unix-like piping of multiple formatters
	if (strpos($format, '|')) {
		$formats = explode('|', $format);
		foreach ($formats as $format) {
			$value = fmt($value, $format);
		}
		return $value;
	}
	
	// Allow a single variable to be given to the formatter
	$extra = false;
	if (strpos($format, ':')) {
		list($format, $extra) = explode(':', $format, 2);
	}
	
	switch ($format) {
		case 'raw': return $value;
		case 'html': return htmlspecialchars($value);
		case 'url': return urlencode($value);
		case 'int': return (int) $value;
		case 'double': return (double) $value;
		case 'currency': return ($extra?$extra:'').number_format($value);
		case 'posessive': return $value.'’'.(substr($value, -1)=='s'?'':'s');
		
		// Catch unknown formatters and assume they are date formats
		default:
			if (!is_numeric($value)) $value = strtotime($value);
			return date($format, $value);
	}
}
