<?php

declare(strict_types=1);

namespace Ivmak\ChainCommandBundle\Model;

/**
 * Common interface for all commands in the chain
 * Interface ChainCommandInterface
 * @package Ivmak\ChainCommandBundle\Service
 */
interface ChainCommandInterface
{
    public function getName(): string;
}