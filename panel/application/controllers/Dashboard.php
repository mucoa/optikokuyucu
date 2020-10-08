<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public $viewFolder = "";
	public $user;
	public $profile;

	public function __construct()
	{
		parent::__construct();
		$this->viewFolder = "dashboard_v";
		$this->load->model("data_model");

		if (!get_active_user()){
			redirect(base_url("login"));
		}
		$this->user = get_active_user();
		$this->profile = $this->data_model->get(array(
			"userId" => $this->user->id
		),"profil");
	}
	public function index()
	{
		$viewData = new stdClass();

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "main_content";

		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function new_user()
	{
		$viewData = new stdClass();
		$bolumler = $this->data_model->get_all(array("  isActive"  => "A"),"bolumler");
		$profil = $this->data_model->get_all(array(),"profil");
		$fakulte = $this->data_model->get_all(array("  isActive"  => "A"),"fakulte");


		$viewData->fakulte = $fakulte;
		$viewData->bolumler = $bolumler;

		$viewData->profile = $this->profile;
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
		$this->form_validation->set_rules("userUN", "Unvan", "required|trim");
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
					"password" 		=> md5($this->input->post("userPass")),
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
						"bolumNo"	=> $this->input->post("userB"),
						"fakulteNo" => $this->input->post("userF"),
						"unvan"		=> $this->input->post("userUN"),
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
				$item = $this->data_model->get(array(
					"sicilNo" => $this->input->post("userSicil")
				),"user");

				if ($this->input->post("userClass") == "admin"){
					$alert = array(
						"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
						"type"   => "error",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/admins"));
				}
				else{
					$alert = array(
						"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
						"type"   => "error",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/users"));
				}
			}
		}
		else{
				$viewData = new stdClass();

				$viewData->profile = $this->profile;
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

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "admins";
		$viewData->items = $items;
		$viewData->profiles = $item_profiles;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function users(){
		$viewData = new stdClass();

		$items= $this->data_model->get_all(array(
			"class" => "user"
		),"user");
		$item_profiles = $this->data_model->get_all(array(),"profil");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "users";
		$viewData->items = $items;
		$viewData->profiles = $item_profiles;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function delete_user($id){

		$info_user = $this->data_model->get(
			array(
				"id" => $id
			), "user"
		);

		$info_profile = $this->data_model->get(array(
			"userId" => $id
		),"profil");
		$filepath="../panel/assets/userImages/".$info_profile->resim;
		unlink($filepath);

		$delete_profile = $this->data_model->delete(array(
			"userId" => $id
		), "profil");

		if ($delete_profile){
			$delete_user = $this->data_model->delete(array(
				"id" => $id
			), "user");

			if ($delete_user){

				if ($info_user->class == "admin"){
					$alert = array(
						"text"   => "İşlem başarılı yönetici kaldırıldı",
						"type"   => "success",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/admins"));
				}else{
					$alert = array(
						"text"   => "İşlem başarılı kullanıcı kaldırıldı",
						"type"   => "success",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/users"));
				}
			}
			else{
				if ($info_user->class == "admin"){
					$alert = array(
						"text"   => "İşlem başarısız",
						"type"   => "error",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/admins"));
				}else{
					$alert = array(
						"text"   => "İşlem başarısız",
						"type"   => "error",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("dashboard/users"));
				}
			}
		}
		else{
			if ($info_user->class == "admin"){
				$alert = array(
					"text"   => "İşlem başarısız",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/admins"));
			}else{
				$alert = array(
					"text"   => "İşlem başarısız",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/users"));
			}
		}
	}

	public function isActiveSetter($id,$table){

		$isActive = ($this->input->post("data") === "true" ? "A" : "P");

		$this->data_model->update(
			array(
				"id"        => $id
			),
			array(
				"isActive"  => $isActive
			),$table);
	}

	public function delete($id,$table,$towhere){

		$delete = $this->data_model->delete(array(
			"id" => $id
		),$table);

		if ($delete){
			$alert = array(
				"text"   => "İşlem başarılı kaldırıldı",
				"type"   => "success",
			);

			$this->session->set_flashdata("alert", $alert);
			redirect(base_url("dashboard/$towhere"));
		}
		else{
			$alert = array(
				"text"   => "İşlem başarısız silinemedi",
				"type"   => "error",
			);

			$this->session->set_flashdata("alert", $alert);
			redirect(base_url("dashboard/$towhere"));
		}
	}

	public function update_user($id){
		$viewData = new stdClass();
		/*Veri tabanından gerekli özelliklere göre getirilme işlemi*/
		$item = $this->data_model->get(
			array(
				"id" => $id
			),"user");

		$profile = $this->data_model->get(array(
			"userId"  => $id
		),"profil");

		$fakulte = $this->data_model->get(array(
			"fakulteKodu" => $this->profile->fakulteNo
		),"fakulte");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "update_user";
		$viewData->item = $item;
		$viewData->item_fak = $fakulte;
		$viewData->item_profile = $profile;

		$this->load->view("{$viewData->viewFolder}/index",$viewData);
	}

	public function do_update_user($id){

		$item = $this->data_model->get(
			array(
				"id" => $id
			),"user");

		$profile = $this->data_model->get(array(
			"userId"  => $id
		),"profil");


		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("userFN", "Ad", "required|trim");
		$this->form_validation->set_rules("userLN", "Soyad", "required|trim");
		$this->form_validation->set_rules("userMail", "Email", "required|trim|valid_email");
		$this->form_validation->set_rules("userPhone", "Telefon", "required|trim|numeric|exact_length[10]");
		$this->form_validation->set_rules("userName", "Kullanıcı Adı", "required|trim");
		$this->form_validation->set_rules("userB", "Bölüm", "required");
		$this->form_validation->set_rules("userF", "Fakülte", "required");
		$this->form_validation->set_rules("userSicil", "Sicil No", "required|trim|numeric|exact_length[13]");
		$this->form_validation->set_rules("userClass", "Yetki", "in_list[admin,user]");
		$this->form_validation->set_rules("userUN", "Unvan", "required|trim");

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
				"exact_length"      => "* <strong>{field}</strong>, alanına uzunluk olarak eksik veya fazla bir değer girdiniz, Lütfen geçerli bir {field} giriniz!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate){
			$class = $item->class;

			$update= $this->data_model->update(array("id" => $id), array(
				"class" 		=> $this->input->post("userClass"),
				"sicilNo" 		=> $this->input->post("userSicil"),
				"userName" 		=> $this->input->post("userName"),
				"email" 		=> $this->input->post("userMail"),
				"phoneNumber" 	=> $this->input->post("userPhone")
			), "user");

			if ($update){

				$update_profile = $this->data_model->update(array( "userId" => $id), array(
					"ad"		=> $this->input->post("userFN"),
					"soyad"		=> $this->input->post("userLN"),
					"bolumNo"	=> $this->input->post("userB"),
					"fakulteNo" => $this->input->post("userF"),
					"unvan" 	=> $this->input->post("userUN")
				), "profil");
				if ($update_profile){
					$alert = array(
						"text"   => "İşlem başarılı düzenleme yapıldı",
						"type"   => "success",
					);

					$this->session->set_flashdata("alert", $alert);
					$tip = $class == "admin" ? "admins" : "users";
					redirect(base_url("dashboard/$tip"));
				}
			}else
			{
				$alert = array(
					"text"   => "İşlem başarısız düzenleme yapılamadı",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				$tip = $class == "admin" ? "admins" : "users";
				redirect(base_url("dashboard/$tip"));
			}
		}else
		{
			$viewData = new stdClass();

			$fakulte = $this->data_model->get(array(
				"fakulteKodu" => $this->profile->fakulteNo
			),"fakulte");
			$viewData->item_fak = $fakulte;
			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update_user";
			$viewData->form_error = true;
			$viewData->item = $item;
			$viewData->item_profile = $profile;
			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}

	public function profile(){
		$viewData = new stdClass();
		/*Veri tabanından gerekli özelliklere göre getirilme işlemi*/
		$item = get_active_user();

		$fakulte = $this->data_model->get(array(
			"fakulteKodu" => $this->profile->fakulteNo
		),"fakulte");
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "profile";
		$viewData->item = $item;
		$viewData->item_fak = $fakulte;
		$this->load->view("{$viewData->viewFolder}/index",$viewData);
	}

	public function profileup(){
		$item = get_active_user();
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("userFN", "Ad", "required|trim");
		$this->form_validation->set_rules("userLN", "Soyad", "required|trim");
		$this->form_validation->set_rules("userMail", "Email", "required|trim|valid_email");
		$this->form_validation->set_rules("userPhone", "Telefon", "required|trim|numeric|exact_length[10]");
		$this->form_validation->set_rules("userUN", "Unvan", "required|trim");

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
				"exact_length"      => "* <strong>{field}</strong>, alanına uzunluk olarak eksik veya fazla bir değer girdiniz, Lütfen geçerli bir {field} giriniz!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate){

			$update= $this->data_model->update(array("id" => $item->id), array(
				"email" 		=> $this->input->post("userMail"),
				"phoneNumber" 	=> $this->input->post("userPhone")
			), "user");

			if ($update){

				$update_profile = $this->data_model->update(array( "userId" => $item->id), array(
					"ad"		=> $this->input->post("userFN"),
					"soyad"		=> $this->input->post("userLN"),
					"unvan" 	=> $this->input->post("userUN")
				), "profil");

				if ($update_profile){
					$alert = array(
						"text"   => "İşlem başarılı düzenleme yapıldı",
						"type"   => "success",
					);

					$this->session->set_flashdata("alert", $alert);

					redirect(base_url("profile"));
				}
			}else
			{
				$alert = array(
					"text"   => "İşlem başarısız düzenleme yapılamadı",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("profile"));
			}

		}else{


			$fakulte = $this->data_model->get(array(
				"fakulteKodu" => $this->profile->fakulteNo
			),"fakulte");

			$viewData = new stdClass();

			$viewData->profile = $this->profile;
			$viewData->viewFolder=$this->viewFolder;
			$viewData->subViewFolder = "profile";
			$viewData->item = $item;
			$viewData->form_error = true;
			$viewData->item_fak = $fakulte;
			$this->load->view("{$viewData->viewFolder}/index",$viewData);
		}

	}

	public function passchange(){
		$item = get_active_user();


		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("userNP", "Yeni şifre", "required|trim|matches[userNPC]|min_length[8]|max_length[20]");
		$this->form_validation->set_rules("userNPC", "Yeni şifre doğrulama", "required|trim");

		$this->form_validation->set_message(
			array(
				"required"          => "* <strong>{field}</strong>, alanı gereklidir!",
				"min_length"        => "* <strong>{field}</strong>, alanına minimum 8, maksimum 20 karakter giriniz!",
				"max_length"        => "* <strong>{field}</strong>, alanına minimum 8, maksimum 20 karakter giriniz!",
				"matches"			=> "* <strong>{field}</strong>, alanı doğrulama alanı ile uyuşmuyor!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate){
				$update = $this->data_model->update(array("id" => $item->id),array(
					"password" => md5($this->input->post("userNP"))
				),"user");

				if ($update){
					$alert = array(
						"text"   => "İşlem başarılı şifre değiştirildi",
						"type"   => "success",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("profile"));
				}
				else{
					$alert = array(
						"text"   => "İşlem başarısız şifre değiştirilemedi",
						"type"   => "error",
					);

					$this->session->set_flashdata("alert", $alert);
					redirect(base_url("profile"));
				}

		}
		else{
			$fakulte = $this->data_model->get(array(
				"fakulteKodu" => $this->profile->fakulteNo
			),"fakulte");

			$viewData = new stdClass();

			$viewData->profile = $this->profile;
			$viewData->viewFolder=$this->viewFolder;
			$viewData->subViewFolder = "profile";
			$viewData->item = $item;
			$viewData->form_error = true;
			$viewData->swicthtopass = true;
			$viewData->item_fak = $fakulte;
			$this->load->view("{$viewData->viewFolder}/index",$viewData);
		}


	}


	//---------------------------------------------------TEST-----------------------------------------------------------

	public function test(){
		$viewData = new stdClass();
		$item= get_active_user();

		$bolum = $this->data_model->get_all(array(),"bolumler");
		$donem = $this->data_model->get_all(array(),"donem");
		$ders = $this->data_model->get_all(array(),"dersler");
		$aders  = $this->data_model->get_all(array(
			"isActive" 	=> "A",
			"userId"	=> $item->id
		),"aders");


		$viewData->aders = $aders;
		$viewData->ders = $ders;
		$viewData->bolum = $bolum;
		$viewData->donem = $donem;
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "add_test";
		$this->load->view("{$viewData->viewFolder}/index",$viewData);

	}

	public function test_add(){
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("sinavBol", "Bölüm", "required|trim");
		$this->form_validation->set_rules("sinavDers", "Dersler", "required|trim");
		$this->form_validation->set_rules("sinavTur", "Sınavtürü", "required|trim");


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

		if ($validate) {

			$viewData = new stdClass();

			$viewData->sinavTur = $this->input->post("sinavTur");
			$viewData->sinavBol = $this->input->post("sinavBol");
			$viewData->sinavDers = $this->input->post("sinavDers");

			$viewData->profile = $this->profile;
			$viewData->viewFolder=$this->viewFolder;
			$viewData->subViewFolder = "test_upload";
			$this->load->view("{$viewData->viewFolder}/index",$viewData);


		}else{
			$viewData = new stdClass();
			$item= get_active_user();

			$bolum = $this->data_model->get_all(array(),"bolumler");
			$donem = $this->data_model->get_all(array(),"donem");
			$ders = $this->data_model->get_all(array(),"dersler");
			$aders  = $this->data_model->get_all(array(
				"isActive" 	=> "A",
				"userId"	=> $item->id
			),"aders");


			$viewData->aders = $aders;
			$viewData->ders = $ders;
			$viewData->bolum = $bolum;
			$viewData->donem = $donem;
			$viewData->form_error = true;
			$viewData->profile = $this->profile;
			$viewData->viewFolder=$this->viewFolder;
			$viewData->subViewFolder = "add_test";
			$this->load->view("{$viewData->viewFolder}/index",$viewData);
		}

	}

	public function upload_test(){

		$studentFullN = array();
		$studentNum = array();
		$studentAnsw = array();
		$studentTur = array();
		$cvp_tur = array();
		$cvp_ans = array();
		$notlar = array();
		$dogyan = array();

		$sinavBolId = $this->input->post("sinavBol");
		$sinavTur = $this->input->post("sinavTur") === "V" ? "Vize" : $this->input->post("sinavTur") === "F" ? "Final" : "Bütünleme";
		$sinavDersId = $this->input->post("sinavDers");

		$sinavDers = $this->data_model->get(array( "id" => $sinavDersId ),"dersler");
		$sinavDonem = $this->data_model->get(array( "id" => $sinavDers->donemId ),"donem");
		$sinavBolum = $this->data_model->get(array( "id" => $sinavBolId ),"bolumler");

		$studentFullN = array();
		$studentNum = array();
		$studentAnsw = array();
		$studentTur = array();

		if ($_FILES["userFile"]["name"] != NULL) {
			$pic_name = $sinavDonem->yil. "-". $sinavDonem->donem . "_" . $sinavDers->dersAdi . "_" . $sinavTur;
			$file_name1 = converToSEO($pic_name) . "." . pathinfo($_FILES["userFile"]["name"], PATHINFO_EXTENSION);
		}
		else
			$file_name1 = "hata";

		if ($_FILES["userFile2"]["name"] != NULL) {
			$pic_name =$sinavDonem->yil. "-". $sinavDonem->donem . "_" . $sinavDers->dersAdi . "_" . $sinavTur;
			$file_name2 = converToSEO($pic_name) . "1." . pathinfo($_FILES["userFile"]["name"], PATHINFO_EXTENSION);
		}
		else
			$file_name2 = "hata";
		//upload Kütüphanesinin Yüklenmesi
		$config["allowed_types"] = "txt";
		$config["file_name"]=$file_name1;
		$config["upload_path"] = "../panel/assets/userImages";
		$config["max_size"] = 2000;
		$this->load->library("upload", $config);

		$type =trim($_FILES['userFile']['type']);
		$path = $_FILES['userFile']['tmp_name'];

		if (empty($_FILES['userFile']['name']))
			$sonuc = true;
		else
			if ($type == "text/plain"){
				if (file_exists($path))
				{
					if (is_readable($path)){

						$obj = fopen($path, "r");

						$string=file_get_contents($path);
						$pattern = "([0-9_]+)";
						$pat = "([0-9][A-ZÇŞĞÜÖİ]+)";

						preg_match_all($pat, $string, $match);
						preg_match_all($pattern, $string, $matches);


						$c = 0;
						while($c < sizeof($matches[0])){

								$deger = substr($match[0][$c], 0, 2);
								$kitapcik = $match[0][$c];
								$number = $matches[0][$c];
								$kitapcik = substr($kitapcik, 1, 1);
								$line = fgets($obj);
								$line = htmlspecialchars($line);
								$pos = strpos($line, $deger);
								$pos += 2;
								$son = strlen($line) - $pos;
								$cevap = substr($line, $pos, $son);
								$forsoyad = substr($matches[0][$c], 0, 1);
								$posforsoyad = strpos($line, $forsoyad);
								$posforsoyad -= 1;
								$adsoyad = substr($line, 0, $posforsoyad);

								array_push($studentAnsw, $cevap);
								array_push($studentFullN, $adsoyad);
								array_push($studentTur, $kitapcik);
								array_push($studentNum, $number);
							$c++;
						}

						$sonuc=false;
					}
					else
						$sonuc = true;
				}
				else
					$sonuc= true;
			}
			else
				$sonuc = true;

			///////////////////////////////////////////////////////////////////////
		$type2 =trim($_FILES['userFile2']['type']);
		$path2 = $_FILES['userFile2']['tmp_name'];
			if (empty($_FILES['userFile2']['name']))
				$sonuc = true;
			else
				if ($type2 == "text/plain") {
					if (file_exists($path2)) {
						if (is_readable($path2)) {
							$obj = fopen($path2, "r");

							$string=file_get_contents($path2);
							while(!feof($obj)){
								$line = fgets($obj);
								$line = htmlspecialchars($line);

								$kitapcik = substr($line, 0, 1);
								$cevaplar = substr($line, 1,strlen($line)-1);


								$kitapcik!=null ? array_push($cvp_tur,$kitapcik):"";
								$cevaplar != null ?array_push($cvp_ans,$cevaplar):"";
							}

							$toplam=strlen($cvp_ans[0])-1;

							$soruPuan = 100/$toplam;


							for ($i = 0; $i<sizeof($studentNum); $i++){
								$ysayisi = 0;
								$result = "";
								$puan = 0;
								if ($studentTur[$i] === $cvp_tur[0]){
									for ($j =0; $j<30; $j++){
										if (substr($studentAnsw[$i], $j, 1) == substr($cvp_ans[0], $j,1))
											$result .= "D";
										else{
											$result .= "Y";
											$ysayisi++;
										}
									}
									$puan += $soruPuan*($toplam-$ysayisi);
									$puan = floor($puan);
								}
								elseif ($studentTur[$i] == $cvp_tur[1]){
									for ($j =0; $j<30; $j++){
										if (substr($studentAnsw[$i], $j, 1) == substr($cvp_ans[1], $j,1))
											$result.= "D";
										else{
											$result .= "Y";
											$ysayisi++;
										}
									}
									$puan += $soruPuan*($toplam-$ysayisi);
									$puan = floor($puan);
								}
								else{
									for ($j =0; $j<strlen($cvp_ans[2]); $j++){
										if (substr($studentAnsw[$i], $j, 1) == substr($cvp_ans[2], $j,1))
											$result .= "D";
										else{
											$result .= "Y";
											$ysayisi++;
										}
									}
									$puan += $soruPuan*($toplam-$ysayisi);
									$puan = floor($puan);
								}

								array_push($notlar,$puan);
								array_push($dogyan, $result);
							}
						}else
							$sonuc = true;
					}else
						$sonuc = true;
				}else
					$sonuc =true;

			if (!$sonuc){
				$upload1 = $this->upload->do_upload("userFile");

				$upload2 = $this->upload->do_upload("userFile2");

				if ($upload1&&$upload2){
					$insert= $this->data_model->add(array(
						"aDersId"	 => $sinavDers->dersAdi,
						"bolumId" 	=> $sinavBolum->bolumAdi,
						"VFB"	  	 => $sinavTur,
						"fileName"  => $file_name1,
						"fileCevap" => $file_name2
					),"notlar");
				}

				$viewData = new stdClass();

				$viewData->ogr_ad = $studentFullN;
				$viewData->ogr_num = $studentNum;
				$viewData->ogr_cvp = $studentAnsw;
				$viewData->ogr_tur = $studentTur;
				$viewData->ogr_not = $notlar;
				$viewData->ogr_dy = $dogyan;

				$viewData->sinavTur = $this->input->post("sinavTur");
				$viewData->sinavBol = $this->input->post("sinavBol");
				$viewData->sinavDers = $this->input->post("sinavDers");
				$viewData->profile = $this->profile;
				$viewData->viewFolder=$this->viewFolder;
				$viewData->subViewFolder = "test_match";

				$this->load->view("{$this->viewFolder}/index", $viewData);

			}else{
				$viewData = new stdClass();


				$viewData->sinavTur = $this->input->post("sinavTur");
				$viewData->sinavBol = $this->input->post("sinavBol");
				$viewData->sinavDers = $this->input->post("sinavDers");

				$viewData->file_error = true;
				$viewData->profile = $this->profile;
				$viewData->viewFolder=$this->viewFolder;
				$viewData->subViewFolder = "test_upload";
				$this->load->view("{$viewData->viewFolder}/index",$viewData);

			}
	}


	public function notlar(){
		$viewData = new stdClass();
		$items = $this->data_model->get_all(array(),"notlar");

		$viewData->items = $items;

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "notlar";
		$this->load->view("{$viewData->viewFolder}/index",$viewData);
	}

	public function update_notlar($file1,$file2){
		$studentFullN = array();
		$studentNum = array();
		$studentAnsw = array();
		$studentTur = array();
		$cvp_tur = array();
		$cvp_ans = array();
		$notlar = array();
		$dogyan = array();
		$file_path1 = base_url("assets")."/userImages/".$file1;
		$file_path2 = base_url("assets")."/userImages/".$file2;

		$obj = fopen($file_path1, "r");

		$string=file_get_contents($file_path1);
		$pattern = "([0-9_]+)";
		$pat = "([0-9][A-ZÇŞĞÜÖİ]+)";

		preg_match_all($pat, $string, $match);
		preg_match_all($pattern, $string, $matches);


		$c = 0;
		while($c < sizeof($matches[0])){

			$deger = substr($match[0][$c], 0, 2);
			$kitapcik = $match[0][$c];
			$number = $matches[0][$c];
			$kitapcik = substr($kitapcik, 1, 1);
			$line = fgets($obj);
			$line = htmlspecialchars($line);
			$pos = strpos($line, $deger);
			$pos += 2;
			$son = strlen($line) - $pos;
			$cevap = substr($line, $pos, $son);
			$forsoyad = substr($matches[0][$c], 0, 1);
			$posforsoyad = strpos($line, $forsoyad);
			$posforsoyad -= 1;
			$adsoyad = substr($line, 0, $posforsoyad);

			array_push($studentAnsw, $cevap);
			array_push($studentFullN, $adsoyad);
			array_push($studentTur, $kitapcik);
			array_push($studentNum, $number);
			$c++;
		}



		$obj2 = fopen($file_path2, "r");

		$string=file_get_contents($file_path2);
		while(!feof($obj2)){
			$line = fgets($obj2);
			$line = htmlspecialchars($line);

			$kitapcik = substr($line, 0, 1);
			$cevaplar = substr($line, 1,strlen($line)-1);


			$kitapcik!=null ? array_push($cvp_tur,$kitapcik):"";
			$cevaplar != null ?array_push($cvp_ans,$cevaplar):"";
		}

		$toplam=strlen($cvp_ans[0])-1;

		$soruPuan = 100/$toplam;


		for ($i = 0; $i<sizeof($studentNum); $i++){
			$ysayisi = 0;
			$result = "";
			$puan = 0;
			if ($studentTur[$i] === $cvp_tur[0]){
				for ($j =0; $j<30; $j++){
					if (substr($studentAnsw[$i], $j, 1) == substr($cvp_ans[0], $j,1))
						$result .= "D";
					else{
						$result .= "Y";
						$ysayisi++;
					}
				}
				$puan += $soruPuan*($toplam-$ysayisi);
				$puan = floor($puan);
			}
			elseif ($studentTur[$i] == $cvp_tur[1]){
				for ($j =0; $j<30; $j++){
					if (substr($studentAnsw[$i], $j, 1) == substr($cvp_ans[1], $j,1))
						$result.= "D";
					else{
						$result .= "Y";
						$ysayisi++;
					}
				}
				$puan += $soruPuan*($toplam-$ysayisi);
				$puan = floor($puan);
			}
			else{
				for ($j =0; $j<strlen($cvp_ans[2]); $j++){
					if (substr($studentAnsw[$i], $j, 1) == substr($cvp_ans[2], $j,1))
						$result .= "D";
					else{
						$result .= "Y";
						$ysayisi++;
					}
				}
				$puan += $soruPuan*($toplam-$ysayisi);
				$puan = floor($puan);
			}

			array_push($notlar,$puan);
			array_push($dogyan, $result);
		}


		$viewData = new stdClass();

		$viewData->ogr_ad = $studentFullN;
		$viewData->ogr_num = $studentNum;
		$viewData->ogr_cvp = $studentAnsw;
		$viewData->ogr_tur = $studentTur;
		$viewData->ogr_not = $notlar;
		$viewData->ogr_dy = $dogyan;


		$viewData->comefrom = true;
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "test_match";

		$this->load->view("{$this->viewFolder}/index", $viewData);
	}


	public function test_ans(){
		$viewData = new stdClass();

		$viewData->sinavTur = $this->input->post("sinavTur");
		$viewData->sinavBol = $this->input->post("sinavBol");
		$viewData->sinavDers = $this->input->post("sinavDers");
		$viewData->path = $this->input->post("path");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "test_matches";
		$this->load->view("{$viewData->viewFolder}/index",$viewData);


	}


	public function last(){
		$alert = array(
			"text"   => "Kayıt gerçekleştirildi",
			"type"   => "success",
		);

		$this->session->set_flashdata("alert", $alert);

		redirect(base_url("dashboard/notlar"));
	}



	public function user_ders(){
		$viewData = new stdClass();
		$user = get_active_user();

		$adersler = $this->data_model->get_all(array(
			"userId" => $user->id,
			"isActive" => "A"
		),"aders");

		$items= $this->data_model->get_all(array(),"dersler");
		$donem = $this->data_model->get_all(array(),"donem");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "user_dersler";
		$viewData->aders = $adersler;
		$viewData->donem = $donem;
		$viewData->items = $items;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}






	//------------------------------------------------------------TEST--------------------------------------------------

	/**-------------------------------------------------------*/

	public function ders(){
		$viewData = new stdClass();

		$items= $this->data_model->get_all(array(),"dersler");
		$donem = $this->data_model->get_all(array(),"donem");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "ders";
		$viewData->donem = $donem;
		$viewData->items = $items;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function new_ders()
	{
		$viewData = new stdClass();

		$items = $this->data_model->get_all(array(	"isActive" => "A"  ),"donem");

		$viewData->items = $items;
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "add_ders";
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function ders_add()
	{
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("dersAdi", "Ders Adı", "required|trim");
		$this->form_validation->set_rules("donemId", "Donem", "required|trim");
		$this->form_validation->set_rules("dersKodu", "Ders Kodu", "required|trim|is_unique[dersler.dersKodu]");


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

		if ($validate) {

			$insert = $this->data_model->add(
				array(
					"dersAdi" 		=> $this->input->post("dersAdi"),
					"dersKodu" 		=> $this->input->post("dersKodu"),
					"donemId" 		=> $this->input->post("donemId"),
					"isActive"		=> $this->input->post("userStat")!= "A" ? "P" : "A"
				), "dersler"
			);
			if ($insert){

				$alert = array(
					"text"   => "İşlem başarılı, yeni ders başarıyla eklendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/ders"));

			}
			else{


				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/dersler"));

			}
		}
		else{
			$viewData = new stdClass();

			$items = $this->data_model->get_all(array(	"isActive" => "A"  ),"donem");

			$viewData->items = $items;
			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "add_ders";
			$viewData->form_error = true;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}

	public function aders(){
		$viewData = new stdClass();

		$items= $this->data_model->get_all(array(),"aders");
		$ders_items = $this->data_model->get_all(array("isActive" => "A"),"dersler");
		$user_items = $this->data_model->get_all(array("isActive" => "A"),"user");
		$item_profiles = $this->data_model->get_all(array(),"profil");

		$viewData->profils = $item_profiles;
		$viewData->users = $user_items;
		$viewData->dersler=$ders_items;
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "aders";
		$viewData->items = $items;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function new_aders()
	{
		$viewData = new stdClass();
		$items = $this->data_model->get_all(array("isActive" => "A"),"dersler");
		$user_items = $this->data_model->get_all(array("isActive" => "A"),"user");
		$item_profiles = $this->data_model->get_all(array(),"profil");

		$viewData->profils = $item_profiles;
		$viewData->users = $user_items;
		$viewData->dersler=$items;
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "add_aders";
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function aders_add()
	{
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("dersId", "Ders", "required|trim");
		$this->form_validation->set_rules("userId", "Hoca", "required|trim");


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

		if ($validate) {

			$insert = $this->data_model->add(
				array(
					"dersId" 		=> $this->input->post("dersId"),
					"userId" 		=> $this->input->post("userId"),
					"isActive"		=> $this->input->post("userStat")!= "A" ? "P" : "A"
				), "aders"
			);
			if ($insert){

				$alert = array(
					"text"   => "İşlem başarılı, ders eklendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/aders"));

			}
			else{


				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/aders"));

			}
		}
		else{
			$viewData = new stdClass();
			$items = $this->data_model->get_all(array("isActive" => "A"),"dersler");
			$user_items = $this->data_model->get_all(array("isActive" => "A"),"user");
			$item_profiles = $this->data_model->get_all(array(),"profil");

			$viewData->profils = $item_profiles;
			$viewData->users = $user_items;
			$viewData->dersler=$items;
			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "add_aders";
			$viewData->form_error = true;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}

	public function update_aders($id){
		$viewData = new stdClass();
		/*Veri tabanından gerekli özelliklere göre getirilme işlemi*/
		$item = $this->data_model->get(
			array(
				"id" => $id
			),"aders");

		$ders_items = $this->data_model->get_all(array("isActive" => "A"),"dersler");
		$user_items = $this->data_model->get_all(array("isActive" => "A"),"user");
		$item_profiles = $this->data_model->get_all(array(),"profil");

		$viewData->profils = $item_profiles;
		$viewData->users = $user_items;
		$viewData->dersler=$ders_items;
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "update_aders";
		$viewData->item = $item;


		$this->load->view("{$viewData->viewFolder}/index",$viewData);
	}

	public function do_update_aders($id){

		$item = $this->data_model->get(
			array(
				"id" => $id
			),"aders");


		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("dersId", "Ders", "required|trim");
		$this->form_validation->set_rules("userId", "Hoca", "required|trim");

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
				"exact_length"      => "* <strong>{field}</strong>, alanına uzunluk olarak eksik veya fazla bir değer girdiniz, Lütfen geçerli bir {field} giriniz!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate){

			$update= $this->data_model->update(array("id" => $id), array(
				"dersId" 		=> $this->input->post("dersId"),
				"userId" 		=> $this->input->post("userId"),
			), "aders");

			if ($update){

				$alert = array(
					"text"   => "İşlem başarılı, düzenlendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/aders"));

			}
			else{
				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/aders"));
			}

		}else
		{
			$viewData = new stdClass();
			$ders_items = $this->data_model->get_all(array("isActive" => "A"),"dersler");
			$user_items = $this->data_model->get_all(array("isActive" => "A"),"user");
			$item_profiles = $this->data_model->get_all(array(),"profil");

			$viewData->profils = $item_profiles;
			$viewData->users = $user_items;
			$viewData->dersler=$ders_items;
			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update_aders";
			$viewData->form_error = true;
			$viewData->item = $item;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}


	public function bolumler(){
		$viewData = new stdClass();

		$items= $this->data_model->get_all(array(),"bolumler");
		$fakulte_items = $this->data_model->get_all(array( "isActive" => "A" ),"fakulte");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "bolumler";
		$viewData->items = $items;
		$viewData->fakulteler = $fakulte_items;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function new_bolum()
	{
		$viewData = new stdClass();
		$fakulte = $this->data_model->get_all(array("  isActive"  => "A"),"fakulte");

		$viewData->profile = $this->profile;
		$viewData->items= $fakulte;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "add_bolum";
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function bolum_add()
	{

		$fakulte = $this->data_model->get_all(array(   "isActive"  => "A"),"fakulte");

		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("bolumAdi", "Bolum Adı", "required|trim");
		$this->form_validation->set_rules("fakulteId", "Fakulte", "required|trim");
		$this->form_validation->set_rules("bolumKodu", "Bolum Kodu", "required|trim|is_unique[bolumler.bolumKodu]");


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

		if ($validate) {

			$insert = $this->data_model->add(
				array(
					"bolumAdi" 		=> $this->input->post("bolumAdi"),
					"bolumKodu" 		=> $this->input->post("bolumKodu"),
					"fakulteId" 		=> $this->input->post("fakulteId"),
					"isActive"		=> $this->input->post("userStat")!= "A" ? "P" : "A"
				), "bolumler"
			);
			if ($insert){

				$alert = array(
					"text"   => "İşlem başarılı, yeni ders başarıyla eklendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/bolumler"));

			}
			else{


				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/bolumler"));

			}
		}
		else{
			$viewData = new stdClass();

			$viewData->items= $fakulte;
			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "add_bolum";
			$viewData->form_error = true;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}


	public function bolum_update($id){

		$fakulte = $this->data_model->get_all(array(	"isActive"  =>  "A"),"fakulte");

		$item = $this->data_model->get(array( "id" => $id),"bolumler");

		$viewData = new stdClass();

		$viewData->itembol = $item;
		$viewData->items= $fakulte;
		$viewData->profile = $this->profile;
		$viewData->viewFolder = $this->viewFolder;
		$viewData->subViewFolder = "update_bolum";

		$this->load->view("{$viewData->viewFolder}/index", $viewData);
	}

	public function do_bolum_update($id){
		$item = $this->data_model->get(
			array(
				"id" => $id
			),"bolumler");

		$fakulte = $this->data_model->get_all(array(	"isActive"  =>  "A"),"fakulte");

		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("bolumKodu", "Bolum Kodu", "required|trim");
		$this->form_validation->set_rules("bolumAdi", "Bolum Adı", "required|trim");
		$this->form_validation->set_rules("fakulteId", "Fakülte", "required|trim");

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
				"exact_length"      => "* <strong>{field}</strong>, alanına uzunluk olarak eksik veya fazla bir değer girdiniz, Lütfen geçerli bir {field} giriniz!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate) {

			$update = $this->data_model->update(array("id" => $id),
				array(
					"bolumAdi" 			=> $this->input->post("bolumAdi"),
					"bolumKodu" 		=> $this->input->post("bolumKodu"),
					"fakulteId" 		=> $this->input->post("fakulteId")
				), "bolumler");

			if ($update) {

				$alert = array(
					"text" => "İşlem başarılı, düzenlendi",
					"type" => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/bolumler"));

			} else {


				$alert = array(
					"text" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type" => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/bolumler"));

			}
		}else{
			$viewData = new stdClass();

			$viewData->itembol = $item;
			$viewData->items= $fakulte;
			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update_bolum";
			$viewData->form_error = true;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}

	}

	public function fakulte(){
		$viewData = new stdClass();

		$items= $this->data_model->get_all(array(),"fakulte");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "fakulte";
		$viewData->items = $items;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function new_fakulte()
	{
		$viewData = new stdClass();

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "add_fakulte";
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function fakulte_add()
	{
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("fakulteAdi", "Fakulte Adı", "required|trim");
		$this->form_validation->set_rules("fakulteKodu", "Fakulte Kodu", "required|trim|is_unique[fakulte.fakulteKodu]");


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

		if ($validate) {

			$insert = $this->data_model->add(
				array(
					"fakulteAdi" 		=> $this->input->post("fakulteAdi"),
					"fakulteKodu" 		=> $this->input->post("fakulteKodu"),
					"isActive"		=> $this->input->post("userStat")!= "A" ? "P" : "A"
				), "fakulte"
			);
			if ($insert){

				$alert = array(
					"text"   => "İşlem başarılı, yeni fakülte başarıyla eklendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/fakulte"));

			}
			else{


				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/fakulte"));

			}
		}
		else{
			$viewData = new stdClass();

			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "add_fakulte";
			$viewData->form_error = true;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}

	public function update_fakulte($id){
		$viewData = new stdClass();
		/*Veri tabanından gerekli özelliklere göre getirilme işlemi*/
		$item = $this->data_model->get(
			array(
				"id" => $id
			),"fakulte");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "update_fakulte";
		$viewData->item = $item;

		$this->load->view("{$viewData->viewFolder}/index",$viewData);
	}

	public function do_update_fakulte($id){

		$item = $this->data_model->get(
			array(
				"id" => $id
			),"fakulte");


		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("fakulteKodu", "Fakulte Kodu", "required|trim");
		$this->form_validation->set_rules("fakulteAdi", "Fakulte Adı", "required|trim");

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
				"exact_length"      => "* <strong>{field}</strong>, alanına uzunluk olarak eksik veya fazla bir değer girdiniz, Lütfen geçerli bir {field} giriniz!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate){
			$class = $item->class;

			$update= $this->data_model->update(array("id" => $id), array(
				"fakulteKodu" 		=> $this->input->post("fakulteKodu"),
				"fakulteAdi" 		=> $this->input->post("fakulteAdi"),
			), "fakulte");

			if ($update){

				$alert = array(
					"text"   => "İşlem başarılı, düzenlendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/fakulte"));

			}
			else{


				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/fakulte"));

			}

		}else
		{
			$viewData = new stdClass();

			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update_fakulte";
			$viewData->form_error = true;
			$viewData->item = $item;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}


	public function donem(){
		$viewData = new stdClass();

		$items= $this->data_model->get_all(array(),"donem");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "donem";
		$viewData->items = $items;
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function new_donem()
	{
		$viewData = new stdClass();

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "add_donem";
		$this->load->view("{$this->viewFolder}/index", $viewData);
	}

	public function donem_add()
	{
		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("yil", "Yıl", "required|trim");
		$this->form_validation->set_rules("donem", "Dönem", "required|trim");


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

		if ($validate) {

			$insert = $this->data_model->add(
				array(
					"yil" 		=> $this->input->post("yil"),
					"donem" 		=> $this->input->post("donem"),
					"isActive"		=> $this->input->post("userStat")!= "A" ? "P" : "A"
				), "donem"
			);
			if ($insert){

				$alert = array(
					"text"   => "İşlem başarılı, yeni dönem başarıyla eklendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/donem"));

			}
			else{


				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/donem"));

			}
		}
		else{
			$viewData = new stdClass();

			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "add_donem";
			$viewData->form_error = true;

			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}






	public function update_ders($id){
		$viewData = new stdClass();
		/*Veri tabanından gerekli özelliklere göre getirilme işlemi*/
		$item = $this->data_model->get(
			array(
				"id" => $id
			),"dersler");
		$donem = $this->data_model->get_all(array(),"donem");

		$viewData->donem = $donem;
		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "update_ders";
		$viewData->item = $item;


		$this->load->view("{$viewData->viewFolder}/index",$viewData);
	}

	public function do_update_ders($id){

		$item = $this->data_model->get(
			array(
				"id" => $id
			),"dersler");
		$donem = $this->data_model->get_all(array(),"donem");


		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("dersAdi", "Ders Adı", "required|trim");
		$this->form_validation->set_rules("dersKodu", "Ders Kodu", "required|trim");
		$this->form_validation->set_rules("donemId", "Donem", "required|trim");

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
				"exact_length"      => "* <strong>{field}</strong>, alanına uzunluk olarak eksik veya fazla bir değer girdiniz, Lütfen geçerli bir {field} giriniz!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate){
			$class = $item->class;

			$update= $this->data_model->update(array("id" => $id), array(
				"dersAdi" 		=> $this->input->post("dersAdi"),
				"dersKodu" 		=> $this->input->post("dersKodu"),
				"donemId" 		=> $this->input->post("donemId"),
			), "dersler");

			if ($update){

				$alert = array(
					"text"   => "İşlem başarılı, düzenlendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/ders"));

			}
			else{


				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/ders"));

			}
			$this->session->set_flashdata("alert", $alert);

			redirect(base_url("dashboard/ders"));

		}else
		{
			$viewData = new stdClass();

			$viewData->donem = $donem;
			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update_ders";
			$viewData->form_error = true;
			$viewData->item = $item;
			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}

	public function update_donem($id){
		$viewData = new stdClass();
		/*Veri tabanından gerekli özelliklere göre getirilme işlemi*/
		$item = $this->data_model->get(
			array(
				"id" => $id
			),"donem");

		$donem= $this->data_model->get_all(array(),"donem");

		$viewData->profile = $this->profile;
		$viewData->viewFolder=$this->viewFolder;
		$viewData->subViewFolder = "update_donem";
		$viewData->item = $item;
		$viewData->donem = $donem;


		$this->load->view("{$viewData->viewFolder}/index",$viewData);
	}

	public function do_update_donem($id){

		$item = $this->data_model->get(
			array(
				"id" => $id
			),"donem");


		/**Validation kütüphanesini yüklenmesi*/
		$this->load->library("form_validation");

		$this->form_validation->set_rules("donem", "Donem", "required|trim");
		$this->form_validation->set_rules("yil", "Yıl", "required|trim");

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
				"exact_length"      => "* <strong>{field}</strong>, alanına uzunluk olarak eksik veya fazla bir değer girdiniz, Lütfen geçerli bir {field} giriniz!"
			)
		);

		$validate= $this->form_validation->run();

		if ($validate){

			$update= $this->data_model->update(array("id" => $id), array(
				"yil" 		=> $this->input->post("yil"),
				"donem" 		=> $this->input->post("donem"),
			), "donem");

			if ($update){

				$alert = array(
					"text"   => "İşlem başarılı, düzenlendi",
					"type"   => "success",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/donem"));
			}
			else{
				$alert = array(
					"text"   => "Bir hata oluştu, lütfen tekrar deneyiniz.",
					"type"   => "error",
				);

				$this->session->set_flashdata("alert", $alert);
				redirect(base_url("dashboard/donem"));

			}
		}else
		{
			$viewData = new stdClass();

			$viewData->profile = $this->profile;
			$viewData->viewFolder = $this->viewFolder;
			$viewData->subViewFolder = "update_donem";
			$viewData->form_error = true;
			$viewData->item = $item;
			$this->load->view("{$viewData->viewFolder}/index", $viewData);
		}
	}





}
