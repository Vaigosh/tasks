<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App
 *
 * @property string title
 * @property string priority_id
 * @property integer user_id
 * @property string status
 * @property array tags
 * @property Priority priority
 *
 * @method static \Illuminate\Database\Eloquent\Collection|static[] all()
 */
class Task extends Model
{
    const STATUSES = ['В работе', 'Завершена'];

    protected $fillable = ['title', 'user_id'];

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
}
