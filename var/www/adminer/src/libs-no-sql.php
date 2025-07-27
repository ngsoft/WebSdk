<?php
/**
 * PHP Dev Tools
 * @author Aymeric Anger
 * @version 25.07.13 build on 2025-07-26
 * @noinspection ALL
 */
namespace {

/**
 * Here we load config for every projects
 */
@date_default_timezone_set('Europe/Paris');
@mb_internal_encoding('UTF-8');

}
namespace {

/**
 * Here are some functions from symfony/polyfill-php7* and symfony/polyfill-php8*
 */

if (PHP_VERSION_ID < 70100) {
    if (!function_exists('is_iterable')) {
        function is_iterable($var)
        {
            return is_array($var) || $var instanceof Traversable;
        }
    }
}

if (PHP_VERSION_ID < 70300) {

    if (!class_exists('JsonException', false)) {
        class JsonException extends Exception
        {
        }
    }


    if (!function_exists('hrtime')) {

        $startAt = (int)microtime(true);
        function hrtime($asNum = false)
        {
            global $startAt;

            $ns = microtime(false);
            $s = substr($ns, 11) - $startAt;
            $ns = 1E9 * (float)$ns;

            if ($asNum) {
                $ns += $s * 1E9;

                return PHP_INT_SIZE === 4 ? $ns : (int)$ns;
            }

            return [$s, (int)$ns];
        }
    }


    if (!function_exists('is_countable')) {
        function is_countable($value)
        {
            return is_array($value) || $value instanceof Countable || $value instanceof ResourceBundle || $value instanceof SimpleXmlElement;
        }
    }

    if (!function_exists('array_key_first')) {
        function array_key_first(array $array)
        {
            foreach ($array as $key => $value) {
                return $key;
            }
            return null;
        }
    }
    if (!function_exists('array_key_last')) {
        function array_key_last(array $array)
        {
            return key(array_slice($array, -1, 1, true));
        }
    }

}


if (PHP_VERSION_ID < 70400) {
    if (!function_exists('mb_str_split')) {
        function mb_str_split($string, $split_length = 1, $encoding = null)
        {
            if (null !== $string && !is_scalar($string) && !(is_object($string) && method_exists($string, '__toString'))) {
                trigger_error('mb_str_split() expects parameter 1 to be string, ' . gettype($string) . ' given', E_USER_WARNING);

                return null;
            }

            if (1 > $split_length = (int)$split_length) {
                trigger_error('The length of each segment must be greater than zero', E_USER_WARNING);

                return false;
            }

            if (null === $encoding) {
                $encoding = mb_internal_encoding();
            }

            if ('UTF-8' === $encoding || in_array(strtoupper($encoding), ['UTF-8', 'UTF8'], true)) {
                return preg_split("/(.{{$split_length}})/u", $string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            }

            $result = [];
            $length = mb_strlen($string, $encoding);

            for ($i = 0; $i < $length; $i += $split_length) {
                $result[] = mb_substr($string, $i, $split_length, $encoding);
            }

            return $result;
        }

    }
}


if (PHP_VERSION_ID < 80000) {

    if (!interface_exists("Stringable", false)) {
        interface Stringable
        {
            /**
             * @return string
             */
            public function __toString();
        }
    }

    if (PHP_VERSION_ID < 70000) {

        /**
         * Add compatibility php 5
         */
        if (!interface_exists('Throwable', false)) {
            interface Throwable extends Stringable
            {
            }


        }

        if (!class_exists('Error', false)) {
            class Error extends RuntimeException implements Throwable
            {
            }
        }

    }
    if (!class_exists("ValueError", false)) {
        class ValueError extends Error
        {
        }
    }


    if (!function_exists('get_debug_type')) {

        /**
         * @param mixed $value
         * @return string
         */
        function get_debug_type($value)
        {
            switch (true) {
                case null === $value:
                    return 'null';
                case is_bool($value):
                    return 'bool';
                case is_string($value):
                    return 'string';
                case is_array($value):
                    return 'array';
                case is_int($value):
                    return 'int';
                case is_float($value):
                    return 'float';
                case is_object($value):
                    break;
                case $value instanceof __PHP_Incomplete_Class:
                    return '__PHP_Incomplete_Class';
                default:
                    if (null === $type = @get_resource_type($value)) {
                        return 'unknown';
                    }

                    if ('Unknown' === $type) {
                        $type = 'closed';
                    }

                    return "resource ($type)";
            }

            $class = get_class($value);

            if (false === strpos($class, '@')) {
                return $class;
            }

            return (get_parent_class($class) ?: key(class_implements($class)) ?: 'class') . '@anonymous';
        }
    }

    if (!function_exists('str_contains')) {
        /**
         * @param string $haystack
         * @param string $needle
         * @return bool
         */

        function str_contains($haystack, $needle)
        {
            return '' === $needle || false !== strpos($haystack, $needle);
        }
    }
    if (!function_exists('str_starts_with')) {
        /**
         * @param string $haystack
         * @param string $needle
         * @return bool
         */
        function str_starts_with($haystack, $needle)
        {
            return 0 === strncmp($haystack, $needle, strlen($needle));
        }
    }
    if (!function_exists('str_ends_with')) {

        /**
         * @param string $haystack
         * @param string $needle
         * @return bool
         */
        function str_ends_with($haystack, $needle)
        {
            if ('' === $needle || $needle === $haystack) {
                return true;
            }

            if ('' === $haystack) {
                return false;
            }

            $needleLength = strlen($needle);

            return $needleLength <= strlen($haystack) && 0 === substr_compare($haystack, $needle, -$needleLength);
        }
    }
}

if (PHP_VERSION_ID < 80100) {

    if (!function_exists('array_is_list')) {

        /**
         * @param array $array
         * @return bool
         */
        function array_is_list(array $array)
        {
            if ([] === $array || $array === array_values($array)) {
                return true;
            }

            $nextKey = -1;

            foreach ($array as $k => $v) {
                if ($k !== ++$nextKey) {
                    return false;
                }
            }

            return true;
        }
    }
}

}
namespace {

/**
 * Here are some functions from symfony/polyfill-php8[3-4]
 */

if (PHP_VERSION_ID < 80300) {
    if (!function_exists('json_validate')) {
        /**
         * @param string $json
         * @param int $depth
         * @param int $flags
         * @return bool
         */
        function json_validate($json, $depth = 512, $flags = 0)
        {
            if (0 !== $flags && defined('JSON_INVALID_UTF8_IGNORE') && JSON_INVALID_UTF8_IGNORE !== $flags) {
                throw new ValueError('json_validate(): Argument #3 ($flags) must be a valid flag (allowed flags: JSON_INVALID_UTF8_IGNORE)');
            }

            if ($depth <= 0) {
                throw new ValueError('json_validate(): Argument #2 ($depth) must be greater than 0');
            }

            if ($depth > 0x7FFFFFFF) {
                throw new ValueError(sprintf('json_validate(): Argument #2 ($depth) must be less than %d', 0x7FFFFFFF));
            }

            json_decode($json, null, $depth, $flags);

            return JSON_ERROR_NONE === json_last_error();
        }
    }

    if (!function_exists('mb_str_pad')) {

        /**
         * @param string $string
         * @param int $length
         * @param string $pad_string
         * @param int $pad_type
         * @param string|null $encoding
         * @return string
         */
        function mb_str_pad($string, $length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = null)
        {
            if (!in_array($pad_type, [STR_PAD_RIGHT, STR_PAD_LEFT, STR_PAD_BOTH], true)) {
                throw new ValueError('mb_str_pad(): Argument #4 ($pad_type) must be STR_PAD_LEFT, STR_PAD_RIGHT, or STR_PAD_BOTH');
            }

            if (null === $encoding) {
                $encoding = mb_internal_encoding();
            }

            try {
                $validEncoding = @mb_check_encoding('', $encoding);
            } catch (ValueError $e) {
                throw new ValueError(sprintf('mb_str_pad(): Argument #5 ($encoding) must be a valid encoding, "%s" given', $encoding));
            }

            // BC for PHP 7.3 and lower
            if (!$validEncoding) {
                throw new ValueError(sprintf('mb_str_pad(): Argument #5 ($encoding) must be a valid encoding, "%s" given', $encoding));
            }

            if (mb_strlen($pad_string, $encoding) <= 0) {
                throw new ValueError('mb_str_pad(): Argument #3 ($pad_string) must be a non-empty string');
            }

            $paddingRequired = $length - mb_strlen($string, $encoding);

            if ($paddingRequired < 1) {
                return $string;
            }

            switch ($pad_type) {
                case STR_PAD_LEFT:
                    return mb_substr(str_repeat($pad_string, $paddingRequired), 0, $paddingRequired, $encoding) . $string;
                case STR_PAD_RIGHT:
                    return $string . mb_substr(str_repeat($pad_string, $paddingRequired), 0, $paddingRequired, $encoding);
                default:
                    $leftPaddingLength = floor($paddingRequired / 2);
                    $rightPaddingLength = $paddingRequired - $leftPaddingLength;

                    return mb_substr(str_repeat($pad_string, $leftPaddingLength), 0, $leftPaddingLength, $encoding) . $string . mb_substr(str_repeat($pad_string, $rightPaddingLength), 0, $rightPaddingLength, $encoding);
            }
        }
    }
    if (!function_exists('str_increment')) {
        /**
         * @param string $string
         * @return string
         */
        function str_increment($string)
        {
            if ('' === $string) {
                throw new ValueError('str_increment(): Argument #1 ($string) cannot be empty');
            }

            if (!preg_match('/^[a-zA-Z0-9]+$/', $string)) {
                throw new ValueError('str_increment(): Argument #1 ($string) must be composed only of alphanumeric ASCII characters');
            }

            if (is_numeric($string)) {
                $offset = stripos($string, 'e');
                if (false !== $offset) {
                    $char = $string[$offset];
                    ++$char;
                    $string[$offset] = $char;
                    ++$string;

                    switch ($string[$offset]) {
                        case 'f':
                            $string[$offset] = 'e';
                            break;
                        case 'F':
                            $string[$offset] = 'E';
                            break;
                        case 'g':
                            $string[$offset] = 'f';
                            break;
                        case 'G':
                            $string[$offset] = 'F';
                            break;
                    }

                    return $string;
                }
            }

            return ++$string;
        }
    }
    if (!function_exists('str_decrement')) {
        /**
         * @param string $string
         * @return string
         */
        function str_decrement($string)
        {
            if ('' === $string) {
                throw new ValueError('str_decrement(): Argument #1 ($string) cannot be empty');
            }

            if (!preg_match('/^[a-zA-Z0-9]+$/', $string)) {
                throw new ValueError('str_decrement(): Argument #1 ($string) must be composed only of alphanumeric ASCII characters');
            }

            if (preg_match('/\A(?:0[aA0]?|[aA])\z/', $string)) {
                throw new ValueError(sprintf('str_decrement(): Argument #1 ($string) "%s" is out of decrement range', $string));
            }

            if (!in_array(substr($string, -1), ['A', 'a', '0'], true)) {
                return implode('', array_slice(str_split($string), 0, -1)) . chr(ord(substr($string, -1)) - 1);
            }

            $carry = '';
            $decremented = '';

            for ($i = strlen($string) - 1; $i >= 0; --$i) {
                $char = $string[$i];

                switch ($char) {
                    case 'A':
                        if ('' !== $carry) {
                            $decremented = $carry . $decremented;
                            $carry = '';
                        }
                        $carry = 'Z';

                        break;
                    case 'a':
                        if ('' !== $carry) {
                            $decremented = $carry . $decremented;
                            $carry = '';
                        }
                        $carry = 'z';

                        break;
                    case '0':
                        if ('' !== $carry) {
                            $decremented = $carry . $decremented;
                            $carry = '';
                        }
                        $carry = '9';

                        break;
                    case '1':
                        if ('' !== $carry) {
                            $decremented = $carry . $decremented;
                            $carry = '';
                        }

                        break;
                    default:
                        if ('' !== $carry) {
                            $decremented = $carry . $decremented;
                            $carry = '';
                        }

                        if (!in_array($char, ['A', 'a', '0'], true)) {
                            $decremented = chr(ord($char) - 1) . $decremented;
                        }
                }
            }

            return $decremented;
        }
    }
}

if (PHP_VERSION_ID < 80400) {
    if (!function_exists('array_find')) {
        /**
         * @param array $array
         * @param callable $callback
         * @return mixed
         */
        function array_find(array $array, callable $callback)
        {
            foreach ($array as $key => $value) {
                if ($callback($value, $key)) {
                    return $value;
                }
            }

            return null;
        }
    }

    if (!function_exists('array_find_key')) {
        /**
         * @param array $array
         * @param callable $callback
         * @return int|string|null
         */
        function array_find_key(array $array, callable $callback)
        {
            foreach ($array as $key => $value) {
                if ($callback($value, $key)) {
                    return $key;
                }
            }

            return null;
        }
    }

    if (!function_exists('array_any')) {
        /**
         * @param array $array
         * @param callable $callback
         * @return bool
         */
        function array_any(array $array, callable $callback)
        {
            if (count($array)) {
                foreach ($array as $key => $value) {
                    if ($callback($value, $key)) {
                        return true;
                    }
                }
            }


            return false;
        }
    }

    if (!function_exists('array_all')) {
        /**
         * @param array $array
         * @param callable $callback
         * @return bool
         */
        function array_all(array $array, callable $callback)
        {
            foreach ($array as $key => $value) {
                if (!$callback($value, $key)) {
                    return false;
                }
            }

            return true;
        }
    }
    if (!function_exists('mb_ucfirst')) {
        /**
         * @param string $string
         * @param string|null $encoding
         * @return string
         */
        function mb_ucfirst($string, $encoding = null)
        {
            if (null === $encoding) {
                $encoding = mb_internal_encoding();
            }

            try {
                $validEncoding = @mb_check_encoding('', $encoding);
            } catch (ValueError $e) {
                throw new ValueError(sprintf('mb_ucfirst(): Argument #2 ($encoding) must be a valid encoding, "%s" given', $encoding));
            }

            // BC for PHP 7.3 and lower
            if (!$validEncoding) {
                throw new ValueError(sprintf('mb_ucfirst(): Argument #2 ($encoding) must be a valid encoding, "%s" given', $encoding));
            }

            $firstChar = mb_substr($string, 0, 1, $encoding);
            $firstChar = mb_convert_case($firstChar, MB_CASE_TITLE, $encoding);

            return $firstChar . mb_substr($string, 1, null, $encoding);
        }
    }

    if (!function_exists('mb_lcfirst')) {
        /**
         * @param string $string
         * @param string|null $encoding
         * @return string
         */
        function mb_lcfirst($string, $encoding = null)
        {
            if (null === $encoding) {
                $encoding = mb_internal_encoding();
            }

            try {
                $validEncoding = @mb_check_encoding('', $encoding);
            } catch (ValueError $e) {
                throw new ValueError(sprintf('mb_lcfirst(): Argument #2 ($encoding) must be a valid encoding, "%s" given', $encoding));
            }

            // BC for PHP 7.3 and lower
            if (!$validEncoding) {
                throw new ValueError(sprintf('mb_lcfirst(): Argument #2 ($encoding) must be a valid encoding, "%s" given', $encoding));
            }

            $firstChar = mb_substr($string, 0, 1, $encoding);
            $firstChar = mb_convert_case($firstChar, MB_CASE_LOWER, $encoding);

            return $firstChar . mb_substr($string, 1, null, $encoding);
        }
    }

    /**
     * @param string $regex
     * @param string $string
     * @param string|null $characters
     * @param string|null $encoding
     * @param string $function
     * @return string
     */
    $mb_internal_trim = function ($regex, $string, $characters, $encoding, $function) {
        if (null === $encoding) {
            $encoding = mb_internal_encoding();
        }

        try {
            $validEncoding = @mb_check_encoding('', $encoding);
        } catch (ValueError $e) {
            throw new ValueError(sprintf('%s(): Argument #3 ($encoding) must be a valid encoding, "%s" given', $function, $encoding));
        }

        // BC for PHP 7.3 and lower
        if (!$validEncoding) {
            throw new ValueError(sprintf('%s(): Argument #3 ($encoding) must be a valid encoding, "%s" given', $function, $encoding));
        }

        if ('' === $characters) {
            return null === $encoding ? $string : mb_convert_encoding($string, $encoding);
        }

        if ('UTF-8' === $encoding || in_array(strtolower($encoding), ['utf-8', 'utf8'], true)) {
            $encoding = 'UTF-8';
        }

        $string = mb_convert_encoding($string, 'UTF-8', $encoding);

        if (null !== $characters) {
            $characters = mb_convert_encoding($characters, 'UTF-8', $encoding);
        }

        if (null === $characters) {
            $characters = "\\0 \f\n\r\t\v\u{00A0}\u{1680}\u{2000}\u{2001}\u{2002}\u{2003}\u{2004}\u{2005}\u{2006}\u{2007}\u{2008}\u{2009}\u{200A}\u{2028}\u{2029}\u{202F}\u{205F}\u{3000}\u{0085}\u{180E}";
        } else {
            $characters = preg_quote($characters);
        }

        $string = preg_replace(sprintf($regex, $characters), '', $string);

        if ('UTF-8' === $encoding) {
            return $string;
        }

        return mb_convert_encoding($string, $encoding, 'UTF-8');
    };

    if (!function_exists('mb_trim')) {
        /**
         * @param string $string
         * @param string|null $characters
         * @param string|null $encoding
         * @return string
         */
        function mb_trim($string, $characters = null, $encoding = null)
        {
            global $mb_internal_trim;
            return $mb_internal_trim('{^[%s]+|[%1$s]+$}Du', $string, $characters, $encoding, __FUNCTION__);
        }
    }

    if (!function_exists('mb_ltrim')) {
        /**
         * @param string $string
         * @param string|null $characters
         * @param string|null $encoding
         * @return string
         */
        function mb_ltrim($string, $characters = null, $encoding = null)
        {
            global $mb_internal_trim;
            return $mb_internal_trim('{^[%s]+}Du', $string, $characters, $encoding, __FUNCTION__);
        }
    }

    if (!function_exists('mb_rtrim')) {
        /**
         * @param string $string
         * @param string|null $characters
         * @param string|null $encoding
         * @return string
         */
        function mb_rtrim($string, $characters = null, $encoding = null)
        {
            global $mb_internal_trim;
            return $mb_internal_trim('{[%s]+$}Du', $string, $characters, $encoding, __FUNCTION__);
        }
    }
}


if (PHP_VERSION_ID < 80500) {

    if (!function_exists('get_error_handler')) {
        /**
         * @return ?callable
         */
        function get_error_handler()
        {
            $handler = set_error_handler(null);
            restore_error_handler();
            return $handler;
        }
    }

    if (!function_exists('get_exception_handler')) {
        /**
         * @return ?callable
         */
        function get_exception_handler()
        {
            $handler = set_exception_handler(null);
            restore_exception_handler();
            return $handler;
        }
    }

}

}
namespace {

/**
 * @param string $namespace
 * @param string $path
 * @param string $extension
 * @return void
 */
function autoload_register_namespace($namespace, $path, $extension = '.php')
{
    static $sep = '\\', $pSep = '/';
    $normalizedPath = rtrim(str_replace($sep, $pSep, $path), $pSep) . $pSep;
    $normalizedNamespace = rtrim($namespace, '\\');
    $extension = "." . ltrim($extension, '.');
    $len = strlen($normalizedNamespace);


    spl_autoload_register(function ($className) use ($normalizedNamespace, $normalizedPath, $extension, $len, $sep, $pSep) {
        if ($normalizedNamespace === substr($className, 0, $len)) {
            $filename = str_replace($sep, $pSep, substr($className, $len)) . $extension;
            require_secure($normalizedPath . $filename);
        }
    });
}

if (!function_exists('renderArgs')) {

    /**
     * Renders arguments as `$prefix.$key="$value"`.
     * Also encodes values to string if a value is null or boolean false, it will not be rendered
     * replaces `myArg => true` to `my-arg` and `myArg => true` to ``.
     *
     * @param iterable $arguments
     * @param string $prefix
     *
     * @return string
     *
     * @throws InvalidArgumentException if one of the arguments is invalid
     *
     * @author Aymeric Anger
     *
     * @example renderArgs(['checked'=>$cond, 'selected'=>$cond]) where $cond is a boolean
     * @example renderArgs(['value'=> "value", "data"=>["jsValue"=>10]]) => `value="value" data-js-value="10"`
     * @example renderArgs(["jsValue"=>10], "data-") => `data-js-value="10"`
     *
     */
    function renderArgs($arguments, $prefix = '')
    {
        $result = [];

        if (!is_string($prefix)) {
            throw new InvalidArgumentException('$prefix is not a string');
        }

        // is_iterable() for php < 7.1
        if (!is_iterable($arguments)) {
            throw new InvalidArgumentException('$arguments is not iterable');
        }

        foreach ($arguments as $key => $value) {
            if (false === $value || null === $value) {
                continue;
            }

            // dataset helper
            if ('data' === $key && (is_array($value) || $value instanceof Traversable)) {
                if ($tmp = renderArgs($value, 'data-')) {
                    $result[] = $tmp;
                }
                continue;
            }

            if (!is_scalar($value)) {
                continue;
            }

            if (!is_string($key)) {
                if (!is_string($value)) {
                    continue;
                }
                $key = $value;
                $value = true;
            }

            $renderKey = preg_replace_callback(
                '#[A-Z]#',
                function ($matches) {
                    return '-' . strtolower($matches[0]);
                },
                lcfirst($prefix . $key)
            );

            if (true === $value) {
                $result[$renderKey] = $renderKey;
                continue;
            }

            if (!is_string($value)) {
                $value = json_encode($value);
            }

            $result[$renderKey] = sprintf('%s="%s"', $renderKey, $value);
        }

        return implode(' ', $result);
    }
}


if (!function_exists('renderTag')) {

    /**
     * @param string|Stringable $tagName
     * @param iterable $arguments
     * @param string|Stringable $innerHtml
     * @return string
     */
    function renderTag($tagName, $arguments = [], $innerHtml = "")
    {
        /**
         * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
         */
        static $voidElements = [
            "area",
            "base",
            "br",
            "col",
            "embed",
            "hr",
            "img",
            "input",
            "link",
            "meta",
            "param",
            "source",
            "track",
            "wbr"
        ];

        if (is_object($tagName) && method_exists($tagName, '__toString')) {
            $tagName = (string)$tagName;
        }

        if (is_object($innerHtml) && method_exists($innerHtml, '__toString')) {
            $innerHtml = (string)$innerHtml;
        }

        if (!is_string($tagName)) {
            throw new InvalidArgumentException('$tagName is not a string');
        }

        if (!is_string($innerHtml)) {
            throw new InvalidArgumentException('$innerHtml is not a string');
        }

        $arguments = rtrim(" " . renderArgs($arguments));

        $tagName = strtolower($tagName);
        if (in_array($tagName, $voidElements)) {
            return sprintf('<%s%s>', $tagName, $arguments);
        }

        return sprintf('<%s%s>%s</%s>', strtolower($tagName), $arguments, $innerHtml, $tagName);
    }
}


if (!function_exists('var_get')) {
    /**
     * @param string|int $name
     * @param array $var
     * @param mixed $defaultValue
     * @return mixed
     */
    function var_get($name, array $var, $defaultValue = null)
    {
        if (isset($var[$name])) {
            return $var[$name];
        }
        return value($defaultValue, $name);
    }
}


if (!function_exists('constant_get')) {
    /**
     * @param string $name
     * @param mixed|null $defaultValue
     * @return mixed
     */
    function constant_get($name, $defaultValue = null)
    {
        if (!defined($name)) {
            return value($defaultValue, $name);
        }
        return constant($name);
    }
}


if (!function_exists('env_get')) {
    /**
     * @param string $name
     * @param mixed|null $defaultValue
     * @return mixed
     */
    function env_get($name, $defaultValue = null)
    {

        if (!isset($_ENV[$name]) && !isset($_SERVER[$name])) {
            return value($defaultValue, $name);
        }
        return decode_value(isset($_ENV[$name]) ? $_ENV[$name] : $_SERVER[$name]);
    }
}


if (!function_exists('value')) {

    /**
     * Return the default value of the given value.
     * @param mixed $value
     * @param mixed ...$args
     * @return mixed
     */
    function value($value, $args = [])
    {

        if ($value instanceof Closure) {
            if (!is_array($args)) {
                $args = array_slice(func_get_args(), 1);
            }
            return call_user_func_array($value, $args);
        }

        return $value;
    }
}


if (!function_exists('tap')) {

    /**
     * Call the given Closure with the given value then return the value.
     * @param mixed $value
     * @param callable $func
     * @return mixed
     */
    function tap($value, callable $func)
    {
        call_user_func($func, $value);
        return $value;
    }
}

if (!function_exists('require_secure')) {
    /**
     * @param string $filename
     * @return mixed
     */
    function require_secure($filename)
    {

        if (is_file($filename)) {
            return include $filename;
        }

        return null;
    }
}


if (!function_exists('str_convert_encoding')) {
    /**
     * Replaces mb_convert_encoding with a better one
     * @param string $str
     * @param string $encoding
     * @return string
     */
    function str_convert_encoding($str, $encoding = 'UTF-8')
    {
        static $types = null;
        if ($types === null) {
            $types = [];
            foreach (mb_list_encodings() as $real) {
                $types[strtolower($real)] = $real;
            }
        }

        if (!isset($types[strtolower($encoding)])) {
            return $str;
        }

        $toEncoding = $types[strtolower($encoding)];

        if (($currentEncoding = mb_detect_encoding($str, $types, true)) && $currentEncoding !== $toEncoding) {
            $str = mb_convert_encoding($str, $toEncoding, $currentEncoding);
        }

        return $str;
    }
}


if (!function_exists('getallheaders')) {

    /**
     * Get all HTTP header key/values as an associative array for the current request.
     *
     * @phan-suppress PhanRedefineFunctionInternal
     *
     * @return array<string,string> The HTTP header key/value pairs.
     */
    function getallheaders()
    {
        $headers = [];

        $copy_server = [
            'CONTENT_TYPE' => 'Content-Type',
            'CONTENT_LENGTH' => 'Content-Length',
            'CONTENT_MD5' => 'Content-Md5',
        ];

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $key = substr($key, 5);
                if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                    $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                    $headers[$key] = $value;
                }
            } elseif (isset($copy_server[$key])) {
                $headers[$copy_server[$key]] = $value;
            }
        }

