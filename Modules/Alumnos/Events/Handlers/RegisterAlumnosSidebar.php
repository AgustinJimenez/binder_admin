<?php

namespace Modules\Alumnos\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAlumnosSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('alumnos::alumnos.title.alumnos'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                     $this->auth->hasAccess('alumnos.alumnos.index')
                     
                );
                $item->item(trans('alumnos::alumnos.title.alumnos'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.alumnos.alumno.create');
                    $item->route('admin.alumnos.alumno.index');
                    $item->authorize(
                        $this->auth->hasAccess('alumnos.alumnos.index')
                    );
                });
                // $item->item(trans('alumnos::relacions.title.relacions'), function (Item $item) {
                //     $item->icon('fa fa-copy');
                //     $item->weight(0);
                //     $item->append('admin.alumnos.relacion.create');
                //     $item->route('admin.alumnos.relacion.index');
                //     $item->authorize(
                //         $this->auth->hasAccess('alumnos.relacions.index')
                //     );
                // });


            });
        });

        return $menu;
    }
}
