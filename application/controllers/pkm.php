<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pkm extends CI_Controller {
	function __construct() {	
		parent::__construct();
		// $this->load->library('Pdf');
		$this->load->library('digipdf');

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
			redirect("index.php/pkm/login");
		}
		
		// $q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$u."' AND password = '".$p."'");
		// $j_cek	= $q_cek->num_rows();
		// $d_cek	= $q_cek->row();

		$a['page']	= "d_amain";
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		$this->load->view('pkm/l_pkm', $a);
	}

	// LOGIN
	public function login() {
		$this->load->view('pkm/login_pkm');
	}
	// LOGIN
	
	//// PENGGUNA
	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
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
			redirect('index.php/pkm/pengguna');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('pkm/l_pkm', $a);	
	}
	//// PENGGUNA
	
	/// TAMBAH PENGGUNA	
	public function manage_admin() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
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
		$nama					= addslashes($this->input->post('namauser'));
		$nip					= addslashes($this->input->post('nip'));
		$level					= addslashes($this->input->post('level'));
		
		$cari					= addslashes($this->input->post('q'));

		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM t_admin WHERE iduser = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted </div>");
			redirect('index.php/pkm/manage_admin');
		} else if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM t_admin WHERE namauser='$nama' LIKE '%$cari%' ORDER BY iduser DESC")->result();
			$a['page']		= "l_manage_admin";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "edt") {
			$a['datpil']	= $this->db->query("SELECT * FROM t_admin WHERE iduser = '$idu'")->row();	
			$a['page']		= "f_manage_admin";
		} else if ($mau_ke == "del") {
			$a['datpil']	= $this->db->query("DELETE FROM t_admin WHERE iduser = '$idu'")->row();	
			
			redirect('index.php/pkm/manage_admin');
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
			
			redirect('index.php/pkm/manage_admin');
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
			
			redirect('index.php/pkm/manage_admin');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM t_admin LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_manage_admin";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// TAMBAH PENGGUNA

	/// UBAH PASSWORD	
	public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		$ke				= $this->uri->segment(3);
		$id_user		= $this->session->userdata('admin_id');
		
		//var post
		$p1				= md5($this->input->post('p1'));
		$p2				= md5($this->input->post('p2'));
		$p3				= md5($this->input->post('p3'));
		
		if ($ke == "simpan") {
			$cek_password_lama	= $this->db->query("SELECT password FROM dosen WHERE id = $id_user")->row();
			//echo 
			
			if ($cek_password_lama->password != $p1) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Lama tidak sama</div>');
				redirect('index.php/pkm/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('index.php/pkm/passwod');
			} else {
				$this->db->query("UPDATE dosen SET password = '$p3' WHERE id = ".$id_user."");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('index.php/pkm/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('pkm/l_pkm', $a);
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
				redirect('index.php/pkm/login');
			}
            $data = array(
                    'admin_id' => $d_cek->id,
                    'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->namadosen,
                    'admin_nip' => $d_cek->nip,
                    'admin_level' => $d_cek->level,
                    'admin_status' => $d_cek->status,
					'admin_valid' => true
                    );
				$this->session->set_userdata($data);
				redirect('index.php/pkm');
				
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('index.php/pkm/login');
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
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM dosen")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/dosen/p");
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
		$fakultas				= addslashes($this->input->post('Fakultas'));
		$jurusan				= addslashes($this->input->post('jurusan'));
		
		$level 					= addslashes($this->input->post('level'));
		$password				= md5(addslashes($this->input->post('password')));
		
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
			$this->db->query("UPDATE dosen SET namadosen = '$namadosen', jurusan = '$jurusan',Fakultas='$fakultas',level='$level',  password='$password' WHERE nidn = '$nidn'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been updated</div>");			
			redirect('index.php/pkm/dosen');
		} else if ($mau_ke == "act_add") {
		
			$cek_user_exist = $this->db->query("SELECT nidn FROM dosen WHERE nidn = '$nidn'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">NIDN Sudah Ada. Ganti yang lain..!</div>");
			} else {

			$this->db->query("INSERT INTO dosen VALUES('$nidn','$nik', '$namadosen',  '$jurusan','$fakultas','$level','$password')");
			// $this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");			
			}
			
			redirect('index.php/pkm/dosen');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM dosen WHERE nidn = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/pkm/dosen');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM dosen ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_dosen";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// DOSEN
	
	/// BUKU
	
	
	/// JURNAL PKM
	public function jurnal_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_jurnalpkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/jurnal_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');
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
				
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/jurnal_pkm');
		}






		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/pkm/jurnal_pkm');
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
				
			redirect('index.php/pkm/jurnal_pkm');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnal_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// JURNAL PKM
	

	
		/// PENELITIAN PKM
	public function penelitian_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM penelitian_pkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/penelitian_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnal";
		} 
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/pkm/penelitian_pkm');
		}else if ($mau_ke == "edt") {
			$this->db->query("UPDATE penelitian_pkm SET keterangan='$hasilketerangan' WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Di Setujui</div>");			
			redirect('index.php/pkm/penelitian_pkm');
		}  
		else {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitian_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// PENELITIAN PKM
	
	
	
	/// SEMINAR PKM
	public function seminar_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_seminarpkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/seminar_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');
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
				
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url', '','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/seminar_pkm');
		}


		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM seminar_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/seminar_pkm');


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
						
			redirect('index.php/pkm/seminar_pkm');
		}  


	  
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminar_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// SEMINAR PKM
	/// BUKU PKM
	public function buku_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_bukupkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/buku_pkm/p");
		
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
		$date = date('Y-m-d H:i:s');
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
				
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn','$halaman','".$up_data['file_name']."','$keterangan','$date')");
			} else {
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn','$halaman','$keterangan','$date')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/buku_pkm');
		}



		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/buku_pkm');
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
			redirect('index.php/pkm/buku_pkm');  
		} 
		
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_buku_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// BUKU PKM
	
	/// HKI
	public function hki_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	

		$total_row		= $this->db->query("SELECT * FROM v_hkipkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/hki_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');
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
				
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran','$status', '$nohki','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/hki_pkm');
		}



		  else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/hki_pkm');
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
			redirect('index.php/pkm/hki_pkm');
		}
		
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_hkipkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hki_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// HKI
	
	/// PUBLIKASI ILMIAH PKM
	public function publikasipkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM v_publikasipkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/publikasipkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn LIKE '%$cari%' OR judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_publikasi_pkm";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_publikasi_pkm";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/publikasipkm');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/publikasipkm');

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
				
			redirect('index.php/pkm/publikasipkm');
		}  
		
		else {
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasi_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// PUBLIKASI ILMIAH PKM

	///DOSEN PUBLIKASI ILMIAH PKM
	public function dosenpublikasipkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/dosenpublikasipkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');
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
				
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL, '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/dosenpublikasipkm');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/dosenpublikasipkm');
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
			redirect('index.php/pkm/dosenpublikasipkm');
		}  
		
		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasidosen_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	///DOSEN PUBLIKASI ILMIAH PKM
	
	///DOSEN HKI PKM
	public function dosenhki_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/dosenhki_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');

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
				
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/dosenhki_pkm');
		}
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/pkm/dosenhki_pkm');
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
			redirect('index.php/pkm/dosenhki_pkm');
		}else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hkidosen_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	///DOSEN HKI PKM
		
	///DOSEN BUKU PKM
	public function dosenbuku_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/dosenbuku_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');		

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
				
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/dosenbuku_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/dosenbuku_pkm');

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
			redirect('index.php/pkm/dosenbuku_pkm');
		}

		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_bukudosen_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	///DOSEN BUKU PKM
	
	
	
	///DOSEN JURNAL PKM
	public function dosenjurnal_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');
		$total_row		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/dosenjurnal_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');

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
				
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan',$tanggal)");
			} else {
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','$keterangan',$tanggal)");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/dosenjurnal_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/dosenjurnal_pkm');
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

				redirect('index.php/pkm/dosenjurnal_pkm');
			}
		}


		else {
			$nidn = $this->session->userdata('admin_nip');
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnaldosen_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	///DOSEN JURNAL PKM
	
	
	
	///DOSEN SEMINAR PKM
	public function dosenseminar_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nip');	
		$total_row		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn=$nidn")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/dosenseminar_pkm/p");
		
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
		$tanggal = date('Y-m-d H:i:s');

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
				
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$nidn', '$judul', '$jenis', '$penulis_2', '$penulis_3',  '$jurnal', '$issn', '$volume', '$nomor', '$halaman', '$url','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/dosenseminar_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM seminar_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/dosenseminar_pkm');
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

				redirect('index.php/pkm/dosenseminar_pkm');
			}
		}



		else {
			$nidn = $this->session->userdata('admin_nip');	
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminardosen_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	///DOSEN SEMINAR PKM
	
	
	
	///DOSEN PENELITIAN PKM
	public function dosenpenelitian_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM penelitian_pkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/dosenpenelitian_pkm/p");
		
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
			
			redirect('index.php/pkm/dosenpenelitian_pkm');
		}
		else {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitiandosen_pkm";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	///DOSEN PENELITIAN PKM
}
