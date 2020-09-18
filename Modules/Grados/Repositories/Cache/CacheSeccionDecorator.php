<?php

namespace Modules\Grados\Repositories\Cache;

use Modules\Grados\Repositories\SeccionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSeccionDecorator extends BaseCacheDecorator implements SeccionRepository
{
    public function __construct(SeccionRepository $seccion)
    {
        parent::__construct();
        $this->entityName = 'grados.seccions';
        $this->repository = $seccion;
    }
}
