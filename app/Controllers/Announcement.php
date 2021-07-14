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
		return view('announcement_list', $data);
	}

	public function get_announcements()
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
		$total_announcement = $this->m_announcement->total_announcement();
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
		$data = [
			"title" => "Tambah Pengumuman",
			"url_active" => "announcement"
		];
		return view('add_announcement', $data);
	}

	public function show($announcement_code)
	{
		$result = $this->m_announcement->announcement($announcement_code);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Pengumuman",
			"url_active" => "announcement",
			"data" => $result
		];
		return view('detail_announcement', $data);
	}

	public function edit($announcement_code)
	{
		$result = $this->m_announcement->announcement($announcement_code);
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
