<?php

namespace Modules\Consultas\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Consultas\Http\Services\ConsultesModelService;

class ConsultasController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(ConsultesModelService $model) {

		$entities = $model->getData();

		//obtener listados disponibles
		// $entities = $this->getTables();

		//  $data['entities'] = $entities;

		return view('consultas::index', ['entities' => $entities->toJson()]);
	}

	/**
	 * Obtiene la configuración del archivo de config
	 *
	 * @return array
	 */
	private function getTables() {
		$config_entities = collect((Config::get('consultas.tables')));

		return $config_entities;
	}

	/**
	 * Recibe los datos del formulario, hace las comprobaciones necesarias y obtiene los datos.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setQuery(Request $request, $excel = false) {

		$data = ['status' => 'success', 'message' => 'anem bé'];
		try {
			// comprobació dels camps obligatoris
			$validate = Validator::make($request->all(), [
					'select' => 'required',
					'table'  => 'required'
				]);

			if ($validate->fails()) {
				throw new \Exception("No s`han definit els camps obligatoris");
			}

			$query = $this->constructQuery($request, $excel);

			$rs = DB::select($query);

			if ($excel) {

				$export = ['select' => explode(',', $request->select), 'rs' => $rs];

				Excel::create('dynamic_request_results', function ($excel) use ($export) {
						$excel->sheet('Report', function ($sheet) use ($export) {
								$sheet->loadView('consultas::export', $export);
								//                        $sheet->setColumnFormat(array(
								//                            'A' => '0',
								//                            'B' => '0',
								//                            'D' => '0',
								//                            'E' => '0',
								//                            'F'=>'0%'
								//                        ));
							});
					})->download('xlsx');
			} else {
				$data = [
					'status'  => 'success',
					'message' => $rs,
					'query'   => $query
				];
			}

		} catch (\Exception $e) {
			if ($excel) {return redirect()->back()->withErrors($e->getMessage());
			}

			$data = [
				'status'  => 'error',
				'message' => $e->getMessage()
			];
		}

		return response()->json($data);

	}

	/**
	 * Construye una query a través de los paràmetros recibidos en le request
	 *
	 * @param $request
	 *
	 * @return string
	 */
	private function constructQuery($request, $excel) {
		$select = "SELECT distinct ";
		$next   = "";

		$select_array = $excel?explode(',', $request->select):$request->select;

		foreach ($select_array as $field) {
			$select .= $next.$field;
			$next = ", ";
		}

		$from = " FROM ".$request->table." ";

		$where = "";

		if ($request->has('where') && count($request->where) > 0) {
			$where_array = ($excel)?json_decode($request->where):$request->where;

			foreach ($where_array as $filter) {
				if ($excel) {$filter = (array) $filter;
				}

				if (!is_numeric($filter['value'])
					 && $filter['operand'] != 'between dates'
					 && $filter['operand'] != 'in'
				) {$filter['value'] = "'".$filter['value']."'";
				}

				if ($where == "") {$filter['operator'] = ' WHERE ';
				}

				switch ($filter['operand']) {
					case 'is null':
					case 'is not null':
						$where .= $filter['operator']." ".$filter['field']." ".$filter['operand'];
						break;
					case 'between dates':
						$dates = $this->setMySqlDates($filter['value']);
						$where .= $filter['operator']." ".$filter['field']." BETWEEN ".$dates[0]." AND ".$dates[1];
						break;
					case 'in':
						$value = $this->setIncludes($filter['value']);
						$where .= $filter['operator']." ".$filter['field']." "."IN".$value;
						break;
					default:
						$where .= $filter['operator']." ".$filter['field']." ".$filter['operand']." ".$filter['value'];
				}

			}
		}

		$order_by = " ORDER BY 1 ASC";

		$query = $select.$from.$where.$order_by;
		return $query;
	}

	/**
	 * Construeix la cadena per poder fer la consulta amb includes
	 *
	 * @author Jesús.T
	 *
	 * @param $value
	 *
	 * @return string
	 */
	public function setIncludes($value) {
		$values = explode(',', $value);
		$val    = '(';
		$next   = '';
		foreach ($values as $p) {
			// if (!is_numeric($p)) {
			$p = "'".$p."'";
			// }
			$val .= $next.$p;
			$next = ',';
		}
		$val .= ')';

		return $val;
	}

	/**
	 * Configura las fechas para filtrar por oracle
	 *
	 * @param $value
	 *
	 * @return array
	 */
	private function setOracleDates($value) {
		$dates = explode('||', $value);
		$date1 = Carbon::createFromFormat('Y-m-d', $dates[0]);
		$date2 = Carbon::createFromFormat('Y-m-d', $dates[1]);

		$date1_oracle = " TO_DATE('".$date1->format('d/m/Y')."','DD/MM/YYYY')";
		$date2_oracle = " TO_DATE('".$date2->format('d/m/Y')."','DD/MM/YYYY')";

		return [$date1_oracle, $date2_oracle];
	}

	/**
	 * Sets my sql dates.
	 * Configura las fechas para ser usadas en MySql
	 *
	 * @param      <type>  $value  The value
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	private function setMySqlDates($value) {
		$dates = explode('||', $value);
		$date1 = Carbon::createFromFormat('Y-m-d', $dates[0]);
		$date2 = Carbon::createFromFormat('Y-m-d', $dates[1]);

		$date1_oracle = " CAST('".$date1->format('Y-m-d')."','AS DATE')";
		$date2_oracle = " CAST('".$date2->format('Y-m-d')."','AS DATE')";

		return [$date1_oracle, $date2_oracle];
	}

}
