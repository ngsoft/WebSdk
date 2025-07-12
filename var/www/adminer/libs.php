<?php
/**
 * PHP Dev Tools
 * @author Aymeric Anger
 * @version 25.07.5 build on 2025-07-11
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
            $filename = str_replace($sep, $pSep, $className) . $extension;
            require_secure($normalizedPath . $filename);
        }
    });

}

if (!function_exists('renderArgs')) {

    /**
     * Renders arguments as `$prefix.$key="$value"`.
     * Also encodes values to string if value is null or boolean false, it will not be rendered
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
     * @noinspection PhpMissingParamTypeInspection
     * @noinspection PhpMissingReturnTypeInspection
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
         * @var string[] $voidElements
         * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
         */
        static $voidElements = [
            "area", "base", "br", "col",
            "embed", "hr", "img", "input",
            "link", "meta", "param", "source",
            "track", "wbr"
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
     * Count number of occurence of value in iterable
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
     * @param bool $more_entropy
     * @return string
     */
    function generate_uid($more_entropy = false)
    {
        static $known = [];
        do {
            $parts = explode('.', uniqid('', (bool)$more_entropy));
            if (isset($parts[1])) {
                $parts[1] = dechex((int)$parts[1]);
            }
            $uid = implode('', $parts);

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
    /** @var array|null */
    private $values = null;
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
     * If the value that is associated to the provided key is an object,
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