        if (!isset($headers['Authorization'])) {
            if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
                $basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
                $headers['Authorization'] = 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass);
            } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
                $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
            }
        }

        return $headers;
    }
}


if (!function_exists('decode_value')) {
    /**
     * Uses json_decode to convert strings to the right type
     * @param mixed $value a value to be decoded
     * @return mixed
     */
    function decode_value($value)
    {

        $value = value($value);

        if (is_string($value)) {
            if ('null' === $value) {
                return null;
            }
            $decoded = json_decode($value, true);
            return null === $decoded ? $value : $decoded;
        }

        if (is_array($value)) {
            foreach ($value as &$item) {
                $item = decode_value($item);
            }
        }
        return $value;
    }
}


if (!function_exists('is_list')) {
    /**
     * Checks if value is a list.
     * @param mixed $value
     * @return bool
     */
    function is_list($value)
    {

        if (!is_iterable($value) && !($value instanceof ArrayAccess && $value instanceof Countable)) {
            return false;
        }
        if (is_array($value)) {
            return array_is_list($value);
        }
        // Traversable
        if (is_iterable($value)) {
            $nextKey = -1;
            foreach ($value as $k => $_) {
                if ($k !== ++$nextKey) {
                    return false;
                }
            }
            return true;
        }
        // Countable
        if (is_countable($value)) {

            if (0 === count($value)) {
                return true;
            }

            // ArrayAccess
            try {
                set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
                });
                for ($offset = 0; $offset < count($value); ++$offset) {
                    if (!isset($value[$offset])) {
                        return false;
                    }
                }
            } catch (ErrorException $err) {
                return false;
            } finally {
                restore_error_handler();
            }
            return true;
        }
        return false;
    }
}


