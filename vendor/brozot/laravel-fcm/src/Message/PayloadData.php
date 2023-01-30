<?php

namespace LaravelFCM\Message;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class PayloadData.
 */
class PayloadData implements Arrayable
{
    /**
     * @internal
     *
     * @var array
     */
    protected $data;

    /**
     * PayloadData constructor.
     *
     * @param PayloadDataBuilder $builder
     */
    public function __construct(PayloadDataBuilder $builder)
    {
        $this->data = $builder->getData();
    }

    /**
     * Transform payloadData to array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
