<?php
/**
 * A convenience method to set up a column definitions array
 */

namespace DataTables\Lib;

/**
 * Class ColumnDefinitions
 *
 * @package DataTables\Lib
 */
class ColumnDefinitions implements \JsonSerializable, \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $columns = [];
    protected $index = [];

    /**
     * @param        $column    string|array name or pre-filled array
     * @param string|null $fieldName : ORM field this column is based on
     *
     * @return ColumnDefinition
     */
    public function add($column, string $fieldName = null)
    : ColumnDefinition
    {
        if (!is_array($column))
            $column = [
                'name' => $column,
                'data' => $column, // a good guess (user can adjust it later)
            ];
        if ($fieldName)
            $column['field'] = $fieldName;

        $column = new ColumnDefinition($column, $this);
        $this->store($column);

        return $column;
    }

    /**
     * @param \DataTables\Lib\ColumnDefinition $column
     */
    protected function store(ColumnDefinition $column)
    {
        $this->columns[] = $column;
        /* keep track of where we stored it.
           Note: our array is only growing! No splicing! */
        $this->index[$column['name']] = count($this->columns) - 1;
    }

    /**
     * Set titles of columns in given order
     * Convenience method for setting all titles at once
     *
     * @param $titles array of titles in order of columns
     */
    public function setTitles(array $titles)
    {
        if (count($titles) != count($this->columns)) {
            $msg = 'Have ' . count($this->columns) . ' columns, but ' . count($titles) . ' titles given!';
            throw new \InvalidArgumentException($msg);
        }
        foreach ($titles as $i => $t) {
            if (!empty($t))
                $this->columns[$i]['title'] = $t;
        }
    }

    /**
     * Serialize to an array in json
     *
     * @return array: column definitions
     */
    public function jsonSerialize()
    : array
    {
        return array_values($this->columns);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    : bool
    {
        if (is_numeric($offset))
            return isset($this->columns[$offset]);

        return isset($this->index[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (is_numeric($offset))
            return $this->columns[$offset];

        return $this->columns[$this->index[$offset]];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException('Direct setting is not supported! Use add().');
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        /* we do not allow splicing because DataTables uses a column's index
           for the ordering command. So the order of columns needs to stay
           consistent from the Controller down to the table displayed. */
        throw new \BadMethodCallException('Unset is not supported!');
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->columns);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->columns);
    }
}
