<?php

namespace Nip\Router\Route\Traits;

/**
 * Trait HasRequestTrait
 * @package Nip\Router\Route\Traits
 */
trait HasRequestTrait
{
    protected $request = null;

    public function populateRequest()
    {
        $params = $this->getParams();
        foreach ($params as $param => $value) {
            switch ($param) {
                case 'module':
                    $this->getRequest()->setModuleName($value);
                    break;
                case 'controller':
                    $this->getRequest()->setControllerName($value);
                    break;
                case 'action':
                    $this->getRequest()->setActionName($value);
                    break;
                default:
                    $this->getRequest()->attributes->set($param, $value);
                    break;
            }
        }
        $this->getRequest()->attributes->add($this->getMatches());
    }

    /**
     * @return \Nip\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Nip\Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}