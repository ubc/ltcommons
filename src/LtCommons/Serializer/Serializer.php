<?php
namespace UBC\LtCommons\Serializer;


interface Serializer {
    public function deserialize($data, $class, $type);
} 