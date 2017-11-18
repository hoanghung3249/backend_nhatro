<?php

namespace Modules\Motel\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterMotelSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('Thống kê'), function (Item $item) {
                $item->weight(3);
                $item->icon('fa fa-bar-chart');
                $item->authorize(
                    $this->auth->hasAccess('user.users.index') or $this->auth->hasAccess('user.roles.index')
                );

                $item->item(trans('Phòng đang được thuê'), function (Item $item) {
                    $item->weight(0);
                    $item->icon('fa fa-home');
                    $item->route('admin.room.room.index');
                    $item->authorize(
                        $this->auth->hasAccess('user.users.index')
                    );
                });
                $item->item(trans('Danh sách người thuê'), function (Item $item) {
                    $item->weight(0);
                    $item->icon('fa fa-users');
                    $item->route('admin.room.room.index');
                    $item->authorize(
                        $this->auth->hasAccess('user.users.index')
                    );
                });
                $item->item(trans('Quản lý tiền phòng'), function (Item $item) {
                    $item->weight(0);
                    $item->icon('fa fa-usd');
                    $item->route('admin.room.room.index');
                    $item->authorize(
                        $this->auth->hasAccess('user.users.index')
                    );
                });
                $item->item(trans('Doanh thu hàng tháng'), function (Item $item) {
                    $item->weight(0);
                    $item->icon('fa fa-snowflake-o');
                    $item->route('admin.room.room.index');
                    $item->authorize(
                        $this->auth->hasAccess('user.users.index')
                    );
                });
            });
            $group->item(trans('Lịch sử thuê phòng'), function (Item $item) {
                $item->weight(0);
                $item->icon('fa fa-history');
                $item->route('admin.room.room.index');
                $item->authorize(
                    $this->auth->hasAccess('user.users.index')
                );
            });
            $group->item(trans('Quản lý phòng'), function (Item $item) {
                $item->weight(0);
                $item->icon('fa fa-building-o');
                $item->route('admin.room.room.index');
                $item->authorize(
                    $this->auth->hasAccess('user.users.index')
                );
            });
            $group->item(trans('Các khoản thu chi'), function (Item $item) {
                $item->weight(0);
                $item->icon('fa fa-money');
                $item->route('admin.room.room.index');
                $item->authorize(
                    $this->auth->hasAccess('user.users.index')
                );
            });
        });

        return $menu;
    }
}
