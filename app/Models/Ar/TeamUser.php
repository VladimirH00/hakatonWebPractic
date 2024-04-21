<?php

namespace App\Models\Ar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $surname
 * @property string $first_name
 * @property string $patronymic
 * @property string $img_path
 * @property string $description
 * @property int $team_id
 *
 * Class TeamUser
 * @package App\Models\Ar
 */
class TeamUser extends Model
{
    use HasFactory;

    public $timestamps = false;
}
