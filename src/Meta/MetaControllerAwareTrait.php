<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Web\Meta;

/**
 * Trait MetaControllerAwareTrait
 *
 * @author Romain Cottard
 */
trait MetaControllerAwareTrait
{
    /** @var array<mixed|array<mixed>> $metaConfig */
    private array $metaConfig;

    /**
     * @param array<mixed|array<mixed>> $metaConfig
     * @return void
     */
    public function setMetaConfig(array $metaConfig): void
    {
        $this->metaConfig = $metaConfig;
    }

    /**
     * @return array<mixed|array<mixed>>
     */
    protected function getMeta(): array
    {
        $meta = $this->metaConfig;
        if (isset($meta['copyright']) && isset($meta['copyright']['year']) && $meta['copyright']['year'] === 'now') {
            $meta['copyright']['year'] = date('Y');
        }

        return $meta;
    }
}
