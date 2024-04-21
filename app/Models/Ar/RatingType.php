<?php

namespace App\Models\Ar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $ord
 *
 * Class RatingType
 * @package App\Models\Ar
 */
class RatingType extends Model
{
    use HasFactory;

    public $timestamps = false;
}
