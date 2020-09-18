<?php namespace Modules\Avisos\Events;

use Modules\Media\Contracts\StoringMedia;

class AvisoWasUpdated implements StoringMedia
{
    /**
     * @var aviso
     */
    private $aviso;
    /**
     * @var array
     */
    private $data;

    public function __construct(\Aviso $aviso, array $data)
    {
        $this->aviso = $aviso;
        $this->data = $data;
    }
    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->aviso;
    }
    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}