<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable =['game_id','type', 'description','status','send_at'];

    public function game():BelongsTo{
        return $this->belongsTo(Game::class);
    }
}
