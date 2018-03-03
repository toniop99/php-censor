<?php

namespace PHPCensor;

use b8\Exception\HttpException;

class Model
{
    /**
     * @var array
     */
    protected $getters = [];

    /**
     * @var array
     */
    protected $setters = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $modified = [];

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @param array $initialData
     */
    public function __construct($initialData = [])
    {
        if (is_array($initialData)) {
            foreach ($initialData as $index => $item) {
                if (!array_key_exists($index, $this->data)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Model "%s" doesn\'t have field "%s"',
                        get_called_class(),
                        $index
                    ));
                }

                $this->data[$index] = $item;
            }
        }
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param string $column
     */
    protected function setModified($column)
    {
        $this->modified[$column] = $column;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws HttpException\ValidationException
     */
    protected function validateString($name, $value)
    {
        if (!is_string($value) && !is_null($value)) {
            throw new HttpException\ValidationException('Column "' . $name . '" must be a string.');
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws HttpException\ValidationException
     */
    protected function validateInt($name, $value)
    {
        if (!is_integer($value) && !is_null($value)) {
            throw new HttpException\ValidationException('Column "' . $name . '" must be an integer.');
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws HttpException\ValidationException
     */
    protected function validateFloat($name, $value)
    {
        if (!is_float($value) && !is_null($value)) {
            throw new HttpException\ValidationException('Column "' . $name . '" must be a float.');
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws HttpException\ValidationException
     */
    protected function validateDate($name, $value)
    {
        if (!($value instanceof \DateTime) && !is_null($value)) {
            throw new HttpException\ValidationException('Column "', $name . '" must be a date object.');
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws HttpException\ValidationException
     */
    protected function validateNotNull($name, $value)
    {
        if (is_null($value)) {
            throw new HttpException\ValidationException('Column "', $name . '" must not be null.');
        }
    }
}
