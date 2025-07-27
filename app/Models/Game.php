<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;
    protected $fillable = ['app_name','app_id', 'rest_api_key'];

    public static function getOneSignalKeys($id) {
        $app = Game::where('id', $id)->first();
        if ($app) {
            return [
                'app_id' => $app->app_id,
                'rest_api_key' => $app->rest_api_key,
            ];
        } else {
            return null; // Handle case where app ID is not found
        }
    }

    public function singlePush():HasMany{
        return $this->hasMany(SinglePush::class);
    }

    public function recurringPush():HasMany{
        return $this->hasMany(RecurringPush::class);
    }

    public function delivery():HasMany{
        return $this->hasMany(Delivery::class);
    }
}