if (!function_exists('count_value')) {

    /**
     * Count the amount of occurrence of value in iterable
     * @param mixed $value
     * @param iterable $iterable
     * @return int
     */
    function count_value($value, $iterable)
    {
        if (!is_iterable($iterable)) {
            return 0;
        }
        $result = 0;
        foreach ($iterable as $item) {
            if ($item === $value) {
                ++$result;
            }
        }
        return $result;
    }
}


if (!function_exists('generate_uid')) {

    /**
     * Generates random string from 16 chars to selected length (max 128)
     * @param int|bool $length false: 16, true: 32, even number from 16 to 128
     * @return string
     */
    function generate_uid($length = false)
    {
        static $known = [];

        if (is_bool($length)) {
            $length = $length ? 32 : 16;
        } elseif (!is_numeric($length)) {
            $length = 16;
        }
        $length = (int)$length;
        // needs an even number
        if (0 !== $length % 2) {
            $length++;
        }
        $length = (int)max(min($length, 128), 16);

        $n = ceil($length / 13);
        do {
            // for php 5
            if (!function_exists('random_bytes')) {
                $uid = '';
                for ($i = 0; $i < $n; $i++) {
                    $uid .= uniqid();
                }
                $uid = substr($uid, -$length);
            } else {
                // php 7.0+
                $uid = bin2hex(random_bytes($length / 2));
            }
        } while (in_array($uid, $known));
        return $known[] = $uid;
    }
}


if (!function_exists('remove_prefix')) {

    /**
     * Removes prefix from string
     * @param string|Stringable $input
     * @param string|Stringable $prefix
     * @return string
     */
    function remove_prefix($input, $prefix)
    {
        $input = (string)$input;
        $prefix = (string)$prefix;
        if (str_starts_with($input, $prefix)) {
            return substr($input, strlen($prefix));
        }
        return $input;
    }
}


if (!function_exists('remove_suffix')) {

    /**
     * Removes suffix from string
     * @param string|Stringable $input
     * @param string|Stringable $suffix
     * @return string
     */
    function remove_suffix($input, $suffix)
    {
        $input = (string)$input;
        $suffix = (string)$suffix;
        if (str_ends_with($input, $suffix)) {
            return substr($input, 0, -strlen($suffix));
        }
        return $input;
    }
}


if (!function_exists('str_format')) {

    /**
     * Use a python like format for named replacements or vsprintf for indexed ones
     * @param string $subject
     * @param array $replacements
     * @return string
     */
    function str_format($subject, array $replacements)
    {

        if (!count($replacements)) {
            return $subject;
        }

        if (array_is_list($replacements) && str_contains($subject, '%')) {
            try {
                // prevent warnings < PHP 8.0
                return @vsprintf($subject, $replacements) ?: $subject;
            } catch (ValueError $error) {
                // prevents ValueError >= PHP 8.0
                return $subject;
            }

        }

        // uses named parameters (or indexed {1}, {2})
        return preg_replace_callback(
            '#{\h*([\w-]+)\h*}#',
            function ($matches) use ($replacements) {
                $key = $matches[1];
                if (is_numeric($key)) {
                    $key = (int)$key;
                }

                if (isset($replacements[$key])) {
                    return $replacements[$key];
                }
                return $matches[0];
            },
            $subject
        );
    }
}

if (!function_exists('set_default_error_handler')) {

    /**
     * Intercepts php warnings and throws errors
     * that can be intercepted
     * @return callable|null
     * @throws ErrorException
     */
    function set_default_error_handler()
    {
        static $handler = null;

        if (!$handler) {
            /**
             * @param int $errno
             * @param string $errstr
             * @param string $errfile
             * @param int $errline
             * @return bool
             * @throws ErrorException
             */
            $handler = static function ($errno, $errstr, $errfile, $errline) {
                static $errors = [
                    E_ERROR, E_WARNING, E_PARSE,
                    E_NOTICE, E_CORE_ERROR, E_CORE_WARNING,
                    E_COMPILE_ERROR, E_COMPILE_WARNING, E_USER_ERROR,
                    E_USER_WARNING, E_USER_NOTICE, E_STRICT,
                    E_RECOVERABLE_ERROR, E_DEPRECATED, E_USER_DEPRECATED];

                if (!(error_reporting() & $errno)) {
                    return false;
                }

                if (in_array($errno, $errors, true)) {
                    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
                }
                return true;
            };
        }

        if (get_error_handler() === $handler) {
            return $handler;
        }
        return set_error_handler($handler);
    }
}


if (!function_exists('preg_exec')) {

    /**
     * Perform a regular expression match.
     * @param string $pattern the regular expression
     * @param string $subject the subject
     * @param int $limit maximum number of results if set to 0, all results are returned
     * @return array
     */
    function preg_exec($pattern, $subject, $limit = 1)
    {
        preg_valid($pattern, true);

        $limit = max(0, $limit);

        if (preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER) > 0) {
            if (0 === $limit) {
                $limit = count($matches);
            }

            if (1 === $limit) {
                return $matches[0];
            }

            while (count($matches) > $limit) {
                array_pop($matches);
            }
            return $matches;
        }

        return [];
    }
}

if (!function_exists('preg_test')) {
    /**
     * Test if the subject matches the pattern.
     * @param string $pattern
     * @param string $subject
     * @return bool
     * @throws ErrorException
     */
    function preg_test($pattern, $subject)
    {
        preg_valid($pattern, true);
        return preg_match($pattern, $subject) > 0;
    }
}

if (!function_exists('preg_valid')) {

    /**
     * Check if regular expression is valid.
     * @phan-suppress PhanParamSuspiciousOrder
     * @param string $pattern
     * @param bool $exception
     * @return bool
     * @throws ErrorException if exception set to true
     */
    function preg_valid($pattern, $exception = false)
    {
        try {
            set_default_error_handler();
            return $pattern !== ltrim($pattern, '%#/') && false !== preg_match($pattern, ''); // must be >=0 to be correct
        } catch (ErrorException $error) {
            if ($exception) {
                $msg = str_replace('_match', '_valid', $error->getMessage());
                throw new ErrorException(
                    $msg,
                    0, $error->getSeverity(),
                    null, null,
                    $error
                );
            }
            return false;
        } finally {
            restore_error_handler();
        }
    }
}

}
namespace {

if (!interface_exists("Lockable", false)) {
    interface Lockable
    {
        /**
         * Lock the object.
         * @return void
         */
        public function lock();

        /**
         * Unlock the object.
         * @return void
         */
        public function unlock();


        /**
         * Get the lock status.
         * @return bool
         */
        public function isLocked();
    }
}

}
namespace DataStructure{




interface ReversibleIterator extends \IteratorAggregate
{
    /**
     * @param bool $reversed
     * @return \Traversable
     */
    public function entries($reversed = false);


    /** @return \Traversable */
    public function getReverseIterator();

}

}
namespace DataStructure{




final class SortableIterator implements ReversibleIterator, \Countable, \Lockable
{


    /**
     * @param iterable $iterable
     * @param bool $static
     * @return static
     */
    public static function of($iterable, $static = false)
    {
        return new self($iterable, $static);
    }

    /**
     * @param \ArrayAccess&\Countable|iterable $value
     * @return static
     */
    public static function ofList($value)
    {
        if (is_iterable($value)) {
            return self::of($value);
        }

        if (!($value instanceof \ArrayAccess && $value instanceof \Countable)) {
            throw new \InvalidArgumentException(sprintf('$value must be of type ArrayAccess&Countable, %s given', get_debug_type($value)));
        }

        if (\is_list($value)) {

            $iterator = new self([], true);
            foreach (Range::of($value) as $offset) {
                $iterator->append($offset, $value[$offset]);
            }
            $iterator->locked = true;

            return $iterator;
        }

        throw new \OutOfRangeException(sprintf('%s cannot determine list of keys.', \get_debug_type($value)));
    }

    /**
     * @param mixed $value
     * @return static
     */
    public static function ofString($value)
    {
        $value = (string)$value;
        return new self('' === $value ? [] : mb_str_split($value), true);
    }

    /** @var iterable */
    private $iterator;
    /** @var bool */
    private $static;
    private $keys = [];
    private $values = [];
    private $locked = false;

