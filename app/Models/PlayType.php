<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PlayType
 * @package App\Models
 *
 * @property $id int
 * @property $name string
 */
class PlayType extends Model
{
    protected $table = 'play_types';

    protected $fillable = ['name'];

    public $timestamps = false;

    public static function id(string $name): int
    {
        return self::query()->firstOrCreate(['name' => $name])->id;
    }
}
