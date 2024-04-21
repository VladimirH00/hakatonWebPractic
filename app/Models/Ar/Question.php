<?php

namespace App\Models\Ar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * Class Question
 * @package App\Models\Ar
 */
class Question extends Model
{
    use HasFactory;
}
