<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dosen extends CI_Controller {
	function __construct() {
		parent::__construct();
		// $this->load->library('Pdf');
		$this->load->library('digipdf');

	}
	
	public function index() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		// $q_cek	= $this->db->query("SELECT * FROM t_admin WHERE username = '".$u."' AND password = '".$p."'");
		// $j_cek	= $q_cek->num_rows();
		// $d_cek	= $q_cek->row();

		$a['page']	= "d_amain";
		$a += array(
			'nama'=> $this->session->userdata('admin_nama'),
			'id'=> $this->session->userdata('admin_id'),
		);
		$this->load->view('dosen/aaa', $a);
	}

	// LOGIN
	public function login() {
		$this->load->view('dosen/login');
	}
	// LOGIN
	
	//// PENGGUNA
	public function pengguna() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
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
			redirect('index.php/dosen/pengguna');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM tr_instansi WHERE id = '1' LIMIT 1")->row();
			$a['page']		= "f_pengguna";
		}
		
		$this->load->view('dosen/aaa', $a);	
	}
	//// PENGGUNA
	
	/// TAMBAH PENGGUNA	
	/// UBAH PASSWORD	
	public function passwod() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
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
				redirect('index.php/dosen/passwod');
			} else if ($p2 != $p3) {
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-error">Password Baru 1 dan 2 tidak cocok</div>');
				redirect('index.php/dosen/passwod');
			} else {
				$this->db->query("UPDATE t_admin SET password = '$p3' WHERE id = ".$id_user."");
				$this->session->set_flashdata('k_passwod', '<div id="alert" class="alert alert-success">Password berhasil diperbaharui</div>');
				redirect('index.php/dosen/passwod');
			}
		} else {
			$a['page']	= "f_passwod";
		}
		
		$this->load->view('dosen/aaa', $a);
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
		
		// die("SELECT * FROM dosen WHERE nidn = '".$u."' AND passwor d = '".$p."'");
        if($j_cek == 1) {
        	if (strtolower($d_cek->level) != 'dosen') {
	        	$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
				redirect('index.php/dosen/login');
			}
            $data = array(
                    // 'admin_id' => $d_cek->id,
                    // 'admin_user' => $d_cek->username,
                    'admin_nama' => $d_cek->namadosen,
                    'admin_nidn' => $d_cek->nidn,
                    'admin_level' => $d_cek->level,
                    'admin_status' => $d_cek->status,
					'admin_valid' => true
                    );
				$this->session->set_userdata($data);
				redirect('index.php/dosen');
				
        } else {	
			$this->session->set_flashdata("k", "<div id=\"alert\" class=\"alert alert-error\">username or password is not valid</div>");
			redirect('index.php/dosen/login');
		}
	}
	// CEK LOGIN
	
	// LOGOUT
	public function logout(){
        $this->session->sess_destroy();
		redirect('index.php/dosen/login');
    }
	// LOGOUT
	/// DOSEN
	///DOSEN PUBLIKASI ILMIAH
	public function dosenpublikasi() {
		//if(empty($id)){
			if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
				redirect("index.php/dosen/login");
			}
			
			/* pagination */
			$nidn = $this->session->userdata('admin_nidn');	
			$total_row		= $this->db->query("SELECT * FROM v_publikasi1 WHERE nidn = '$nidn' ")->num_rows();
			$per_page		= 10;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;
			
			$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpublikasi/p");
			
			//ambil variabel URL
			$mau_ke					= $this->uri->segment(3);
			$idu					= $this->uri->segment(4);
			
			$cari					= addslashes($this->input->post('q'));

			//ambil variabel Postingan
			$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
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
			$date = date('Y-m-d H:i:s');
			$this->load->library('upload', $config);
			
			if ($mau_ke == "cari") {
				$nidn = $this->session->userdata('admin_nidn');	
				$a['data']		= $this->db->query("SELECT * FROM v_publikasi1 WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
				$a['page']		= "l_publikasidosen";
			} else if ($mau_ke == "add") {
				$where['idpenelitian'] = $this->session->userdata('idpenelitian');
				$a['data']	= $this->db->get_where("penelitian",$where);
				$a['page']		= "f_publikasidosen";
			}  else if ($mau_ke == "act_add") {
				$idp = $this->input->post('idp');
				if ($this->upload->do_upload('file_surat')) {
					$up_data	 	= $this->upload->data();
					
					
					$this->db->query("INSERT INTO publikasiilmiah VALUES (NULL,'$idp', '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$keterangan','$date')");
				} else {
					$this->db->query("INSERT INTO publikasiilmiah VALUES (NULL,'$idp', '$nidn', '$judul', '$institusi', '$tanggal', '$tempat','$keterangan','$date')");
				}	
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan. ".$this->upload->display_errors()."</div>");
				
				redirect('index.php/dosen/detail_publikasi/'.$this->input->post('idp'));

			} else if ($mau_ke == "del") {

				$where['idpenelitian'] = $this->session->userdata('idpenelitian');
				$a['data']	= $this->db->get_where("penelitian",$where);
				$idp = $this->session->userdata('idpenelitian');

				$this->db->query("DELETE FROM publikasiilmiah WHERE id = '$idu'");
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");	

				redirect('index.php/dosen/detail_publikasi/'.$idp);

			}else if ($mau_ke == "edt") {
				$where['idpenelitian'] = $this->session->userdata('idpenelitian');
				$a['data']	= $this->db->get_where("penelitian",$where);
				$a['datpil']		= $this->db->query("SELECT * FROM v_publikasi1 WHERE id=$idu")->result();
				$a['page']		= "f_publikasidosen";

			} else if($mau_ke == "act_edt") {
				$idp = $this->input->post('idp');
				if ($this->upload->do_upload('file_surat')) {
					$up_data	 	= $this->upload->data();
					
					
					$this->db->query("UPDATE publikasiilmiah SET idpenelitian='$idp',nidn='$nidn', judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat',file='$up_data[file_name]', status='$keterangan' WHERE id = '$id'");
				}else{
					
					$query = "UPDATE publikasiilmiah SET idpenelitian='$idp', nidn='$nidn', judul='$judul', institusi='$institusi', tanggal='$tanggal', tempat='$tempat', status='$keterangan' WHERE id = '$id'";
					
					$this->db->query($query);
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
				}
				redirect('index.php/dosen/detail_publikasi/'.$this->input->post('idp'));
			}  
			
			// else {
			// 	$nidn = $this->session->userdata('admin_nidn');
			// 	$a['data']= $this->db->query("SELECT * FROM v_publikasi1 WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			// 	$x=$this->db->query("SELECT * FROM v_publikasi1 WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			// 	var_dump($id);
			// 	$a['page']		= "l_publikasidosen";
			// }
		
		$this->load->view('dosen/aaa', $a);
	}

	public function detail_publikasi($id){
		if(isset($id) && !empty($id)){
			$sess['idpenelitian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data']= $this->db->query("SELECT * FROM v_publikasi1 WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			$x=$this->db->query("SELECT * FROM v_publikasi1 WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			var_dump($id);
			$a['page']		= "l_publikasidosen";
			$this->load->view('dosen/aaa', $a);
		}
	}
	///DOSEN PUBLIKASI ILMIAH
	
	///DOSEN PUBLIKASI ILMIAH PKM
	public function dosenpublikasipkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpublikasipkm/p");
		
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
			$nidn = $this->session->userdata('admin_nidn');	
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
			
			redirect('index.php/dosen/dosenpublikasipkm');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM publikasiilmiah_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenpublikasipkm');
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
			redirect('index.php/dosen/dosenpublikasipkm');
		}  
		
		else {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_publikasidosen_pkm";
		}
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN PUBLIKASI ILMIAH PKM
	
	///DOSEN HKI
	public function dosenhki() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_hki WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenhki/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
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
		$tanggal = date('Y-m-d H:i:s');

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_hkidosen";
		} else if ($mau_ke == "add") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$a['page']		= "f_hkidosen";
		} else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO hki VALUES (NULL,'$idp', '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','".$up_data['file_name']."','$keterangan',$tanggal)");
			} else {
				$this->db->query("INSERT INTO hki VALUES (NULL,'$idp', '$nidn', '$judul', '$jenis', '$nomorpendaftaran', '$status', '$nohki','','$keterangan',$tanggal)");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Disimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/detail_hki/'.$this->input->post('idp'));

		} else if ($mau_ke == "del") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$idp = $this->session->userdata('idpenelitian');

			$this->db->query("DELETE FROM hki WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");

			redirect('index.php/dosen/detail_hki/'.$idp);

		}else if ($mau_ke == "edt") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$a['datpil']		= $this->db->query("SELECT * FROM v_hki WHERE id=$idu")->result();
			$a['page']		= "f_hkidosen";

		}else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE hki SET idpenelitian='$idp', nidn='$nidn', judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki',file='$up_data[file_name]', status='$status', keterangan='$keterangan' WHERE id = '$id'");
			}else{	
				$query="UPDATE hki SET idpenelitian='$idp', nidn='$nidn', judul='$judul', jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki', status='$status', keterangan='$keterangan' WHERE id = '$id'";
		
			$this->db->query($query);
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Diubah </div>");	
			}		

			redirect('index.php/dosen/detail_hki/'.$this->input->post('idp'));
		
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');	
		// 	$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_hkidosen";
		// }
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN HKI
	
	public function detail_hki($id){
		if(isset($id) && !empty($id)){
			$sess['idpenelitian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data']= $this->db->query("SELECT * FROM v_hki WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			$x=$this->db->query("SELECT * FROM v_hki WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			var_dump($id);
			$a['page']		= "l_hkidosen";
			$this->load->view('dosen/aaa', $a);
		}
	}


	///DOSEN HKI PKM
	public function dosenhki_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenhki_pkm/p");
		
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
			$nidn = $this->session->userdata('admin_nidn');	
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
			
			redirect('index.php/dosen/dosenhki_pkm');
		}
		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM hki_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");			
			redirect('index.php/dosen/dosenhki_pkm');
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
			redirect('index.php/dosen/dosenhki_pkm');
		}else {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_hkidosen_pkm";
		}
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN HKI PKM
	
	///DOSEN BUKU
	public function dosenbuku() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');
		$total_row		= $this->db->query("SELECT * FROM v_buku WHERE nidn = $nidn ")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenbuku/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 			= addslashes($this->input->post('idpenelitian'));
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
		$tanggal = date('Y-m-d H:i:s');

		$this->load->library('upload', $config);

		$nidn = $this->session->userdata('admin_nidn');
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_buku WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_bukudosen";
		} else if ($mau_ke == "add") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$a['page']		= "f_bukudosen";
		}  else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO buku VALUES (NULL,'$idp', '$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO buku VALUES (NULL, '$idp','$nidn', '$judul', '$penerbit', '$isbn', '$halaman', '','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/detail_buku/'.$this->input->post('idp'));

		}else if ($mau_ke == "del") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$idp = $this->session->userdata('idpenelitian');

			$this->db->query("DELETE FROM buku WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");	

			redirect('index.php/dosen/detail_buku/'.$idp);

		}else if ($mau_ke == "edt") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$a['datpil']		= $this->db->query("SELECT * FROM v_buku WHERE id=$idu")->result();
			$a['page']		= "f_bukudosen";

		} else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE buku SET idpenelitian='$idp',nidn='$nidn', judul='$judul', penerbit='$penerbit', isbn='$isbn', halaman='$halaman',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE buku SET idpenelitian='$idp',nidn='$nidn', judul='$judul', penerbit='$penerbit', isbn='$isbn', halaman='$halaman',keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");
			}
			redirect('index.php/dosen/detail_buku/'.$this->input->post('idp'));
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');
		// 	$a['data']		= $this->db->query("SELECT * FROM v_buku WHERE nidn = $nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_bukudosen";
		// }
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN BUKU
	

	public function detail_buku($id){
			if(isset($id) && !empty($id)){
				$sess['idpenelitian'] = $id;
				$this->session->set_userdata($sess);
				$nidn = $this->session->userdata('admin_nidn');
				$a['data']= $this->db->query("SELECT * FROM v_buku WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
				$x=$this->db->query("SELECT * FROM v_buku WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
				var_dump($id);
				$a['page']		= "l_bukudosen";
				$this->load->view('dosen/aaa', $a);
			}
		}


	///DOSEN BUKU PKM
	public function dosenbuku_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenbuku_pkm/p");
		
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
			$nidn = $this->session->userdata('admin_nidn');	
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
			
			redirect('index.php/dosen/dosenbuku_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM buku_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenbuku_pkm');

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
			redirect('index.php/dosen/dosenbuku_pkm');
		}

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_bukudosen_pkm";
		}
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN BUKU PKM
	
	///DOSEN JURNAL
	public function dosenjurnal() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenjurnal/p");
		
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
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/jurnal';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '5120';
		// $config['max_width']  		= '13000';
		// $config['max_height'] 		= '13000';
		$tanggal = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnaldosen";
		} else if ($mau_ke == "add") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$a['page']		= "f_jurnaldosen";
		}  else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO jurnal VALUES (NULL,'$idp', '$nidn', '$judul','$namajurnal',
				 '$jenis', '$peranpenulis', '$tahun','$volume', '$nomor', '$url', '$issn', '".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO jurnal VALUES (NULL, '$idp', '$nidn', '$judul','$namajurnal',
				'$jenis', '$peranpenulis', '$tahun','$volume', '$nomor', '$url', '$issn','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/detail_jurnal/'.$this->input->post('idp'));
		}

		else if ($mau_ke == "del") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$idp = $this->session->userdata('idpenelitian');

			$this->db->query("DELETE FROM jurnal WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			
			redirect('index.php/dosen/detail_jurnal/'.$idp);
		}

		else if ($mau_ke == "edt") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$a['datpil']		= $this->db->query("SELECT * FROM v_jurnal WHERE id='$idu'")->result();
			$a['page']		= "f_jurnaldosen";
		}

		else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				// die(print_r($up_data));
				$query = "UPDATE jurnal SET idpenelitian='$idp',nidn='$nidn', judul='$judul', 
				namajurnal='$namajurnal',jenis='$jenis',peranpenulis='$peranpenulis',tahun='$tahun',
				volume='$volume',no='$nomor',url='$url',issn='$issn',file='$up_data[file_name]', 
				keterangan='$keterangan' WHERE id = '$id'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");
			}else{
				// die('blah');
				$query = "UPDATE jurnal SET idpenelitian='$idp',nidn='$nidn', judul='$judul', 
				namajurnal='$namajurnal',jenis='$jenis',peranpenulis='$peranpenulis',tahun='$tahun',
				volume='$volume',no='$nomor',url='$url',issn='$issn',
				keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	
			}
			redirect('index.php/dosen/detail_jurnal/'.$this->input->post('idp'));
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');	
		// 	$a['data']		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_jurnaldosen";
		// }
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN JURNAL
	
	public function detail_jurnal($id){
		if(isset($id) && !empty($id)){
			$sess['idpenelitian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data']= $this->db->query("SELECT * FROM v_jurnal WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			$x=$this->db->query("SELECT * FROM v_jurnal WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			var_dump($id);
			$a['page']		= "l_jurnaldosen";
			$this->load->view('dosen/aaa', $a);
		}
	}


	///DOSEN JURNAL PKM
	public function dosenjurnal_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');
		$total_row		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenjurnal_pkm/p");
		
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
			$nidn = $this->session->userdata('admin_nidn');
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
			
			redirect('index.php/dosen/dosenjurnal_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurnal_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenjurnal_pkm');
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

				redirect('index.php/dosen/dosenjurnal_pkm');
			}
		}


		else {
			$nidn = $this->session->userdata('admin_nidn');
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurnaldosen_pkm";
		}
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN JURNAL PKM
	
	///DOSEN SEMINAR
	public function dosenseminar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_seminar WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenseminar/p");
		
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
		$keterangan				= "Menunggu Verifikasi";
		$hasilketerangan		= "Disetujui";
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/seminar';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$tanggal = date('Y-m-d H:i:s');

		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_seminar WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_seminardosen";
		} else if ($mau_ke == "add") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$a['page']	= "f_seminardosen";
		}  else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$idp','$nidn', '$judul', 
				'$tahunprosiding', '$peranpenulis','$volume', '$nomor', '$isbn',
				 '$url', '$jenisprosiding','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO seminar VALUES (NULL, '$idp','$nidn', '$judul', 
				'$tahunprosiding',  '$peranpenulis','$volume', '$nomor', '$isbn',
				 '$url', '$jenisprosiding','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data 
			Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/detail_seminar/'.$this->input->post('idp'));
		} else if ($mau_ke == "del") {

			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
			$a['data']	= $this->db->get_where("penelitian",$where);
			$idp = $this->session->userdata('idpenelitian');

			$this->db->query("DELETE FROM seminar WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");	

			redirect('index.php/dosen/detail_seminar/'.$idp);

		}

		else if ($mau_ke == "edt") {
			$where['idpenelitian'] = $this->session->userdata('idpenelitian');
				$a['data']	= $this->db->get_where("penelitian",$where);
			$a['datpil']		= $this->db->query("SELECT * FROM v_seminar WHERE id=$idu")->result();
			$a['page']		= "f_seminardosen";
		}

		else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE seminar SET idpenelitian='$idp', nidn='$nidn', namaprosiding='$judul', 
				tahunprosiding='$tahunprosiding',peranpenulis='$peranpenulis',
				volume='$volume',no='$nomor',isbn='$isbn',url='$url',
				jenisprosiding='$jenisprosiding',file='$up_data[file_name]', 
				keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE seminar SET idpenelitian='$idp', nidn='$nidn', namaprosiding='$judul',
				 tahunprosiding='$tahunprosiding',peranpenulis='$peranpenulis',
				 volume='$volume',no='$nomor',isbn='$isbn',url='$url',
				 jenisprosiding='$jenisprosiding', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	

			}

			redirect('index.php/dosen/detail_seminar/'.$this->input->post('idp'));
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');	
		// 	$a['data']		= $this->db->query("SELECT * FROM v_seminar WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_seminardosen";
		// }
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN SEMINAR
	
	public function detail_seminar($id){
		if(isset($id) && !empty($id)){
			$sess['idpenelitian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data']= $this->db->query("SELECT * FROM v_seminar WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			$x=$this->db->query("SELECT * FROM v_seminar WHERE nidn='$nidn' and idpenelitian='$id' ORDER BY nidn DESC  ")->result();
			var_dump($id);
			$a['page']		= "l_seminardosen";
			$this->load->view('dosen/aaa', $a);
		}
	}

	///DOSEN SEMINAR PKM
	public function dosenseminar_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenseminar_pkm/p");
		
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
			$nidn = $this->session->userdata('admin_nidn');	
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
			
			redirect('index.php/dosen/dosenseminar_pkm');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM seminar_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenseminar_pkm');
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

				redirect('index.php/dosen/dosenseminar_pkm');
			}
		}



		else {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_seminardosen_pkm";
		}
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN SEMINAR PKM
	
	///DOSEN PENELITIAN
	public function dosenpenelitian() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpenelitian/p");
		
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen";
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
			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE idpenelitian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE idpenelitian=$idu")->result();
			$a['page']		= "f_penelitiandosen";
		} else if($mau_ke == "act_edt") {
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
			redirect('index.php/dosen/dosenpenelitian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->where("detail_anggotapenelitian.nidn",$nidn)->where("detail_anggotapenelitian.ket","ketua")->order_by("ket","DESC")->get()->result();
			$a['page']		= "l_penelitiandosen";
		}
		
		$this->load->view('dosen/aaa', $a);
	}


	public function detail_anggota($id){
		if(isset($id) && !empty($id)){
			$a['id'] = $id;
			$a['page']		= "f_detail_anggota";
			$a['anggota'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->join("dosen","dosen.nidn=detail_anggotapenelitian.nidn")->where("penelitian.idpenelitian",$id)->get();
			$this->load->view('dosen/aaa', $a);
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
			
				redirect('index.php/dosen/detail_anggota/'.$this->input->post('id'));
			}else{
				$data_['idpenelitian'] = $this->input->post('id');
				$data_['nidn'] = $this->input->post('dosen');
				$data_['ket'] = 'anggota';
				$this->db->insert("detail_anggotapenelitian",$data_);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Dosen Berhasil Ditambahkan </div>");
				redirect('index.php/dosen/detail_anggota/'.$this->input->post('id'));
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
				redirect('index.php/dosen/detail_anggota/'.$idp);
	}


	///DOSEN PENELITIAN
	
	///DOSEN PENELITIAN PKM
	public function dosenpenelitian_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$total_row		= $this->db->query("SELECT * FROM penelitian_pkm")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpenelitian_pkm/p");
		
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
			
			redirect('index.php/dosen/dosenpenelitian_pkm');
		}
		else {
			$a['data']		= $this->db->query("SELECT * FROM penelitian_pkm ORDER BY id DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_penelitiandosen_pkm";
		}
		
		$this->load->view('dosen/aaa', $a);
	}
	///DOSEN PENELITIAN PKM

	public function dosenpenelitianpublikasi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpenelitian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 					= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tse					= addslashes($this->input->post('tse'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi				= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosenpublikasi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE idpenelitian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE idpenelitian=$idu")->result();
			$a['page']		= "f_penelitiandosen";
		} else if($mau_ke == "act_edt") {
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
			redirect('index.php/dosen/dosenpenelitian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->where("detail_anggotapenelitian.nidn",$nidn)->where("detail_anggotapenelitian.ket","ketua")->get()->result();
			$a['page']		= "l_penelitiandosenpublikasi";
		}
		
		$this->load->view('dosen/aaa', $a);
	}

	public function dosenpenelitianhki() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpenelitian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 					= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tse					= addslashes($this->input->post('tse'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi				= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosenpublikasi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE idpenelitian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE idpenelitian=$idu")->result();
			$a['page']		= "f_penelitiandosen";
		} else if($mau_ke == "act_edt") {
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
			redirect('index.php/dosen/dosenpenelitian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->where("detail_anggotapenelitian.nidn",$nidn)->where("detail_anggotapenelitian.ket","ketua")->get()->result();
			$a['page']		= "l_penelitiandosenhki";
		}
		
		$this->load->view('dosen/aaa', $a);
	}

	public function dosenpenelitianbuku() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpenelitian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 					= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tse					= addslashes($this->input->post('tse'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi				= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosenpublikasi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE idpenelitian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE idpenelitian=$idu")->result();
			$a['page']		= "f_penelitiandosen";
		} else if($mau_ke == "act_edt") {
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
			redirect('index.php/dosen/dosenpenelitian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->where("detail_anggotapenelitian.nidn",$nidn)->where("detail_anggotapenelitian.ket","ketua")->get()->result();
			$a['page']		= "l_penelitiandosenbuku";
		}
		
		$this->load->view('dosen/aaa', $a);
	}

	public function dosenpenelitianjurnal() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpenelitian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 					= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tse					= addslashes($this->input->post('tse'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi				= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosenpublikasi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE idpenelitian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE idpenelitian=$idu")->result();
			$a['page']		= "f_penelitiandosen";
		} else if($mau_ke == "act_edt") {
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
			redirect('index.php/dosen/dosenpenelitian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->where("detail_anggotapenelitian.nidn",$nidn)->where("detail_anggotapenelitian.ket","ketua")->get()->result();
			$a['page']		= "l_penelitiandosenjurnal";
		}
		
		$this->load->view('dosen/aaa', $a);
	}

	public function dosenpenelitianseminar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/dosen/login");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/dosen/dosenpenelitian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpenelitian 					= addslashes($this->input->post('idpenelitian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$jenis					= addslashes($this->input->post('jenis'));
		$bidang					= addslashes($this->input->post('bidang'));
		$tse					= addslashes($this->input->post('tse'));
		$sumber					= addslashes($this->input->post('sumber'));
		$institusi				= addslashes($this->input->post('institusi'));
		$jumlah					= addslashes($this->input->post('jumlah'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_penelitiandosenpublikasi";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_penelitiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO penelitian VALUES (NULL,'$judulpenelitian','$jenis',  '$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapenelitian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM penelitian WHERE idpenelitian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/dosen/dosenpenelitian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_penelitian WHERE idpenelitian=$idu")->result();
			$a['page']		= "f_penelitiandosen";
		} else if($mau_ke == "act_edt") {
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
			redirect('index.php/dosen/dosenpenelitian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->where("detail_anggotapenelitian.nidn",$nidn)->where("detail_anggotapenelitian.ket","ketua")->get()->result();
			$a['page']		= "l_penelitiandosenseminar";
		}
		
		$this->load->view('dosen/aaa', $a);
	}

}
