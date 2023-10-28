<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use App\Models\{History, Company, Role};
use DB;

trait HasHistories {

	/**
	 * Guardar en el historial cualquier cambio
	 * 
	 * @param array $table [string $name, string $formatted_name, numeric $id]
	 * @param string $column name
	 * @param mix $value
	 * 
	 * @return \App\Model\History
	 * */
	public function setHistory($table, $column, $value)
	{
		try
		{
			/* obtener los antiguos valores */
			$db = collect(DB::table($table['name'])->where('id', $table['id'])->first())->toArray();

			$name = $table['formatted_name'] ?? $table['name'];

			/* $db[$column] es igual da el value de role_id o company_id */
			$old_value = $db[$column];

			if($column == 'company_id')
			{
				$old_value = Company::find($db[$column])->name;
			}
			else if($column == 'role_id')
			{
				$old_value = Role::find($db[$column])->name;
			}

			$message = "Cambio en {$name} de '{$old_value}' a '{$value}'";

			/**
			 * Seguramente $db['id'] lo cambie en un futuro a algo como $user_id en los parametros
			 * */
			$history = History::create([
				'user_id' => $db['id'],
				'message' => $message,
			]);

			return $history;
		}
		catch (\Exception $e)
		{
			Log::error($e->getMessage());

			return null;	
		}
	}
}