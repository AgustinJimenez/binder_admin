<?php

namespace Modules\Horarios\Repositories\Cache;

use Modules\Horarios\Repositories\HorarioExamenRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheHorarioExamenDecorator extends BaseCacheDecorator implements HorarioExamenRepository
{
    public function __construct(HorarioExamenRepository $horarioexamen)
    {
        parent::__construct();
        $this->entityName = 'horarios.horarioexamens';
        $this->repository = $horarioexamen;
    }
}
