<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	public function index() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		// $q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$u."' AND password = '".$p."'");
		// $j_cek	= $q_cek->num_rows();
		// $d_cek	= $q_cek->row();

		$a['page']	= "d_amain";
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		$this->load->view('admin/aaa', $a);
	}

	// LOGIN
	public function login() {
		$this->load->view('admin/login');
	}
	// LOGIN
	
	//// PENGGUNA
	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
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
			redirect('index.php/admin/pengguna');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('admin/aaa', $a);	
	}
	//// PENGGUNA
	
	/// TAMBAH PENGGUNA	
	public function manage_admin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM t_admin")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."admin/manage_admin/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idp					= addslashes($this->input->post('idp'));
		$username				= addslashes($this->input->post('username'));
		$pass_raw1				= addslashes($this->input->post('password'));
		$pass_raw2				= addslashes($this->input->post('password2'));
		$password				= md5(addslashes($this->input->post('password')));
		$nama					= addslashes($this->input->post('nama'));
		$nip					= addslashes($this->input->post('nip'));
		$level					= addslashes($this->input->post('level'));
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_admin WHERE iduser = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_admin WHERE nama LIKE '%$cari%' ORDER BY iduser DESC")->result();
			$a['page']		= "l_manage_admin";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_admin WHERE iduser = '$idu'")->row();	
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "del") {
			$a['datpil']	= $this->db->query("DELETE FROM t_admin WHERE iduser = '$idu'")->row();	
			
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "act_add") {	
			$cek_user_exist = $this->db->query("SELECT username FROM t_admin WHERE username = '$username'")->num_rows();

			if (strlen($username) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username minimal 4 huruf</div>");
			} else if (strlen($pass_raw1) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password minimal 4 huruf</div>");
			} else if ($pass_raw1 != $pass_raw2) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password konfirmasi tidak sama..</div>");
			} else if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username telah dipakai. Ganti yang lain..!</div>");
			} else {
				$this->db->query("INSERT INTO t_admin VALUES (NULL, '$username', '$password', '$nama', '$nip', '$level')");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			redirect('index.php/admin/manage_admin');
		} else if ($mau_ke == "act_edt") {
			if (strlen($username) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username minimal 4 huruf</div>");
			} else if (strlen($pass_raw1) < 4) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password minimal 4 huruf</div>");
			} else if ($pass_raw1 != $pass_raw2) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Password konfirmasi tidak sama..</div>");
			} else if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Username telah dipakai. Ganti yang lain..!</div>");
			} else {
				
				if ($pass_raw1 == "") {
					$this->db->query("UPDATE t_admin SET username = '$username', nama = '$nama', nip = '$nip', level = '$level' WHERE iduser = '$idp'");
				} else {
					$this->db->query("UPDATE t_admin SET username = '$username', password = '$password', nama = '$nama', nip = '$nip', level = '$level' WHERE iduser = '$idp'");
				}

				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");
			}
			
			redirect('index.php/admin/manage_admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_admin LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_manage_admin";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// TAMBAH PENGGUNA

	/// UBAH PASSWORD	
	public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
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
				redirect('index.php/admin/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('index.php/admin/passwod');
			} else {
				$this->db->query("UPDATE t_admin SET password = '$p3' WHERE id = ".$id_user."");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('index.php/admin/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// UBAH PASSWORD
	// CEK LOGIN
	public function do_login() {
		$u 		= $this->security->xss_clean($this->input->post('u'));
		$ta 	= $this->security->xss_clean($this->input->post('ta'));
        $p 		= md5($this->security->xss_clean($this->input->post('p')));
        $status = 'Aktif'; 
		$q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$u."' AND password = '".$p."'");
		$j_cek	= $q_cek->num_rows();
		$d_cek	= $q_cek->row();
		//echo $this->db->last_query();
		
        if($j_cek == 1) {
            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->namauser,
                    'admin_nip' => $d_cek->nip,
                    'admin_level' => $d_cek->level,
                    'admin_status' => $d_cek->status,
					'admin_valid' => true
                    );
				$this->session->set_userdata($data);
				redirect('index.php/admin');
				
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('index.php/admin/login');
		}
	}
	// CEK LOGIN
	
	// LOGOUT
	public function logout(){
        $this->session->sess_destroy();
		redirect('index.php/admin/login');
    }
	// LOGOUT
	/// DOSEN
	public function dosen() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM dosen")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosen/p");
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
		$jurusan				= addslashes($this->input->post('jurusan'));
		$password				= md5(addslashes($this->input->post('nidn')));
		$cari					= addslashes($this->input->post('q'));
		$ket = "Dosen";
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM dosen WHERE nidn LIKE '%$cari%' OR namadosen LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_dosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_dosen";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM dosen WHERE nidn = '$idu'")->row();	
			$a['page']		= "f_dosen";
		} else if ($mau_ke == "act_edt") {
			$this->db->query("UPDATE dosen SET namadosen = '$nama', jurusan = '$jurusan' WHERE nidn = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/admin/dosen');
		} else if ($mau_ke == "act_add") {
		
			$cek_user_exist = $this->db->query("SELECT nidn FROM dosen WHERE nidn = '$nidn'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">NIDN Sudah Ada. Ganti yang lain..!</div>");
			} else {
			$this->db->query("INSERT INTO dosen VALUES('$nidn','$nik', '$namadosen',  '$jurusan')");
			$this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");			
			}
			
			redirect('index.php/admin/dosen');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM dosen WHERE nidn = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/admin/dosen');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM dosen ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_dosen";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// DOSEN
	
	/// BUKU
	public function buku() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_buku")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/buku/p");
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


		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$penerbit					= addslashes($this->input->post('penerbit'));
		$isbn					= addslashes($this->input->post('isbn'));
		$halaman					= addslashes($this->input->post('halaman'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/buku';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_buku WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_buku";
		}else if ($mau_ke == "add") {
			$a['page']		= "f_buku";
		}
		else if ($mau_ke == "act_add") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO buku VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn','$halaman','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO buku VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn','$halaman','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/hki');
		}
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/buku');
		}
		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_buku WHERE id=$idu")->result();
			$a['page']		= "f_buku";
		}
		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE buku SET judul='$judul', penerbit='$penerbit', isbn='$isbn',halaman='$halaman',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");


			}else{

				 $query="UPDATE buku SET judul='$judul',  penerbit='$penerbit', isbn='$isbn',halaman='$halaman',keterangan='$keterangan' WHERE id = '$id'";

			$this->db->query($query);
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Di DiUbah</div>");			
			
			} 
			redirect('index.php/admin/buku');  
		} 
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_buku ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_buku";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// BUKU
	
	/// JURNAL
	public function jurnal() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_jurnal")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/jurnal/p");
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
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= addslashes($this->input->post('status'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnal";
		}  else if ($mau_ke == "add") {
			$a['page']		= "f_jurnal";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO jurnal VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO jurnal VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/jurnal');
		}


		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/jurnal');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_jurnal WHERE id=$idu")->result();
			$a['page']		= "f_jurnal";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				
				$this->db->query("UPDATE jurnal SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{

				$query="UPDATE jurnal SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	
			}
				
			redirect('index.php/admin/jurnal');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_jurnal ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnal";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// JURNAL
	/// JURNAL PKM
	public function jurnal_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_jurnalpkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/jurnal_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnal_pkm";
		} 

		else if ($mau_ke == "add") {
			$a['page']		= "f_jurnal_pkm";
		}

		else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/jurnal_pkm');
		}






		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/admin/jurnal_pkm');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE id=$idu")->result();
			$a['page']		= "f_jurnal_pkm";
		}

