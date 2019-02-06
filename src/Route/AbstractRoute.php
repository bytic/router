<?php

namespace Nip\Router\Route;

use Nip\Router\Route\Traits\HasParserTrait;
use Nip\Router\Route\Traits\HasRequestTrait;
use Nip\Router\Route\Traits\HasTypeTrait;
use Nip\Utility\Traits\NameWorksTrait;

/**
 * Class AbstractRoute
 * @package Nip\Router\Route
 */
abstract class AbstractRoute extends \Symfony\Component\Routing\Route
{
    use NameWorksTrait;
    use HasParserTrait;
    use HasTypeTrait;
    use HasRequestTrait;

    /**
     * @var string
     */
    protected $name = null;

    protected $base = null;

    /**
     * @var string
     */
    protected $uri;

    /**
     * AbstractRoute constructor.
     * @param bool $map
     * @param array $params
     */
    public function __construct($map = false, $params = [])
    {
        if ($map) {
            $this->getParser()->setMap($map);
        }

        if (count($params)) {
            $this->getParser()->setParams($params);
        }
        $this->init();
    }


    public function init()
    {
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->getParser(), $name], $arguments);
    }

    /**
     * @param array $params
     * @return string
     */
    public function assembleFull($params = [])
    {
        $base = $this->getBase($params);
        $base = rtrim($base, "/");

        return $base . $this->assemble($params);
    }

    /**
     * @param array $params
     * @return string
     */
    public function getBase($params = [])
    {
        $this->checkBase($params);
        if (isset($params['_subdomain']) && !empty($params['_subdomain'])) {
            $base = $this->replaceSubdomain($params['_subdomain'], $this->base);

            return $base;
        }

        return $this->base;
    }

    /**
     * @param string $base
     */
    public function setBase($base)
    {
        $this->base = $base;
    }

    /** @noinspection PhpUnusedParameterInspection
     * @param array $params
     */
    public function checkBase($params = [])
    {
        if ($this->base === null) {
            $this->initBase($params);
        }
    }

    /** @noinspection PhpUnusedParameterInspection
     * @param array $params
     */
    public function initBase($params = [])
    {
        $this->setBase(BASE_URL);
    }

    /**
     * @param $subdomain
     * @param $url
     * @return mixed
     */
    public function replaceSubdomain($subdomain, $url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        $parts = explode('.', $host);
        if (count($parts) > 2) {
            array_shift($parts);
        }

        array_unshift($parts, $subdomain);
        $newHost = implode('.', $parts);

        return str_replace($host, $newHost, $url);
    }

    /**
     * @param array $params
     * @return string
     */
    public function assemble($params = [])
    {
        return $this->getParser()->assemble($params);
    }

    /**
     * @param $uri
     * @return bool
     */
    public function match($uri)
    {
        $this->uri = $uri;
        if ($this->domainCheck()) {
            $return = $this->getParser()->match($uri);
            if ($return === true) {
                $this->postMatch();
            }

            return $return;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function domainCheck()
    {
        return true;
    }

    public function postMatch()
    {
    }


    /**
     * @return array
     */
    public function getParams()
    {
        return $this->getParser()->getParams();
    }

    /**
     * @return array
     */
    public function getMatches()
    {
        return $this->getParser()->getMatches();
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if ($this->name == null) {
            $this->initName();
        }

        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function initName()
    {
        $this->setName($this->getClassName());
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }
}
