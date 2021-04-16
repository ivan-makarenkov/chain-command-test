<?php

declare(strict_types=1);

namespace Ivmak\ChainCommandBundle\Service;

/**
 * Interface for command Follower(child)
 * Interface ChainCommandFollowerInterface
 * @package Ivmak\ChainCommandBundle\Service
 */
interface ChainCommandFollowerInterface extends ChainCommandInterface
{
    public function getParent(): string;

    public function getPriority(): int;
}