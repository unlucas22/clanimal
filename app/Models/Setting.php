<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'description',
        'type',
    ]; // type: numeric, string, image, url

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'type_formatted',
        'value_formatted',
    ];

    public function getValueFormattedAttribute()
    {
        if($this->type == 'image')
        {
            $link = Storage::url('public/'.$this->value);

            return '<a href="'.$link.'" target="_blank"><img width="100" src="'.$link.'"></a>';
        }
        else
        {
            return $this->value;
        }
    }

    public function getTypeFormattedAttribute()
    {
        switch($this->type)
        {
            case 'numeric':
                return '<span class="block bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Númerico</span>';
                break;

            case 'string':
                return '<span class="block bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Texto</span>';
                break;

            case 'image':
                return '<span class="block bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Imagen</span>';
                break;

            case 'url':
                return '<span class="block bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300"><a href="'.$this->value.'">URL</a></span>';
                break;

        }
    }
}
