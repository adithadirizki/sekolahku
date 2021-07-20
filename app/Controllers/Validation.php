<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;

class Validation
{
	protected $request;

	public function striptags($data)
	{
		if (is_array($data)) {
			foreach ($data as $value) {
				if (strip_tags($value) == '') {
					return false;
				}
			}
		} else {
			if (strip_tags($data) == '') {
				return false;
			}
		}
		return true;
	}

	public function choicelength($data)
	{
		if (is_array($data) && count($data) > 1) {
			return true;
		}
		return false;
	}

	public function anskey($data)
	{
		parse_str(file_get_contents('php://input'), $input);
		if (!isset($input['choice'])) return false;
		if (!in_array($data, range(0, count($input['choice']) - 1))) {
			return false;
		}
		return true;
	}

	public function essay_score($data)
	{
		parse_str(file_get_contents('php://input'), $input);
		if (!is_array($data)) {
			return false;
		}
		foreach ($data as $key => $value) {
			if (!is_numeric($key)) {
				return false;
			}

			if (!is_numeric($value) || $value < 0 || $value > 100) {
				return false;
			}
		}
		return true;
	}

	public function multiple_majors($data)
	{
		$m_majors = new \App\Models\M_Major();
		return $m_majors->validation_multiple_majors($data);
	}

	public function multiple_class_group($data)
	{
		$m_class = new \App\Models\M_Class_Group();
		return $m_class->validation_multiple_class_groups($data);
	}

	public function required_files($data = null, $fieldname)
	{
		$this->request = Services::request();
		if (!$this->request->getFileMultiple($fieldname)) {
			return false;
		}
		return true;
	}

	public function file_mime($data = null, $params)
	{
		$params = explode(',', $params);
		$name   = array_shift($params);
		$type   = array_shift($params);

		if ($type == 'image') {
			$allowedMimeType = ['image/jpeg', 'image/png'];
		} elseif ($type == 'any') {
			$allowedMimeType = ['image/jpeg', 'image/png', 'audio/mpeg', 'video/mp4', 'text/csv', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
		}

		$this->request = Services::request();

		if (!($files = $this->request->getFileMultiple($name))) {
			$files = [$this->request->getFile($name)];
		}
		foreach ($files as $file) {
			if (is_null($file)) {
				return false;
			}
			if ($file->getError() === UPLOAD_ERR_NO_FILE) {
				return true;
			}
			if (!in_array($file->getMimeType(), $allowedMimeType)) {
				return false;
			}
		}
		return true;
	}

	public function file_ext($data = null, $params)
	{
		$params = explode(',', $params);
		$name   = array_shift($params);
		$type   = array_shift($params);

		if ($type == 'image') {
			$allowedExtensions = ['jpeg', 'jpg', 'png'];
		} elseif ($type == 'any') {
			$allowedExtensions = ['jpeg', 'jpg', 'png', 'mp3', 'mp4', 'csv', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'];
		}

		$this->request = Services::request();

		if (!($files = $this->request->getFileMultiple($name))) {
			$files = [$this->request->getFile($name)];
		}
		foreach ($files as $file) {
			if (is_null($file)) {
				return false;
			}
			if ($file->getError() === UPLOAD_ERR_NO_FILE) {
				return true;
			}
			if (!in_array($file->getClientExtension(), $allowedExtensions)) {
				return false;
			}
		}
		return true;
	}
}
