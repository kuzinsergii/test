<?php

namespace App\Dto\Response\Transformer;

abstract class AbstractResponseDtoTransformer implements ResponseDtoTransformerInterface
{

    /**
     * @param iterable $objects
     * @return iterable
     */
    public function transformFromObjects(iterable $objects) : iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformFromObject($object);
        }

        return $dto;
    }

}
