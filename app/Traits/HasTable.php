<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use DB;

trait HasTable {

    /**
     * para @class en <td> 
     * */
    public $canActive = false;

    /**
     * Para una extension de la tabla 
     * */
    public $relationships = [];

    /**
     *  rows por default 
     * */
    public $rows = 20;
    
    /**
     *  cantidad de rows para seleccionar 
     * */
    public $rows_count = [20, 50, 100];

    /**
     * Se habilitan las columnas timestamp 
     * */
    public $created_at = true;
    public $updated_at = true;

    /**
     * Tabla para manipular data simple 
     * */
    public $table = '';

    public function changeRow($total)
    {
        if(in_array(intval($total), $this->rows_count)) {
            $this->rows = $total;
        }
    }

    /* eliminar un item */
    public function deleteItem($item_id)
    {
        DB::table($this->table)->where('id', $item_id)->delete();
    }

    /**
     * @param id
     * @param columna para actualizar
     * @param nuevo valor
     * 
     * actualizar una sola columna del item
     * se usa en la extension de actions
     * que se encuentra en components.actions.[table_name]
     * 
     * ¡no tiene validaciones!
     * */
    public function updateItem($item_id, string $column, $value)
    {
        $table = DB::table($this->table)->where('id', $item_id)->update([
            $column => $value,
        ]);
    }

    /**
     * Cuenta las columnas utilizadas en total
     * 
     * @param $columns
     * */
    public function getColumnsCount($columns)
    {
        $count = count($columns);

        $count += $this->created_at + $this->updated_at;

        return $count + 1 + count($this->relationships);
    }

}