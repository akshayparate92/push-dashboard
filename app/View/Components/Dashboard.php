<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Game;
use App\Models\Product;
use App\Models\SinglePush;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class Dashboard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = User::count();
        view()->share('user',$user);
        
        $game = Game::count();
        view()->share('game',$game);
        
        $singlePush = SinglePush::where('push_type', 'single')->count();
        view()->share('singlePush',$singlePush);
        
        $recurringPush =  DB::table('recurring_pushes')
                        ->select('game_id', 'frequency')
                        ->groupBy('game_id', 'frequency')
                        ->get()
                        ->count();
        view()->share('recurringPush',$recurringPush);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard');
    }
}
