<?php

namespace Nip\Router\Route\Traits;

use Nip\Router\Parsers\AbstractParser;

/**
 * Class HasParserTrait
 * @package Nip\Router\Route\Traits
 */
trait HasParserTrait
{
    protected $parser = null;


    /**
     * @return AbstractParser
     */
    public function getParser()
    {
        if ($this->parser === null) {
            $this->initParser();
        }

        return $this->parser;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setParser($class)
    {
        $this->parser = $class;

        return $this;
    }

    public function initParser()
    {
        $class = $this->getParserClass();
        $parser = new $class;
        $this->setParser($parser);
    }

    /**
     * @return string
     */
    public function getParserClass()
    {
        return 'Nip\Router\Parsers\\' . inflector()->camelize($this->getType());
    }
}
