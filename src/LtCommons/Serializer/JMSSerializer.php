<?php
namespace UBC\LtCommons\Serializer;


use JMS\Serializer\SerializerBuilder;

/**
 * Class JMSSerializer JMS Serializer implementation
 * @package UBC\LtCommons\Serializer
 */
class JMSSerializer implements Serializer {
    protected $serializer;

    public function __construct() {
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function deserialize($data, $class, $type)
    {
        $data = $this->serializer->deserialize($data, $class, $type);
        return $data;
    }
}