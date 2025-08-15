<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Meta;

trait MetaControllerAwareTrait
{
    /** @var array<string, string|int|string[]|int[]|string[][]|int[][]> $metaConfig */
    private array $metaConfig;

    /**
     * @param array<string, string|int|string[]|int[]|string[][]|int[][]> $metaConfig
     */
    public function setMetaConfig(array $metaConfig): void
    {
        $this->metaConfig = $metaConfig;
    }

    /**
     * @return array<string, string|int|string[]|int[]|string[][]|int[][]>
     */
    protected function getMeta(): array
    {
        $meta = $this->metaConfig;
        if (isset($meta['copyright']['year']) && $meta['copyright']['year'] === 'now') {
            $meta['copyright']['year'] = \date('Y');
        }

        return $meta;
    }
}
