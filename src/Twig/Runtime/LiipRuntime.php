<?php

namespace App\Twig\Runtime;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Twig\Extension\RuntimeExtensionInterface;

class LiipRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly CacheManager $cacheManager,
    ) {
    }

    public function multipleFilter(string $path, array $filters): string
    {
        foreach ($filters as $filter) {
            $path = $this->applyFilter($path, $filter);
        }
        return $path;
    }

    private function applyFilter(string $path, string $filter): string
    {
        $applyFilter = $this->cacheManager->getBrowserPath($path, $filter);
        file_get_contents($applyFilter);
        return str_replace('/resolve', '', parse_url($applyFilter, PHP_URL_PATH));
    }
}
