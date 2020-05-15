<?php

namespace Nip\Router\Generator;

use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\RequestContext;

/**
 * Class CompiledUrlGenerator
 * @package Nip\Router\Generator
 */
class CompiledUrlGenerator extends \Symfony\Component\Routing\Generator\CompiledUrlGenerator
{
    use Traits\FormattingTrait;
    use Traits\HasDefaultRouteTrait;
    use Traits\HasPreviousUrlTrait;
    use Traits\HasRequestTrait;
    use Traits\UrlFunctionTrait;

    protected $compiledRoutes = [];

    /**
     * @inheritDoc
     */
    public function __construct(
        array $compiledRoutes,
        RequestContext $context,
        LoggerInterface $logger = null,
        string $defaultLocale = null
    ) {
        parent::__construct($compiledRoutes, $context, $logger, $defaultLocale);
        $this->compiledRoutes = $compiledRoutes;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasRoute($name)
    {
        return isset($this->compiledRoutes[$name]);
    }
}
