<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Student;
use App\Models\M_Teacher;
use App\Models\M_User;

class User extends BaseController
{
	protected $m_user;
	protected $m_teacher;
	protected $m_student;

	public function __construct()
	{
		$this->m_user = new M_User();
		$this->m_teacher = new M_Teacher();
		$this->m_student = new M_Student();
	}

	public function create_teacher()
	{
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
      }
      
		$validation = \Config\Services::validation();
		$validation->setRules(
			[
				"username" => "required|is_unique[tb_user.username]",
				"photo" => "permit_empty|max_size[photo,2048]|file_mime[photo,image]|file_ext[photo,image]",
				"fullname" => "required",
				"email" => "required|valid_email",
				"password" => "required|min_length[6]",
				"is_active" => "required|in_list[0,1,2]",
				"nip" => "required|numeric",
				"pob" => "permit_empty|alpha",
				"dob" => "permit_empty|valid_date[Y-m-d]",
				"religion" => "permit_empty|in_list[islam,protestan,khatolik,hindu,budha,khonghucu]",
				"gender" => "required|in_list[male,female]",
				"phone" => "permit_empty|numeric",
				"teaching_class*" => "permit_empty|multiple_class_group",
				"teaching_subject*" => "permit_empty|multiple_subject"
			],
			[
				"username" => [
					"required" => "Username harus diisi.",
					"is_unique" => "Username sudah ada."
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
				"password" => [
					"required" => "Password harus diisi..",
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
				],
				"teaching_class*" => [
					"multiple_class_group" => "Kelas tidak valid."
				],
				"teaching_subject*" => [
					"multiple_subject" => "Mata Pelajaran tidak valid."
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

		$data1['username'] = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
		$data1['fullname'] = htmlentities($_POST['fullname'], ENT_QUOTES, 'UTF-8');
		$data1['email'] = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
		$data1['is_active'] = htmlentities($_POST['is_active'], ENT_QUOTES, 'UTF-8');
		$data1['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$data1['role'] = 'teacher';
		
		$data2['teacher_username'] = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
		$data2['nip'] = htmlentities($_POST['nip'], ENT_QUOTES, 'UTF-8');
		$data2['pob'] = empty($_POST['pob']) ? null : htmlentities($_POST['pob'], ENT_QUOTES, 'UTF-8');
		$data2['dob'] = empty($_POST['dob']) ? null : htmlentities($_POST['dob'], ENT_QUOTES, 'UTF-8');
		$data2['religion'] = empty($_POST['religion']) ? null : htmlentities($_POST['religion'], ENT_QUOTES, 'UTF-8');
		$data2['gender'] = htmlentities($_POST['gender'], ENT_QUOTES, 'UTF-8');
		$data2['phone'] = empty($_POST['phone']) ? null : htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8');
		$data2['address'] = empty($_POST['address']) ? null : htmlentities($_POST['address'], ENT_QUOTES, 'UTF-8');
		$data2['teaching_class'] = empty($_POST['teaching_class']) ? json_encode([]) : json_encode($_POST['teaching_class']);
		$data2['teaching_subject'] = empty($_POST['teaching_subject']) ? json_encode([]) : json_encode($_POST['teaching_subject'], JSON_NUMERIC_CHECK);

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
			$data1['photo'] = $filename;
		}

		$result1 = $this->m_user->create_user($data1);
		$result2 = $this->m_teacher->create_teacher($data2);

		if ($result1 && $result2) {
			return $this->respond([
				"message" => "Added successfully.",
				"status" => 200,
				"error" => false
			]);
		}
		return $this->respond([
			"message" => "Failed to added.",
			"status" => 400,
			"error" => true
		]);
	}

	public function create_student()
	{
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
      }
      
		$validation = \Config\Services::validation();
		$validation->setRules(
			[
				"username" => "required|is_unique[tb_user.username]",
				"photo" => "permit_empty|max_size[photo,2048]|file_mime[photo,image]|file_ext[photo,image]",
				"fullname" => "required",
				"email" => "required|valid_email",
				"password" => "required|min_length[6]",
				"is_active" => "required|in_list[0,1,2]",
				"nis" => "required|numeric",
				"pob" => "permit_empty|alpha",
				"dob" => "permit_empty|valid_date[Y-m-d]",
				"religion" => "permit_empty|in_list[islam,protestan,khatolik,hindu,budha,khonghucu]",
				"gender" => "required|in_list[male,female]",
				"phone" => "permit_empty|numeric",
				"curr_class_group" => "required|is_not_unique[tb_class_group.class_group_code]"
			],
			[
				"username" => [
					"required" => "Username harus diisi.",
					"is_unique" => "Username sudah ada."
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
				"password" => [
					"required" => "Password harus diisi..",
					"min_length" => "Panjang password minimal 6 karakter."
				],
				"is_active" => [
					"required" => "Status harus diisi.",
					"in_list" => "Status tidak valid."
				],
				"nis" => [
					"required" => "NIS harus diisi.",
					"numeric" => "NIS harus terdiri dari angka."
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
				],
				"curr_class_group" => [
					"required" => "Kelas harus diisi.",
					"is_not_unique" => "Kelas tidak valid."
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

		$data1['username'] = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
		$data1['fullname'] = htmlentities($_POST['fullname'], ENT_QUOTES, 'UTF-8');
		$data1['email'] = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
		$data1['is_active'] = htmlentities($_POST['is_active'], ENT_QUOTES, 'UTF-8');
		$data1['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$data1['role'] = 'student';
		
		$data2['student_username'] = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
		$data2['nis'] = htmlentities($_POST['nis'], ENT_QUOTES, 'UTF-8');
		$data2['pob'] = empty($_POST['pob']) ? null : htmlentities($_POST['pob'], ENT_QUOTES, 'UTF-8');
		$data2['dob'] = empty($_POST['dob']) ? null : htmlentities($_POST['dob'], ENT_QUOTES, 'UTF-8');
		$data2['religion'] = empty($_POST['religion']) ? null : htmlentities($_POST['religion'], ENT_QUOTES, 'UTF-8');
		$data2['gender'] = htmlentities($_POST['gender'], ENT_QUOTES, 'UTF-8');
		$data2['phone'] = empty($_POST['phone']) ? null : htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8');
		$data2['address'] = empty($_POST['address']) ? null : htmlentities($_POST['address'], ENT_QUOTES, 'UTF-8');
		$data2['curr_class_group'] = htmlentities($_POST['curr_class_group'], ENT_QUOTES, 'UTF-8');

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
			$data1['photo'] = $filename;
		}

		$result1 = $this->m_user->create_user($data1);
		$result2 = $this->m_student->create_student($data2);

		if ($result1 && $result2) {
			return $this->respond([
				"message" => "Added successfully.",
				"status" => 200,
				"error" => false
			]);
		}
		return $this->respond([
			"message" => "Failed to added.",
			"status" => 400,
			"error" => true
		]);
	}

	public function update_teacher($username)
	{
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
      }
      
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
				"phone" => "permit_empty|numeric",
				"teaching_class*" => "permit_empty|multiple_class_group",
				"teaching_subject*" => "permit_empty|multiple_subject"
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
				],
				"teaching_class*" => [
					"multiple_class_group" => "Kelas tidak valid."
				],
				"teaching_subject*" => [
					"multiple_subject" => "Mata Pelajaran tidak valid."
				]
			]
		);
		if ($validation->withRequest($this->request)->run() == false) {
			return $this->respond([
				"message" => "Failed to save changes.",
				"status" => 400,
				"errors" => $validation->getErrors()
			]);
		}
		$file = $this->request->getFile('photo');

		$data1['fullname'] = htmlentities($_POST['fullname'], ENT_QUOTES, 'UTF-8');
		$data1['email'] = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
		$data1['is_active'] = htmlentities($_POST['is_active'], ENT_QUOTES, 'UTF-8');
		empty($_POST['password']) ? null : $data1['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
		
		$data2['nip'] = htmlentities($_POST['nip'], ENT_QUOTES, 'UTF-8');
		$data2['pob'] = empty($_POST['pob']) ? null : htmlentities($_POST['pob'], ENT_QUOTES, 'UTF-8');
		$data2['dob'] = empty($_POST['dob']) ? null : htmlentities($_POST['dob'], ENT_QUOTES, 'UTF-8');
		$data2['religion'] = empty($_POST['religion']) ? null : htmlentities($_POST['religion'], ENT_QUOTES, 'UTF-8');
		$data2['gender'] = htmlentities($_POST['gender'], ENT_QUOTES, 'UTF-8');
		$data2['phone'] = empty($_POST['phone']) ? null : htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8');
		$data2['address'] = empty($_POST['address']) ? null : htmlentities($_POST['address'], ENT_QUOTES, 'UTF-8');
		$data2['teaching_class'] = empty($_POST['teaching_class']) ? json_encode([]) : json_encode($_POST['teaching_class']);
		$data2['teaching_subject'] = empty($_POST['teaching_subject']) ? json_encode([]) : json_encode($_POST['teaching_subject'], JSON_NUMERIC_CHECK);

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
			$data1['photo'] = $filename;
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

	public function update_student($username)
	{
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
      }
      
		$validation = \Config\Services::validation();
		$validation->setRules(
			[
				"photo" => "permit_empty|max_size[photo,2048]|file_mime[photo,image]|file_ext[photo,image]",
				"fullname" => "required",
				"email" => "required|valid_email",
				"password" => "permit_empty|min_length[6]",
				"is_active" => "required|in_list[0,1,2]",
				"nis" => "required|numeric",
				"pob" => "permit_empty|alpha",
				"dob" => "permit_empty|valid_date[Y-m-d]",
				"religion" => "permit_empty|in_list[islam,protestan,khatolik,hindu,budha,khonghucu]",
				"gender" => "required|in_list[male,female]",
				"phone" => "permit_empty|numeric",
				"curr_class_group" => "required|is_not_unique[tb_class_group.class_group_code]"
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
				"nis" => [
					"required" => "NIS harus diisi.",
					"numeric" => "NIS harus terdiri dari angka."
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
				],
				"curr_class_group" => [
					"required" => "Kelas harus diisi.",
					"is_not_unique" => "Kelas tidak valid."
				]
			]
		);
		if ($validation->withRequest($this->request)->run() == false) {
			return $this->respond([
				"message" => "Failed to save changes.",
				"status" => 400,
				"errors" => $validation->getErrors()
			]);
		}
		$file = $this->request->getFile('photo');

		$data1['fullname'] = htmlentities($_POST['fullname'], ENT_QUOTES, 'UTF-8');
		$data1['email'] = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
		$data1['is_active'] = htmlentities($_POST['is_active'], ENT_QUOTES, 'UTF-8');
		empty($_POST['password']) ? null : $data1['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
		
		$data2['nis'] = htmlentities($_POST['nis'], ENT_QUOTES, 'UTF-8');
		$data2['pob'] = empty($_POST['pob']) ? null : htmlentities($_POST['pob'], ENT_QUOTES, 'UTF-8');
		$data2['dob'] = empty($_POST['dob']) ? null : htmlentities($_POST['dob'], ENT_QUOTES, 'UTF-8');
		$data2['religion'] = empty($_POST['religion']) ? null : htmlentities($_POST['religion'], ENT_QUOTES, 'UTF-8');
		$data2['gender'] = htmlentities($_POST['gender'], ENT_QUOTES, 'UTF-8');
		$data2['phone'] = empty($_POST['phone']) ? null : htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8');
		$data2['address'] = empty($_POST['address']) ? null : htmlentities($_POST['address'], ENT_QUOTES, 'UTF-8');
		$data2['curr_class_group'] = htmlentities($_POST['curr_class_group'], ENT_QUOTES, 'UTF-8');

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
			"student_username" => $username
		];
		$result2 = $this->m_student->update_student($data2, $where2);

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

	public function delete($username)
	{
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
      }
      
		$where = [
			"username" => $username
		];
		try {
			$this->m_user->delete_user($where);
			return $this->respond([
				"message" => "Successfully deleted.",
				"status" => 200,
				"error" => false
			]);
		} catch (\Exception $e) {
			return $this->respond([
				"message" => "Failed to delete.",
				"status" => 400,
				"error" => true
			]);
		}
	}
}
