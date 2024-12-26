<?php

namespace Foamycastle\Traits;

use ArrayAccess;
use Iterator;

/**
 * This interface is used in conjunction with the 'hasMetaData' trait
 */
interface MetaDataInterface
{
    /**
     * Indicates that a key exist in the metadata storage
     * @param string $key the id by which the user references the metadata
     * @return bool TRUE if the key exists in the metadata storage
     */
    function metaExists(string $key):bool;

    /**
     * Retrieve the metadata
     * @param string $key the id by which the user references the metadata
     * @return mixed the metadata entry
     */
    function metaGet(string $key):mixed;

    /**
     * Commit a metadata entry
     * @param string $key the id by which the user references the metadata
     * @param mixed $value the metadata
     * @return void
     */
    function metaSet(string $key, mixed $value):void;

    /**
     * Remove a metadata entry
     * @param string $key the id by which the user references the metadata
     * @return void
     */
    function metaUnset(string $key):void;

}