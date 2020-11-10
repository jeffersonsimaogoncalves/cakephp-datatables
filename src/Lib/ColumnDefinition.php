<?php

namespace DataTables\Lib;

use JeffersonSimaoGoncalves\Utility\Lib\CallbackFunction;

/**
 * A convenience array wrapper that holds a single column definition
 *
 * @method ColumnDefinition visible()
 * @method ColumnDefinition notVisible()
 * @method ColumnDefinition orderable()
 * @method ColumnDefinition notOrderable()
 * @method ColumnDefinition searchable()
 * @method ColumnDefinition notSearchable()
 *
 * @package DataTables\Lib
 */
class ColumnDefinition implements \JsonSerializable, \ArrayAccess
{
    /** @var array holding all column properties */
    public $content = [];

    /** @var ColumnDefinitions */
    protected $owner = null;

    protected $switchesPositive = ['visible', 'orderable', 'searchable'];
    // will be filled in constructor
    protected $switchesNegative = [];

    /**
     * ColumnDefinition constructor.
     *
     * @param array $template
     * @param \DataTables\Lib\ColumnDefinitions $owner
     */
    public function __construct(array $template, ColumnDefinitions $owner)
    {
        $this->content = $template;
        $this->owner = $owner;

        $this->switchesNegative = array_map(function ($e) {
            return 'not' . ucfirst($e);
        }, $this->switchesPositive);
    }

    /**
     * Refer back to owner's add()
     * A convenient way to add another column
     *
     * @param array $args
     *
     * @return \DataTables\Lib\ColumnDefinition
     */
    public function add(...$args): ColumnDefinition
    {
        return $this->owner->add(...$args);
    }

    /**
     * Set one or many properties
     *
     * @param $key   string|array If array given, it should be key -> value
     * @param $value : The singular value to set, if string $key given
     *
     * @return ColumnDefinition
     */
    public function set($key, $value = null): ColumnDefinition
    {
        if (is_array($key)) {
            if (!empty($value))
                throw new \InvalidArgumentException("Provide either array or key/value pair!");

            $this->content = $key + $this->content;
        } else {
            $this->content[$key] = $value;
        }

        return $this;
    }

    /* provide some convenience wrappers for set() */
    /**
     * @param $name
     * @param $arguments
     *
     * @return \DataTables\Lib\ColumnDefinition
     */
    public function __call($name, $arguments): ColumnDefinition
    {
        if (in_array($name, $this->switchesPositive)) {
            if (!empty($arguments))
                throw new \InvalidArgumentException("$name() takes no arguments!");

            $this->content[$name] = true;
        }
        if (in_array($name, $this->switchesNegative)) {
            if (!empty($arguments))
                throw new \InvalidArgumentException("$name() takes no arguments!");

            $name = lcfirst(substr($name, 3));
            $this->content[$name] = false;
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return \DataTables\Lib\ColumnDefinition
     */
    public function unset(string $key): ColumnDefinition
    {
        unset($this->content[$key]);

        return $this;
    }

    /**
     * @param $name : see CallbackFunction::__construct
     * @param $args : see CallbackFunction::__construct
     *
     * @return ColumnDefinition
     */
    public function render(string $name, array $args = []): ColumnDefinition
    {
        $this->content['render'] = new CallbackFunction($name, $args);

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->content;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->content[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->content[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->content[] = $value;
        } else {
            $this->content[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->content[$offset]);
    }

}
