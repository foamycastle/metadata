<?php

namespace Foamycastle\Traits;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;

class MetaDataObject implements MetaDataObjectInterface, ArrayAccess, Countable, IteratorAggregate
{
    protected array $_metaDataArray;

    public function __construct()
    {
        $this->init();
    }
    protected function init():void
    {
        $this->_metaDataArray =[];
    }

    function add(string $key, mixed $value):void
    {
        $this->_metaDataArray[$key] = $value;
    }

    function remove(string $key):void
    {
        if($this->has($key)){
            unset($this->_metaDataArray[$key]);
        }
    }

    function has(string $key): bool
    {
        return isset($this->_metaDataArray[$key]);
    }

    function get(string $key): mixed
    {
        return $this->_metaDataArray[$key] ?? null;
    }

    function __set(string $key, mixed $value):void
    {
        $this->add($key,$value);
    }
    function __get(string $key): mixed
    {
        return $this->has($key) ? $this->_metaDataArray[$key] : null;
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->add($offset,$value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }

    public function count(): int
    {
        return count($this->_metaDataArray);
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->_metaDataArray);
    }

}