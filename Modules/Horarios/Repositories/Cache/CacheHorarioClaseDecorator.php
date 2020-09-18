<?php

namespace Modules\Horarios\Repositories\Cache;

use Modules\Horarios\Repositories\HorarioClaseRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheHorarioClaseDecorator extends BaseCacheDecorator implements HorarioClaseRepository
{
    public function __construct(HorarioClaseRepository $horarioclase)
    {
        parent::__construct();
        $this->entityName = 'horarios.horarioclases';
        $this->repository = $horarioclase;
    }
}
