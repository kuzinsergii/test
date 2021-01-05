<?php

namespace App\Dto\Response\Transformer;

interface ResponseDtoTransformerInterface
{

    /**
     * @param $object
     * @return mixed
     */
    public function transformFromObject($object);

    /**
     * @param iterable $objects
     * @return iterable
     */
    public function transformFromObjects(iterable $objects) : iterable;
}