    /**
     * @param iterable $iterator The iterable to iterate
     * @param bool $static true if the state of the iterator cannot change
     */
    public function __construct($iterator, $static = false)
    {
        if (!is_iterable($iterator)) {
            throw new \InvalidArgumentException(sprintf('$iterator must be iterable, %s given', get_debug_type($iterator)));
        }
        $this->iterator = $iterator;
        $this->static = $static !== false;
    }


    public function __debugInfo()
    {
        return [];
    }


    public function entries($reversed = false)
    {
        $offsets = $this->getOffsets();
        if ($reversed) {
            $offsets = array_reverse($offsets);
        }
        return $this->yieldOffsets($offsets);
    }

    /** @return \Traversable */
    public function getIterator()
    {
        return $this->entries();
    }


    /** @return \Traversable */
    public function getReverseIterator()
    {
        return $this->entries(true);
    }

    /** @return int */
    public function count()
    {
        return count($this->getOffsets());
    }


    /**
     * @param mixed $key
     * @param mixed $value
     * @return void
     * @internal
     */
    private function append($key, $value)
    {
        if (!$this->locked) {
            $this->keys[] = $key;
            $this->values[] = $value;
        }
    }

    /**
     * @return void
     * @internal
     */
    private function reset()
    {
        if (!$this->static) {
            $this->keys = [];
            $this->values = [];
            $this->locked = false;
        }
    }

    /**
     * @return \Traversable
     * @internal
     */
    private function yieldOffsets(array $offsets)
    {
        foreach ($offsets as $offset) {
            yield $this->keys[$offset] => $this->values[$offset];
        }

        $this->reset();
    }

    /**
     * @return array
     * @internal
     */
    private function getOffsets()
    {
        if (!$this->locked) {
            foreach ($this->iterator as $key => $value) {
                $this->append($key, $value);
            }
            $this->locked = true;
        }

        return array_keys($this->keys);
    }


    public function lock()
    {
        $this->locked = true;
    }

    public function unlock()
    {
        $this->locked = false;
    }

    public function isLocked()
    {
        return $this->locked;
    }
}

}
namespace DataStructure{



final class Range implements ReversibleIterator, \Stringable
{

    /** @var int */
    public $start;
    /** @var int|null */
    public $stop;
    /** @var int */
    public $step;
    /** @var int|null */
    private $length = null;

    /**
     * @param int $start
     * @param int|null $stop
     * @param int $step
     */
    public function __construct(
        $start,
        $stop = null,
        $step = 1
    )
    {
        if (0 === $step) {
            throw new \InvalidArgumentException('Step cannot be 0');
        }

        if (is_null($stop)) {
            $stop = $start;
            $start = 0;
        }

        list($this->start, $this->stop, $this->step) = [$start, $stop, $step];
    }


    public function __debugInfo()
    {
        return [
            'params' => $this->__toString(),
            'length' => $this->count(),
        ];
    }

    public function __toString()
    {
        return sprintf('range(%d, %d, %d)', $this->start, $this->stop, $this->step);
    }

    /**
     * Creates a Range.
     * @param int $start
     * @param int|null $stop
     * @param int $step
     * @return static
     */
    public static function create($start, $stop = null, $step = 1)
    {
        return new self($start, $stop, $step);
    }


    /**
     * Get a range for a Countable.
     * @param \Countable|array $countable
     * @return self
     */
    public static function of($countable)
    {
        if (!is_countable($countable)) {
            throw new \InvalidArgumentException('$countable is not countable');
        }
        return new self(0, count($countable));
    }

    /**
     * Checks if empty range.
     */
    public function isEmpty()
    {
        return $this->step > 0 ? $this->stop <= $this->start : $this->stop >= $this->start;
    }

    public function count()
    {
        if (is_null($this->length)) {
            $this->length = 0;

            if (!$this->isEmpty()) {
                list($min, $max, $step) = [$this->start, $this->stop, abs($this->step)];

                if ($min > $max) {
                    list($min, $max) = [$max, $min];
                }

                $this->length = intval(ceil(($max - $min) / $step));
            }
        }

        return $this->length;
    }

    public function entries($reversed = false)
    {
        if (!$this->isEmpty()) {
            if ($reversed) {
                for ($offset = -1; $offset >= -$this->count(); --$offset) {
                    yield $this->getOffset($offset);
                }
            } else {
                for ($offset = 0; $offset < $this->count(); ++$offset) {
                    yield $this->getOffset($offset);
                }
            }
        }
    }

    /**
     * @param int $offset
     * @return int
     */
    private function getOffset($offset)
    {
        if (0 > $offset) {
            $offset += $this->count();
        }
        return $this->start + ($offset * $this->step);
    }

    public function getIterator()
    {
        return $this->entries();
    }

    public function getReverseIterator()
    {
        return $this->entries(true);
    }
}

}
namespace DataStructure{



abstract class Common implements ReversibleIterator, \Stringable, \Countable, \Lockable
{

    protected $locked = false;

    /**
     * Lock the object.
     * @return void
     */
    public function lock()
    {
        $this->locked = true;
    }

    /**
     * Unlock the object.
     * @return void
     */
    public function unlock()
    {
        $this->locked = false;
    }


    /**
     * Get the lock status.
     * @return bool
     */
    public function isLocked()
    {
        return $this->locked;
    }


    public function __toString()
    {
        return sprintf('object(%s)', get_class($this));
    }


    /** @return \Traversable */
    public function getIterator()
    {
        return $this->entries();
    }


    /** @return \Traversable */
    public function getReverseIterator()
    {
        return $this->entries(true);
    }


    /**
     * Tests if at least one of the elements from the storage pass the test implemented by the callable.
     * @param callable $callback
     * @return bool
     */
    public function some(callable $callback)
    {
        $empty = true;

        foreach ($this->entries() as $key => $value) {
            $empty = false;
            if (!$callback($value, $key, $this)) {
                return false;
            }
        }

        return !$empty;
    }


    /**
     * Tests if all the elements from the storage pass the test implemented by the callable.
     *
     * @param callable $callback
     * @return bool
     */
    public function every(callable $callback)
    {
        foreach ($this->entries() as $key => $value) {
            if (!$callback($value, $key, $this)) {
                return false;
            }
        }
        return true;
    }


    /**
     * Runs the given callable for each of the elements.
     *
     * @param callable $callback
     * @return void
     */
    public function each(callable $callback)
    {
        foreach ($this->entries() as $key => $value) {
            $callback($value, $key, $this);
        }
    }


    /**
     * @return bool
     */
    public function isEmpty()
    {
        return 0 === $this->count();
    }


    /**
     * Sorts array
     * @param array $array
     * @param bool $reversed
     * @return array
     */
    protected function sortArray(array $array, $reversed = false)
    {
        if ($reversed) {
            return array_reverse($array);
        }

        return $array;
    }


    /**
     * Helper to be used with __clone() method.
     * @param array $array
     * @param bool $recursive
     * @return array
     */
    protected function cloneArray(array $array, $recursive = true)
    {
        $result = [];

        foreach ($array as $offset => $value) {
            if (is_object($value)) {
                $result[$offset] = clone $value;
                continue;
            }

            if (is_array($value) && $recursive) {
                $result[$offset] = $this->cloneArray($value, $recursive);
                continue;
            }

            $result[$offset] = $value;
        }

        return $result;
    }


}

}
namespace DataStructure{




/**
 * The Map object holds key-value pairs and remembers the original insertion order of the keys.
 * Any value (both objects and primitive values) may be used as either a key or a value.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Map JS Map
 */
final class Map extends Common implements \ArrayAccess, \JsonSerializable, \Serializable
{


    /**
     * Create a new Map.
     * @return static
     */
    public static function create()
    {
        return new self();
    }


    /**
     * Creates a new instance initialized with an iterable.
     * @param iterable $iterable
     * @return static
     */
    public static function of($iterable)
    {
        return new self($iterable);
    }


    /** @var array */
    protected $keys = [];
    /** @var array */
    protected $values = [];


    /**
     * @param iterable|null $iterable
     */
    public function __construct($iterable = null)
    {
        if (is_iterable($iterable)) {
            $this->importIterable($iterable);
        }
    }

    public function __debugInfo()
    {
        $result = [];

        foreach ($this->entries() as $key => $value) {
            $result[is_scalar($key) ? $key : get_debug_type($key)] = $value;
        }

        return $result;
    }


    public function serialize()
    {
        return serialize($this->__serialize());
    }

    public function unserialize($data)
    {
        $this->__unserialize(unserialize($data));
    }

    public function __serialize()
    {
        return [$this->keys, $this->values, $this->locked];
    }

    public function __unserialize(array $data)
    {
        list($this->keys, $this->values, $this->locked) = $data;
    }

    public function __clone()
    {
        $this->keys = $this->cloneArray($this->keys);
        $this->values = $this->cloneArray($this->values);
    }


    public function jsonSerialize()
    {
        $result = [];

        foreach ($this->entries() as $key => $value) {
            $result[] = [$key, $value];
        }

        return $result;
    }

    /**
     * The clear() method removes all elements from a Map object.
     * @return void
     */
    public function clear()
    {
        if (!$this->isLocked()) {
            $this->keys = $this->values = [];
        }
    }


    /**
     * The delete() method removes the specified element from a Map object by key.
     * @param mixed $key
     * @return bool
     */
    public function delete($key)
    {
        if (!$this->isLocked()) {
            if (($index = $this->indexOf($key)) > -1) {
                unset($this->keys[$index], $this->values[$index]);
                return true;
            }
        }

        return false;
    }


    /**
     * The get() method returns a specified element from a Map object.
     * If the value associated with the provided key is an object,
     * then you will get a reference to that object and any change made
     * to that object will effectively modify it inside the Map object.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return
            ($index = $this->indexOf($key)) > -1 ?
                $this->values[$index] :
                null;
    }

    /**
     * The search() method returns the first key match from a value.
     * @param mixed $value
     * @return mixed
     */
    public function search($value)
    {
        return
            ($index = $this->indexOfValue($value)) > -1 ?
                $this->keys[$index] :
                null;
    }

    /**
     * The entries() method returns a new iterator object that contains the [key, value] pairs for each element in the Map object in insertion order.
     */
    public function entries($reversed = false)
    {
        foreach ($this->sortArray(array_keys($this->keys), $reversed) as $offset) {
            yield $this->keys[$offset] => $this->values[$offset];
        }
    }

    /**
     * The set() method adds or updates an element with a specified key and a value to a Map object.
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->delete($key);
        return $this->append($key, $value);
    }

    /**
     * The add() method adds an element with a specified key and a value to a Map object if it doesn't already exist.
     * @param mixed $key
     * @param mixed $value
     * @return static
     */
    public function add($key, $value)
    {
        if ($this->has($key)) {
            return $this;
        }
        return $this->append($key, $value);
    }

    /**
     * The has() method returns a boolean indicating whether an element with the specified key exists or not.
     * @param mixed $key
     * @return bool
     */
    public function has($key)
    {
        return $this->indexOf($key) > -1;
    }


    /**
     * The keys() method returns a new iterator object that contains the keys for each element in the Map object in insertion order.
     * @param bool $reversed
     * @return iterable
     */
    public function keys($reversed = false)
    {
        foreach ($this->sortArray($this->keys, $reversed) as $key) {
            yield $key;
        }
    }

    /**
     * The values() method returns a new iterator object that contains the values for each element in the Map object in insertion order.
     * @param bool $reversed
     * @return iterable
     */
    public function values($reversed = false)
    {
        foreach ($this->sortArray($this->values, $reversed) as $value) {
            yield $value;
        }
    }


    private function indexOf($key)
    {
        $index = array_search($key, $this->keys, true);
        return false !== $index ? $index : -1;
    }

    private function indexOfValue($value)
    {
        $index = array_search($value, $this->values, true);
        return false !== $index ? $index : -1;
    }


    private function append($key, $value)
    {
        if (!$this->isLocked()) {
            $this->keys[] = $key;
            $this->values[] = $value;
        }

        return $this;
    }

    /**
     * @param iterable $iterable
     */
    private function importIterable($iterable)
    {
        foreach ($iterable as $item) {
            if (!is_list($item) || 2 < count($item)) {
                continue;
            }

            $this->set($item[0], $item[1]);
        }
    }

