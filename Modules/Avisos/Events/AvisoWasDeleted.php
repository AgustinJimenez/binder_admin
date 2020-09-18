<?php namespace Modules\Avisos\Events;

use Modules\Media\Contracts\DeletingMedia;

class AvisoWasDeleted implements DeletingMedia
{
    /**
     * @var aviso
     */
    private $aviso;
    
    public function __construct(\Aviso $aviso)
    {
        $this->aviso = $aviso;
    }
    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->aviso->id;
    }
    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return get_class($this->aviso);
    }
}