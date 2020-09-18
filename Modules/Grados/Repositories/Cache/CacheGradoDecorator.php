<?php

namespace Modules\Grados\Repositories\Cache;

use Modules\Grados\Repositories\GradoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheGradoDecorator extends BaseCacheDecorator implements GradoRepository
{
    public function __construct(GradoRepository $grado)
    {
        parent::__construct();
        $this->entityName = 'grados.grados';
        $this->repository = $grado;
    }
}
