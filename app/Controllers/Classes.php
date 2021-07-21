<?php

namespace App\Controllers;

use App\Models\M_Class;
use App\Models\M_Class_Group;
use App\Models\M_Major;

class Classes extends BaseController
{
	protected $m_class;
	protected $m_major;
	protected $m_class_group;

	public function __construct()
	{
		$this->m_class = new M_Class();
		$this->m_major = new M_Major();
		$this->m_class_group = new M_Class_Group();
	}

	public function index()
	{
		$data = [
			"title" => "Kelas",
			"url_active" => "classes",
			"class" => $this->m_class->classes(),
			"major" => $this->m_major->majors()
		];
		return view('class_list', $data);
	}

	public function get_classes()
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
		$total_class = $this->m_class->total_class();
		$total_class_filtered = $this->m_class->total_class_filtered($where, $keyword);
		$class_data = $this->m_class->class_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_class,
			"recordsFiltered" => $total_class_filtered,
			"data" => $class_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function get_class_groups()
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

		if ($this->role == 'teacher') {
			foreach ($this->class as $v) {
				$where[] = "class_group_code = '$v'";
			}
			$where = count($where) > 0 ? implode(' OR ', $where) : "class_group_code IS NULL";
		}

		$orderby = implode(',', $orderby);
		$total_class_group = $this->m_class_group->total_class_group($where);
		$total_class_group_filtered = $this->m_class_group->total_class_group_filtered($where, $keyword);
		$class_group_data = $this->m_class_group->class_group_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_class_group,
			"recordsFiltered" => $total_class_group_filtered,
			"data" => $class_group_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}
}
