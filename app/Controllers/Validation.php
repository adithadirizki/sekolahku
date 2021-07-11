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

	public function multiple_majors($data)
	{
		$m_majors = new \App\Models\M_Major();
		return $m_majors->validation_multiple_majors($data);
	}

	public function multiple_class_group($data)
	{
		$m_class = new \App\Models\M_ClassGroup();
		return $m_class->validation_multiple_class_group($data);
	}

	public function required_files($data = null, $fieldname)
	{
		$this->request = Services::request();
		if (!$this->request->getFileMultiple($fieldname)) {
			return false;
		}
		return true;
	}

	public function mime_files_in($data = null, $params)
	{
		$params = explode(',', $params);
		$fieldname = array_shift($params);
		$this->request = Services::request();
		if (!$files = $this->request->getFileMultiple($fieldname)) {
			$files[] = $this->request->getFile($fieldname);
		}
		foreach ($files as $file) {
			$filename = $file->getName();
			$filesize = $file->getSize();
			if ($filename == null || $filesize == 0) {
				continue;
			}
			if (!in_array($file->getMimeType(), $params)) {
				return false;
			}
		}
		return true;
	}

	public function ext_files_in($data = null, $params)
	{
		$params = explode(',', $params);
		$fieldname = array_shift($params);
		$this->request = Services::request();
		if (!$files = $this->request->getFileMultiple($fieldname)) {
			$files[] = $this->request->getFile($fieldname);
		}
		foreach ($files as $file) {
			$filename = $file->getName();
			$filesize = $file->getSize();
			if ($filename == null || $filesize == 0) {
				continue;
			}
			if (!in_array($file->getClientExtension(), $params)) {
				return false;
			}
		}
		return true;
	}

	public function max_files_size($data = null, $params)
	{
		$params = explode(',', $params);
		$fieldname = array_shift($params);
		$this->request = Services::request();
		if (!$files = $this->request->getFileMultiple($fieldname)) {
			$files[] = $this->request->getFile($fieldname);
		}
		foreach ($files as $file) {
			if ($file->getError() === UPLOAD_ERR_INI_SIZE) {
				return false;
			}
			if ($file->getSize() / 1024 > $params[0]) {
				return false;
			}
		}
		return true;
	}
}
