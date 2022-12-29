<?php

namespace DeGraciaMathieu\SmellyCodeDetector\Tests\Stubs;

class Foo
{
    public function bar($a): void
    {
        if (true) {
            //
        }
    }

    public function baz($a): void
    {
        switch (true) {
            case true:
                break;
            default:
                break;
        }

        echo 1 <=> 1;
    }
}
