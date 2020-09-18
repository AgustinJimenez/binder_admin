<?php

namespace Modules\Grados\Repositories\Cache;

use Modules\Grados\Repositories\CategoriaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoriaDecorator extends BaseCacheDecorator implements CategoriaRepository
{
    public function __construct(CategoriaRepository $categoria)
    {
        parent::__construct();
        $this->entityName = 'grados.categorias';
        $this->repository = $categoria;
    }
}
