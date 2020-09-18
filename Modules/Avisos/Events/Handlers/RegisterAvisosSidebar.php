<?php

namespace Modules\Avisos\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAvisosSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
        $menu->group(trans('core::sidebar.content'), function (Group $group) 
        {
            $group->item( "Avisos", function (Item $item) 
            {
                $item->icon('fa fa-envelope');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item( "Listado de Avisos", function (Item $item) 
                {
                    $item->icon('fa');
                    $item->weight(0);
                    $item->route('admin.avisos.aviso.index');
                    $item->authorize(
                        $this->auth->hasAccess('avisos.avisos.index')
                    );
                });

                $item->item( "Aviso General", function (Item $item) 
                {
                    $item->icon('fa');
                    $item->weight(0);
                    $item->route('admin.avisos.aviso.create_general');
                    $item->authorize(
                        $this->auth->hasAccess('avisos.avisos.create_general')
                    );
                });

                $item->item( "Aviso por Categoria" , function (Item $item) 
                {
                    $item->icon('fa');
                    $item->weight(0);
                    $item->route('admin.avisos.aviso.create_por_categoria');
                    $item->authorize(
                        $this->auth->hasAccess('avisos.avisos.create_por_categoria')
                    );
                });

                $item->item( "Aviso por Grado", function (Item $item) 
                {
                    $item->icon('fa');
                    $item->weight(0);
                    $item->route('admin.avisos.aviso.create_por_grado');
                    $item->authorize(
                        $this->auth->hasAccess('avisos.avisos.create_por_grado')
                    );
                });

                $item->item( "Aviso por Sección", function (Item $item) 
                {
                    $item->icon('fa');
                    $item->weight(0);
                    $item->route('admin.avisos.aviso.create_por_seccion');
                    $item->authorize(
                        $this->auth->hasAccess('avisos.avisos.create_por_seccion')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
