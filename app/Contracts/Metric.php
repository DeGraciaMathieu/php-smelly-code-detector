<?php

namespace App\Contracts;

use PhpParser\Node\Stmt\ClassMethod;

interface Metric
{
    public static function calcul(ClassMethod $node): int;
}