    public function count()
    {
        return count($this->keys);
    }


    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }
}

}
namespace DataStructure{



/**
 * The Set object lets you store unique values of any type, whether primitive values or object references.
 */
final class Set extends Common implements ReversibleIterator, \JsonSerializable, \Serializable
{


    /**
     * Create a new Set.
     * @return static
     */
    public static function create()
    {
        return new self();
    }


    /**
     * Creates a new instance initialized with an iterable.
     * @param iterable $iterable
     * @return static
     */
    public static function of($iterable)
    {
        return new self($iterable);
    }


    /** @var array */
    private $storage = [];

    /**
     * @param iterable|null $iterable
     */
    public function __construct($iterable = null)
    {
        if (is_iterable($iterable)) {
            $this->importIterable($iterable);
        }
    }


    /**
     * The has() method returns a boolean indicating whether an element with the specified value exists in a Set object or not.
     * @param mixed $value
     * @return bool
     */
    public function has($value)
    {
        return -1 !== $this->indexOf($value);
    }


    /**
     * The add() method appends a new element with a specified value to the end of a Set object.
     * @param mixed $value
     * @return static
     */
    public function add($value)
    {
        if (!$this->has($value) && !$this->isLocked()) {
            $this->storage[] = $value;
        }
        return $this;
    }

    /**
     * The delete() method removes a specified value from a Set object, if it is in the set.
     *
     * @param mixed $value
     * @return bool
     */
    public function delete($value)
    {
        if (!$this->isLocked()) {
            $offset = $this->indexOf($value);

            if ($offset > -1) {
                unset($this->storage[$offset]);
                return true;
            }
        }

        return false;
    }

    /**
     * The clear() method removes all elements from a Set object.
     * @return void
     */
    public function clear()
    {
        if (!$this->isLocked()) {
            $this->storage = [];
        }

    }

    /**
     * The values() method returns a new Iterator object that contains the values for each element in the Set object in insertion order.
     *
     * @param bool $reversed
     * @return iterable
     */
    public function values($reversed = false)
    {
        foreach ($this->getIndexes($reversed) as $offset) {
            yield $this->storage[$offset];
        }
    }


    /**
     * The entries() method returns a new Iterator object that contains an array of [value, value] for each element in the Set object, in insertion order.
     */
    public function entries($reversed = false)
    {
        foreach ($this->getIndexes($reversed) as $offset) {
            yield $this->storage[$offset] => $this->storage[$offset];
        }
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $this->storage = $this->cloneArray($this->storage);
    }

    public function serialize()
    {
        return serialize($this->__serialize());
    }

    public function unserialize($data)
    {
        $this->__unserialize(unserialize($data));
    }

    /**
     * @return array
     */
    public function __serialize()
    {
        return [$this->storage, $this->locked];
    }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data)
    {
        list($this->storage, $this->locked) = $data;
    }

    public function count()
    {
        return count($this->storage);
    }

    public function jsonSerialize()
    {
        return $this->storage;
    }

    /**
     * @param iterable $iterable
     * @return void
     */
    private function importIterable($iterable)
    {
        foreach ($iterable as $item) {
            $this->add($item);
        }
    }

    /**
     * @param mixed $value
     * @return int
     */
    private function indexOf($value)
    {
        $index = array_search($value, $this->storage, true);
        return false !== $index ? $index : -1;
    }

    /**
     * @param bool $reversed
     * @return \Traversable
     */
    private function getIndexes($reversed = false)
    {

        foreach ($this->sortArray(array_keys($this->storage), $reversed) as $index) {
            yield $index;
        }

    }


}

}
namespace {

/**
 * An application logger than can dynamically write to log file defined as channel
 * Can prefix INFO:, WARN:, ERR: to logs using the right method
 * Can use variadic or array replacements on every php versions between 5.5 and 8.4
 * eg: ApplicationLogger(APP_ID)->info('app started on %s', date('Y-m-d H:i:s'));.
 *
 * @author Aymeric Anger
 */
class ApplicationLogger
{
    const DEFAULT_CHANNEL = 'app';

    protected $channel = '';

    protected $prefix = '';

    protected $logs = [];

    protected $rotationDone = false;

    protected static $instances = [];
    protected static $logRoot = '';
    protected static $rotate = 0;
    protected static $archiveLocation = '';
    protected static $logDays = false;
    protected static $backTrace = true;
    protected static $logOutput = false;


    public function __construct($channel = self::DEFAULT_CHANNEL)
    {
        $this->channel = $channel;
    }

    /**
     * @return bool
     */
    public static function getLogDays()
    {
        return self::$logDays;
    }


    /**
     * @param bool $logDays
     * @return void
     */
    public static function setLogDays($logDays)
    {
        self::$logDays = (bool)$logDays;
    }


    /**
     * @param string $archiveLocation
     * @return void
     */
    public static function setArchiveLocation($archiveLocation)
    {
        $archiveLocation = self::normalizePath($archiveLocation) . DIRECTORY_SEPARATOR;
        $umask = @umask(0);
        @mkdir($archiveLocation, 0777, true);
        @umask($umask);
        self::$archiveLocation = $archiveLocation;
    }

    /**
     * @return string
     */
    public static function getArchiveLocation()
    {
        if (!self::$archiveLocation) {

            $pth = constant_get(
                "LOG_PATH_ARCHIVE",
                self::getLogRoot() . 'archives' . DIRECTORY_SEPARATOR
            );
            self::setArchiveLocation($pth);
        }

        return self::$archiveLocation;
    }

    /**
     * @return int
     */
    public static function getRotate()
    {
        return self::$rotate;
    }


    /**
     * @param int $rotate
     * @return void
     */
    public static function setRotate($rotate)
    {
        self::$rotate = max($rotate, 0);
    }

    /**
     * @return string
     */
    public static function getLogRoot()
    {
        if (!self::$logRoot) {
            $pth = constant_get('LOG_PATH', getcwd() . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR);
            self::setLogRoot($pth);
        }
        return self::$logRoot;
    }

    /**
     * @param string $dir
     * @return void
     */
    public static function setLogRoot($dir)
    {
        $dir = self::normalizePath($dir) . DIRECTORY_SEPARATOR;
        $umask = @umask(0);
        @mkdir($dir, 0777, true);
        @umask($umask);
        self::$logRoot = $dir;
    }


    /**
     * Normalize pathname.
     * @param string $path
     * @return string
     */
    protected static function normalizePath($path)
    {
        if (empty($path)) {
            return $path;
        }

        return rtrim(
            preg_replace('#[\\\/]+#', DIRECTORY_SEPARATOR, $path),
            DIRECTORY_SEPARATOR
        );
    }

    /**
     * @param string|null $channel
     * @return static
     */
    public static function getLogger($channel = null)
    {
        if (empty($channel)) {
            $channel = self::getDefaultChannel();
        }

        if (!isset(self::$instances[$channel])) {
            self::$instances[$channel] = new ApplicationLogger($channel);
        }
        return self::$instances[$channel];
    }

    /**
     * @return string
     */
    protected static function getDefaultChannel()
    {
        return constant_get('APP_ID', self::DEFAULT_CHANNEL);
    }

    /**
     * @return bool
     */
    public static function hasBackTrace()
    {
        return self::$backTrace;
    }

    /**
     * @param bool $backTrace
     * @return void
     */
    public static function setBackTrace($backTrace)
    {
        self::$backTrace = $backTrace;
    }

    /**
     * @return bool
     */
    public static function canLogOutput()
    {
        return self::$logOutput;
    }

    /**
     * @param bool $logOutput
     * @return void
     */
    public static function setLogOutput($logOutput)
    {
        self::$logOutput = $logOutput;
    }


    /**
     * @return string
     */
    public function getPrefix()
    {
        return rtrim($this->prefix);
    }


    /**
     * @param string $prefix
     * @return static
     */
    public function setPrefix($prefix)
    {
        if (empty($prefix)) {
            $this->prefix = '';
            return $this;
        }

        if (rtrim($prefix, ' ') !== $prefix) {
            $prefix = rtrim("$prefix") . ' ';
        }

        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }


    /**
     * @param string $channel
     * @return static
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }


    /**
     * @param string $message
     * @param array $replacements
     * @return static
     */
    public function log($message, $replacements = [])
    {
        if (!is_array($replacements)) {
            $args = func_get_args();
            array_splice($args, 0, 1);
            $replacements = $args;
        }

        if (count($replacements) > 0 && !empty($message)) {

            // encode object value to string if possible
            foreach ($replacements as $key => $value) {
                if (is_object($value) && !method_exists($value, '__toString')) {
                    if (false !== $json = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) {
                        $replacements[$key] = $json;
                    }
                }
            }

            $message = str_format($message, $replacements);
        }

        $file = $this->getFilename();
        $dir = dirname($file);
        $umask = @umask(0);

        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        $metadata = date('Y/m/d H:i:s');

        if (self::hasBackTrace()) {
            foreach (@debug_backtrace() as $trace) {
                if ($trace["file"] !== __FILE__) {
                    $metadata .= sprintf(" %s:%s", basename($trace["file"]), $trace["line"]);
                    break;
                }
            }
        }

        $this->logs[] = $msg = sprintf("%s %s%s\n", $metadata, $this->prefix, $message);


        @file_put_contents(
            $file,
            $msg,
            FILE_APPEND
        );

        @chmod($file, 0777);

        @umask($umask);

        if (self::canLogOutput()) {
            echo $msg;
        }

        return $this->rotateLogs();
    }

    /**
     * @param string $message
     * @param array $replacements
     * @return static
     */
    public function info($message, $replacements = [])
    {
        if (!is_array($replacements)) {
            $args = func_get_args();
            array_splice($args, 0, 1);
            $replacements = $args;
        }
        return $this->log("INFO: $message", $replacements);
    }


    /**
     * @param string $message
     * @param array $replacements
     * @return static
     */
    public function debug($message, $replacements = [])
    {
        if (!constant_get('DEV_ENV', false)) {
            return $this;
        }

        if (!is_array($replacements)) {
            $args = func_get_args();
            array_splice($args, 0, 1);
            $replacements = $args;
        }
        return $this->log("DEBUG: $message", $replacements);
    }


    /**
     * @param string $message
     * @param array $replacements
     * @return static
     */
    public function error($message, $replacements = [])
    {
        if (!is_array($replacements)) {
            $args = func_get_args();
            array_splice($args, 0, 1);
            $replacements = $args;
        }
        return $this->log("ERR: $message", $replacements);
    }


    /**
     * @param string $message
     * @param array $replacements
     * @return static
     */
    public function warn($message, $replacements = [])
    {
        if (!is_array($replacements)) {
            $args = func_get_args();
            array_splice($args, 0, 1);
            $replacements = $args;
        }

        return $this->log("WARN: $message", $replacements);
    }

    /**
     * @param string $channel
     * @return string
     */
    protected function getRealChannel($channel)
    {
        if (!str_ends_with($channel, '-dev') && constant_get('DEV_ENV')) {
            $channel .= '-dev';
        }
        return $channel;
    }


    /**
     * @param string|null $channel
     * @return string
     */
    protected function getFilename($channel = null)
    {
        static $filenames = [];

        if (!isset($channel)) {
            $channel = $this->getChannel();

            if (empty($channel)) {
                $channel = self::getDefaultChannel();
            }
        }


        // if the log channel is in a sub-dir
        $channel = $this->getRealChannel(trim($channel, '/'));

        if (!isset($filenames[$channel])) {
            $chan = $channel;
            $dest = self::getLogRoot();
            $dir = '';
            if (false !== $pos = strrpos($channel, '/')) {
                // normalize
                $dir = ltrim(substr($channel, 0, $pos + 1), '/');
                $chan = substr($channel, $pos + 1);
            }

            $filenames[$channel] = sprintf(
                '%s%s-%s.log',
                $dest . $dir,
                self::getLogDays() ? date('ymd') : date('ym'),
                $chan
            );
        }


        return $filenames[$channel];
    }

