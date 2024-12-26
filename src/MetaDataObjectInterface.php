<?php

namespace Foamycastle\Traits;

interface MetaDataObjectInterface
{
    function add(string $key, mixed $value):void;
    function remove(string $key):void;
    function has(string $key):bool;
    function get(string $key):mixed;
}