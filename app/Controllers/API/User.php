<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Teacher;
use App\Models\M_User;

class User extends BaseController
{
	protected $m_user;
	protected $m_teacher;
	protected $rules_account = [
		"username" => "required|is_not_unique[tb_user.username]",
		"photo" => "permit_empty|max_size[photo,2048]|file_mime[photo,image]|file_ext[photo,image]",
		"fullname" => "required",
		"email" => "required|valid_email",
		"role" => "required|in_list[superadmin,teacher,student]",
		"is_active" => "required|in_list[0,1,2]"
	];
	protected $errors_account = [
		"username" => [
			"required" => "Username harus diisi.",
			"is_not_unique" => "Username tidak valid."
		],
		"photo" => [
			"max_size" => "Ukuran file tidak boleh lebih dari 2MB.",
			"file_mime" => "Format file tidak diperbolehkan.",
			"file_ext" => "Format file tidak diperbolehkan."
		],
		"fullname" => [
			"required" => "Nama Lengkap harus diisi."
		],
		"email" => [
			"required" => "E-mail harus diisi.",
			"valid_email" => "Format e-mail tidak valid."
		],
		"role" => [
			"required" => "Role harus diisi.",
			"in_list" => "Role tidak valid."
		],
		"is_active" => [
			"required" => "Status harus diisi.",
			"in_list" => "Status tidak valid."
		]
	];
	protected $rules_info = [
		"username" => "required|is_not_unique[tb_user.username]",
		"role" => "required|in_list[superadmin,teacher,student]",
		"birth_in" => "permit_empty|alpha",
		"birth_at" => "permit_empty|valid_date[Y-m-d]",
		"phone" => "permit_empty|numeric",
		"religion" => "required|in_list[islam,protestan,khatolik,hindu,budha,khonghucu]",
		"gender" => "required|in_list[male,female]"
	];
	protected $errors_info = [
		"username" => [
			"required" => "Username harus diisi.",
			"is_not_unique" => "Username tidak valid."
		],
		"role" => [
			"required" => "Role harus diisi.",
			"in_list" => "Role tidak valid."
		],
		"birth_in" => [
			"alpha" => "Tempat lahir  harus terdiri dari huruf."
		],
		"birth_at" => [
			"valid_date" => "Tanggal lahir tidak valid."
		],
		"phone" => [
			"numeric" => "No telp harus terdiri dari angka."
		],
		"religion" => [
			"in_list" => "Agama tidak valid."
		],
		"gender" => [
			"required" => "Jenis kelamin harus diisi.",
			"in_list" => "Jenis kelamin tidak valid."
		]
	];

	public function __construct()
	{
		$this->m_user = new M_User();
		$this->m_teacher = new M_Teacher();
	}

	public function update_teacher($username)
	{
		$validation = \Config\Services::validation();
		$validation->setRules(
			[
				"photo" => "permit_empty|max_size[photo,2048]|file_mime[photo,image]|file_ext[photo,image]",
				"fullname" => "required",
				"email" => "required|valid_email",
				"password" => "permit_empty|min_length[6]",
				"is_active" => "required|in_list[0,1,2]",
				"nip" => "required|numeric",
				"pob" => "permit_empty|alpha",
				"dob" => "permit_empty|valid_date[Y-m-d]",
				"religion" => "permit_empty|in_list[islam,protestan,khatolik,hindu,budha,khonghucu]",
				"gender" => "required|in_list[male,female]",
				"phone" => "permit_empty|numeric"
			],
			[
				"photo" => [
					"max_size" => "Ukuran file tidak boleh lebih dari 2MB.",
					"file_mime" => "Format file tidak diperbolehkan.",
					"file_ext" => "Format file tidak diperbolehkan."
				],
				"fullname" => [
					"required" => "Nama Lengkap harus diisi."
				],
				"email" => [
					"required" => "E-mail harus diisi.",
					"valid_email" => "Format e-mail tidak valid."
				],
				"password" => [
					"min_length" => "Panjang password minimal 6 karakter."
				],
				"is_active" => [
					"required" => "Status harus diisi.",
					"in_list" => "Status tidak valid."
				],
				"nip" => [
					"required" => "NIP harus diisi.",
					"numeric" => "NIP harus terdiri dari angka."
				],
				"pob" => [
					"alpha" => "Tempat Lahir harus terdiri dari huruf."
				],
				"dob" => [
					"valid_date" => "Tanggal Lahir tidak valid."
				],
				"religion" => [
					"in_list" => "Agama tidak valid."
				],
				"gender" => [
					"required" => "Jenis Kelamin harus diisi.",
					"in_list" => "Jenis Kelamin tidak valid."
				],
				"phone" => [
					"numeric" => "No Telp harus terdiri dari angka."
				]
			]
		);
		if ($validation->withRequest($this->request)->run() == false) {
			return $this->respond([
				"message" => "Failed to added.",
				"status" => 400,
				"errors" => $validation->getErrors()
			]);
		}
		$file = $this->request->getFile('photo');
		foreach ($_POST as $key => $value) {
			if (in_array($key, ['fullname', 'email', 'password', 'is_active'])) {
				$data1[$key] = $value == null ? null : htmlentities($value, ENT_QUOTES, 'UTF-8');
				if ($key == 'password' && $value != null) {
					$data1[$key] = password_hash($value, PASSWORD_BCRYPT);
				}
			} else {
				$data2[$key] = $value == null ? null : htmlentities($value, ENT_QUOTES, 'UTF-8');
			}
		}

		$isValid = $file->isValid();
		$filename = $file->getRandomName();
		$mimetype = $file->getMimeType();
		$pathfile = $file->getTempName();
		if ($isValid) {
			if ($mimetype == 'image/jpeg') {
				$imgjpeg = imagecreatefromjpeg($pathfile);
				imagejpeg($imgjpeg, $pathfile, 100);
				imagedestroy($imgjpeg);
			} elseif ($mimetype == 'image/png') {
				$imgpng = imagecreatefrompng($pathfile);
				imagepng($imgpng, $pathfile, 100);
				imagedestroy($imgpng);
			}
			if (!$file->move('assets/upload', $filename)) {
				return $this->respond([
					"message" => "Failed to upload file.",
					"status" => 400,
					"error" => true
				]);
			}
			$data['photo'] = $filename;
		}
		
		$where1 = [
			"username" => $username
		];
		$result1 = $this->m_user->update_user($data1, $where1);

		$where2 = [
			"teacher_username" => $username
		];
		$result2 = $this->m_teacher->update_teacher($data2, $where2);

		if ($result1 && $result2) {
			return $this->respond([
				"message" => "Changes saved successfully.",
				"status" => 200,
				"error" => false
			]);
		}
		return $this->respond([
			"message" => "Failed to save changes.",
			"status" => 400,
			"error" => true
		]);
	}
}