    /**
     * @return static
     */
    protected function rotateLogs()
    {
        if ($this->rotationDone) {
            return $this;
        }
        $this->rotationDone = true;
        $keep = self::getRotate();

        if (!$keep) {
            return $this;
        }
        $orig = self::getLogRoot();
        $dest = self::getArchiveLocation();
        $chan = $this->getRealChannel(trim($this->channel, '/'));
        $dir = '';
        if (false !== $pos = strrpos($chan, '/')) {
            // normalize
            $dir = substr($chan, 0, $pos + 1);
            $dest .= $dir;
            $chan = substr($chan, $pos + 1);
            $umask = @umask(0);
            @mkdir($dest, 0777, true);
            @umask($umask);
        }


        $list = [];

        foreach (glob($orig . $dir . '[0-9][0-9]*.log') as $file) {
            if (!is_file($file)) {
                continue;
            }

            if (preg_match('#^\d+(.+)\.log#', basename($file), $matches)) {
                @list(, $name) = $matches;
                $name = trim($name, '-_');

                if ($name !== $chan) {
                    continue;
                }

                $list[filemtime($file)] = $file;
            }
        }

        ksort($list);

        while (count($list) > $keep) {
            $file = array_shift($list);
            $basename = basename($file);
            @rename($file, $dest . $basename);
        }


        return $this;
    }
}

}
namespace Observable{




interface Observable
{

    /**
     * @param Event $event
     * @return Event
     */
    public function dispatchEvent(Event $event);


    /**
     * @param non-empty-string $type
     * @param callable $listener
     * @return void
     */
    public function addEventListener($type, callable $listener);

}

}
namespace Observable{



class Event
{
    /** @var string */
    protected $type;

    /** @var mixed */
    protected $detail;
    /** @var bool */
    protected $propagationStopped = false;

    /** @var ?Observable */
    protected $observer = null;

    /** @return bool */
    final public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    /** @return static */
    final public function stopPropagation()
    {
        $this->propagationStopped = true;
        return $this;
    }

    /**
     * @param non-empty-string $type
     * @param mixed $detail
     */
    public function __construct($type, $detail = null)
    {
        if (!$type || !is_string($type)) {
            throw new \InvalidArgumentException('$type must be a non empty string');
        }

        $this->type = $type;
        $this->detail = $detail;
    }

    /** @return string */
    final public function getType()
    {
        return $this->type;
    }


    /** @return mixed */
    final public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param mixed $detail
     * @return static
     */
    final public function setDetail($detail)
    {
        $this->detail = $detail;
        return $this;
    }

    /**
     * @return ?Observable
     */
    final public function getObserver()
    {
        return $this->observer;
    }

    /**
     * @param Observable $observer
     * @return Event
     */
    final public function setObserver(Observable $observer)
    {
        $this->observer = $observer;
        return $this;
    }


    /**
     * @param non-empty-string $type
     * @param mixed $detail
     * @return static
     */
    public static function newEvent($type, $detail = null)
    {
        return new static($type, $detail);
    }

}

}
namespace Observable{



final class EventDispatcher implements Observable
{

    private $listeners = [];


    public function dispatchEvent(Event $event)
    {

        if (!$event->isPropagationStopped()) {
            $event->setObserver($this);
            $type = $event->getType();
            if (!empty($this->listeners[$type])) {
                krsort($this->listeners[$type]);
                foreach ($this->listeners[$type] as $listenersSortedByPriority) {
                    foreach ($listenersSortedByPriority as $listener) {
                        $listener($event);
                        if ($event->isPropagationStopped()) {
                            break 2;
                        }
                    }
                }
            }
        }

        return $event;
    }

    /**
     * @param non-empty-string $type
     * @param callable $listener
     * @param int $priority greater priority will be executed first
     * @return void
     */
    public function addEventListener($type, callable $listener, $priority = 100)
    {
        if (!$type || !is_string($type)) {
            throw new \InvalidArgumentException('$type must be a non empty string');
        }

        if (!isset($this->listeners[$type])) {
            $this->listeners[$type] = [];
        }
        if (!isset($this->listeners[$type][$priority])) {
            $this->listeners[$type][$priority] = [];
        }
        $this->listeners[$type][$priority][] = $listener;

    }
}

}
namespace {

class EventListener
{
    /** @var null|Observable\EventDispatcher */
    protected static $instance = null;

    /**
     * @return Observable\EventDispatcher
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Observable\EventDispatcher();
        }

        return self::$instance;
    }

    /**
     * @param non-empty-string $eventType
     * @param callable $listener
     * @param int $priority greater priority will be executed first
     * @return void
     */
    public static function addEventListener($eventType, callable $listener, $priority = 100)
    {
        self::getInstance()->addEventListener($eventType, $listener, $priority);
    }

    /**
     * @param non-empty-string $eventType
     * @param mixed $data
     * @return \Observable\Event
     */
    public static function dispatchEvent($eventType, $data = null)
    {
        return self::getInstance()->dispatchEvent(new Observable\Event($eventType, $data));
    }

}

}
namespace {

class CurlHandler
{

    /**
     * Experimental technology to fetch a long list of urls faster
     * Only supports GET method with no header parsing
     *
     * @param string[]|Stringable[] $urls
     * @return HttpClient\CurlResponse[] returns responses in order of urls
     */
    public static function makeMultiGetRequests(array $urls)
    {
        $multi = new HttpClient\CurlMultiRequest();
        $cookies = tempnam(sys_get_temp_dir(), 'curl_multi');
        foreach ($urls as $url) {

            $req = (new HttpClient\CurlRequest());
            $multi->add(
                $req
                    // prevent multi handler to follow using synchronous request
                    ->setOpt(CURLOPT_FOLLOWLOCATION, true)
                    // as headers cannot be defined in that function,
                    // make belief we are in the last firefox version
                    ->setUserAgent(self::generateUserAgent())
                    // cookie support if needed
                    ->setCookieFile($cookies)
                    ->prepare(self::METHOD_GET, $url)
            );
        }

        // make request
        return $multi->execute()->getResults();
    }


    /**
     * @param string|Stringable $url
     * @param null|string|array<string, string> $params
     * @param string|Stringable $method
     * @param ?array<string, string|string[]> $headers
     * @param int $timeout
     *
     * @return HttpClient\CurlResponse
     */
    public static function makeHttpRequest($url, $params = null, $method = 'GET', $headers = null, $timeout = 0)
    {


        $req = new HttpClient\CurlRequest();
        $req->enableHeaderParsing();

        if (is_int($headers)) {
            $timeout = $headers;
            $headers = null;
        }

        if (is_array($method)) {
            $headers = $method;
            $method = "GET";
        }

        if (is_array($headers)) {

            $usable = [];

            foreach ($headers as $name => $val) {
                // add custom curl options to request
                if (strtolower($name) === "curl-options") {
                    if (is_array($val)) {
                        $req->setOpts($val);
                    }
                    continue;
                }
                if (strtolower($name) === "cookie-file") {
                    $req->setCookieFile($val);
                    continue;
                }
                $usable[$name] = $val;
            }
            $req->setHeaders($usable);
        }


        if ($timeout > 0) {
            $req->setTimeout($timeout);
        }

        try {
            return $req->fetch($method, $url, $params);
        } finally {
            $req->closeHandle();
        }
    }

    /**
     * @param string $method
     * @param bool $normalize
     * @return bool
     */
    public static function isValidMethod($method, $normalize = true)
    {
        if ($normalize) {
            $method = strtoupper($method);
        }
        return in_array($method, self::$VALID_METHODS);
    }

    /**
     * @param string|int|null|bool $version true => random, null|false => latest, int => "$version.0"
     * @return string
     */
    public static function generateUserAgent($version = null)
    {

        /**
         * @link https://wiki.mozilla.org/Release_Management/Product_details
         */
        static $ffListApi = "https://product-details.mozilla.org/1.0/firefox_history_major_releases.json",
        $ffLastApi = "https://product-details.mozilla.org/1.0/firefox_versions.json",
        $template = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:{version}) Gecko/20100101 Firefox/{version}";


        if (!isset(self::$firefoxVersions)) {

            $cachedFile = sys_get_temp_dir() . "/curl_firefox_versions.json";
            $cachedData = false;
            @mkdir(dirname($cachedFile), 0777, true);

            if (@filemtime($cachedFile) > time() - 3600) {

                $cachedData = @file_get_contents($cachedFile);

                if (is_string($cachedData)) {
                    $cachedData = json_decode($cachedData, true);
                }
            }

            if (!$cachedData) {
                $versions = [];

                if ($list = self::makeSimpleGetHttpRequest($ffListApi)) {
                    foreach (array_reverse($list) as $ver => $date) {

                        if (strtotime($date) < strtotime("-3 years")) {
                            continue;
                        }
                        if (!preg_match("#^\d+\.\d+$#", $ver)) {
                            continue;
                        }
                        if (strtotime($date) < time()) {
                            $versions[] = $ver;
                        }
                    }
                }

                $latest = self::$latestFirefoxVersion;

                if (!empty($versions)) {
                    $latest = $versions[0];
                }

                $data = self::makeSimpleGetHttpRequest($ffLastApi);
                if ($data) {
                    $latest = $data['LATEST_FIREFOX_VERSION'];
                }

                if (!empty($versions)) {
                    $cachedData = [$versions, $latest];
                    @file_put_contents($cachedFile, json_encode($cachedData));
                }
            }


            if ($cachedData) {
                list(self::$firefoxVersions, self::$latestFirefoxVersion) = $cachedData;
            }
        }


        if (!empty($version)) {

            if (is_int($version)) {
                $version = "$version.0";
            } elseif (true === $version) {
                $version = self::$firefoxVersions[array_rand(self::$firefoxVersions)];
            }
        } else {
            $version = self::$latestFirefoxVersion;
        }

        $version = preg_replace('#^(\d+\.\d+)\D*.*$#', '$1', $version);

        return str_replace("{version}", $version, $template);
    }

    public static function makeSimpleGetHttpRequest($url)
    {
        $json = @file_get_contents(
            $url,
            false,
            stream_context_create([
                'http' => ['method' => 'GET'],
                'ssl' => [
                    "verify_peer" => false,
                    "verify_peer_name" => false
                ]
            ])
        ) ?: "";
        if (null === $decoded = @json_decode($json, true)) {
            return $json;
        }
        return $decoded;
    }

    public static function getReasonPhrase($statusCode)
    {
        return isset(self::$REASON_PHRASES[$statusCode]) ? self::$REASON_PHRASES[$statusCode] : self::$REASON_PHRASES[0];
    }

    protected static $firefoxVersions = null;
    protected static $latestFirefoxVersion = "140.0";
    /**
     * @link https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     */
    protected static $REASON_PHRASES = [
        0 => "Unassigned",
        100 => "Continue",
        101 => "Switching Protocols",
        102 => "Processing",
        103 => "Early Hints",
        200 => "OK",
        201 => "Created",
        202 => "Accepted",
        203 => "Non-Authoritative Information",
        204 => "No Content",
        205 => "Reset Content",
        206 => "Partial Content",
        207 => "Multi-Status",
        208 => "Already Reported",
        226 => "IM Used",
        300 => "Multiple Choices",
        301 => "Moved Permanently",
        302 => "Found",
        303 => "See Other",
        304 => "Not Modified",
        305 => "Use Proxy",
        307 => "Temporary Redirect",
        308 => "Permanent Redirect",
        400 => "Bad Request",
        401 => "Unauthorized",
        402 => "Payment Required",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        406 => "Not Acceptable",
        407 => "Proxy Authentication Required",
        408 => "Request Timeout",
        409 => "Conflict",
        410 => "Gone",
        411 => "Length Required",
        412 => "Precondition Failed",
        413 => "Payload Too Large",
        414 => "URI Too Long",
        415 => "Unsupported Media Type",
        416 => "Range Not Satisfiable",
        417 => "Expectation Failed",
        421 => "Misdirected Request",
        422 => "Unprocessable Entity",
        423 => "Locked",
        424 => "Failed Dependency",
        425 => "Too Early",
        426 => "Upgrade Required",
        428 => "Precondition Required",
        429 => "Too Many Requests",
        431 => "Request Header Fields Too Large",
        451 => "Unavailable For Legal Reasons",
        500 => "Internal Server Error",
        501 => "Not Implemented",
        502 => "Bad Gateway",
        503 => "Service Unavailable",
        504 => "Gateway Timeout",
        505 => "HTTP Version Not Supported",
        506 => "Variant Also Negotiates",
        507 => "Insufficient Storage",
        508 => "Loop Detected",
        510 => "Not Extended",
        511 => "Network Authentication Required",
    ];


