<?php

namespace Modules\Responsables\Repositories\Cache;

use Modules\Responsables\Repositories\ResponsableRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheResponsableDecorator extends BaseCacheDecorator implements ResponsableRepository
{
    public function __construct(ResponsableRepository $responsable)
    {
        parent::__construct();
        $this->entityName = 'responsables.responsables';
        $this->repository = $responsable;
    }
}
