<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

use PhpParser\Node;
use DeGraciaMathieu\SmellyCodeDetector\Method;

class NodeMethodExplorer
{
    public function __construct(
        protected string $filePathName,
    ) {}

    public function get(Node $node): iterable
    {
        $arguments = SignatureParser::parse(
            arguments: $node->getParams(),
        );

        yield new Method(
            filePathName: $this->filePathName, 
            name: $node->name->name, 
            lenght: $this->getlenght($node), 
            arguments: $arguments,
        );
    }

    protected function getlenght(Node $node):int
    {
        // Remove brackets
        return ($node->getEndLine() - $node->getStartLine()) - 2;
    }
}
