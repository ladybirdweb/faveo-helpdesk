<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher\Adapter;

use Sly\NotificationPusher\Model\BaseParameteredModel;
use Sly\NotificationPusher\Model\Response;
use Sly\NotificationPusher\Model\ResponseInterface;
use Sly\NotificationPusher\PushManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * BaseAdapter.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
abstract class BaseAdapter extends BaseParameteredModel implements AdapterInterface
{
    /**
     * @var string
     */
    protected $adapterKey;

    /**
     * @var string
     */
    protected $environment;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param array $parameters Adapter specific parameters
     */
    public function __construct(array $parameters = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined($this->getDefinedParameters());
        $resolver->setDefaults($this->getDefaultParameters());
        $resolver->setRequired($this->getRequiredParameters());

        $reflectedClass   = new \ReflectionClass($this);
        $this->adapterKey = lcfirst($reflectedClass->getShortName());
        $this->parameters = $resolver->resolve($parameters);
        $this->response   = new Response();
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return ucfirst($this->getAdapterKey());
    }

    /**
     * Get AdapterKey.
     *
     * @return string
     */
    public function getAdapterKey()
    {
        return $this->adapterKey;
    }

    /**
     * Get Environment.
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set Environment.
     *
     * @param string $environment Environment value to set
     *
     * @return \Sly\NotificationPusher\Adapter\AdapterInterface
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * isDevelopmentEnvironment.
     *
     * @return boolean
     */
    public function isDevelopmentEnvironment()
    {
        return (PushManager::ENVIRONMENT_DEV === $this->getEnvironment());
    }

    /**
     * isProductionEnvironment.
     *
     * @return boolean
     */
    public function isProductionEnvironment()
    {
        return (PushManager::ENVIRONMENT_PROD === $this->getEnvironment());
    }

}
