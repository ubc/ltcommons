<?php
namespace UBC\SISAPI\Serializer;


use JMS\Serializer\SerializerBuilder;

/**
 * Class JMSSerializer JMS Serializer implementation
 * @package UBC\SISAPI\Serializer
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