<?php

namespace Modules\Horarios\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterHorariosSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item("Horarios", function (Item $item) {
                $item->icon('fa fa-calendar');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item( "Horarios de Clases", function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.horarios.horarioclase.create');
                    $item->route('admin.horarios.horarioclase.index');
                    $item->authorize(
                        $this->auth->hasAccess('horarios.horarioclases.index')
                    );
                });
                $item->item(trans("Horarios de Examenes"), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.horarios.horarioexamen.create');
                    $item->route('admin.horarios.horarioexamen.index');
                    $item->authorize(
                        $this->auth->hasAccess('horarios.horarioexamens.index')
                    );
                });
// append


            });
        });

        return $menu;
    }
}
