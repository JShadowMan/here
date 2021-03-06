<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Model;

use Bops\Exception\Framework\Mvc\Model\ModelSaveException;
use Bops\Mvc\Model;


/**
 * Class Field
 *
 * @package Here\Model
 */
class Field extends Model {

    /**
     *
     * @var integer
     */
    protected $field_id;

    /**
     *
     * @var string
     */
    protected $field_key;

    /**
     *
     * @var string
     */
    protected $field_value;

    /**
     *
     * @var string
     */
    protected $field_value_type;

    /**
     * Method to set the value of field field_key
     *
     * @param string $field_key
     * @return $this
     */
    public function setFieldKey(string $field_key) {
        $this->field_key = $field_key;

        return $this;
    }

    /**
     * Method to set the value of field field_value
     *
     * @param string $field_value
     * @return $this
     */
    public function setFieldValue(string $field_value) {
        $this->field_value = $field_value;

        return $this;
    }

    /**
     * Methods to make string field
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    final public function setStringField(string $key, string $value) {
        $this->field_key = $key;
        $this->field_value_type = self::FIELD_VALUE_TYPE_STRING;
        $this->field_value = $value;
        return $this;
    }

    /**
     * Methods to make integer field
     *
     * @param string $key
     * @param int $value
     * @return $this
     */
    final public function setIntegerField(string $key, int $value) {
        $this->field_key = $key;
        $this->field_value_type = self::FIELD_VALUE_TYPE_INTEGER;
        $this->field_value = $value;
        return $this;
    }

    /**
     * Methods to make float field
     *
     * @param string $key
     * @param float $value
     * @return $this
     */
    final public function setFloatField(string $key, float $value) {
        $this->field_key = $key;
        $this->field_value_type = self::FIELD_VALUE_TYPE_FLOAT;
        $this->field_value = strval($value);
        return $this;
    }

    /**
     * Methods to make integer field
     *
     * @param string $key
     * @param bool $value
     * @return $this
     */
    final public function setBooleanField(string $key, bool $value) {
        $this->field_key = $key;
        $this->field_value_type = self::FIELD_VALUE_TYPE_BOOLEAN;
        $this->field_value = $value ? 'true' : 'false';
        return $this;
    }

    /**
     * Methods to make serialized field
     *
     * @param string $key
     * @param $value
     * @return $this
     */
    final public function setSerializedField(string $key, $value) {
        $this->field_key = $key;
        $this->field_value_type = self::FIELD_VALUE_TPE_SERIALIZED;
        $this->field_value = serialize($value);
        return $this;
    }

    /**
     * Method to set the value of field field_value_type
     *
     * @param string $field_value_type
     * @return $this
     */
    public function setFieldValueType(string $field_value_type) {
        $this->field_value_type = $field_value_type;

        return $this;
    }

    /**
     * Returns the value of field field_id
     *
     * @return integer
     */
    public function getFieldId() {
        return (int)$this->field_id;
    }

    /**
     * Returns the value of field field_key
     *
     * @return string
     */
    public function getFieldKey() {
        return $this->field_key;
    }

    /**
     * Returns the value of field field_value
     *
     * @return string
     */
    public function getFieldValue() {
        return $this->field_value;
    }

    /**
     * Returns the value of field field_value_type
     *
     * @return string
     */
    public function getFieldValueType() {
        return $this->field_value_type;
    }

    /**
     * Returns the field is string type
     *
     * @return bool
     */
    public function isStringField(): bool {
        return is_null($this->field_value_type) ||
            $this->field_value_type === self::FIELD_VALUE_TYPE_STRING;
    }

    /**
     * Returns the field is integer type
     *
     * @return bool
     */
    public function isIntegerField(): bool {
        return $this->field_value_type === self::FIELD_VALUE_TYPE_INTEGER;
    }

    /**
     * Returns the field is integer type
     *
     * @return bool
     */
    public function isFloatField(): bool {
        return $this->field_value_type === self::FIELD_VALUE_TYPE_FLOAT;
    }

    /**
     * Returns the field is boolean type
     *
     * @return bool
     */
    public function isBooleanField(): bool {
        return $this->field_value_type === self::FIELD_VALUE_TYPE_BOOLEAN;
    }

    /**
     * Returns the field is serialized type
     *
     * @return bool
     */
    public function isSerializedField(): bool {
        return $this->field_value_type === self::FIELD_VALUE_TPE_SERIALIZED;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSource('field');
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'field';
    }

    /**
     * Query field by column name, returns null when field
     * not exists.
     *
     * @param string $key
     * @return Field|null
     */
    public static function findByKey(string $key): ?self {
        return static::findFirst([
            'conditions' => 'field_key = ?0',
            'bind' => [$key]
        ]);
    }

    /**
     * Create a field but does't inserted into the database
     *
     * @param string $key
     * @return Field
     */
    public static function factory(string $key): self {
        $field = new static();
        $field->setFieldKey($key);

        return $field;
    }

    /**
     * find first and create when field not exists
     *
     * @param string $key
     * @return static
     * @throws ModelSaveException
     */
    public static function autoFactory(string $key): self {
        $field = static::findByKey($key);
        if (!$field) {
            $field = static::factory($key);
            $field->save();
        }
        return $field;
    }

    /**
     * Field type: string
     */
    public const FIELD_VALUE_TYPE_STRING = 'string';

    /**
     * Field type: integer
     */
    public const FIELD_VALUE_TYPE_INTEGER = 'integer';

    /**
     * Field type: float
     */
    public const FIELD_VALUE_TYPE_FLOAT = 'float';

    /**
     * Field type: boolean
     */
    public const FIELD_VALUE_TYPE_BOOLEAN = 'boolean';

    /**
     * Field type: serialized
     */
    public const FIELD_VALUE_TPE_SERIALIZED = 'serialized';

}
