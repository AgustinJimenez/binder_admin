<?php namespace Modules\Colegios\Events;

use Modules\Media\Contracts\StoringMedia;

class ColegioWasUpdated implements StoringMedia
{
    /**
     * @var element
     */
    private $element;
    /**
     * @var array
     */
    private $data;

    public function __construct( \Colegio $element, array $data)
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