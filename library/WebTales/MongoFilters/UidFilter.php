<?php
namespace WebTales\MongoFilters;

use WebTales\MongoFilters\AbstractFilter;
use WebTales\MongoFilters\Exception;

class UidFilter extends AbstractFilter
{

    protected $value;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if (! is_string($value) && ! $value instanceof \MongoId) {
            throw new Exception('Only Accepts string or MongoId');
        }
        $this->value = $value;
        
        return $this;
    }

    public function __construct(array $params = null)
    {
        if (isset($params['value'])) {
            $this->setValue($params['value']);
        }
        
        return $this;
    }

    public function toArray()
    {
        $id = $this->value;
        
        if (! $id instanceof \MongoId) {
            if (! is_string($id) || preg_match('/[\dabcdef]{24}/', $id) !== 1) {
                throw new Exception('Invalid MongoId :' . $id);
            }
            $id = new \MongoId($id);
        }
        return array(
            '_id' => $id
        );
    }
}
