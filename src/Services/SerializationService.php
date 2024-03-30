<?php 
namespace App\Services;

use JMS\Serializer\SerializerInterface;

class SerializationService
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize($data): string
    {
        return $this->serializer->serialize($data, 'json');
    }

    public function deserialize(string $data, string $type)
    {
        return $this->serializer->deserialize($data, $type, 'json');
    }

    public function deserializeArray(string $data, string $type)
    {
        return $this->serializer->deserialize($data, 'array<' . $type . '>', 'json');
    }

    public function deserializeArrayWithKey(string $data, string $type)
    {
        return $this->serializer->deserialize($data, 'array<' . $type . '>', 'json');
    }

    public function deserializeArrayWithKeyAndValue(string $data, string $type)
    {
        return $this->serializer->deserialize($data, 'array<' . $type . '>', 'json');
    }

    public function deserializeArrayWithKeyAndValueAndGroup(string $data, string $type, string $group)
    {
        return $this->serializer->deserialize($data, 'array<' . $type . '>', 'json', $group);
    }

    public function deserializeArrayWithKeyAndValueAndGroupAndContext(string $data, string $type, string $group, array $context)
    {
        return $this->serializer->deserialize($data, 'array<' . $type . '>', 'json', $group, $context);
    }

    public function decode(string $data)
    {
        return json_decode($data, true);
    }
}