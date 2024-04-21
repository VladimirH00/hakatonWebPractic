<?php

namespace App\Models;

use App\Models\Ar\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $team_id
 * @property string $token
 * @property string $expires_at
 * @property string $created_at
 * @property string $deleted_at
 *
 * @property Team $team
 *
 */
class TeamAuth extends Model
{
    use HasFactory;

    protected $table = 'team_auths';
    public $timestamps = false;
    /**
     * @return void
     */
    public function user()
    {
        $this->belongsTo(Team::class, 'team_id');
    }
}
