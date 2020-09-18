<?php namespace Modules\Responsables\Repositories;

use Illuminate\Http\Request;

class CustomAccessRepository
{

    private $access;
    private $error_repo;

    public function __construct( \ResponsableAccess $access, \ErrorsRepository $error_repo )
    {
        $this->access = $access;
        $this->error_repo = $error_repo;
    }

}