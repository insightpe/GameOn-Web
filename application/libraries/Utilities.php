<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: furbox
 * Date: 15/02/16
 * Time: 12:50 AM
 */
class Utilities
{

	protected $CI;

	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI = &get_instance();
	}

	public function is_session_start()
	{
		if (!@$_SESSION['is_logged_in']) {
			redirect('inicio-sesion');
		}
	}

	public function is_valid_token()
	{
		$headers = $this->CI->input->request_headers();

		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			$decodedToken = false;

			try {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			} catch (Exception $e) {
				return false;
			}

			if ($decodedToken != false) {
				return true;
			}
		}
		return false;
	}

	public function getDecodedToken(){
		$decodedToken = false;
		$headers = $this->CI->input->request_headers();
		try {
			$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
		} catch (Exception $e) {
		}

		return $decodedToken;
	}

	public function randomString($length)
	{
		$str = "";
		$characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}

	public function randomStringLower($length)
	{
		$str = "";
		$characters = array_merge(range('a', 'z'), range('0', '9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}

	public function sendMail($email_a, $subject, $message)
	{
		$this->CI->load->library('email');

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => HOST_SMTP_EMAIL_CONTACT,
			'smtp_port' => PORT_SMPT_EMAIL_CONTACT,
			'smtp_user' => EMAIL_CONTACT,
			'smtp_pass' => PASS_EMAIL_CONTACT,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);
		//cargamos la configuración para enviar
		$this->CI->email->initialize($config);

		$this->CI->email->set_mailtype('html');
		$this->CI->email->from(EMAIL_CONTACT);
		$this->CI->email->to($email_a);
		$this->CI->email->subject($subject);    //http://localhost/ci_moresystems/public_html/email_validation/e8fd3041065932a7ef764b7e5d961fb74edf1d59
		$this->CI->email->message($message);


		return $this->CI->email->send();
	}

	public function random_salt()
	{
		return md5(mt_rand());
	}

	public function hash_passwd($password, $random_salt)
	{
		return is_php('5.5') ? password_hash($password . config_item('encryption_key'), PASSWORD_BCRYPT, array('cost' => 11)) : crypt($password . config_item('encryption_key'), '$2a$09$' . $random_salt . '$');
	}

	public function check_passwd($hash, $random_salt, $password)
	{
		if (is_php('5.5') && password_verify($password . config_item('encryption_key'), $hash)) {
			return TRUE;
		} else if ($hash === $this->hash_passwd($password, $random_salt)) {
			return TRUE;
		}

		return FALSE;
	}

	function cambiaf_a_mysql($fecha)
	{
		$fecha = strtotime($fecha);
		$fecha_nueva = date('Y-m-d', $fecha);
		return $fecha_nueva;
	}

	function get_base64_doc_from_doc_id($id_documento)
	{
		$this->CI->load->model('Consulta_model');
		$this->CI->load->model('Config_model');

		$config = $this->CI->Config_model->get(1);
		$doc = $this->CI->Consulta_model->get_document_path($id_documento);

		$path_doc = $config->file_system_server . "/" . $doc->id_sede . "/" . $doc->id_dependencia . "/" . $doc->id_serie . "/" . $doc->id_subserie . "/" . $doc->id_tipologia . "/" . $doc->ruta;

		$type = pathinfo($path_doc, PATHINFO_EXTENSION);
		$data = file_get_contents($path_doc);
		$base64 = 'data:application/pdf/' . $type . ';base64,' . base64_encode($data);

		return $base64;
	}

	function GUID()
	{
		if (function_exists('com_create_guid') === true) {
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	function base64_to_file($base64_string, $output_file)
	{
		// open the output file for writing
		$ifp = fopen($output_file, 'x');

		// split the string on commas
		// $data[ 0 ] == "data:image/png;base64"
		// $data[ 1 ] == <actual base64 string>
		//$data = explode( ',', $base64_string );

		// we could add validation here with ensuring count( $data ) > 1
		//fwrite( $ifp, base64_decode( $data[ 1 ] ) );
		fwrite($ifp, base64_decode($base64_string));
		// clean up the file resource
		fclose($ifp);

		return $output_file;
	}

	function encrypt($pure_string, $encryption_key)
	{
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
		return $encrypted_string;
	}

	/**
	 * Returns decrypted original string
	 */
	function decrypt($encrypted_string, $encryption_key)
	{
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
		return $decrypted_string;
	}

	function dec_enc($action, $string)
	{
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_key = ENCRYPTION_KEY;
		$secret_iv = ENCRYPTION_IV;

		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if ($action == 'encrypt') {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if ($action == 'decrypt') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}
}