    const METHOD_GET = "GET";
    const METHOD_HEAD = "HEAD";
    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    const METHOD_DELETE = "DELETE";
    const METHOD_CONNECT = "CONNECT";
    const METHOD_OPTIONS = "OPTIONS";
    const METHOD_TRACE = "TRACE";
    const METHOD_PATCH = "PATCH";


    /**
     * Valid Methods
     */
    protected static $VALID_METHODS = [
        self::METHOD_GET,
        self::METHOD_HEAD,
        self::METHOD_POST,
        self::METHOD_PUT,
        self::METHOD_DELETE,
        self::METHOD_CONNECT,
        self::METHOD_OPTIONS,
        self::METHOD_TRACE,
        self::METHOD_PATCH,
    ];
}

}
namespace HttpClient{



use Lockable;


class CurlMultiRequest implements Lockable, \IteratorAggregate, \Countable
{

    /** @var \CurlMultiHandle|resource|null */
    protected $handle;
    protected $closed = true;
    protected $ready = false;
    protected $locked = false;
    /** @var array<string,CurlRequest> */
    protected $curlHandles = [];
    /** @var ?array<string,CurlResponse> */
    protected $results = null;
    /** @var ?array<string,CurlRequest> */
    protected $resultRequests = null;

    /**
     * @return static
     */
    public function execute()
    {
        if ($this->isLocked() || !$this->ready) {
            throw new \RuntimeException('CurlMultiRequest is locked or requests are not ready yet.');
        }

        $this->ready = false;
        $this->lock();


        $this->results = $this->resultRequests = [];
        $results = [];
        $handles = [];
        $mh = $this->getHandle();

        $n = 0;

        foreach ($this->curlHandles as $curlHandle) {
            if ($curlHandle->isReady()) {
                $n++;
                @curl_multi_add_handle(
                    $mh,
                    $handles[$curlHandle->getUid()] = $curlHandle->getHandle()
                );
            }
        }

        if (!$n) {
            throw new \RuntimeException('no requests are ready.');
        }

        $active = null;
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);


        while ($active && $mrc == CURLM_OK) {
            curl_multi_select($mh);
            usleep(90);
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            while ($info = curl_multi_info_read($mh)) {

                $ch = $info["handle"];
                curl_multi_remove_handle($mh, $ch);
                $uid = array_search($ch, $handles, true);
                $req = $this->curlHandles[$uid];

                $result = $req->getResult();
                // redirection
                if ($req->isReady()) {
                    $result = $req->execute();
                }
                $results[$uid] = $result;
            }
        }

        $this->unlock();
        // sort results by request order
        foreach (array_keys($this->curlHandles) as $uid) {
            if (isset($results[$uid])) {
                $this->results[$uid] = $results[$uid];
                $this->resultRequests[$uid] = $this->curlHandles[$uid];
                $this->remove($uid);
            }
        }


        return $this->closeHandle();
    }

    /**
     * @return CurlResponse[]
     */
    public function getResults()
    {

        if (empty($this->results)) {
            return [];
        }


        return $this->results;
    }


    /**
     * @param CurlRequest|string $request
     * @return static
     */
    public function remove($request)
    {

        if (!$this->isLocked()) {
            if ($request instanceof CurlRequest) {
                $request = $request->getUid();
            }

            if (is_string($request)) {
                unset($this->curlHandles[$request]);
            }

            $this->ready = array_any($this->curlHandles, function ($request) {
                return $request->isReady();
            });
        }


        return $this;
    }


    public function add(CurlRequest $curlRequest)
    {
        if (!$this->isLocked()) {
            $this->curlHandles[$curlRequest->getUid()] = $curlRequest;
            if ($curlRequest->isReady()) {
                $this->ready = true;
            }
        }

        return $this;
    }

    /**
     * @param CurlRequest[] $requests
     * @return $this
     */
    public function addMany(array $requests)
    {
        foreach ($requests as $request) {
            if (!($request instanceof CurlRequest)) {
                throw new \InvalidArgumentException('$requests must be of type CurlRequest[]');
            }
            $this->add($request);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        return $this->ready;
    }


    public function __destruct()
    {
        if (!$this->closed) {
            @curl_multi_close($this->handle);
        }
    }

    /**
     * @return \CurlMultiHandle|resource
     */
    public function getHandle()
    {
        if ($this->closed) {
            $this->handle = @curl_multi_init();
            $this->closed = false;
        }

        return $this->handle;
    }


    /**
     * @return static
     */
    public function closeHandle()
    {
        if (!$this->closed) {
            @curl_multi_close($this->handle);
            $this->closed = true;
            $this->ready = false;
            $this->handle = null;
        }

        return $this;
    }


    public function lock()
    {
        $this->locked = true;
    }

    public function unlock()
    {
        $this->locked = false;
    }

    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @return \Traversable<CurlRequest,CurlResponse>
     */
    public function getIterator()
    {
        if (is_array($this->results)) {
            foreach ($this->results as $uid => $response) {
                yield $this->resultRequests[$uid] => $response;
            }
        }
    }

    public function count()
    {
        return is_array($this->results) ? count($this->results) : 0;
    }
}

}
namespace HttpClient{



use CurlHandler;

/**
 * @property-read ?resource $file
 * @property-read string $uid
 * @property-read int $requestCount
 */
class CurlRequest
{

    /** @var \CurlHandle|resource|null */
    protected $handle;
    protected $closed = true;
    protected $ready = false;
    /** @var string */
    protected $uid;

    protected $options = [];

    /** @var ?resource */
    protected $file = null;
    protected $initialCount = 0;

    protected $requestHeaders = [];
    protected $requestCount = 0;


    protected $parseHeaders = false;
    protected $rawHeaders = "";
    protected $responseHeaders = [];

    /** @var null|CurlResponse */
    protected $previous = null;

    /**
     * @param string|\Stringable $method
     * @param string|\Stringable $url
     * @param string|array|null $params
     * @return CurlResponse
     */

    public function fetch($method, $url, $params = null)
    {
        return $this
            ->prepare($method, $url, $params)
            ->execute();
    }


    /**
     * Make a GET request
     * @param string $url
     * @param null|string|array $params
     * @param ?array $headers
     * @return CurlResponse
     */
    public function get($url, $params = null, $headers = null)
    {
        if (is_array($headers)) {
            $this->setHeaders($headers);
        }
        return $this->fetch(self::GET, $url, $params);
    }


    /**
     * Make a POST request
     * if params are json please set header: "content-type" => "application/json"
     * @param string $url
     * @param null|string|array $params
     * @param ?array $headers
     * @return CurlResponse
     */
    public function post($url, $params = null, $headers = null)
    {
        if (is_array($headers)) {
            $this->setHeaders($headers);
        }

        return $this->fetch(self::POST, $url, $params);
    }


    /**
     * @param string|\Stringable $method
     * @param string|\Stringable $url
     * @param string|array|null $params
     * @return static
     */
    public function prepare($method, $url, $params = null)
    {

        $url = (string)$url;
        $method = (string)$method;

        $this->previous = null;
        $this->responseHeaders = [];
        $this->rawHeaders = "";
        $this->initialCount = $this->requestCount;


        $json = false;
        $requestMethod = strtoupper($method);
        if (preg_match("#^(.+)JSON$#", $requestMethod, $matches)) {
            $requestMethod = $matches[1];
            $json = true;
        }

        if (!CurlHandler::isValidMethod($requestMethod)) {
            throw new \InvalidArgumentException("Invalid method $requestMethod");
        }

        // for faster requests
        $this->unsetOpt(\CURLOPT_HEADERFUNCTION);
        if ($this->parseHeaders) {
            $this->setOpt(\CURLOPT_HEADERFUNCTION, $this->generateHeaderFunction());
        }

        $this->setOpt(\CURLOPT_CUSTOMREQUEST, $requestMethod);

        if (!$this->getHeader("content-type") && $requestMethod !== "GET") {
            $this->addHeader("content-type", "application/x-www-form-urlencoded");
            if ($json) {
                $this->addHeader("content-type", "application/json");
            }
        }

        if (is_array($params)) {
            $params = $json ? json_encode($params) : http_build_query($params);
        }


        $this->unsetOpt(\CURLOPT_POSTFIELDS);

        if ($method === "GET" && !$json) {
            $this->unsetOpt(\CURLOPT_CUSTOMREQUEST);
            if (!empty($params)) {
                $url .= false !== strpos($url, "?") ? "&" : "?";
                $url .= $params;
            }
        } elseif (is_string($params)) {
            $this->setOpt(\CURLOPT_POSTFIELDS, $params);
        }

        $this->unsetOpt(\CURLOPT_HTTPHEADER);


        if (!empty($this->requestHeaders)) {
            $this->setOpt(\CURLOPT_HTTPHEADER, $this->makeHeaders());
        }

        $this->setOpt(\CURLOPT_URL, $url);
        $this->setOpt(\CURLOPT_FILE, $this->createFileHandle());
        $ch = $this->getHandle();
        curl_reset($ch);
        foreach ($this->options as $name => $value) {
            curl_setopt($this->getHandle(), $name, $value);
        }
        $this->ready = true;
        return $this;
    }

    /**
     * @return CurlResponse
     */
    public function getResult()
    {

        $ch = $this->getHandle();
        $info = curl_getinfo($ch);
        $statusCode = intval($info['http_code']);
        $success = 0 !== $statusCode;
        $statusText = CurlHandler::getReasonPhrase($statusCode);
        $info["status"] = $statusCode;
        $info["statusText"] = $statusText;
        $info["error"] = [
            curl_errno($ch) => curl_error($ch)
        ];


        $redirections = ($this->requestCount - $this->initialCount) - 1;
        if (!empty($info["redirect_count"])) {
            $redirections = $info["redirect_count"];
        }

        $resp = CurlResponse::make([
            "success" => $success,
            "info" => $info,
            "stream" => $this->file,
            "headers" => $this->responseHeaders,
            "previous" => $this->previous,
            "redirections" => $redirections
        ]);

        // prevent infinite loop in execute on multi redirects
        $this->ready = false;

        // auto redirect (301,302)
        if (!empty($info["redirect_url"])) {
            $this->previous = $resp;
            // reset data for new request
            $this->rawHeaders = "";
            $this->responseHeaders = [];
            curl_setopt($ch, \CURLOPT_FILE, $this->file = @fopen("php://temp", "r+"));
            curl_setopt($ch, \CURLOPT_URL, $info["redirect_url"]);
            $this->ready = true;
        }
        return $resp;
    }


    /**
     * @return CurlResponse|null
     */
    public function execute()
    {
        if ($this->ready) {


            $ch = $this->getHandle();
            while (1) {
                @set_time_limit(120);
                @curl_exec($ch);

                $resp = $this->getResult();
                // redirection
                if ($this->ready) {
                    continue;
                }
                return $resp;
            }
        }
        return null;
    }


    public function __construct()
    {
        $this->uid = \generate_uid();
        $this->options = [
            \CURLOPT_ENCODING => 'gzip,deflate',
            \CURLOPT_AUTOREFERER => true,
            \CURLOPT_SSL_VERIFYPEER => 0,
        ];
    }


    public function __destruct()
    {
        if (!$this->closed) {
            @curl_close($this->handle);
        }
    }

    /**
     * @return \CurlHandle|resource
     */
    public function getHandle()
    {
        if ($this->closed) {
            $this->handle = curl_init();
            $this->closed = false;
        }
        return $this->handle;
    }

