<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Web\Meta;

/**
 * Trait MetaControllerAwareTrait
 *
 * @author Romain Cottard
 */
trait MetaControllerAwareTrait
{
    /** @var array $config */
    private $metaConfig;

    /**
     * @param array $metaConfig
     * @return void
     */
    public function setMetaConfig(array $metaConfig)
    {
        $this->metaConfig = $metaConfig;
    }

    /**
     * @return array
     */
    protected function getMeta()
    {
        $meta = $this->metaConfig;
        if (isset($meta['copyright']['year']) && $meta['copyright']['year'] === 'now') {
            $meta['copyright']['year'] = date('Y');
        }

        return $meta;
    }
}
