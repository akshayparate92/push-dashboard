<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\RecurringPush;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendWeeklyRecurringNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-weekly-recurring-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly recurring notifications at the optimal time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->output->writeln('Sending weekly recurring notifications!.');
        $now = Carbon::now(config('app.timezone'));
        $notificationAllApp = RecurringPush::where('status', 'scheduled')
                                            ->whereNull('game_id')
                                            ->whereNotNull('description')
                                            ->where('frequency', 'weekly')
                                            ->where(function ($query) use ($now) {
                                                $query->whereNull('start_time')
                                                    ->orWhere('start_time', '<=', $now);
                                            })
                                            ->inRandomOrder() // Get random notification
                                            ->first();
        $distinctGameIds = RecurringPush::where('status', 'scheduled')
                                            ->whereNotNull('game_id')
                                            ->whereNotNull('description')
                                            ->where('frequency', 'weekly')
                                            ->distinct()
                                            ->pluck('game_id');
       
            if ($notificationAllApp) {
                $this->output->writeln('Notification found all app weekly: ' . $notificationAllApp->id);
                $notification = $notificationAllApp;
                // Send notification
                $this->sendSingleRecurringNotification($notification);
                $this->markAllNotificationsAsSent($notificationAllApp);
            } else {
                $this->output->writeln('No scheduled weekly notifications found for all apps.');
            }
            foreach ($distinctGameIds as $gameId) {
                $notificationSingleApp = RecurringPush::where('status', 'scheduled')
                                             ->where('game_id', $gameId)
                                             ->whereNotNull('description')
                                             ->where('frequency', 'weekly')
                                             ->where(function ($query) use ($now) {
                                                $query->whereNull('start_time')
                                                    ->orWhere('start_time', '<=', $now);
                                                })
                                             ->inRandomOrder()
                                             ->first();
            
               
            if ($notificationSingleApp) {
                $this->output->writeln('Notification found single app for weekly: ' . $notificationSingleApp->id);
                $notification = $notificationSingleApp;
                // Send notification
                $this->sendSingleRecurringNotification($notification);
                $this->markAllNotificationsAsSent($notificationSingleApp);
            } else {
                $this->output->writeln('No scheduled single daily notifications found:'. $notificationSingleApp->id );
            }
        }
    }

    // Set onesignal keys
    private function sendSingleRecurringNotification(RecurringPush $notification)
    {
        try {
            // Get the app key based on game_id or all games
            if ($notification->game_id !== null) {
                $getAppKey = Game::select('app_id', 'rest_api_key', 'app_name')
                                ->where('id', $notification->game_id)
                                ->first();
                $this->sendNotification($getAppKey, $notification);
                $this->output->writeln('Notification single sent successfully.');
            } else {
                $getAppKeys = Game::select('app_id', 'rest_api_key')->get();
                foreach ($getAppKeys as $getAppKey) {
                    $this->sendNotification($getAppKey, $notification);
                    $this->output->writeln('Notification all app  sent successfully.');
                }
            }


            $this->output->writeln('Weekly Notification sent successfully.');
        } catch (\Exception $e) {
           
            $this->output->writeln('Failed to send weekly notification: ' . $e->getMessage());
        }
    }

    // send weekly notifications
    private function sendNotification($getAppKey, RecurringPush $notification)
    {
        try {
            // Initialize OneSignal client
            // $oneSignalClient = new \Berkayk\OneSignal\OneSignalClient(
            //     $getAppKey->app_id,
            //     decrypt($getAppKey->rest_api_key),
            //     null
            // );

            // Prepare notification parameters
            $pushDescription = $notification->description === '' ? "\u{2063}" : str_replace('&nbsp;', '', $notification->description);
            $imageUrl = $notification->image_url ?? '';
            $title = str_replace('&nbsp;', '', $notification->title) ?? '';
            $url = $notification->url ?? null;

            $parameters = [
                'app_id' => $getAppKey->app_id,
                'headings' => [
                    'en' => $title,
                ],
                'contents' => [
                    'en' => $pushDescription,
                ],
                'big_picture' => $imageUrl,
                'large_icon' => $imageUrl,
                'ios_attachments' => [
                    'id' => $imageUrl
                ],
                'included_segments' => ['All'],
                'small_icon' => 'ic_notification',
                'url' => $url,
            ];

            // Set send_after if start_time is in the future
            $now = Carbon::now();
          if($notification->start_time <= $now){
                // $scheduledTime = Carbon::createFromFormat('Y-m-d H:i:s', $notification->start_time)->format('H:i:s');
                // $scheduledNxtDate = Carbon::createFromFormat('Y-m-d H:i:s', $now,config('app.timezone'))->format('Y-m-d');
                $scheduledNxtDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $notification->start_time,config('app.timezone'));
                $scheduledNxtDateTime->setTimezone('UTC');
                $parameters['send_after'] = $scheduledNxtDateTime->toDateTimeString();
            }
            // Send notification
            // $oneSignalClient->sendNotificationCustom($parameters);
            if($notification->optimize_type === 'intelligent'){
                $parameters['delayed_option'] = 'intelligent'; 
            }
            Http::withHeaders([
                'Authorization' => 'Basic ' . decrypt($getAppKey->rest_api_key),
                'Content-Type' => 'application/json',
            ])->post('https://onesignal.com/api/v1/notifications', $parameters);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function markAllNotificationsAsSent(RecurringPush $notification = null)
    {
        $customTime = Carbon::createFromFormat('Y-m-d H:i:s', $notification->start_time,config('app.timezone'))->format('H:i:s');
        $currentDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now(),config('app.timezone'))->format('Y-m-d');
        $scheduledNxtDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' ' . $customTime,config('app.timezone'))->addWeek();
        if ($notification->game_id !== null) {
            RecurringPush::where('game_id', $notification->game_id)
                ->where('status', 'scheduled')
                ->update(['start_time' => $scheduledNxtDateTime]);
        } else {
            RecurringPush::whereNull('game_id')
                ->where('status', 'scheduled')
                ->update(['start_time' => $scheduledNxtDateTime]);
        }
    }
}
