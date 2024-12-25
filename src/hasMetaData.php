<?php

namespace Foamycastle\Traits;
use SplFixedArray;
trait hasMetaData
{
    protected SplFixedArray $metaData;
    protected int $metaDataCount = 0;

    public function clearMeta():void
    {
        $this->metaData = new SplFixedArray();
        $this->metaData->setSize(0);
        $this->metaDataCount=0;
    }

    public function addMeta(?string $key=null, mixed $value=null): bool
    {
        if(!empty($key)){
            if(!$this->hasMeta($key)) {
                $this->metaData->setSize(++$this->metaDataCount);
                $this->metaData[$key] = null;
            }
        }
        if(!empty($value) && $this->hasMeta($key)) {
            if(is_array($value)) {
                while(count($value) > 0) {
                    $this->metaData->setSize(++$this->metaDataCount);
                    $current=array_shift($value);
                    $this->metaData[key($current)] = current($current);
                }
                return true;
            }
        }
        if(!empty($value)) {
            if(!$this->hasMeta($key)){
                return false;
            }else{
                $this->metaData[$key] = $value;
                return true;
            }
        }
        return false;
    }
    protected function arrayAdd(array $addMeta):bool
    {
        $added = false;
        foreach ($addMeta as $key => $value) {
            $added=$this->addMeta($key, $value);
        }
        return $added;
    }

    public function removeMeta(string $key):bool
    {
        if(!$this->hasMeta($key)) return false;
        unset($this->metaData[$key]);
        $this->metaData->setSize(--$this->metaDataCount);
        return true;
    }

    public function hasMeta(?string $key=null):bool
    {
        if(empty($key)) return false;
        return isset($this->metaData[$key]);
    }

    public function getMeta(string $key, mixed $default=null):mixed
    {
        return $this->hasMeta($key) ? $this->metaData[$key] : $default;
    }

    public function allMeta():\Iterator&\ArrayAccess
    {
        return $this->metaData;
    }

}