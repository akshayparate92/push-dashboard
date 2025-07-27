<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SinglePush extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'url', 'send_at','image_url', 'status' , 'game_id','push_type', 'optimize_type'];

    public function game():BelongsTo{
        return $this->belongsTo(Game::class);
    }
}
