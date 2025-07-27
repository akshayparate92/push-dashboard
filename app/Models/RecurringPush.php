<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringPush extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'url','image_url', 'status' , 'game_id','scheduled_time','start_time','frequency','optimize_type'];
    public function game():BelongsTo{
        return $this->belongsTo(Game::class);
    }
}
