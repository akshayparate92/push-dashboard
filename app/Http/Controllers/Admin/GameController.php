<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {

        $data = Game::select('id','app_name','app_id')->orderBy('id', 'DESC')->get();
        view()->share('data', $data);
    }
    public function index()
    {
        return view('admin.games.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'app_name'      => 'required',
            'app_id'        => 'required',
            'rest_api_key'  => 'required',
        ]);
        // Create new game instance
        $game = new Game();
        $game->app_name = $request->app_name;
        $game->app_id = $request->app_id;
        $game->rest_api_key = encrypt($request->rest_api_key);
        $game->save();
        return redirect()->route('admin.game.index')->with('success', 'Game App created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Game::select('id','app_name','app_id')->where('id', decrypt($id))->first();
        return view('admin.games.edit', compact( 'data' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $request->validate([
            'app_name'      => 'required',
            'app_id'        => 'required',
        ]);

        // Update game instance
        $game = Game::where('id', $request->id)->first();
        $game->app_name = $request->app_name;
        $game->app_id = $request->app_id;
        if ($request->filled('rest_api_key')) {
            $game->rest_api_key = encrypt($request->input('rest_api_key'));
        }
        $game->save();
        return redirect()->route('admin.game.index')->with('success', 'Game App updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::where('id', decrypt($id))->first();
        $game->delete();
        return redirect()->route('admin.game.index')->with('error', 'Product deleted successfully.');
    }
}
