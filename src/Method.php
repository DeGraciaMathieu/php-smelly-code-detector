<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

class Method
{
    protected const nullables = 2;
    protected const booleans = 3;
    protected const references = 4;

    public function __construct(
        protected string $filePathName, 
        protected string $name, 
        protected int $lenght, 
        protected array $arguments,
    ) {}

    public function getFilePathName(): string
    {
        return $this->filePathName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLenght(): int
    {
        return $this->lenght;
    }

    public function getSmell(): int
    {
        $lenght = $this->getLenght();

        return (
            $this->arguments['count'] 
            + ($this->arguments['nullables'] * self::nullables)
            + ($this->arguments['booleans'] * self::booleans)
            + ($this->arguments['references'] * self::references)
        ) * ($lenght++);
    }

    public function isConstructor(): bool
    {
        return $this->name === '__construct';
    }
}
