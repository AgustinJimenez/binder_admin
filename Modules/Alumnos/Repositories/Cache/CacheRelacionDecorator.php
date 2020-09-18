<?php

namespace Modules\Alumnos\Repositories\Cache;

use Modules\Alumnos\Repositories\RelacionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRelacionDecorator extends BaseCacheDecorator implements RelacionRepository
{
    public function __construct(RelacionRepository $relacion)
    {
        parent::__construct();
        $this->entityName = 'alumnos.relacions';
        $this->repository = $relacion;
    }
}