else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				
				$this->db->query("UPDATE jurnal_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{

				$query="UPDATE jurnal_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	
			}
				
			redirect('index.php/admin/jurnal_pkm');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnal_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// JURNAL PKM
	
	/// PENELITIAN
	public function penelitian() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/penelitian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$anggota_1					= addslashes($this->input->post('anggota_1'));
		$anggota_2					= addslashes($this->input->post('anggota_2'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tm					= addslashes($this->input->post('tm'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi					= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/penelitian';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

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
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL, '$nidn', '$judul', '$anggota_1', '$anggota_2', '$jenis',  '$bidang', '$tm', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL, '$nidn', '$judul', '$anggota_1', '$anggota_2', '$jenis',  '$bidang', '$tm', '$sumber', '$institusi', '$jumlah',  '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/penelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/admin/penelitian');
		}
		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE id=$idu")->result();
			$a['page']		= "f_penelitian";
		}

else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE penelitian SET nidn='$nidn', judul='$judul', anggota_1='$anggota_1', anggota_2='$anggota_2', jenis='$jenis', bidang='$bidang',  tm='$tm', sumber='$sumber',institusi='$institusi', jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				
				$query = "UPDATE penelitian SET nidn='$nidn', judul='$judul', anggota_1='$anggota_1', anggota_2='$anggota_2', jenis='$jenis', bidang='$bidang',  tm='$tm', sumber='$sumber',institusi='$institusi', jumlah='$jumlah', keterangan='$keterangan' WHERE id = '$id'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			redirect('index.php/admin/penelitian');
		}  
		else {

			$a['data']		= $this->db->query("SELECT * FROM v_penelitian ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitian";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// PENELITIAN
	
		/// PENELITIAN PKM
	public function penelitian_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM penelitian_pkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/penelitian_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/penelitian';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnal";
		} 
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/admin/penelitian_pkm');
		}else if ($mau_ke == "edt") {
			$this->db->query("UPDATE penelitian_pkm SET keterangan='$hasilketerangan' WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Di Setujui</div>");			
			redirect('index.php/admin/penelitian_pkm');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitian_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// PENELITIAN PKM
	
	/// SEMINAR
	public function seminar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_seminar")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/seminar/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));

		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_seminar WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_seminar";
		} 

		else if ($mau_ke == "add") {
			$a['page']		= "f_seminar";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/seminar');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM seminar WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Dihapus</div>");			
			redirect('index.php/admin/seminar');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_seminar WHERE id=$idu")->result();
			$a['page']		= "f_seminar";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$this->db->query("UPDATE seminar SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{

				$query="UPDATE seminar SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

			}
						
			redirect('index.php/admin/seminar');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_seminar ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminar";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// SEMINAR
	
	/// SEMINAR PKM
	public function seminar_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_seminarpkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/seminar_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_seminar_pkm";
		} 

		else if ($mau_ke == "add") {
			$a['page']		= "f_seminar_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/seminar_pkm');
		}


		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM seminar_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/seminar_pkm');


		}else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE id=$idu")->result();
			$a['page']		= "f_seminar_pkm";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$this->db->query("UPDATE seminar_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{

				$query="UPDATE seminar_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

			}
						
			redirect('index.php/admin/seminar_pkm');
		}  


	  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminar_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// SEMINAR PKM
	/// BUKU PKM
	public function buku_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_bukupkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/buku_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$penerbit					= addslashes($this->input->post('penerbit'));
		$isbn					= addslashes($this->input->post('isbn'));
		$halaman					= addslashes($this->input->post('halaman'));
		$keterangan				= addslashes($this->input->post('keterangan'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/bukupkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_buku_pkm";
		}

		else if ($mau_ke == "add") {
			$a['page']		= "f_buku_pkm";
		}

		else if ($mau_ke == "act_add") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn','$halaman','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn','$halaman','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/hki');
		}



		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/buku_pkm');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_bukupkm WHERE id=$idu")->result();
			$a['page']		= "f_buku_pkm";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE buku_pkm SET judul='$judul', penerbit='$penerbit', isbn='$isbn',halaman='$halaman',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");


			}else{

				 $query="UPDATE buku_pkm SET judul='$judul',  penerbit='$penerbit', isbn='$isbn',halaman='$halaman',keterangan='$keterangan' WHERE id = '$id'";

			$this->db->query($query);
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Di DiUbah</div>");			
			
			} 
			redirect('index.php/admin/buku_pkm');  
		} 
		
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_buku_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// BUKU PKM
	
	/// PUBLIKASI ILMIAH
	public function publikasi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_publikasi")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/publikasi/p");
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

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * from v_publikasi WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_publikasi";
		}
		else if ($mau_ke == "add") {
			$a['page']		= "f_publikasi";
		}
		else if ($mau_ke == "act_add") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO publikasiilmiah VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO publikasiilmiah VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','','$keterangan)");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/publikasi');
		}
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/admin/publikasi');
		}
		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_publikasi WHERE id=$idu")->result();
			$a['page']		= "f_publikasi";

		}
		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query("UPDATE publikasiilmiah SET judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat',file='$up_data[file_name]', status='$keterangan' WHERE id = '$id'");
			}else{
				$query = "UPDATE publikasiilmiah SET judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat', status='$keterangan' WHERE id = '$id'";

					$this->db->query($query);
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Behasil DiUbah</div>");	
			}
				
			redirect('index.php/admin/publikasi');
		}else {
			$a['data']		= $this->db->query("SELECT * from v_publikasi ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasi";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// PUBLIKASI ILMIAH
	
	/// HKI
	public function hki() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM hki")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/hki/p");
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

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_hki";
		}else if ($mau_ke == "add") {
			$a['page']		= "f_hki";
		}  

		else if ($mau_ke == "act_add") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO hki VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO hki VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/hki');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/hki');

		}else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_hki WHERE id=$idu")->result();
			$a['page']		= "f_hki";
		}

		else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query("UPDATE hki SET judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status',nohki='$nohki',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query = "UPDATE hki SET judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status',nohki='$nohki', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");		
			}
			redirect('index.php/admin/hki');
		}else {
			$a['data']		= $this->db->query("SELECT * FROM v_hki ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hki";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// HKI
	
	/// HKI
	public function hki_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	

		$total_row		= $this->db->query("SELECT * FROM v_hkipkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/hki_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
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

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_hki_pkm";
		}

		else if ($mau_ke == "add") {
			$a['page']		= "f_hki_pkm";
		}  

		else if ($mau_ke == "act_add") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/hki_pkm');
		}



		  else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/hki_pkm');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_hkipkm WHERE id=$idu")->result();
			$a['page']		= "f_hki_pkm";
		}

		else if($mau_ke == "act_edt") {
		if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query("UPDATE hki_pkm SET judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status',nohki='$nohki',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query = "UPDATE hki_pkm SET judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status',nohki='$nohki', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");		
			}
			redirect('index.php/admin/hki_pkm');
		}
		
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_hkipkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hki_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// HKI
	
	/// PUBLIKASI ILMIAH PKM
	public function publikasipkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_publikasipkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/publikasipkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$institusi				= addslashes($this->input->post('institusi'));
		$tempat					= addslashes($this->input->post('tempat'));
		$tanggal					= addslashes($this->input->post('tanggal'));
		$keterangan				= addslashes($this->input->post('status'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/publikasipkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_publikasi_pkm";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_publikasi_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','','$keterangan)");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/publikasipkm');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/publikasipkm');

		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE id=$idu")->result();
			$a['page']		= "f_publikasi_pkm";

		}



		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
			$this->db->query("UPDATE publikasiilmiah_pkm SET judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat',file='$up_data[file_name]', status='$keterangan' WHERE id = '$id'");
			}else{
				$query = "UPDATE publikasiilmiah_pkm SET judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat', status='$keterangan' WHERE id = '$id'";

					$this->db->query($query);
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Behasil DiUbah</div>");	
			}
				
			redirect('index.php/admin/publikasipkm');
		}  
		
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasi_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	/// PUBLIKASI ILMIAH PKM

	
	///DOSEN PUBLIKASI ILMIAH
	public function dosenpublikasi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_publikasi WHERE nidn = $nidn ")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenpublikasi/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$institusi				= addslashes($this->input->post('institusi'));
		$tempat					= addslashes($this->input->post('tempat'));
		$tanggal					= addslashes($this->input->post('tanggal'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/publikasi';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_publikasi WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_publikasidosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_publikasidosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO publikasiilmiah VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO publikasiilmiah VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','','$keterangan)");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenpublikasi');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenpublikasi');
		}else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_publikasi WHERE id=$idu")->result();
			$a['page']		= "f_publikasidosen";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE publikasiilmiah SET nidn='$nidn', judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat',file='$up_data[file_name]', status='$keterangan' WHERE id = '$id'");
			}else{
				
				$query = "UPDATE publikasiilmiah SET nidn='$nidn', judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat', status='$keterangan' WHERE id = '$id'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			redirect('index.php/admin/dosenpublikasi');
		}  
		
		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_publikasi WHERE nidn=$nidn ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasidosen";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN PUBLIKASI ILMIAH
	
	///DOSEN PUBLIKASI ILMIAH PKM
	public function dosenpublikasipkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenpublikasipkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$institusi				= addslashes($this->input->post('institusi'));
		$tempat					= addslashes($this->input->post('tempat'));
		$tanggal					= addslashes($this->input->post('tanggal'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/publikasipkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_publikasidosen_pkm";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_publikasidosen_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','','$keterangan)");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenpublikasipkm');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenpublikasipkm');
		}
		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE id=$idu")->result();
			$a['page']		= "f_publikasidosen_pkm";

		}else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE publikasiilmiah_pkm SET nidn='$nidn', judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat',file='$up_data[file_name]', status='$keterangan' WHERE id = '$id'");
			}else{
				
				$query = "UPDATE publikasiilmiah_pkm SET nidn='$nidn', judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat', status='$keterangan' WHERE id = '$id'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			redirect('index.php/admin/dosenpublikasipkm');
		}  
		
		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasidosen_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN PUBLIKASI ILMIAH PKM
	
	///DOSEN HKI
	public function dosenhki() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_hki WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenhki/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$nomorpendaftaran		= addslashes($this->input->post('nomorpendaftaran'));
		$status					= addslashes($this->input->post('status'));
		$nohki					= addslashes($this->input->post('nohki'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/hki';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_hkidosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_hkidosen";
		} else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO hki VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO hki VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','','$keterangan)");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Disimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenhki');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/admin/dosenhki');
		}else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_hki WHERE id=$idu")->result();
			$a['page']		= "f_hkidosen";

		}else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE hki SET nidn='$nidn', judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki',file='$up_data[file_name]', status='$status', keterangan='$keterangan' WHERE id = '$id'");
			}else{	
				$query="UPDATE hki SET nidn='$nidn', judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki', status='$status', keterangan='$keterangan' WHERE id = '$id'";
		
			$this->db->query($query);
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Diubah </div>");	
			}		
			redirect('index.php/admin/dosenhki');
		
		}

		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hkidosen";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN HKI
	
	///DOSEN HKI PKM
	public function dosenhki_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenhki_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$nomorpendaftaran		= addslashes($this->input->post('nomorpendaftaran'));
		$status					= addslashes($this->input->post('status'));
		$nohki					= addslashes($this->input->post('nohki'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/hkipkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_hkidosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_hkidosen_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenhki_pkm');
		}
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/admin/dosenhki_pkm');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_hkipkm WHERE id=$idu")->result();
			$a['page']		= "f_hkidosen_pkm";

		}
		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE hki_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki',file='$up_data[file_name]', status='$status', keterangan='$keterangan' WHERE id = '$id'");
			}else{	
				$query="UPDATE hki_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki', status='$status', keterangan='$keterangan' WHERE id = '$id'";
		
			$this->db->query($query);
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Diubah </div>");	
			}		
			redirect('index.php/admin/dosenhki_pkm');
		}else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hkidosen_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN HKI PKM
	
	///DOSEN BUKU
	public function dosenbuku() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');
		$total_row		= $this->db->query("SELECT * FROM v_buku WHERE nidn = $nidn ")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenbuku/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$penerbit					= addslashes($this->input->post('penerbit'));
		$isbn					= addslashes($this->input->post('isbn'));
		$halaman					= addslashes($this->input->post('halaman'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/buku';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);

		$nidn = $this->session->userdata('admin_nip');
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_buku WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_bukudosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_bukudosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO buku VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO buku VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenbuku');

		}else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenbuku');

		}else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_buku WHERE id=$idu")->result();
			$a['page']		= "f_bukudosen";

		} else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE buku SET nidn='$nidn', judul='$judul', penerbit='$penerbit', isbn='$isbn', halaman='$halaman',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE buku SET nidn='$nidn', judul='$judul', penerbit='$penerbit', isbn='$isbn', halaman='$halaman',keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");
			}
			redirect('index.php/admin/dosenbuku');
		}

		else {
			$nidn = $this->session->userdata('admin_nip');
			$a['data']		= $this->db->query("SELECT * FROM v_buku WHERE nidn = $nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_bukudosen";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN BUKU
	
	///DOSEN BUKU PKM
	public function dosenbuku_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenbuku_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$penerbit					= addslashes($this->input->post('penerbit'));
		$isbn					= addslashes($this->input->post('isbn'));
		$halaman					= addslashes($this->input->post('halaman'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/bukupkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_bukudosen_pkm";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_bukudosen_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenbuku_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenbuku_pkm');

		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_bukupkm WHERE id=$idu")->result();
			$a['page']		= "f_bukudosen_pkm";

		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE buku_pkm SET nidn='$nidn', judul='$judul', penerbit='$penerbit', isbn='$isbn', halaman='$halaman',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE buku_pkm SET nidn='$nidn', judul='$judul', penerbit='$penerbit', isbn='$isbn', halaman='$halaman',keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");
			}
			redirect('index.php/admin/dosenbuku_pkm');
		}

		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_bukudosen_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN BUKU PKM
	
	///DOSEN JURNAL
	public function dosenjurnal() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenjurnal/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnaldosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_jurnaldosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO jurnal VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO jurnal VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenjurnal');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenjurnal');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_jurnal WHERE id=$idu")->result();
			$a['page']		= "f_jurnaldosen";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE jurnal SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
				
			}else{
				$query="UPDATE jurnal SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

				redirect('index.php/admin/dosenjurnal');
			}
		}

		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnaldosen";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN JURNAL
	
	///DOSEN JURNAL PKM
	public function dosenjurnal_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');
		$total_row		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenjurnal_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnalpkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnaldosen_pkm";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_jurnaldosen_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenjurnal_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenjurnal_pkm');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE id=$idu")->result();
			$a['page']		= "f_jurnaldosen_pkm";
		}
		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE jurnal_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
				
			}else{
				$query="UPDATE jurnal_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

				redirect('index.php/admin/dosenjurnal_pkm');
			}
		}


		else {
			$nidn = $this->session->userdata('admin_nip');
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnaldosen_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN JURNAL PKM
	
	///DOSEN SEMINAR
	public function dosenseminar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_seminar WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenseminar/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/seminar';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_seminar WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_seminardosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_seminardosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenseminar');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_seminar WHERE id=$idu")->result();
			$a['page']		= "f_seminardosen";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE seminar SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE seminar SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

				redirect('index.php/admin/dosenseminar');
			}
		}

		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_seminar WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminardosen";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN SEMINAR
	
	///DOSEN SEMINAR PKM
	public function dosenseminar_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenseminar_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$jenis					= addslashes($this->input->post('jenis'));
		$penulis_2					= addslashes($this->input->post('penulis_2'));
		$penulis_3					= addslashes($this->input->post('penulis_3'));
		$jurnal					= addslashes($this->input->post('jurnal'));
		$issn					= addslashes($this->input->post('issn'));
		$volume					= addslashes($this->input->post('volume'));
		$nomor					= addslashes($this->input->post('nomor'));
		$halaman					= addslashes($this->input->post('halaman'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		$config['upload_path'] 		= './upload/seminar';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_seminardosen_pkm";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_seminardosen_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenseminar_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM seminar_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenseminar_pkm');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE id=$idu")->result();
			$a['page']		= "f_seminardosen_pkm";
		}

		else if ($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE seminar_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE seminar_pkm SET nidn='$nidn', judul='$judul', jenis='$jenis', penulis_2='$penulis_2', penulis_3='$penulis_3',jurnal='$jurnal',issn='$issn',volume='$volume',no='$nomor',halaman='$halaman',url='$url', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

				redirect('index.php/admin/dosenseminar_pkm');
			}
		}



		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminardosen_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN SEMINAR PKM
	
	///DOSEN PENELITIAN
	public function dosenpenelitian() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenpenelitian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$anggota_1					= addslashes($this->input->post('anggota_1'));
		$anggota_2					= addslashes($this->input->post('anggota_2'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tm					= addslashes($this->input->post('tm'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi					= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/penelitian';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL, '$nidn', '$judul', '$anggota_1', '$anggota_2', '$jenis',  '$bidang', '$tm', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL, '$nidn', '$judul', '$anggota_1', '$anggota_2', '$jenis',  '$bidang', '$tm', '$sumber', '$institusi', '$jumlah',  '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenpenelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/admin/dosenpenelitian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE id=$idu")->result();
			$a['page']		= "f_penelitiandosen";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE penelitian SET nidn='$nidn', judul='$judul', anggota_1='$anggota_1', anggota_2='$anggota_2', jenis='$jenis', bidang='$bidang',  tm='$tm', sumber='$sumber',institusi='$institusi', jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				
				$query = "UPDATE penelitian SET nidn='$nidn', judul='$judul', anggota_1='$anggota_1', anggota_2='$anggota_2', jenis='$jenis', bidang='$bidang',  tm='$tm', sumber='$sumber',institusi='$institusi', jumlah='$jumlah', keterangan='$keterangan' WHERE id = '$id'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			redirect('index.php/admin/dosenpenelitian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitiandosen";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN PENELITIAN
	
	///DOSEN PENELITIAN PKM
	public function dosenpenelitian_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/admin/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM penelitian_pkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/admin/dosenpenelitian_pkm/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$anggota_1					= addslashes($this->input->post('anggota_1'));
		$anggota_2					= addslashes($this->input->post('anggota_2'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tm					= addslashes($this->input->post('tm'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi					= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
		$url					= addslashes($this->input->post('url'));
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/penelitian_pkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '100000';
		$config['max_width']  		= '130000';
		$config['max_height'] 		= '130000';

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosen_pkm";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian_pkm VALUES (NULL, '$nidn', '$judul', '$anggota_1', '$anggota_2', '$jenis',  '$bidang', '$tm', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan')");
			} else {
				$this->db->query("INSERT INTO penelitian_pkm VALUES (NULL, '$nidn', '$judul', '$anggota_1', '$anggota_2', '$jenis',  '$bidang', '$tm', '$sumber', '$institusi', '$jumlah',  '','$keterangan')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/admin/dosenpenelitian_pkm');
		}
		else {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitiandosen_pkm";
		}
		
		$this->load->view('admin/aaa', $a);
	}
	///DOSEN PENELITIAN PKM
}
