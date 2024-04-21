<?php

namespace App\Models\Ar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string $login
 * @property string $password
 * @property string $icon_path
 *
 * Class Team
 * @package App\Models\Ar
 */
class Team extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
}
