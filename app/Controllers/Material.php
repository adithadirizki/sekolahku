<?php

namespace App\Controllers;

use App\Models\M_Material;
use App\Models\M_Class_Group;
use App\Models\M_Subject;
use CodeIgniter\Exceptions\PageNotFoundException;

class Material extends BaseController
{
	protected $m_material;
	protected $m_subject;
	protected $m_class_group;

	public function __construct()
	{
		$this->m_material = new M_Material();
		$this->m_subject = new M_Subject();
		$this->m_class_group = new M_Class_Group();
	}

	public function index()
	{
		$data = [
			"title" => "Materi",
			"url_active" => "material"
		];
		return view('material_list', $data);
	}

	public function get_materials()
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
		$total_material = $this->m_material->total_material();
		$total_material_filtered = $this->m_material->total_material_filtered($where, $keyword);
		$material_data = $this->m_material->material_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_material,
			"recordsFiltered" => $total_material_filtered,
			"data" => $material_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function new()
	{
		$data = [
			"title" => "Tambah Materi",
			"url_active" => "material",
			"subject" => $this->m_subject->subjects(),
		];
		return view('add_material', $data);
	}

	public function show($material_code)
	{
		$result = $this->m_material->material($material_code);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Materi",
			"url_active" => "material",
			"data" => $result
		];
		return view('detail_material', $data);
	}

	public function edit($material_code)
	{
		$result = $this->m_material->material($material_code);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$where = [];
		foreach (json_decode($result->class_group_code) as $v) {
			$where[] = "class_group_code = '$v'";
		}
		$where = implode(' OR ', $where);
		$data = [
			"title" => "Edit Materi",
			"url_active" => "material",
			"data" => $result,
			"subject" => $this->m_subject->subjects(),
			"class_group" => $this->m_class_group->class_groups($where)
		];
		return view('edit_material', $data);
	}
}
