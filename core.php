<?php
// Environment setup
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

// Load constants
require_once(__DIR__.'/config.php');

// Autoloader
require_once(PATH_BASE.'/vendor/autoload.php');

/**
 * Format a value
 * @param  mixed $value   Value to format
 * @param  string $format Format function to apply to the value, multiple
 *                        formats can be piped together in one string
 * @return mixed          Formatted version of the input value
 */
function fmt($value, $format)
{
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
        case 'datetime': return new DateTime($value);
        case 'postlink': return preg_replace('/&gt;&gt; ?([0-9]+)/', '<a href="/forum/$1">&gt;&gt;$1</a>', $value);

        // Catch unknown formatters and assume they are date formats
        default:
            $value = new DateTime($value);
            return $value->format($format);
    }
}
