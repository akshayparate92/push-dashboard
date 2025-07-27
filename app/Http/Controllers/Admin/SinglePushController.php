<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Game;
use App\Models\SinglePush;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SinglePushController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $data = SinglePush::with(['game' => function ($query) {
            return $query->select('id', 'app_name'); // Make sure to include the 'id' field for proper relationships
        }])
            ->where('push_type', 'single')
            ->orderBy('updated_at', 'DESC')
            ->get();
        view()->share('data', $data);
    }
    public function index()
    {
        return view('admin.single-push.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.single-push.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validatedPushMsgData = $request->validate([
    //         'title' => 'nullable|max:255',
    //         'description' => 'required',
    //         'url' => 'nullable|url',
    //         'delivery_type' => 'required'
    //     ]);
    //     $validationScheduleData = 0;
    //     if ($validatedPushMsgData['delivery_type'] === 'scheduled') {

    //         $validationScheduleData =  $request->validate([
    //             'scheduled_time' => 'required|date_format:"m-d-Y H:i:s"',
    //             'timezone' => 'required|timezone',
    //         ]);
    //     }
    //     if ($validatedPushMsgData) {
    //         $dom = new \DOMDocument();
    //         $dom->loadHTML($validatedPushMsgData['description']);

    //         $images = [];
    //         foreach ($dom->getElementsByTagName('img') as $img) {
    //             $src = $img->getAttribute('src');
    //             $images[] = $src;
    //         }
    //         if ($images) {
    //             $image_path = $images[0]; // $image_path = "../../storage/uploads/92e3f718-2cb7-4058-b49a-1a8ba7efde01.jpeg"
    //             $image_path = str_replace('../../', '', $image_path);
    //             $image_url = url($image_path);
    //         } else {
    //             $image_url = '';
    //         }
    //         $pushDesciption = strip_tags(trim($validatedPushMsgData['description'])) === '' ? "\u{2063}" : strip_tags($validatedPushMsgData['description']);
    //         $pushTitle = strip_tags(trim($validatedPushMsgData['title'])) ?? '';
    //         $pushUrl = strip_tags($validatedPushMsgData['url']) ?? null;
    //         // Parse the datetime with timezone
    //         $defaultTimezone = config('app.timezone');
    //         $now = Carbon::now();
    //         $currentTime = Carbon::createFromFormat('Y-m-d H:i:s', $now, config('app.timezone'));
    //         if ($validationScheduleData) {
    //             $datetime = Carbon::createFromFormat('m-d-Y H:i:s', $validationScheduleData['scheduled_time'], $validationScheduleData['timezone']);
    //             // Convert to UTC
    //             $datetimeUtc = $datetime->setTimezone($defaultTimezone)->format('Y-m-d H:i:s');
    //         } else {
    //             $datetimeUtc = $currentTime;
    //         }

    //         $game = Game::where('id', $request->input('game_id'))->first();
    //         if ($game) {
    //             $game->singlePush()->create([
    //                 'title' => $pushTitle,
    //                 'description' => $pushDesciption,
    //                 'url' => $pushUrl,
    //                 'image_url' => $image_url,
    //                 'send_at' => $datetimeUtc,
    //             ]);

    //             $getAppKeys = Game::select('app_id', 'rest_api_key', 'app_name')->where('id', $request->input('game_id'))->first();

    //             $singePushData = SinglePush::where('game_id', $game->id)->where('status', 'pending')->first();
    //             $notificationSent =  $this->sendSinglePush($getAppKeys, $singePushData);
    //             // update db
    //             if ($notificationSent) {
    //                 SinglePush::where('game_id', $game->id)->where('status', 'pending')->update([
    //                     'status' => 'delivered'
    //                 ]);

    //                 if ($datetimeUtc > $currentTime) {
    //                     $status = 'scheduled';
    //                 } else {
    //                     $status = 'delivered';
    //                 }
    //                 $game->delivery()->create([
    //                     'type' => 'single',
    //                     'description' => $pushDesciption,
    //                     'status' => $status,
    //                     'send_at' => $datetimeUtc ?? $currentTime
    //                 ]);
    //             } else {
    //                 return redirect()->route('admin.push.index')->with('error', 'Failed to send notifications');
    //             }

    //             return redirect()->route('admin.push.index')->with('success', 'Single push send successfully ' . $getAppKeys->app_name . '!.');
    //         } elseif ($game == null) {
    //             SinglePush::create([
    //                 'title' => $pushTitle,
    //                 'description' => $pushDesciption,
    //                 'url' => $pushUrl,
    //                 'image_url' => $image_url,
    //                 'send_at' => $datetimeUtc
    //             ]);
    //             $getAppKeys = Game::select('app_id', 'rest_api_key', 'app_name')->get();
    //             $singePushData = SinglePush::where('game_id', null)->where('status', 'pending')->first();

    //             foreach ($getAppKeys as $getAppKey) {
    //                 $this->sendSinglePush($getAppKey, $singePushData);
    //             }
    //             $singePushData->update([
    //                 'status' => 'delivered'
    //             ]);
    //             if ($datetimeUtc > $currentTime) {
    //                 $status = 'scheduled';
    //             } else {
    //                 $status = 'delivered';
    //             }
    //             Delivery::create([
    //                 'type' => 'single',
    //                 'description' => $pushDesciption,
    //                 'status' => $status,
    //                 'send_at' => $datetimeUtc ?? $currentTime
    //             ]);
    //             return redirect()->route('admin.push.index')->with('success', 'Single push send successfully all apps!.');
    //         }
    //     } else {
    //         return redirect()->route('admin.push.index')->with('error', 'Failed to send notifications');
    //     }
    //     return redirect()->route('admin.push.index')->with('success', 'Single push send successfully.');
    // }
    public function store(Request $request)
    {
        $validatedPushMsgData = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'required',
            'url' => 'nullable|url',
            'delivery_type' => 'required|in:scheduled,immediate',
            'scheduled_time' => 'required_if:delivery_type,scheduled|date_format:"m-d-Y H:i:s"',
            'timezone' => 'required_if:delivery_type,scheduled|timezone',
        ]);
        $image_url = $this->extractFirstImageUrl($validatedPushMsgData['description']);

        $pushDescription = strip_tags(trim($validatedPushMsgData['description'])) ?: "\u{2063}";
        $pushTitle = strip_tags(trim($validatedPushMsgData['title'])) ?: '';
        $pushUrl = strip_tags($validatedPushMsgData['url']) ?: null;
        $datetimeUtc = $this->getScheduledTimeUtc(
            $validatedPushMsgData['delivery_type'],
            $validatedPushMsgData['scheduled_time'] ?? null,
            $validatedPushMsgData['timezone'] ?? null
        );
        if( $datetimeUtc){
            $pushOptimizeType = $request->input('optimize_type');
        }else{
            $pushOptimizeType = null;
        }
        $game = Game::find($request->input('game_id'));

        if ($game) {
            $singlePush = $game->singlePush()->create([
                'title' => $pushTitle,
                'description' => $pushDescription,
                'url' => $pushUrl,
                'image_url' => $image_url,
                'send_at' => $datetimeUtc,
                'optimize_type' => $pushOptimizeType
            ]);

            $this->sendNotificationAndUpdateStatus($singlePush, $game);
        } else {
            $singlePush = SinglePush::create([
                'title' => $pushTitle,
                'description' => $pushDescription,
                'url' => $pushUrl,
                'image_url' => $image_url,
                'send_at' => $datetimeUtc,
                'optimize_type' => $pushOptimizeType
            ]);

            $this->sendNotificationToAllGamesAndUpdateStatus($singlePush);
        }

        return redirect()->route('admin.push.index')->with('success', 'Single push sent successfully.');
    }

    private function extractFirstImageUrl($html)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $images = [];

        foreach ($dom->getElementsByTagName('img') as $img) {
            $images[] = $img->getAttribute('src');
        }

        if ($images) {
            $image_path = str_replace('../../', '', $images[0]);
            return url($image_path);
        }

        return '';
    }

    private function getScheduledTimeUtc($deliveryType, $scheduledTime, $timezone)
    {
        if ($deliveryType === 'scheduled') {
            $datetime = Carbon::createFromFormat('m-d-Y H:i:s', $scheduledTime, $timezone);
            return $datetime->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
        }

        return Carbon::now()->format('Y-m-d H:i:s');
    }

    private function sendNotificationAndUpdateStatus($singlePush, $game)
    {
        $notificationSent = $this->sendSinglePush($game, $singlePush);
        if ($notificationSent) {
            $singlePush->update(['status' => 'delivered']);
            $game->delivery()->create([
                'type' => 'single',
                'description' => $singlePush->description,
                'status' => $singlePush->send_at > Carbon::now() ? 'scheduled' : 'delivered',
                'send_at' => $singlePush->send_at
            ]);
        } else {
            return redirect()->route('admin.push.index')->with('error', 'Failed to send notifications');
        }
    }

    private function sendNotificationToAllGamesAndUpdateStatus($singlePush)
    {
        $getAppKeys = Game::select('app_id', 'rest_api_key', 'app_name')->get();

        foreach ($getAppKeys as $getAppKey) {
            $this->sendSinglePush($getAppKey, $singlePush);           
        }

        $singlePush->update(['status' => 'delivered']);
        Delivery::create([
            'type' => 'single',
            'description' => $singlePush->description,
            'status' => $singlePush->send_at > Carbon::now() ? 'scheduled' : 'delivered',
            'send_at' => $singlePush->send_at
        ]);
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
        return redirect()->route('admin.push.index')->with('error', 'Single Push deleted successfully.');
    }
    /**
     * TinyMCE the store image upload.
     */
    public function tinyMCEImageUpload(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/uploads', $filename);
    
                return response()->json(['location' => Storage::url($path)]);
            }
    
            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            Log::error('TinyMCE Image Upload Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendSinglePush($getAppKeys, $singePushData)
    {

        // $oneSignalClient = new \Berkayk\OneSignal\OneSignalClient($getAppKeys->app_id, decrypt($getAppKeys->rest_api_key), null);
        try {
            $parameters = [
                'app_id' => $getAppKeys->app_id,
                'headings'       => [
                    'en' => str_replace('&nbsp;', '', $singePushData->title) ?? "\u{2063}",
                ],
                'contents'       => [
                    'en' => str_replace('&nbsp;', '', $singePushData->description) ?? "\u{2063}",
                ],
                'big_picture' => $singePushData->image_url ?? null,
                'large_icon' => $singePushData->image_url ?? null,
                // 'ios_badgeType' => 'SetTo',
                // 'ios_badgeCount' => 1,
                'ios_attachments' => [
                    "id" => $singePushData->image_url ?? null, // banner image
                    // "url" => 'https://cdn.iconscout.com/icon/premium/png-512-thumb/online-url-encoder-decod-4-53626.png?f=webp&w=256'
                ],
                // 'ios_badgeType'  => 'Increase',
                'included_segments' => array('All'),
                'small_icon' => 'ic_notification',
                'url' => $singePushData->url ?? null
            ];
            if ($singePushData->send_at != null) {
                $scheduledDate = Carbon::createFromFormat('Y-m-d H:i:s', $singePushData->send_at);
                $scheduledDate->setTimezone('UTC');
                $parameters['send_after'] = $scheduledDate->toDateTimeString();
                if($singePushData->optimize_type === 'intelligent'){
                    $parameters['delayed_option'] = 'intelligent'; 
                }
            }
            Http::withHeaders([
                'Authorization' => 'Basic ' . decrypt($getAppKeys->rest_api_key),
                'Content-Type' => 'application/json',
            ])->post('https://onesignal.com/api/v1/notifications', $parameters);
            // $oneSignalClient->sendNotificationCustom($parameters);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
