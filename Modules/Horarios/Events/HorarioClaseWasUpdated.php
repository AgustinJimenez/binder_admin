<?php namespace Modules\Horarios\Events;

use Modules\Media\Contracts\StoringMedia;

class HorarioClaseWasUpdated implements StoringMedia
{
    /**
     * @var element
     */
    private $element;
    /**
     * @var array
     */
    private $data;

    public function __construct(\HorarioClase $element, array $data)
    {
        $this->element = $element;
        $this->data = $data;
    }
    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->element;
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