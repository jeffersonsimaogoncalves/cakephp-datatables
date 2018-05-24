<?php
/**
 * Created by PhpStorm.
 * User: jeffersonsimaogoncalves
 * Date: 23/05/2018
 * Time: 23:31
 */

namespace DataTables\Utility;

/**
 * Class TableUtility
 *
 * @property string table
 * @property array columns
 * @property int count
 * @property array data
 * @property array order
 *
 * @package DataTables\Utility
 */
class TableUtility
{
    /**
     * @return array
     */
    public function getClass(): array
    {
        return [
            'class' => 'table table-bordered table-striped',
        ];
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'data' => $this->data,
            'deferLoading' => $this->count,
            'columns' => $this->columns,
            'order' => $this->order,
        ];
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return strtolower($this->table) . '-table';
    }
}
