<?php

class Userop extends CI_Controller{
	public $viewFolder="";

	public function __construct()
	{
		parent::__construct();
		$this->viewFolder = "login";
		$this->load->model("user_model");
		$this->load->model("data_model");


	}

	public function login(){

		if (get_active_user()){
			redirect(base_url());
		}
		$viewData = new stdClass();

		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "login";
		$this->load->view("{$viewData->viewFolder}/index", $viewData);
	}

	public function do_login(){

		if (get_active_user()){
			redirect(base_url());
		}
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("userN", "Kullanıcı adı", "required|trim");
		$this->form_validation->set_rules("userPass", "Şifre", "required|trim");

		$this->form_validation->set_message(
			array(
				"required"          => "* <strong>{field}</strong>, alanı gereklidir!",
				"min_length"        => "* <strong>{field}</strong>, alanına minimum 8, maksimum 20 karakter giriniz!",
				"max_length"        => "* <strong>{field}</strong>, alanına minimum 8, maksimum 20 karakter giriniz!",

			)
		);
		$validate= $this->form_validation->run();

		if ($validate){
			$user = $this->user_model->get(array(
				"userName"	=> $this->input->post("userN"),
				"password"	=> md5($this->input->post("userPass"))
			));
			$user_active = $user->isActive == "A" ? true : false;

			if ($user){
				if ($user_active) {
					$item = $this->data_model->get(array(
						"userId" => $user->id
					), "profil");

					$alert = array(
						"text" => "Hoşgeldiniz, $item->ad $item->soyad",
						"type" => "success",
					);

					$this->session->set_userdata("user", $user);
					$this->session->set_flashdata("alert", $alert);
					redirect(base_url());
				}else{
					$alert = array(
						"text"   => "Girişiniz engellenmiştir, lütfen yöneticiniz ile iletişime geçin.",
						"type"   => "error",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("login"));
				}

			}
			else{

				$alert = array(
					"text"   => "Lütfen giriş bilgilerinizi kontrol ediniz!",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("login"));
			}
		}
		else{

			$viewData = new stdClass();

			$viewData->viewFolder = $this->viewFolder;
			$viewData->form_error = true;
			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}

	public function logout(){

		$this->session->unset_userdata("user");
		redirect(base_url("login"));

	}

	public function forget_pass(){
		if (get_active_user()){
			redirect(base_url());
		}
		$viewData = new stdClass();

		$viewData->subViewFolder = "forget_password";
		$viewData->viewFolder=$this->viewFolder;
		$this->load->view("{$viewData->viewFolder}/index", $viewData);
	}

	public function reset_pass(){
		if (get_active_user()){
			redirect(base_url());
		}
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("email", "Email", "required|trim|valid_email");
		$this->form_validation->set_message(
			array(
				"required"          => "* <strong>{field}</strong>, alanı gereklidir!",
				"valid_email"		=> "* <strong>{field}</strong>, alanına geçerli bir mail giriniz!"
			)
		);
		$validate= $this->form_validation->run();

		if ($validate){
			$this->load->model("data_model");

			$this->load->helper("string");

			$temp_password = random_string();

			$mailctrl = $this->data_model->get(array(
				"email" => $this->input->post("email")
			),"user");

			if ($mailctrl != null){

				$config = array(
					"protocol"      => "smtp",
					"smtp_host"     => "ssl://smtp.gmail.com",
					"smtp_port"     => "465",
					"smtp_user"     => "orneksmtpuse12@gmail.com",
					"smtp_pass"     => "i159357456",
					"starttls"      => true,
					"charset"       => "utf-8",
					"mailtype"      => "html",
					"wordwrap"      => true,
					"newline"       => "\r\n"
				);

				//Email
				$this->load->library("email", $config);


				$this->email->from("orneksmtpuse12@gmail.com", "Koü");
				$this->email->to($this->input->post("email"));
				$this->email->subject("Kocaeli Üniversitesi - Şifre Unuttum");
				$this->email->message("Sisteme <strong>{$temp_password}</strong> şifresi ile giriş yapabilirsiniz.");

				$send = $this->email->send();

				if ($send){

					$userup = $this->data_model->update(array(	"id"	=>	$mailctrl->id   ), array(
						"password" => md5($temp_password)
					), "user");

					$alert = array(
						"text"   => "Mail gönderimi başarılı, mailinizi kontrol ediniz",
						"type"   => "success",
					);
					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("login"));
				}
				else{
					$alert = array(
						"text"   => "Mail gönderimi başarısız, lütfen erişim engelinizi olmadığına emin olun ve tekrar deneyiniz!",
						"type"   => "error",
					);
					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("sifremi-unuttum"));
				}

			}
			else{
				$alert = array(
					"text"   => "Girdiğiniz email adresine ait kullanıcı bulunamadı!",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("sifremi-unuttum"));
			}

		}else{
			$viewData = new stdClass();

			$viewData->form_error = true;
			$viewData->subViewFolder = "forget_password";
			$viewData->viewFolder=$this->viewFolder;
			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}
}
