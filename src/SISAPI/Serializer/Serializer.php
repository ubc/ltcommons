<?php
namespace UBC\SISAPI\Serializer;


interface Serializer {
    public function deserialize($data, $class, $type);
} 