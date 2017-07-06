<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;

class HomeController extends Controller
{
    protected function store(){
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');
            $user_count     = User::count();
            $vip_count      = User::where('level', 2)->count();
            $order_count    = Order::where('type', Order::TYPE_CONSUME)->count();
            $recharge_count = Order::where('type', Order::TYPE_RECHARGE)->count();
            $content->row(function ($row) use ($user_count, $vip_count, $order_count, $recharge_count) {
                $row->column(3, new InfoBox('用户', 'users', 'aqua', '/admin/users', $user_count));
                $row->column(3, new InfoBox('会员', 'user', 'green', '/admin/orders', $vip_count));
                $row->column(3, new InfoBox('订单', 'shopping-cart', 'yellow', '/admin/articles', $order_count));
                $row->column(3, new InfoBox('充值订单', 'dollar', 'red', '/admin/files', $recharge_count));
            });

            $content->row(function (Row $row) {

                $row->column(6, function (Column $column) {

                    $tab = new Tab();

                    $pie = new Pie([
                        ['Stracke Ltd', 450], ['Halvorson PLC', 650], ['Dicki-Braun', 250], ['Russel-Blanda', 300],
                        ['Emmerich-O\'Keefe', 400], ['Bauch Inc', 200], ['Leannon and Sons', 250], ['Gibson LLC', 250],
                    ]);

                    $tab->add('Pie', $pie);
                    $tab->add('Table', new Table());
                    $tab->add('Text', 'blablablabla....');

                    $tab->dropDown([['Orders', '/admin/orders'], ['administrators', '/admin/administrators']]);
                    $tab->title('Tabs');

                    $column->append($tab);

                    $collapse = new Collapse();

                    $bar = new Bar(
                        ["January", "February", "March", "April", "May", "June", "July"],
                        [
                            ['First', [40, 56, 67, 23, 10, 45, 78]],
                            ['Second', [93, 23, 12, 23, 75, 21, 88]],
                            ['Third', [33, 82, 34, 56, 87, 12, 56]],
                            ['Forth', [34, 25, 67, 12, 48, 91, 16]],
                        ]
                    );
                    $collapse->add('Bar', $bar);
                    $collapse->add('Orders', new Table());
                    $column->append($collapse);

                    $doughnut = new Doughnut([
                        ['Chrome', 700],
                        ['IE', 500],
                        ['FireFox', 400],
                        ['Safari', 600],
                        ['Opera', 300],
                        ['Navigator', 100],
                    ]);
                    $column->append((new Box('Doughnut', $doughnut))->removable()->collapsable()->style('info'));
                });

                $row->column(6, function (Column $column) {

                    $column->append(new Box('Radar', new Radar()));

                    $polarArea = new PolarArea([
                        ['Red', 300],
                        ['Blue', 450],
                        ['Green', 700],
                        ['Yellow', 280],
                        ['Black', 425],
                        ['Gray', 1000],
                    ]);
                    $column->append((new Box('Polar Area', $polarArea))->removable()->collapsable());

                    $column->append((new Box('Line', new Line()))->removable()->collapsable()->style('danger'));
                });

            });

            $headers = ['Id', 'Email', 'Name', 'Company', 'Last Login', 'Status'];
            $rows    = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 'Goodwin-Watsica', '1997-08-13 13:59:21', 'open'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 'Murphy, Koepp and Morar', '1988-07-19 03:19:08', 'blocked'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 'Kihn LLC', '1978-06-19 11:12:57', 'blocked'],
                [4, 'xet@yahoo.com', 'William Koss', 'Becker-Raynor', '1988-09-07 23:57:45', 'open'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 'Braun Ltd', '2013-10-16 10:00:01', 'open'],
            ];

            $content->row((new Box('Table', new Table($headers, $rows)))->style('info')->solid());
        });
    }
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');
            $user_count     = User::count();
            $vip_count      = User::where('level', 2)->count();
            $order_count    = Order::where('type', Order::TYPE_CONSUME)->count();
            $recharge_count = Order::where('type', Order::TYPE_RECHARGE)->count();
            $content->row(function ($row) use ($user_count, $vip_count, $order_count, $recharge_count) {
                $row->column(3, new InfoBox('用户', 'users', 'aqua', config('admin.prefix').'/user?&type=all', $user_count));
                $row->column(3, new InfoBox('会员', 'user', 'green', config('admin.prefix').'/user?&type=2', $vip_count));
                $row->column(3, new InfoBox('消费订单', 'shopping-cart', 'yellow', config('admin.prefix').'/order?&type=2', $order_count));
                $row->column(3, new InfoBox('充值订单', 'dollar', 'red', config('admin.prefix').'/order?&type=1', $recharge_count));
            });

        });
    }
}
