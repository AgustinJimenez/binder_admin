<?php

namespace Modules\Alumnos\Repositories\Cache;

use Modules\Alumnos\Repositories\AlumnoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAlumnoDecorator extends BaseCacheDecorator implements AlumnoRepository
{
    public function __construct(AlumnoRepository $alumno)
    {
        parent::__construct();
        $this->entityName = 'alumnos.alumnos';
        $this->repository = $alumno;
    }
}
