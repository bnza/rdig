<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;


class EntityJsonSerializer
{
    protected $serializer;
    public function __construct()
    {
        $encoder = new JsonEncoder();
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setCircularReferenceLimit(0);
        $normalizer->setCircularReferenceHandler(function ($entity) {
            return $entity->getId();
        });
        $this->serializer = new Serializer(array($normalizer), array($encoder));
    }

    public function serialize($entity)
    {
        if ($entity instanceof PersistentCollection) {
            $json = $entity->map(function ($subEntity) {
                return $this->serializer->serialize($subEntity, 'json');
            });
            return sprintf('[%s]', implode(',', $json->getValues()));
        }
        return $this->serializer->serialize($entity, 'json');
    }
}

