<?php

namespace App\Models\Ar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $team_id
 * @property int $rating_type_id
 * @property int $mark
 *
 * Class Rating
 * @package App\Models\Ar
 */
class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating';

    public $timestamps = false;
}
