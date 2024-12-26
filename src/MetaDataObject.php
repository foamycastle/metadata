<?php

namespace Foamycastle\Traits;

use SplFixedArray;
use Traversable;

class MetaDataObject implements \IteratorAggregate, \Countable, \ArrayAccess
{
    protected \SplFixedArray $keys;
    protected \SplFixedArray $values;
    protected int $index;
    protected int $count;

    public function __construct(int $initCount = 0)
    {
        $this->init($initCount);
    }
    public function has(int|string $key): int
    {
        if($this->count === 0) return -1;
        $this->reset();
        if(is_int($key)) {
            return $this->keys->offsetExists($key) && $this->keys->offsetGet($key)!==null
                ? $key
                : -1;
        }
        do {
            if($this->keys->valid() && $this->keys->current() === $key) return $this->index;
            $this->keys->next();
        } while (++$this->index < $this->count);
        return -1;
    }
    public function get(int|string $key): ?array
    {
        if(is_int($key) && $key>-1) {
            return ($this->keys->offsetExists($key) && $this->keys->offsetGet($key)!==null)
                ? [$this->keys->offsetGet($key) => $this->values->offsetGet($key)]
                : null;
        }

        $this->index=$this->has($key);

        if($this->index > -1){
            if($this->keys[$this->index]===null) {
                return [];
            }else{
                return [$this->keys[$this->index] => $this->values[$this->index]];
            }
        }
        return null;
    }

    public function set(string $key, $value): void
    {
        $this->index=$this->has($key);
        if($this->index == -1){
            $this->keys->setSize(++$this->count);
            $this->values->setSize($this->count);
            $this->index=$this->count-1;
        }else{
            $this->values[$this->index]=$value;
            $this->keys[$this->index]=$key;
        }
    }
    protected function reset():void
    {
        $this->index = 0;
        $this->keys->rewind();
        $this->values->rewind();
        $this->count = $this->keys->count();
    }
    protected function init(int $initCount):void
    {
        unset($this->keys,$this->values);
        $this->keys = new \SplFixedArray($initCount);
        $this->values = new \SplFixedArray($initCount);
        $this->index = 0;
        $this->count = $initCount;
    }
    protected function void(int $index):void
    {
        $this->keys = SplFixedArray::fromArray(
            array_filter(
                $this->keys->toArray(),
                function ($key) use ($index) {
                    return $key!==$index;
                },
                ARRAY_FILTER_USE_KEY
            )
        );
        $this->values = SplFixedArray::fromArray(
            array_filter(
                $this->values->toArray(),
                function ($value) use ($index) {
                    return $value!==$index;
                },
                ARRAY_FILTER_USE_KEY
            )
        );
        $this->reset();
    }

    public function getIterator(): Traversable
    {
        $this->reset();
        $iterator = new \MultipleIterator();
        $iterator->attachIterator($this->keys,$this->values);
        return $iterator;
    }

    public function offsetExists(mixed $offset): bool
    {
        if(is_string($offset)) {
            return $this->has($offset) > -1;
        }
        if(!is_int($offset)) return false;
        return $this->keys->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if(is_string($offset)) {
            $this->index=$this->has($offset);
            if($this->index > -1) return $this->values[$this->index];
            return null;
        }
        if(!is_int($offset)) return null;
        return $this->keys->offsetExists($offset) ?
            $this->values[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->index=$this->has($offset);
        if($this->index > -1) $this->void($offset);
    }

    public function count(): int
    {
        $this->reset();
        return $this->count;
    }

}