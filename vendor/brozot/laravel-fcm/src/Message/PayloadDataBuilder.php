<?php

namespace LaravelFCM\Message;

/**
 * Class PayloadDataBuilder.
 *
 * Official google documentation :
 *
 * @link http://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
 */
class PayloadDataBuilder
{
    /**
     * @internal
     *
     * @var array
     */
    protected $data;

    /**
     * add data to existing data.
     *
     * @param array $data
     *
     * @return PayloadDataBuilder
     */
    public function addData(array $data)
    {
        $this->data = $this->data ?: [];

        $this->data = array_merge($data, $this->data);

        return $this;
    }

    /**
     * erase data with new data.
     *
     * @param array $data
     *
     * @return PayloadDataBuilder
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Remove all data.
     */
    public function removeAllData()
    {
        $this->data = null;
    }

    /**
     * return data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * generate a PayloadData.
     *
     * @return PayloadData new PayloadData instance
     */
    public function build()
    {
        return new PayloadData($this);
    }
}
