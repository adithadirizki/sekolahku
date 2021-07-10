<?php

namespace App\Controllers;

use App\Models\M_School_Year;

class Schoolyear extends BaseController
{
	protected $m_school_year;

	public function __construct()
	{
		$this->m_school_year = new M_School_Year();
	}

	public function index()
	{
		$data = [
			"title" => "Tahun Pelajaran",
			"url_active" => "schoolyear"
		];
		return view('school_year_list', $data);
	}

	public function get_school_years()
	{
		$limit = $_POST['length'];
		$offset = $_POST['start'];
		$keyword = $_POST['search']['value'];
		$orderby = [];
		$where = [];
		foreach ($_POST['order'] as $key => $value) {
			$field = $_POST['columns'][$value['column']]['data'];
			$dir = $value['dir'];
			array_push($orderby, "$field $dir");
		}
		$orderby = implode(',', $orderby);
		$total_school_year = $this->m_school_year->total_school_year();
		$total_school_year_filtered = $this->m_school_year->total_school_year_filtered($where, $keyword);
		$school_year_data = $this->m_school_year->school_year_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_school_year,
			"recordsFiltered" => $total_school_year_filtered,
			"data" => $school_year_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}
}
