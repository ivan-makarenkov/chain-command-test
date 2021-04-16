<?php

declare(strict_types=1);

namespace App\FooBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FooBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}