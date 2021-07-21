<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Auth;
use App\Models\M_Student;
use App\Models\M_Teacher;
use App\Models\M_User;

class Auth extends BaseController
{
	protected $m_auth;
	protected $m_user;
	protected $m_teacher;
	protected $m_student;

	public function __construct()
	{
		$this->m_auth = new M_Auth();
		$this->m_user = new M_User();
		$this->m_teacher = new M_Teacher();
		$this->m_student = new M_Student();
	}

	public function login()
	{
		$username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
		$password = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');
		$result = $this->m_auth->login($username, $password);

		if ($result->data) {
			if ($result->data->role == 'superadmin') {
				$class = null;
				$subject = null;
			} elseif ($result->data->role == 'teacher') {
				$teacher = $this->m_teacher->teacher($result->data->username);
				$class = json_decode($teacher->teaching_class);
				$subject = json_decode($teacher->teaching_subject);
			} elseif ($result->data->role == 'student') {
				$student = $this->m_student->student($result->data->username);
				$class = $student->curr_class_group;
				$subject = null;
			}
			// Set JWT Token
			$payload = [
				"iss" => $this->request->config->baseURL,
				"aud" => $this->request->config->baseURL,
				"iat" => time(),
				"nbf" => time(),
				"exp" => time() + $_ENV['JWT_EXPIRE'], // for 6 hours
				"data" => [
					"username" => $result->data->username,
					"role" => $result->data->role,
					"class" => $class,
					"subject" => $subject
				]
			];
			$jwt_token = $this->jwt::encode($payload, $_ENV['JWT_PRIVATE_KEY']);
			$result->response['token'] = $jwt_token;

			// Cookie Remember me for 6 hours
			if (isset($_POST['remember_me'])) {
				$token = '';
				for ($i = 0; $i < 16; $i++) {
					$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$token .= $string[rand(0, strlen($string) - 1)];
				}
				$expired = time() + (60 * 60 * 6);
				setcookie('token', $token, $expired, '/', '', false, true);
				$token_expired = date('Y-m-d H:i:s', $expired);
				$data = [
					"token" => $token,
					"token_expired" => $token_expired
				];
				$where = [
					"username" => $username
				];
				$this->m_user->update_user($data, $where);
			}

			// Set session
			session()->set([
				"username" => $result->data->username,
				"photo" => $result->data->photo,
				"fullname" => $result->data->fullname,
				"email" => $result->data->email,
				"role" => $result->data->role,
				"class" => $class,
				"subject" => $subject,
				"token" => $jwt_token,
				"hasLogin" => true
			]);
		}

		return $this->respond($result->response);
	}

}