    /**
     * @return static
     */
    public function closeHandle()
    {
        if (!$this->closed) {
            @curl_close($this->handle);
            $this->closed = true;
            $this->ready = false;
            $this->uid = \generate_uid();
            $this->handle = null;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getRequestCount()
    {
        return $this->requestCount;
    }


    /**
     * @return bool
     */
    public function isReady()
    {
        return $this->ready;
    }


    /**
     * @param int $option
     * @param mixed $value
     * @return static
     */
    public function setOpt($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * @param array<int,mixed> $options
     * @return static
     */
    public function setOpts(array $options)
    {
        foreach ($options as $option => $value) {
            $this->setOpt($option, $value);
        }
        return $this;
    }

    /**
     * @param int $option
     * @return static
     */
    public function unsetOpt($option)
    {
        unset($this->options[$option]);
        return $this;
    }


    /**
     * @param string $file
     * @return static
     */
    public function setCookieFile($file)
    {
        $umask = @umask(0);
        @mkdir(dirname($file), 0777, true);
        @umask($umask);
        if (!is_writable(dirname($file))) {
            throw new \RuntimeException("Cookie file $file cannot be created.");
        }
        $this->setOpt(\CURLOPT_COOKIEFILE, $file);
        return $this->setOpt(\CURLOPT_COOKIEJAR, $file);
    }

    /**
     * @param int $timeout
     * @return static
     */
    public function setTimeout($timeout)
    {

        if (is_int($timeout) && $timeout > 0) {
            $this->setOpts([
                \CURLOPT_CONNECTTIMEOUT => $timeout,
                \CURLOPT_TIMEOUT => $timeout,
            ]);
        }

        return $this;
    }


    /**
     * @param string|bool|null $userAgent
     * @return static
     */
    public function setUserAgent($userAgent = null)
    {
        if (is_int($userAgent) || true === $userAgent || null === $userAgent) {
            $userAgent = CurlHandler::generateUserAgent($userAgent);
        }

        unset($this->requestHeaders["user-agent"]);

        if (false === $userAgent) {
            unset($this->options[\CURLOPT_USERAGENT]);
            return $this;
        }

        return $this->setOpt(\CURLOPT_USERAGENT, $userAgent);
    }

    /**
     * @return bool
     */
    public function canParseHeaders()
    {
        return $this->parseHeaders;
    }

    /**
     * @param bool $parseHeaders
     * @return static
     */
    public function enableHeaderParsing($parseHeaders = true)
    {
        $this->parseHeaders = $parseHeaders !== false;
        return $this;
    }


    /**
     * @param string $name
     * @return string
     */
    public function getHeader($name)
    {
        if (!isset($this->requestHeaders[strtolower($name)])) {
            return "";
        }
        return $this->requestHeaders[strtolower($name)];
    }


    /**
     * Erases previous headers and replaces them with provided values
     * @param array<string,string|string[]> $headers
     * @return static
     */
    public function setHeaders(array $headers)
    {
        $this->requestHeaders = [];
        return $this->addHeaders($headers);
    }


    /**
     * @param array<string,string|string[]> $headers
     * @return static
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->addHeader($name, $value);
        }
        return $this;
    }

    /**
     * @param string $name
     * @param string|string[] $value
     * @return $this
     */
    public function addHeader($name, $value)
    {

        if (!is_array($value)) {
            $value = array_slice(func_get_args(), 1);
        }
        if (is_string($name)) {
            $name = strtolower($name);
            if ($name === "user-agent") {
                return $this->setOpt(\CURLOPT_USERAGENT, $value[0]);
            }
            $this->requestHeaders[$name] = implode(", ", $value);

            if ($name === "referer") {
                unset($this->options[\CURLOPT_AUTOREFERER]);
            }
        }
        return $this;
    }

    public function removeHeader($name)
    {
        unset($this->requestHeaders[strtolower($name)]);
        return $this;
    }


    /**
     * @param string $name
     * @return string
     */
    protected function getHeaderName($name)
    {
        return ucfirst(preg_replace_callback('#-([a-z])#', function ($matches) {
            return strtoupper($matches[0]);
        }, strtolower($name)));
    }

    /**
     * @return string[]
     */
    protected function makeHeaders()
    {
        $headers = [];
        foreach ($this->requestHeaders as $name => $value) {
            $headers[] = sprintf('%s: %s', $this->getHeaderName($name), $value);
        }
        return $headers;
    }

    /**
     * @return resource
     */
    protected function createFileHandle()
    {
        if ($this->file) {
            @fclose($this->file);
        }
        return $this->file = @fopen("php://temp", "r+");
    }


    protected function generateHeaderFunction()
    {
        return function () {
            $doNotSplit = ["set-cookie"];
            $this->rawHeaders .= $raw = func_get_arg(1);
            $len = strlen($raw);

            if (!empty($line = rtrim($raw)) && preg_match("#^(\H+):\h+(.+)$#", $line, $matches)) {


                $responseHeaders = &$this->responseHeaders;
                list(, $name, $values) = $matches;
                $name = strtolower($name);
                if (!isset($responseHeaders[$name])) {
                    $responseHeaders[$name] = [];
                }

                // dates and others
                if (in_array($name, $doNotSplit) || false !== strtotime($values)) {
                    $responseHeaders[$name][] = trim($values);
                    return $len;
                }


                foreach (explode(",", $values) as $value) {
                    $responseHeaders[$name][] = trim($value);
                }
            } elseif (0 === strpos($raw, "HTTP/")) {
                // detects a new request
                $this->responseHeaders = [];
                $this->rawHeaders = $raw;
                $this->requestCount++;
            }

            return $len;
        };
    }

    public function __get($name)
    {
        if (!$this->__isset($name)) {
            return null;
        }
        return $this->{$name};
    }


    public function __isset($name)
    {
        return property_exists($this, $name) && $this->{$name} !== null;
    }


    public function __set($name, $value)
    {
    }

    public function __unset($name)
    {
    }


    /**
     * Methods
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     */
    const GET = "GET";
    const HEAD = "HEAD";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";
    const CONNECT = "CONNECT";
    const OPTIONS = "OPTIONS";
    const TRACE = "TRACE";
    const PATCH = "PATCH";
}

}
namespace HttpClient{




/**
 * @property-read string $body
 * @property-read int $status
 * @property-read string $statusText
 * @property-read array<int,string> $error
 */
class CurlResponse
{


    /**
     * @var array<string,mixed>
     */
    public $info = null;

    public $success = false;
    protected $contents = null;
    protected $stream = null;
    protected $headers = [];

    public $redirections = 0;

    /**
     * @var array<string,string>
     */
    protected $headerNames = [];


    protected $previous = null;

    /**
     * @return ?static
     */
    public function getPrevious()
    {
        return $this->previous;
    }


    protected function fixHeaders()
    {


        if ($this->stream) {
            $this->contents = null;
        }

        $this->headerNames = [];
        foreach (array_keys($this->headers) as $lowercased) {
            $lowercased = strtolower($lowercased);
            $name = preg_replace_callback("#-\w#", function ($matches) {
                return strtoupper($matches[0]);
            }, ucfirst($lowercased));
            $this->headerNames[$lowercased] = $name;
        }
        $headers = $this->headers;
        $this->headers = [];
        foreach ($this->headerNames as $lower => $name) {
            $this->headers[$name] = $headers[$lower];
        }
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $header
     * @return bool
     */
    public function hasHeader($header)
    {
        return isset($this->headerNames[strtolower($header)]);
    }


    /**
     * @param string $header
     * @return array
     */
    public function getHeader($header)
    {
        $header = strtolower($header);

        if (!isset($this->headerNames[$header])) {
            return [];
        }

        $header = $this->headerNames[$header];
        return $this->headers[$header];
    }

    /**
     * @param string $header
     * @return string
     */
    public function getHeaderLine($header)
    {
        return implode(', ', $this->getHeader($header));
    }


    /**
     * @return string
     */
    public function getRawHeaders()
    {
        $str = "";
        foreach (array_keys($this->headerNames) as $name) {
            $str .= sprintf("%s: %s\n", $this->headerNames[$name], $this->getHeaderLine($name));
        }


        return rtrim($str);
    }


    public function __destruct()
    {
        if ($this->stream) {
            @fclose($this->stream);
        }
    }

    /**
     * @param array $data
     * @param ?static $instance
     * @return static
     */
    public static function make(array $data, $instance = null)
    {
        if (!isset($instance)) {
            $instance = new static();
        }
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
            }
        }
        $instance->fixHeaders();
        return $instance;
    }

    /**
     * @return ?string
     */
    public function getContents()
    {

        if (!isset($this->contents)) {
            $this->contents = "";
            if ($this->stream) {
                if (-1 !== @fseek($this->stream, 0)) {
                    $this->contents = stream_get_contents($this->stream);
                }
                @fclose($this->stream);
                $this->stream = null;
            }
        }
        return $this->contents;
    }


    /**
     * @return mixed
     */
    public function getDecodedContents()
    {
        $contents = $this->getContents();

        if (null === ($value = @json_decode($contents, true))) {
            $value = $contents;
        }

        return $value;
    }


    public function __get($name)
    {
        if ($name === "body") {
            return $this->getContents();
        }

        if ($this->__isset($name)) {
            return $this->info[$name];
        }

        return null;
    }


    public function __isset($name)
    {
        if ($name === "body") {
            return true;
        }

        return is_array($this->info) && isset($this->info[$name]);
    }


    public function __set($name, $value)
    {
    }

    public function __unset($name)
    {
    }

}

}
namespace {

class HeaderManager implements IteratorAggregate, Countable, JsonSerializable
{
    /**
     * @param array<string,string|string[]> $headers
     * @return static
     */
    public static function of(array $headers)
    {
        $instance = new static();
        return $instance->setHeaders($headers);
    }


    /**
     * @var array<string,string>
     */
    private $names = [];

    /**
     * @var array<string,string[]>
     */
    private $values = [];


    /**
     * @param string $name
     * @return string[]
     */
    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        return $this->values[$this->normalizeName($name)];
    }


    /**
     * @param string $name
     * @return string
     */
    public function getHeaderLine($name)
    {
        return implode(', ', $this->getHeader($name));
    }


    /**
     * @return string
     */
    public function getRawHeaders()
    {
        $str = "";
        foreach ($this->names as $name) {
            $str .= sprintf("%s: %s\n", $name, $this->getHeaderLine($name));
        }
        return rtrim($str);
    }


    /**
     * @param string $name
     * @return bool
     */
    public function hasHeader($name)
    {
        return isset($this->names[$this->normalizeName($name)]);
    }

    /**
     * @param string $name
     * @param string|string[] $value
     * @param string ...$otherValues
     * @return static
     */
    public function addHeader($name, $value)
    {

        $values = $this->getHeader($name);

        if (!is_array($value)) {
            $value = array_slice(func_get_args(), 1);
        }

        foreach ($value as $v) {
            if (!in_array($v, $values)) {
                $values[] = $v;
            }
        }

        $this->setHeader($name, $values);

        return $this;
    }

    /**
     * @param array<string,string|string[]> $values
     * @return static
     */
    public function setHeaders(array $values)
    {
        $this->names = $this->values = [];

        foreach ($values as $name => $value) {

            if (!is_array($value)) {
                $value = [$value];
            }
            $this->setHeader($name, $value);
        }

        return $this;
    }


    /**
     * @param string $name
     * @param string|string[] $value
     * @param string ...$otherValues
     * @return static
     */
    public function setHeader($name, $value)
    {
        $norm = $this->normalizeName($name);
        $real = $this->getHeaderName($norm);
        if (!is_array($value)) {
            $value = array_slice(func_get_args(), 1);
        }

        $this->names[$norm] = $real;
        $this->values[$norm] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @return static
     */
    public function removeHeader($name)
    {
        unset($this->names[$this->normalizeName($name)], $this->values[$this->normalizeName($name)]);
        return $this;

    }


    /**
     * @param string $name
     * @return string
     */
    private function getHeaderName($name)
    {
        $normalized = $this->normalizeName($name);
        if (isset($this->names[$normalized])) {
            return $this->names[$normalized];
        }

        return ucfirst(preg_replace_callback('#-([a-z])#', function ($matches) {
            return strtoupper($matches[0]);
        }, $normalized));
    }

    private function normalizeName($name)
    {
        return strtolower($name);
    }

    /**
     * @return Traversable
     */

    public function getIterator()
    {
        foreach ($this->names as $name) {
            yield $name => $this->getHeaderLine($name);
        }
    }

    /**
     * @return int
     */

    public function count()
    {
        return count($this->names);
    }

    /**
     * @return array<string,string>
     */
    public function toArray()
    {
        return iterator_to_array($this);
    }

    /**
     * @return array<string,string>
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}

}