<?php

namespace Modules\Responsables\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Badge;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterResponsablesSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;
    protected $responsable_repo;
    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth, \CustomUserResponsableRepository $responsable_repo)
    {
        $this->auth = $auth;
        $this->responsable_repo = $responsable_repo;
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
            $group->item(trans('responsables::responsables.title.responsables'), function (Item $item) {
                $item->icon('fa fa-users');
                $item->weight(10);
                
                if( $cantidad_responsables_pendientes = $this->responsable_repo->get_cantidad_responsables_pendientes() )
                    $item->badge(function (Badge $badge) use ($cantidad_responsables_pendientes) 
                    {
                        $badge->setClass('bg-yellow')->setValue( $cantidad_responsables_pendientes);
                    });
                else
                    $item->append('admin.responsables.responsable.create');
                
                $item->route('admin.responsables.responsable.index');
                $item->authorize(
                    $this->auth->hasAccess('responsables.responsables.index')
                );
// append

            });
        });

        return $menu;
    }
}
