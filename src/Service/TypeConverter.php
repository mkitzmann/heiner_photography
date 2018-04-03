<?php

namespace App\Service;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class TypeConverter
{

    public function jsonConvert($input)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('photos'));
        $normalizers = array($normalizer);

        $serializer = new Serializer($normalizers, $encoders);

        $return = $serializer->serialize($input, 'json');

        return $return;
    }


}