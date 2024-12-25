<?php

namespace Foamycastle\Traits;

use ArrayAccess;
use Iterator;

interface MetaDataInterface
{

    /**
     * Clear and initialize all metadata
     * @return void
     */
    function clearMeta():void;

    /**
     * Retrieve metadata by the given key
     * @param string $key
     * @param mixed $default the value to return if the provided $key is not found
     * @return mixed
     */
    function getMeta(string $key, mixed $default = null): mixed;

    /**
     * Indicate if the metadata exists
     * @param string|null $key the key by which the data is referenced
     * @return bool TRUE if the data exists
     */
    function hasMeta(?string $key=null):bool;

    /**
     * Add metadata
     * @param string $key
     * @param mixed $value
     * @return bool TRUE if the data was added, FALSE if not
     */
    function addMeta(string $key, mixed $value):bool;

    /**
     * Remove metadata
     * @param string $key
     * @return bool TRUE if data was removed, FALSE if data was not removed.
     */
    function removeMeta(string $key):bool;

    /**
     * Return access to the metadata array
     * @return ArrayAccess&Iterator
     */
    function allMeta(): Iterator&ArrayAccess;

}