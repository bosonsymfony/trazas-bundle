<?php

namespace UCI\Boson\TrazasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 */
class Data
{

    /**
     * @var string
     *
     */
    private $action;

    /**
     * @var string
     *
     */
    private $performance;

    /**
     * @var string
     *
     */
    private $exception;

    /**
     * @var string
     *
     */
    private $data;

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Data
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set performance
     *
     * @param string $performance
     *
     * @return Data
     */
    public function setPerformance($performance)
    {
        $this->performance = $performance;

        return $this;
    }

    /**
     * Get performance
     *
     * @return string
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * Set exception
     *
     * @param string $exception
     *
     * @return Data
     */
    public function setException($exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Get exception
     *
     * @return string
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Data
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
}

