<?php

namespace Modules\Noticias\Repositories\Cache;

use Modules\Noticias\Repositories\NoticiaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNoticiaDecorator extends BaseCacheDecorator implements NoticiaRepository
{
    public function __construct(NoticiaRepository $noticia)
    {
        parent::__construct();
        $this->entityName = 'noticias.noticias';
        $this->repository = $noticia;
    }
}
