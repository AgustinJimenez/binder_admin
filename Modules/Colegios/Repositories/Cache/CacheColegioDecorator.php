<?php

namespace Modules\Colegios\Repositories\Cache;

use Modules\Colegios\Repositories\ColegioRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheColegioDecorator extends BaseCacheDecorator implements ColegioRepository
{
    public function __construct(ColegioRepository $colegio)
    {
        parent::__construct();
        $this->entityName = 'colegios.colegios';
        $this->repository = $colegio;
    }
}
