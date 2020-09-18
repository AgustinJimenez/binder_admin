<?php

namespace Modules\Grados\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterGradosSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(/*trans('grados::grados.title.grados')*/'Grados', function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                     $this->auth->hasAccess('grados.categorias.index')
                );
                $item->item(trans('grados::categorias.title.categorias'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.grados.categoria.create');
                    $item->route('admin.grados.categoria.index');
                    $item->authorize(
                        $this->auth->hasAccess('grados.categorias.index')
                    );
                });
                $item->item(trans('grados::grados.title.grados'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.grados.grado.create');
                    $item->route('admin.grados.grado.index');
                    $item->authorize(
                        $this->auth->hasAccess('grados.grados.index')
                    );
                });
                $item->item(trans('grados::seccions.title.seccions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.grados.seccion.create');
                    $item->route('admin.grados.seccion.index');
                    $item->authorize(
                        $this->auth->hasAccess('grados.seccions.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
