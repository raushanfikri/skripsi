<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class penelitian extends CI_Controller {
	function __construct() {
		parent::__construct();
		// $this->load->library('Pdf');
		$this->load->library('digipdf');

	}

	public function get_datadosen(){
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->db->select('*');
			$this->db->like('namadosen', $q);
			$this->db->from('dosen');
			$query = $this->db->get();

			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=htmlentities(stripslashes($row['nidn']));
					$new_row['value']=htmlentities(stripslashes($row['namadosen']));
					$new_row['id']=htmlentities(stripslashes($row['nidn']));
					$row_set[] = $new_row; //build an array
				}
			echo json_encode($row_set); //format the array into json data
			}
        }
    }

    public function get_datafakultas(){
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->db->select('*');
			$this->db->like('namafakultas', $q);
			$this->db->from('fakultas');
			$query = $this->db->get();

			if($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$new_row['label']=htmlentities(stripslashes($row['kodefakultas']));
					$new_row['value']=htmlentities(stripslashes($row['namafakultas']));
					$new_row['id']=htmlentities(stripslashes($row['kodefakultas']));
					$row_set[] = $new_row; //build an array
				}
			echo json_encode($row_set); //format the array into json data
			}
        }
    }

	public function exportPDF($table){
		$awal = $this->input->post('awal');
		$akhir = $this->input->post('akhir');
		$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
		$data['hariini'] = date('d F Y');
		if ($namadosen == null) {
			$data['query'] = $this->db->query("SELECT * from $table where date BETWEEN '$awal' and '$akhir'")->result();			
		} else {
			$data['query'] = $this->db->query("SELECT * from $table where namadosen='$namadosen' and date BETWEEN '$awal' and '$akhir'")->result();	
		}
		
		$this->load->view($table, $data);

	}


	
	public function index() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		// $q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$u."' AND password = '".$p."'");
		// $j_cek	= $q_cek->num_rows();
		// $d_cek	= $q_cek->row();

		$a['page']	= "d_amain";
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		$this->load->view('penelitian/aaa', $a);
	}

	// LOGIN
	public function login() {
		$this->load->view('penelitian/login');
	}
	// LOGIN
	
	//// PENGGUNA
	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		
		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$nama					= addslashes($this->input->post('nama'));
		$alamat					= addslashes($this->input->post('alamat'));
		$pimpinan					= addslashes($this->input->post('pimpinan'));
		$nrp_pimpinan				= addslashes($this->input->post('nrp_pimpinan'));
		
		$cari					= addslashes($this->input->post('q'));

		//upload config 
		$config['upload_path'] 		= './upload';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '2000';
		$config['max_width']  		= '3000';
		$config['max_height'] 		= '3000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('logo')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', pimpinan = '$pimpinan', nrp_pimpinan = '$nrp_pimpinan', logo = '".$up_data['file_name']."' WHERE id = '$idp'");

			} else {
				$this->db->query("UPDATE tr_instansi SET nama = '$nama', alamat = '$alamat', pimpinan = '$pimpinan', nrp_pimpinan = '$nrp_pimpinan' WHERE id = '$idp'");
			}		

			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/penelitian/pengguna');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('penelitian/aaa', $a);	
	}
	//// PENGGUNA
	
		
	

	/// UBAH PASSWORD	
	public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		$ke				= $this->uri->segment(3);
		$id_user		= $this->session->userdata('admin_id');
		
		//var post
		$p1				= md5($this->input->post('p1'));
		$p2				= md5($this->input->post('p2'));
		$p3				= md5($this->input->post('p3'));
		
		if ($ke == "simpan") {
			$cek_password_lama	= $this->db->query("SELECT password FROM t_admin WHERE id = $id_user")->row();
			//echo 
			
			if ($cek_password_lama->password != $p1) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Lama tidak sama</div>');
				redirect('index.php/penelitian/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('index.php/penelitian/passwod');
			} else {
				$this->db->query("UPDATE t_admin SET password = '$p3' WHERE id = ".$id_user."");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('index.php/penelitian/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}
	/// UBAH PASSWORD
	// CEK LOGIN
	public function do_login() {
		$u 		= $this->security->xss_clean($this->input->post('u'));
		$ta 	= $this->security->xss_clean($this->input->post('ta'));
        $p 		= md5($this->security->xss_clean($this->input->post('p')));
        $status = 'Aktif'; 
		$q_cek	= $this->db->query("SELECT * FROM dosen WHERE nidn = '".$u."' AND password = '".$p."'");
		$j_cek	= $q_cek->num_rows();
		$d_cek	= $q_cek->row();
		//echo $this->db->last_query();
        if($j_cek == 1) {

        	if (strtolower($d_cek->level) != 'admin') {
	        	$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
				redirect('index.php/penelitian/login');
			}

            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->namadosen,
                    'admin_nip' => $d_cek->nidn,
                    'admin_level' => $d_cek->level,
                    'admin_status' => $d_cek->status,
					'admin_valid' => true
                    );
				$this->session->set_userdata($data);
				redirect('index.php/penelitian');
				
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('index.php/penelitian/login');
		}
	}
	// CEK LOGIN
	
	// LOGOUT
	public function logout(){
        $this->session->sess_destroy();
		redirect('index.php/admin/');
    }
	// LOGOUT
	/// DOSEN
	public function dosen() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM dosen Where nidn ORDER BY nidn DESC")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/dosen/p");
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$nidn					= addslashes($this->input->post('nidn'));
		$nik					= addslashes($this->input->post('nik'));
		$namadosen				= addslashes($this->input->post('namadosen'));
		$kodejurusan			= addslashes($this->input->post('kodejurusan'));
		$fakultas				= addslashes($this->input->post('Fakultas'));
		$jurusan				= addslashes($this->input->post('jurusan'));
		
		$level 					= addslashes($this->input->post('level'));
		$password				= md5(addslashes($this->input->post('password')));
		
		$cari					= addslashes($this->input->post('q'));
		$ket = "Dosen";
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_dosen WHERE nidn LIKE '%$cari%' OR namadosen LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_dosen";
		} else if ($mau_ke == "add") {
			//$a['fakultas'] = $this->db->get("fakultas");
			//$a['prodi'] = $this->db->get("jurusan");
			$a['page']		= "f_dosen";
		} else if ($mau_ke == "edt") {
			//$a['fakultas'] = $this->db->get("fakultas");
			//$a['prodi'] = $this->db->get("jurusan");
			//$a['datpil']	= $this->db->query("SELECT * FROM dosen WHERE nidn = '$idu'")->row();
			$a['datpil']	= $this->db->select("*")->from("dosen")->join("jurusan","jurusan.kodejurusan=dosen.kodejurusan")->join("fakultas","fakultas.kodefakultas=jurusan.kodefakultas")->where("dosen.nidn",$idu)->get();	
			$a['page']		= "f_dosen";
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE dosen SET nik='$nik',namadosen ='$namadosen',level='$level', password='$password', kodejurusan='$kodejurusan' WHERE nidn = '$nidn'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/penelitian/dosen');
		} else if ($mau_ke == "act_add") {
		
			$cek_user_exist = $this->db->query("SELECT nidn FROM dosen WHERE nidn = '$nidn'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">NIDN Sudah Ada. Ganti yang lain..!</div>");
			} else {

			$this->db->query("INSERT INTO dosen VALUES('$nidn','$nik', '$namadosen', '$level','$password','$kodejurusan')");
			// $this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");			
			}
			
			redirect('index.php/penelitian/dosen');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM dosen WHERE nidn = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/penelitian/dosen');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM v_dosen ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_dosen";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}
	/// DOSEN
	
	public function fakultas(){
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}

		$total_row		= $this->db->query("SELECT * FROM fakultas")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;

		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/fakultas/p");
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);

		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$kodefakultas			= addslashes($this->input->post('kodefakultas'));
		$namafakultas			= addslashes($this->input->post('namafakultas'));
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM fakultas WHERE namafakultas LIKE '%$cari%'  ORDER BY kodefakultas DESC")->result();
			$a['page']		= "l_fakultas";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_fakultas";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM fakultas WHERE kodefakultas = '$idu'")->row();	
			$a['page']		= "f_fakultas";
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE fakultas SET namafakultas='$namafakultas' WHERE kodefakultas = '$kodefakultas'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			redirect('index.php/penelitian/fakultas');
		} else if ($mau_ke == "act_add") {
		
			$cek_user_exist = $this->db->query("SELECT kodefakultas FROM fakultas WHERE kodefakultas = '$kodefakultas'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Kode Fakultas Sudah Ada. Ganti yang lain..!</div>");
			} else {

			$this->db->query("INSERT INTO fakultas VALUES('$kodefakultas','$namafakultas')");
			// $this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan</div>");			
			}
			
			redirect('index.php/penelitian/fakultas');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM fakultas WHERE kodefakultas = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/penelitian/fakultas');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM fakultas ORDER BY kodefakultas ASC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_fakultas";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}

	public function jurusan(){

		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}

		$total_row		= $this->db->query("SELECT * FROM jurusan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;

		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/jurusan/p");
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);

		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$kodejurusan			= addslashes($this->input->post('kodejurusan'));
		$namajurusan			= addslashes($this->input->post('namajurusan'));
		$kodefakultas 			= addslashes($this->input->post('kodefakultas'));
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM jurusan WHERE namajurusan LIKE '%$cari%'  ORDER BY kodefakultas DESC")->result();
			$a['page']		= "l_jurusan";
		} else if ($mau_ke == "add") {
			$a['fakultas'] = $this->db->get("fakultas");
			$a['page']		= "f_jurusan";
		} else if ($mau_ke == "edt") {
			$a['fakultas'] = $this->db->get("fakultas");
			$a['datpil']	= $this->db->query("SELECT * FROM jurusan WHERE kodejurusan = '$idu'")->row();	
			$a['page']		= "f_jurusan";
		} else if ($mau_ke == "act_edt") { 
			$this->db->query("UPDATE jurusan SET namajurusan='$namajurusan', kodefakultas='$kodefakultas' WHERE kodejurusan = '$kodejurusan'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			redirect('index.php/penelitian/jurusan');
		} else if ($mau_ke == "act_add") {
			$cek_user_exist = $this->db->query("SELECT kodejurusan FROM jurusan WHERE kodejurusan = '$kodejurusan'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k","<div class=\"alert alert-danger\" id=\"alert\">Kode Jurusan Sudah Ada. Ganti yang lain..!</div>");
			} else {

			

			$this->db->query("INSERT INTO jurusan VALUES('$kodejurusan','$namajurusan', '$kodefakultas')");
			// $this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan</div>");			
			}
			
			redirect('index.php/penelitian/jurusan');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurusan WHERE kodejurusan = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/penelitian/jurusan');
		} else {
			$a['data']		= $this->db->query("SELECT jurusan.kodejurusan, fakultas.namafakultas, jurusan.namajurusan FROM jurusan, fakultas WHERE jurusan.kodefakultas=fakultas.kodefakultas ORDER BY namafakultas ASC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurusan";
		}
		
		$this->load->view('penelitian/aaa', $a);


	}

	/// BUKU
	public function buku() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_buku")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/buku/p");
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$penerbit				= addslashes($this->input->post('penerbit'));
		$isbn					= addslashes($this->input->post('isbn'));
		$halaman				= addslashes($this->input->post('halaman'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/buku';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$date = date('Y-m-d H:i:s'); // 2019-07-19 16:
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_buku WHERE nidn LIKE '%$cari%' OR judul 
			LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_buku";
		}else if ($mau_ke == "add") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['page']		= "f_buku";
		}
		else if ($mau_ke == "act_add") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO buku VALUES (NULL,'$idpenelitian', '$nidn', '$judul', '$penerbit', '$isbn', 
				'$halaman', '".$up_data['file_name']."','$keterangan','$date')");
			} else {
				$this->db->query("INSERT INTO buku VALUES (NULL,'$idpenelitian', '$nidn', '$judul', '$penerbit', 
				'$isbn','$halaman','$keterangan', '$date')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/penelitian/buku');
		}
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/penelitian/buku');
		}
		else if ($mau_ke == "edt") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['datpil']	= $this->db->query("SELECT * FROM v_buku WHERE id=$idu")->result();
			$a['page']		= "f_buku";
		}
		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE buku SET idpenelitian='$idpenelitian',nidn='$nidn', judul='$judul', penerbit='$penerbit', isbn='$isbn', 
				halaman='$halaman',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");


			}else{

				 $query="UPDATE buku SET idpenelitian='$idpenelitian',nidn='$nidn', judul='$judul', penerbit='$penerbit', 
				 isbn='$isbn', halaman='$halaman',keterangan='$keterangan' WHERE id = '$id'";

			$this->db->query($query);
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Di DiUbah</div>");			
			
			} 
			redirect('index.php/penelitian/buku');  
		} 
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_buku ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_buku";
		}
		$this->load->view('penelitian/aaa', $a);
	}
	/// BUKU
	
	/// JURNAL
	public function jurnal() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_jurnal")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/jurnal/p");
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		
		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$namajurnal				= addslashes($this->input->post('namajurnal'));
		$jenis					= addslashes($this->input->post('jenis'));
		$peranpenulis			= addslashes($this->input->post('peranpenulis'));
		$tahun					= addslashes($this->input->post('tahun'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('no'));
		$url					= addslashes($this->input->post('url'));
		$issn					= addslashes($this->input->post('issn'));
		$keterangan				= addslashes($this->input->post('status'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$tanggal = date('Y-m-d H:i:s');

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnal";
		}  else if ($mau_ke == "add") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['page']		= "f_jurnal";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO jurnal VALUES (NULL,'$idpenelitian', '$nidn', '$judul','$namajurnal',
				'$jenis', '$peranpenulis', '$tahun','$volume', '$nomor', '$url', '$issn', 
				'".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO jurnal VALUES (NULL, '$idp', '$nidn', '$judul','$namajurnal',
				'$jenis', '$peranpenulis', '$tahun','$volume', '$nomor', '$url', '$issn','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/penelitian/jurnal');
		}


		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/penelitian/jurnal');
		}

		else if ($mau_ke == "edt") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['datpil']		= $this->db->query("SELECT * FROM v_jurnal WHERE id=$idu")->result();
			$a['page']		= "f_jurnal";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				
				$this->db->query("UPDATE jurnal SET idpenelitian='$idpenelitian',nidn='$nidn', judul='$judul', 
				namajurnal='$namajurnal',jenis='$jenis',peranpenulis='$peranpenulis',tahun='$tahun',
				volume='$volume',no='$nomor',url='$url',issn='$issn',file='$up_data[file_name]', 
				keterangan='$keterangan' WHERE id = '$id'");
			}else{

				$query="UPDATE jurnal SET idpenelitian='$idpenelitian',nidn='$nidn', judul='$judul', 
				namajurnal='$namajurnal',jenis='$jenis',peranpenulis='$peranpenulis',tahun='$tahun',
				volume='$volume',no='$nomor',url='$url',issn='$issn',
				keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	
			}
				
			redirect('index.php/penelitian/jurnal');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_jurnal ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnal";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}
	/// JURNAL
	/// JURNAL PKM
	
	
	/// PENELITIAN
	public function penelitiann() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/penelitiann/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tse					= addslashes($this->input->post('tse'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi				= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/penelitian';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$tanggal = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitian";
		} 

		else if ($mau_ke == "add") {
			$a['page']		= "f_penelitian";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/penelitian/penelitiann');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE idpenelitian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/penelitian/penelitiann');
		}
		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE idpenelitian=$idu")->result();
			$a['page']		= "f_penelitian";
		}else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$query="UPDATE penelitian SET judulpenelitian='$judulpenelitian',jenis='$jenis', bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi', jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE idpenelitian = '$idpenelitian'";

				$this->db->query($query);
				
			}else{
				
				$query = "UPDATE penelitian SET judulpenelitian='$judulpenelitian', jenis='$jenis', bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi', jumlah='$jumlah', keterangan='$keterangan' WHERE idpenelitian = '$idpenelitian'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			// die($query);
			redirect('index.php/penelitian/penelitiann');
		}  
		else {

			$a['data']		= $this->db->query("SELECT * FROM v_penelitian where ket='ketua'ORDER BY idpenelitian  DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitian";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}
	/// PENELITIAN
	public function detail_anggota($id){
		if(isset($id) && !empty($id)){
			$a['id'] = $id;
			$a['page']		= "f_detail_anggota";
			$a['anggota'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->join("dosen","dosen.nidn=detail_anggotapenelitian.nidn")->where("penelitian.idpenelitian",$id)->get();
			$this->load->view('penelitian/aaa', $a);
		}else{
			$this->dosenpenelitian();
		}
	}

	public function simpan_anggota(){
		if(isset($_POST) && !empty($_POST)){
			$data['nidn'] = $this->input->post('dosen');
			$data['idpenelitian'] = $this->input->post('id'); 

			$cek = $this->db->get_where("detail_anggotapenelitian",$data);
			if($cek->num_rows()>0){
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Dosen Sudah Terdaftar </div>");
			
				redirect('index.php/penelitian/detail_anggota/'.$this->input->post('id'));
			}else{
				$data_['idpenelitian'] = $this->input->post('id');
				$data_['nidn'] = $this->input->post('dosen');
				$data_['ket'] = 'anggota';
				$this->db->insert("detail_anggotapenelitian",$data_);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Dosen Berhasil Ditambahkan </div>");
				redirect('index.php/penelitian/detail_anggota/'.$this->input->post('id'));
			}
		}else{
			$this->dosenpenelitian();
		}
	}

	public function hapus_anggota($idp,$nidn){
		$where = array(
			'idpenelitian' => $idp,
			'nidn' => $nidn,
		);
		$this->db->delete("detail_anggotapenelitian",$where);
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Dosen Berhasil Dihapus </div>");
				redirect('index.php/penelitian/detail_anggota/'.$idp);
	}
		/// PENELITIAN PKM
	
	
	/// SEMINAR
	public function seminar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_seminar")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/seminar/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('namaprosiding'));
		$tahunprosiding			= addslashes($this->input->post('tahunprosiding'));
		$peranpenulis			= addslashes($this->input->post('peranpenulis'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('no'));
		$isbn					= addslashes($this->input->post('isbn'));
		$url					= addslashes($this->input->post('url'));
		$jenisprosiding			= addslashes($this->input->post('jenisprosiding'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$tanggal = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_seminar WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_seminar";
		} 

		else if ($mau_ke == "add") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['page']		= "f_seminar";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$idpenelitian','$nidn', '$judul', 
				'$tahunprosiding', '$peranpenulis','$volume', '$nomor', '$isbn',
				 '$url', '$jenisprosiding','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$idpenelitian','$nidn', '$judul', 
				'$tahunprosiding',  '$peranpenulis','$volume', '$nomor', '$isbn',
				 '$url', '$jenisprosiding','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/penelitian/seminar');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM seminar WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Dihapus</div>");			
			redirect('index.php/penelitian/seminar');
		}

		else if ($mau_ke == "edt") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['datpil']		= $this->db->query("SELECT * FROM v_seminar WHERE id=$idu")->result();
			$a['page']		= "f_seminar";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$this->db->query("UPDATE seminar SET idpenelitian='$idp', nidn='$nidn', namaprosiding='$judul', 
				tahunprosiding='$tahunprosiding',peranpenulis='$peranpenulis',
				volume='$volume',no='$nomor',isbn='$isbn',url='$url',
				jenisprosiding='$jenisprosiding',file='$up_data[file_name]', 
				keterangan='$keterangan' WHERE id = '$id");
			}else{

				$query="UPDATE seminar SET idpenelitian='$idpenelitian', nidn='$nidn', namaprosiding='$judul',
				tahunprosiding='$tahunprosiding',peranpenulis='$peranpenulis',
				volume='$volume',no='$nomor',isbn='$isbn',url='$url',
				jenisprosiding='$jenisprosiding', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

			}
						
			redirect('index.php/penelitian/seminar');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_seminar ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminar";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}
	/// SEMINAR
	
	
	/// PUBLIKASI ILMIAH
	public function publikasi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_publikasi1")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/publikasi/p");
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));
		$id 					= addslashes($this->input->post('id'));

		//ambil variabel Postingan
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$institusi				= addslashes($this->input->post('institusi'));
		$tempat					= addslashes($this->input->post('tempat'));
		$tanggal					= addslashes($this->input->post('tanggal'));
		$keterangan				= addslashes($this->input->post('status'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/publikasi';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$date = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * from v_publikasi1 WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_publikasi";
		}
		else if ($mau_ke == "add") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['page']		= "f_publikasi";
		}
		else if ($mau_ke == "act_add") {
		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				

				$query="INSERT INTO publikasiilmiah VALUES (NULL,'$idpenelitian', 
				'$nidn', '$judul','$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan','$date')";

				// die($query);
				$this->db->query($query);
			} else {
				$this->db->query("INSERT INTO publikasiilmiah VALUES (NULL,'$idpenelitian', 
				'$nidn', '$judul','$institusi', '$tanggal', '$tempat','$keterangan','$date')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/penelitian/publikasi');
		}
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/penelitian/publikasi');
		}
		else if ($mau_ke == "edt") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['datpil']	= $this->db->query("SELECT * FROM v_publikasi1 WHERE id=$idu")->result();
			$a['page']		= "f_publikasi";

		}
		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
					$this->db->query("UPDATE publikasiilmiah SET idpenelitian='$idpenelitian',nidn='$nidn',
					 judul='$judul', institusi='$institusi', tanggal='$tanggal', 
					 tempat='$tempat',file='$up_data[file_name]', status='$keterangan' WHERE id = '$id'");
			}else{
				$query = "UPDATE publikasiilmiah SET idpenelitian='$idpenelitian',nidn='$nidn',
				judul='$judul', institusi='$institusi', tanggal='$tanggal', 
				tempat='$tempat', status='$keterangan' WHERE id = '$id'";

					$this->db->query($query);
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Behasil DiUbah</div>");	
			}
				
			redirect('index.php/penelitian/publikasi');
		}else {
			$a['data']		= $this->db->query("SELECT * from v_publikasi1 ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasi";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}
	/// PUBLIKASI ILMIAH
	
	/// HKI
	public function hki() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/penelitian/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM hki")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/penelitian/hki/p");
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$nomorpendaftaran		= addslashes($this->input->post('nomorpendaftaran'));
		$status					= addslashes($this->input->post('status'));
		$nohki					= addslashes($this->input->post('nohki'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/hki';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$date = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_hki";
		}else if ($mau_ke == "add") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['page']		= "f_hki";
		}  

		else if ($mau_ke == "act_add") 
		{
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO hki VALUES (NULL, '$idpenelitian', '$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','".$up_data['file_name']."','$keterangan','$date')");
			} else {
				$this->db->query("INSERT INTO hki VALUES (NULL, '$idpenelitian','$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','$keterangan','$date')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/penelitian/hki');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/penelitian/hki');

		}else if ($mau_ke == "edt") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian")->result();
			$a['datpil']		= $this->db->query("SELECT * FROM v_hki WHERE id=$idu")->result();
			$a['page']		= "f_hki";
		}

		else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query("UPDATE hki SET idpenelitian='$idpenelitian',judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status',nohki='$nohki',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query = "UPDATE hki SET judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status',nohki='$nohki', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");		
			}
			redirect('index.php/penelitian/hki');
		}else {
			$a['data']		= $this->db->query("SELECT * FROM v_hki ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hki";
		}
		
		$this->load->view('penelitian/aaa', $a);
	}
	/// HKI
	
	/// HKI
		///DOSEN PENELITIAN PKM
}