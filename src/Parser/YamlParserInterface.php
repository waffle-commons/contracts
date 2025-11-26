<?php

declare(strict_types=1);

namespace Waffle\Commons\Contracts\Parser;

interface YamlParserInterface
{
    public function parseFile(string $path): array;
}
