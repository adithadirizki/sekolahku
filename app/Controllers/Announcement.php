<?php

namespace App\Controllers;

use App\Models\M_Announcement;
use App\Models\M_Class_Group;
use App\Models\M_Subject;
use CodeIgniter\Exceptions\PageNotFoundException;

class Announcement extends BaseController
{
	protected $m_announcement;
	protected $m_subject;
	protected $m_class_group;

	public function __construct()
	{
		$this->m_announcement = new M_Announcement();
		$this->m_subject = new M_Subject();
		$this->m_class_group = new M_Class_Group();
	}

	public function index()
	{
		$data = [
			"title" => "Pengumuman",
			"url_active" => "announcement"
		];
		if ($this->role == 'superadmin') {
			return view('announcement_list', $data);
		} elseif ($this->role == 'teacher') {
			return view('announcement_list', $data);
		} elseif ($this->role == 'student') {
			return view('student/announcement_list', $data);
		}
	}

	public function get_announcements()
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
			$where = "announced_by = '$this->username' OR (announcement_for IN ('all', 'teacher') AND NOW() > announced_at)";
		}

		$total_announcement = $this->m_announcement->total_announcement($where);
		$total_announcement_filtered = $this->m_announcement->total_announcement_filtered($where, $keyword);
		$announcement_data = $this->m_announcement->announcement_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_announcement,
			"recordsFiltered" => $total_announcement_filtered,
			"data" => $announcement_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function new()
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}
		
		$data = [
			"title" => "Tambah Pengumuman",
			"url_active" => "announcement"
		];
		return view('add_announcement', $data);
	}

	public function show($announcement_id)
	{
		if ($this->role == 'superadmin') {
			$result = $this->m_announcement->detail_announcement($announcement_id);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_announcement->detail_announcement_teacher($this->username, $announcement_id);
		} elseif ($this->role == 'student') {
			$result = $this->m_announcement->detail_announcement_student($announcement_id);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Pengumuman",
			"url_active" => "announcement",
			"data" => $result
		];
		if ($this->role == 'superadmin') {
			return view('detail_announcement', $data);
		} elseif ($this->role == 'teacher') {
			return view('teacher/detail_announcement', $data);
		} elseif ($this->role == 'student') {
			return view('student/detail_announcement', $data);
		}
	}

	public function edit($announcement_id)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		if ($this->role == 'teacher') {
			if (!$this->m_announcement->have_announcement($this->username, $announcement_id)) {
				throw new PageNotFoundException();
			}
		}
		
		$result = $this->m_announcement->announcement($announcement_id);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Edit Pengumuman",
			"url_active" => "announcement",
			"data" => $result
		];
		return view('edit_announcement', $data);
	}
}
