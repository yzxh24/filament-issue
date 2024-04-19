<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamQuestion extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_id',
        'score',
        'sort_value',
    ];
}
