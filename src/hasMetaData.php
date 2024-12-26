<?php

namespace Foamycastle\Traits;

/**
 * The object that uses this trait must call metaInit() in its constructor
 */
trait hasMetaData
{
    protected MetaDataObject $metaData;

    protected function metaInit():void
    {
        $this->metaData = new MetaDataObject(0);
    }

    public function metaGet(string $key):mixed
    {
        $entry = $this->metaData->get($key);
        if ($entry) {
            return $entry[$key];
        }
        return null;
    }

    public function metaExists(string $key):bool
    {
        return $this->metaData->has($key)>-1;
    }

    public function metaSet(string $key, mixed $value):void
    {
        $this->metaData->set($key, $value);
    }
    public function metaUnset(string $key):void
    {
        $this->metaData->offsetUnset($key);
    }


}