<?php

namespace App\Models\Ar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $question_id
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * Class Answer
 * @package App\Models\Ar\Ar
 */
class Answer extends Model
{
    use HasFactory;
}
