<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Game;
use App\Models\Product;
use App\Models\RecurringPush;
use App\Models\SinglePush;
use App\Models\SubCategory;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $signlePushCount = SinglePush::where('push_type', 'single')->count();
        view()->share('signlePushCount',$signlePushCount);

        $recurringPushCount = DB::table('recurring_pushes')
                            ->select('game_id', 'frequency')
                            ->groupBy('game_id', 'frequency')
                            ->get()
                            ->count();
        view()->share('recurringPushCount',$recurringPushCount);

        $gameCount = Game::count();
        view()->share('gameCount',$gameCount);

        $userCount = User::count();
        view()->share('userCount',$userCount);
        
        $RoleCount = Role::count();
        view()->share('RoleCount',$RoleCount);
        
        $PermissionCount = Permission::count();
        view()->share('PermissionCount',$PermissionCount);
        
        $CategoryCount = Category::count();
        view()->share('CategoryCount',$CategoryCount);
        
        $SubCategoryCount = SubCategory::count();
        view()->share('SubCategoryCount',$SubCategoryCount);
        
        $CollectionCount = Collection::count();
        view()->share('CollectionCount',$CollectionCount);
        
        $ProductCount = Product::count();
        view()->share('ProductCount',$ProductCount);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
