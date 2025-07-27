<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\RecurringPush;
use App\Models\SinglePush;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RecurringPushController extends Controller
{   
    protected $data;
    protected $indexData;

    public function __construct()
    {
            $this->data = RecurringPush::with(['game' => function($query) {
                return $query->select('id', 'app_name'); // Make sure to include the 'id' field for proper relationships
            }])
            ->select('id','game_id','description','url','image_url','status','start_time','frequency','optimize_type')
            ->where('status', 'created')
            ->orderBy('updated_at', 'DESC')->get();
            View::composer('admin.recurring-push.create', function($view)  {
            $view->with('data', $this->data);
            });
            $this->indexData = RecurringPush::with(['game' => function($query) {
                return $query->select('id', 'app_name'); // Ensure to include the 'id' field for proper relationships
            }])
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->groupBy(function ($item) {
                return $item->game ? $item->game->app_name : 'All Apps';
            });
    
        View::composer( 'admin.recurring-push.index', function($view) {
            $view->with('indexData', $this->indexData);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return view('admin.recurring-push.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.recurring-push.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedPushMsgData = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'required',
            'url' => 'nullable|url',
        ]);
      
        if($validatedPushMsgData){
            $dom = new \DOMDocument();
            $dom->loadHTML($validatedPushMsgData['description']);

            $images = [];
            foreach ($dom->getElementsByTagName('img') as $img) {
                $src = $img->getAttribute('src');
                $images[] = $src;
            }
            if($images){
                $image_path = $images[0]; // $image_path = "../../storage/uploads/92e3f718-2cb7-4058-b49a-1a8ba7efde01.jpeg"
                $image_path = str_replace('../../', '', $image_path);
                $image_url = url( $image_path);
            }else{
                $image_url = ''; 
            }
            $pushDesciption = strip_tags(trim($validatedPushMsgData['description'])) === '' ? "\u{2063}" : strip_tags($validatedPushMsgData['description']);
            $pushTitle = strip_tags(trim($validatedPushMsgData['title'])) ?? '';
            $pushUrl = strip_tags($validatedPushMsgData['url']) ?? null;
            // Parse the datetime with timezone
            // if($validationScheduleData){
            //     $datetime = Carbon::createFromFormat('m-d-Y H:i:s', $validationScheduleData['scheduled_time'], $validationScheduleData['timezone']);
            //      // Convert to UTC
            //     $defaultTimezone = config('app.timezone');
            //     $datetimeUtc = $datetime->setTimezone($defaultTimezone);
            // }else{
            //     $datetimeUtc= null;
            // }
            $game = Game::where('id' ,$request->input('game_id'))->first();
            if($game){
                $game->recurringPush()->create([
                    'title' => $pushTitle,
                    'description' => $pushDesciption,
                    'url' => $pushUrl,
                    'image_url' =>$image_url,
                    'game_id' => $request->input('game_id'),
                    'start_time' => $request->input('start_time'),
                    'frequency' => $request->input('frequency'),
                    'optimize_type' => $request->input('optimize_type'),
                    'status' => 'scheduled'
                ]);                                                       
                return redirect()->back()->with('success', 'Recurring push saved successfully '.$game->app_name . '!.');     

            }
            elseif ($game == null){
                RecurringPush::create([
                    'title' => $pushTitle,
                    'description' => $pushDesciption,
                    'url' => $pushUrl,
                    'image_url' =>$image_url,
                    'start_time' => $request->input('start_time'),
                    'frequency' => $request->input('frequency'),
                    'optimize_type' => $request->input('optimize_type'),
                    'status' => 'scheduled'
                ]);
                return redirect()->back()->with('success','Recurring push scheduled for all games successfully');
              
            }
          
        }
        return redirect()->route('admin.push.index')->with('success', 'Recurring push scheduled successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = SinglePush::where('id', decrypt($id))->first();
        $game->delete();
        return redirect()->route('admin.recurring.index')->with('error', 'Recurring push deleted successfully.');
    }

    public function recurringEdit($game = null , $frequency){
        $query = RecurringPush::query();
        if ($game !== null && $game !== 'all') {
            $query->where('game_id', $game)->where('frequency',$frequency);
            $appData = Game::select('app_name')->where('id',$game)->first();
            $appName =$appData->app_name;
        }else if($game == 'all'){
            $query->where('frequency', $frequency)->where('game_id', null);
            $appName = 'All Apps';
        }
        $recurringPushes = $query->orderBy('updated_at', 'DESC')->get();
        $games = Game::pluck('app_name', 'id');
        return view('admin.recurring-push.edit', [
            'recurringPushes' => $recurringPushes,
            'selectedGameId' => $game,
            'games' => $games,
            'appName' => $appName
        ]);
    }
    // Delete app recurring push

    public function recurringDelete($game = null , $frequency){
        $query = RecurringPush::query();
        if($game !== null &&  $game !== 'all'){
            $query->where('game_id',$game)->where('frequency',$frequency);
            $appData = Game::select('app_name')->where('id',$game)->first();
            $appName =$appData->app_name;
        }elseif($game == 'all'){
            $query->where('frequency', $frequency)->where('game_id', null);
            $appName = 'All Apps';
        }
        $query->delete();
        return redirect()->route('admin.recurring.index')->with('error',  $appName.' with ' .$frequency.' Recurring pushes deleted successfully.');
    }
    // Recurring push message delete
    public function recurringPushDelete($messageId){
        $messageId = decrypt($messageId);
       $deleted = RecurringPush::where('id',$messageId)->delete();
        if($deleted){
            return back()->with('error', 'Recurring Push Deleted Successfully!.');
        }
        return back()->with('error', 'Failed to Deleted Recurring Push Successfully!.');
    }
   // schedule recurring push 
   public function recurringScheduleTime(Request  $request){
    // dd($request->all());
    $validatedScheduleTimeData = $request->validate([
        'app_name' => 'required',
        'frequency' => 'required|string',
        'start_date' => 'required|date_format:m-d-Y',
        'delivery_type' => 'required|string',
        'scheduled_time' => 'required|date_format:H:i',
        'timezone' => 'required|string|timezone',
    ]);

    $startDateTimeString = $validatedScheduleTimeData['start_date'] . ' ' . $validatedScheduleTimeData['scheduled_time'];
    $startDateTime = Carbon::createFromFormat('m-d-Y H:i', $startDateTimeString, $validatedScheduleTimeData['timezone']);
    $game_id = $validatedScheduleTimeData['app_name'] == 'all' ? null : $validatedScheduleTimeData['app_name'];
    if($startDateTime){
        $optimizeType = $request->input('delivery_type');
    }
    $checkAppScheduleRegister = RecurringPush::where('game_id', $game_id)
                                ->where('frequency',$validatedScheduleTimeData['frequency'] )->exists();
    if( $checkAppScheduleRegister ){
        return response()->json(['status' => 'error', 'msg' => 'This App Schedule Already registered!.'],422);
    }else{
        $recurringPushScheduleUpdate =RecurringPush::create(
            [
                'game_id' => $game_id,
                'frequency' => $validatedScheduleTimeData['frequency'],
                'start_time' => $startDateTime,
                'status' => 'scheduled',
                'optimize_type' =>  $optimizeType
            ]
        );
        if($recurringPushScheduleUpdate){
            return response()->json(['status' => 'success', 'msg' => 'Schedule App Added successfully!.']);
    
        }
    }
   
    return response()->json(['status' => 'error', 'msg' => 'Failed to schedule App']);
   } 
}
