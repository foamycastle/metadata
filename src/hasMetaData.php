<?php

namespace Foamycastle\Traits;
use SplFixedArray;
trait hasMetaData
{
    protected SplFixedArray $metaData;
    protected int $metaDataCount = 0;

    protected function clearMeta():void
    {
        $this->metaData = new SplFixedArray();
        $this->metaData->setSize(0);
        $this->metaDataCount=0;
    }

    protected function addMeta(?string $key=null, mixed $value=null): bool
    {
        if(!empty($key)){
            if(!$this->hasMetaData($key)) {
                $this->metaData->setSize(++$this->metaDataCount);
                $this->metaData[$key] = null;
            }
        }
        if(!empty($value) && $this->hasMetaData($key)) {
            $this->metaData[$key] = $value;
            return true;
        }
        return false;
    }

    protected function removeMeta(string $key):bool
    {
        if(!$this->hasMetaData($key)) return false;
        unset($this->metaData[$key]);
        $this->metaData->setSize(--$this->metaDataCount);
        return true;
    }

    protected function hasMeta(string $key):bool
    {
        return isset($this->metaData[$key]);
    }

    protected function getMeta(string $key):mixed
    {
        if($this->hasMetaData($key)) return $this->metaData[$key];
        return null;
    }

    protected function allMeta():\Iterator&\ArrayAccess
    {
        return $this->metaData;
    }

}