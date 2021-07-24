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
		if ($this->role == 'superadmin') {
			return view('material_list', $data);
		} elseif ($this->role == 'teacher') {
			return view('material_list', $data);
		} elseif ($this->role == 'student') {
			return view('student/material_list', $data);
		}
	}

	public function get_materials()
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

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

		if ($this->role == 'teacher') {
			$where = [
				"created_by" => $this->username
			];
		}

		$total_material = $this->m_material->total_material($where);
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
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		$subject = [];
		if ($this->role == 'teacher') {
			foreach ($this->subject as $v) {
				$subject[] = "subject_id = '$v'";
			}
			$subject = count($subject) > 0 ? implode(' OR ', $subject) : "subject_id IS NULL";
		}

		$data = [
			"title" => "Tambah Materi",
			"url_active" => "material",
			"subject" => $this->m_subject->subjects($subject),
		];
		return view('add_material', $data);
	}

	public function show($material_code)
	{
		if ($this->role == 'superadmin') {
			$result = $this->m_material->detail_material($material_code);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_material->detail_material_teacher($this->username, $material_code);
		} elseif ($this->role == 'student') {
			$result = $this->m_material->detail_material_student($this->class, $material_code);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Materi",
			"url_active" => "material",
			"data" => $result
		];
		if ($this->role == 'superadmin') {
			return view('detail_material', $data);
		} elseif ($this->role == 'teacher') {
			return view('teacher/detail_material', $data);
		} elseif ($this->role == 'student') {
			return view('student/detail_material', $data);
		}
	}

	public function edit($material_code)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		if ($this->role == 'superadmin') {
			$result = $this->m_material->detail_material($material_code);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_material->detail_material_teacher($this->username, $material_code);
		} elseif ($this->role == 'student') {
			$result = $this->m_material->detail_material_student($this->class, $material_code);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$class = [];
		foreach (json_decode($result->class_group_code) as $v) {
			$class[] = "class_group_code = '$v'";
		}
		$class = count($class) > 0 ? implode(' OR ', $class) : "class_group_code IS NULL";

		$subject = [];
		if ($this->role == 'teacher') {
			foreach ($this->subject as $v) {
				$subject[] = "subject_id = '$v'";
			}
			$subject = count($subject) > 0 ? implode(' OR ', $subject) : "subject_id IS NULL";
		}

		$data = [
			"title" => "Edit Materi",
			"url_active" => "material",
			"data" => $result,
			"subject" => $this->m_subject->subjects($subject),
			"class_group" => $this->m_class_group->class_groups($class)
		];
		return view('edit_material', $data);
	}
}
