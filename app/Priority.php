<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Priority
 * @package App
 *
 * @property string title
 * @property integer id
 * @method static find(int $id)
 */
class Priority extends Model
{
    protected $fillable = ['title'];
    public $timestamps = false;
}
