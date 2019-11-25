<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public $viewFolder = "";

	public function __construct()
	{
		parent::__construct();
		$this->viewFolder = "dashboard_v";

		$this->load->model("data_model");
	}
	public function index()
	{
		$viewData = new stdClass();

		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "main_content";
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function new_user()
	{
		$viewData = new stdClass();

		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "add_user";
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function user_add()
	{

		if ($_FILES["userFile"]["name"] != NULL) {
			$pic_name = time() . "_" . $this->input->post("userFN") . "_" . $this->input->post("userLN");
			$file_name = converToSEO($pic_name) . "." . pathinfo($_FILES["userFile"]["name"], PATHINFO_EXTENSION);
		}
		else
			$file_name = "resim_yok";
		/**Upload Kütüphanesinin Yüklenmesi*/
		$config["allowed_types"] = "jpeg|jpg|png|gif";
		$config["upload_path"] = "../panel/assets/userImages";
		$config['file_name'] = $file_name;
		$config["max_size"] = 2000;
		$this->load->library("upload", $config);
		$pic_type =trim($_FILES['userFile']['type']);

		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("userFN", "Ad", "required|trim");
		$this->form_validation->set_rules("userLN", "Soyad", "required|trim");
		$this->form_validation->set_rules("userMail", "Email", "required|trim|valid_email|is_unique[user.email]");
		$this->form_validation->set_rules("userPass", "Sifre", "required|trim|min_length[8]|max_length[20]");
		$this->form_validation->set_rules("userPhone", "Telefon", "required|trim|numeric|exact_length[10]|is_unique[user.phoneNumber]");
		$this->form_validation->set_rules("userName", "Kullanıcı Adı", "required|trim|is_unique[user.userName]");
		$this->form_validation->set_rules("userB", "Bölüm", "required");
		$this->form_validation->set_rules("userF", "Fakülte", "required");
		$this->form_validation->set_rules("userSicil", "Sicil No", "required|trim|numeric|is_unique[user.sicilNo]");
		$this->form_validation->set_rules("userClass", "Yetki", "in_list[admin,user]");
		if (empty($_FILES['userFile']['name']))
			$sonuc = true;
		else
			if ($pic_type == "image/png" || $pic_type == "image/jpeg" || $pic_type == "image/jpg")
				$sonuc = false;
			else
				$sonuc = true;


		$this->form_validation->set_message(
			array(
				"required"          => "* <strong>{field}</strong>, alanı gereklidir!",
				"alpha"             => "* <strong>{field}</strong>, alanına lütfen sadece harf giriniz!",
				"valid_email"       => "* <strong>{field}</strong>, alanına geçerli bir email giriniz!",
				"is_unique"         => "* <strong>{field}</strong>, alanı eşsiz olmalıdır, kayıtlı bir {field} girdiniz!",
				"min_length"        => "* <strong>{field}</strong>, alanına minimum 8, maksimum 20 karakter giriniz!",
				"max_length"        => "* <strong>{field}</strong>, alanına minimum 8, maksimum 20 karakter giriniz!",
				"in_list"           => "* <strong>{field}</strong>, alanı için lütfen bir seçim yapınız!",
				"numeric"           => "* <strong>{field}</strong>, alanına geçerli bir numara giriniz!",
				"exact_length"      => "* <strong>{field}</strong>, alanına geçerli bir numarayı belirtilen şekle uygun olarak giriniz!"

			)
		);

		$validate= $this->form_validation->run();

		if ($validate && $sonuc != true) {
			/**Resimin Upload edilmesi?*/

			$upload = $this->upload->do_upload("userFile");

			if ($upload) {
				$uploaded_file = $this->upload->data("file_name");
			}

			$insert = $this->data_model->add(
				array(
					"class" 		=> $this->input->post("userClass"),
					"sicilNo" 		=> $this->input->post("userSicil"),
					"userName" 		=> $this->input->post("userName"),
					"password" 		=> $this->input->post("userPass"),
					"email" 		=> $this->input->post("userMail"),
					"phoneNumber" 	=> $this->input->post("userPhone"),
					"isActive"		=> $this->input->post("userStat")!= "A" ? "P" : "A"
				), "user"
			);
			if ($insert){
				$item = $this->data_model->get(array(
					"sicilNo" => $this->input->post("userSicil")
				),"user");

				$insert_profil = $this->data_model->add(
					array(
						"userId" 	=> $item->id,
						"ad"		=> $this->input->post("userFN"),
						"soyad"		=> $this->input->post("userLN"),
						"bolumId"	=> $this->input->post("userB"),
						"fakulteId" => $this->input->post("userF"),
						"resim"		=> $upload == true ? $uploaded_file : NULL,
					), "profil"
				);

				if ($this->input->post("userClass") == "admin"){
					$alert = array(
						"text"   => "İşlem başarılı, yeni yönetici başarıyla eklendi",
						"type"   => "success",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/admins"));
				}
				else{
					$alert = array(
						"text"   => "İşlem başarılı, yeni kullanıcı başarıyla eklendi",
						"type"   => "success",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/users"));
				}
			}
			else{
				$viewData = new stdClass();

				$viewData->viewFolder = $this->viewFolder;
				$viewData->subViewFolder = "add-user";
				$viewData->folder = "error";

				$this->load->view("{$viewData->viewFolder}/index", $viewData);
			}
		}
		else{
				$viewData = new stdClass();

				$viewData->viewFolder = $this->viewFolder;
				$viewData->subViewFolder = "add_user";
				$viewData->form_error = true;
				$viewData->pic_error = $sonuc;

				$this->load->view("{$viewData->viewFolder}/index", $viewData);
			}


	}

	public function admins(){
		$viewData = new stdClass();

		$items= $this->data_model->get_all(array(
			"class" => "admin"
		),"user");
		$item_profiles = $this->data_model->get_all(array(),"profil");

		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "admins";
		$viewData->items = $items;
		$viewData->profiles = $item_profiles;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}
}
