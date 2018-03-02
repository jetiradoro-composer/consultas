<?php
/**
 * Created by PhpStorm.
 * User: jtirado
 * Date: 28/2/18
 * Time: 11:16
 */

namespace Modules\Consultas\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class ConsultesModelService
 * Crea array de configuración para el funcionamiento del módulo
 * @author Jesús.T *
 * @package Modules\Consultas\Http\Services
 */

class ConsultesModelService {

	/**
	 * Obté tota la configuració d'entitats necessària per treballar amb el mòdul
	 * @return array
	 * @throws \Exception
	 */
	public function getData() {
		$models = Config::get('consultas.entities');
		if ($models == null || count($models) == 0) {throw new \Exception("No se han encontrado modelos definidos en la configuración");
		}

		$rs = ['tables' => []];

		foreach ($models as $k => $entity) {

			$instance = $this->getModel($entity);

			$rs[$k] = [
				'entity' => $k,
				'table'  => $instance->getTable(),
			];
			$rs[$k]['fields'] = $this->getEntityDesc($instance);
		}

		return collect($rs);
	}

	/**
	 * Torna l'array d'una entitat en concret
	 * @param \Illuminate\Database\Eloquent\Model $entity
	 *
	 * @return array
	 */
	private function getEntityDesc(Model $entity) {
		$columns = $entity->getConnection()->getSchemaBuilder()->getColumnListing($entity->getTable());
		asort($columns);

		$hiddens = $entity->getHidden();
		$rs      = [];
		foreach ($columns as $col) {
			$key = str_replace('_', ' ', $col);
			if (!in_array(strtolower($col), $hiddens)) {
				// $type = $entity->getConnection()->getSchemaBuilder()->getColumnType($entity->getTable(),$col);
				$rs[$key] = $col;
			}

		}
		//        foreach($columns as $col){
		//            $type = $entity->getConnection()->getSchemaBuilder()->getColumnType($entity->getTable(),$col);
		//            $rs[$col] = $type;
		//        }
		return $rs;
	}

	/**
	 * Crea una nova instància de la classe passada per paràmetre
	 * @param $name
	 *
	 * @return mixed
	 */
	private function getModel($name) {
		return new $name();

	}
}