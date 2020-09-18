<?php

namespace Modules\Noticias\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterNoticiasSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item("Noticias", function (Item $item)
            {
                $item->icon('fa fa-newspaper-o');
                $item->weight(10);
                $item->append('admin.noticias.noticia.create');
                $item->route('admin.noticias.noticia.index');
                $item->authorize(
                    $this->auth->hasAccess('noticias.noticias.index')
                );

            });
        });

        return $menu;
    }
}
