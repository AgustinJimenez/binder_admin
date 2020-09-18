<?php

namespace Modules\Avisos\Repositories\Cache;

use Modules\Avisos\Repositories\AvisoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAvisoDecorator extends BaseCacheDecorator implements AvisoRepository
{
    public function __construct(AvisoRepository $aviso)
    {
        parent::__construct();
        $this->entityName = 'avisos.avisos';
        $this->repository = $aviso;
    }
}
