<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pkm extends CI_Controller {
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

	public function cetaklaporan(){

		$a['page'] = 'f_cetak_laporan';
		$this->load->view('pkm/l_pkm', $a);

	}

	public function cetak_laporan()
	{
		if(isset($_POST) && !empty($_POST)){
			$id = $this->input->post('luaran');
			$data['hariini'] = date('d F Y');
			$luaran = $this->input->post('caption');
			if($luaran=='HKI'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "hki_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("hki_pkm","hki_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("hki_pkm","hki_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('v_hkipkm',$data);
			}else if($luaran=='Publikasi'){$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "publikasiilmiah_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("publikasiilmiah_pkm","publikasiilmiah_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("publikasiilmiah_pkm","publikasiilmiah_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();
				}
				$this->load->view('v_publikasipkm',$data);
			}else if($luaran=='Buku Ajar'){
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					join("buku_pkm","buku_pkm.idpengabdian=pengabdiann.idpengabdian")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					join("buku_pkm","buku_pkm.idpengabdian=pengabdiann.idpengabdian")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('v_bukupkm',$data);
			}else if($luaran=='Artikel Jurnal'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "jurnal_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("jurnal_pkm","jurnal_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("jurnal_pkm","jurnal_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('v_jurnalpkm',$data);
			}else if($luaran=='Artikel Prosiding'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "seminar_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("seminar_pkm","seminar_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("seminar_pkm","seminar_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('v_seminarpkm',$data);
			}
		}
	}

	public function laporan(){
		if(isset($_POST) && !empty($_POST)){
			$id = $this->input->post('luaran');
			$luaran = $this->input->post('caption');
			if($luaran=='HKI'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "hki_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("hki_pkm","hki_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("hki_pkm","hki_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('pkm/tb_laporanhki',$data);
			}else if($luaran=='Publikasi'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "publikasiilmiah_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("publikasiilmiah_pkm","publikasiilmiah_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("publikasiilmiah_pkm","publikasiilmiah_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();
				}
				$this->load->view('pkm/tb_laporan',$data);
			}else if($luaran=='Buku Ajar'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "buku_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					join("buku_pkm","buku_pkm.idpengabdian=pengabdiann.idpengabdian")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					join("buku_pkm","buku_pkm.idpengabdian=pengabdiann.idpengabdian")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('pkm/tb_laporanbuku',$data);
			}else if($luaran=='Artikel Jurnal'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "jurnal_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("jurnal_pkm","jurnal_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("jurnal_pkm","jurnal_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('pkm/tb_laporanjurnal',$data);
			}else if($luaran=='Artikel Prosiding'){
				$awal = $this->input->post('awal');
				$akhir = $this->input->post('akhir');
				$where = "seminar_pkm.date BETWEEN '$awal' AND '$akhir' ";
				$namadosen  = $this->input->post('namadosen') ? $this->input->post('namadosen') : null;
				if($namadosen == null) {
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("seminar_pkm","seminar_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("luaran.idluaran",$id)->get();
				}else{
					$data['result'] = $this->db->select("*")->from("luaran")->
					join("detail_luaranpengabdian","detail_luaranpengabdian.idluaran=luaran.idluaran")->
					join("pengabdiann","pengabdiann.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("seminar_pkm","seminar_pkm.idpengabdian=pengabdiann.idpengabdian")->
					join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=detail_luaranpengabdian.idpengabdian")->
					join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
					where("detail_anggotapengabdian.ket","ketua")->
					where($where)->
					where("dosen.namadosen",$namadosen)->
					where("luaran.idluaran",$id)->get();

				}
				$this->load->view('pkm/tb_laporanseminar',$data);
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
		$total_row		= $this->db->query("SELECT * FROM dosen Where nidn ORDER BY nidn DESC")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/pkm/p");
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
			redirect('index.php/pkm/dosen');
		} else if ($mau_ke == "act_add") {
		
			$cek_user_exist = $this->db->query("SELECT nidn FROM dosen WHERE nidn = '$nidn'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">NIDN Sudah Ada. Ganti yang lain..!</div>");
			} else {

			$this->db->query("INSERT INTO dosen VALUES('$nidn','$nik', '$namadosen', '$level','$password','$kodejurusan')");
			// $this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been added</div>");			
			}
			
			redirect('index.php/pkm/dosen');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM dosen WHERE nidn = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data has been deleted</div>");			
			redirect('index.php/pkm/dosen');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM v_dosen ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_dosen";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// DOSEN
	
	public function fakultas(){
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}

		$total_row		= $this->db->query("SELECT * FROM fakultas")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;

		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/fakultas/p");
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
			redirect('index.php/pkm/fakultas');
		} else if ($mau_ke == "act_add") {
		
			$cek_user_exist = $this->db->query("SELECT kodefakultas FROM fakultas WHERE kodefakultas = '$kodefakultas'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Kode Fakultas Sudah Ada. Ganti yang lain..!</div>");
			} else {

			$this->db->query("INSERT INTO fakultas VALUES('$kodefakultas','$namafakultas')");
			// $this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan</div>");			
			}
			
			redirect('index.php/pkm/fakultas');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM fakultas WHERE kodefakultas = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/fakultas');
		} else {
			$a['data']		= $this->db->query("SELECT * FROM fakultas ORDER BY kodefakultas ASC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_fakultas";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}

	public function jurusan(){

		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}

		$total_row		= $this->db->query("SELECT * FROM jurusan")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;

		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/jurusan/p");
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
			$this->db->query("UPDATE jurusan SET namajurusan='$namajurusan',
			 kodefakultas='$kodefakultas' WHERE kodejurusan = '$kodejurusan'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			redirect('index.php/pkm/jurusan');
		} else if ($mau_ke == "act_add") {
			$cek_user_exist = $this->db->query("SELECT kodejurusan FROM jurusan WHERE 
			kodejurusan = '$kodejurusan'")->num_rows();
			if ($cek_user_exist > 0) {
				$this->session->set_flashdata("k","<div class=\"alert alert-danger\" id=\"alert\">Kode 
				Jurusan Sudah Ada. Ganti yang lain..!</div>");
			} 
			else {

			$this->db->query("INSERT INTO jurusan VALUES('$kodejurusan','$namajurusan', '$kodefakultas')");
			// $this->db->query("INSERT INTO t_admin VALUES (NULL, '$nidn', '$password', '$namadosen', '$nik', '$ket')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data 
			Berhasil DiSimpan</div>");			
			}
			
			redirect('index.php/pkm/jurusan');
		} else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM jurusan WHERE kodejurusan = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/jurusan');
		} else {
			$a['data']		= $this->db->query("SELECT jurusan.kodejurusan, fakultas.namafakultas,
			jurusan.namajurusan FROM jurusan, fakultas WHERE jurusan.kodefakultas=fakultas.kodefakultas
			ORDER BY namafakultas ASC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_jurusan";
		}
		
		$this->load->view('pkm/l_pkm', $a);


	}
	
	
	public function pengabdian() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/pengabdian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	 	
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$mitra					= addslashes($this->input->post('mitra'));
		$alamatmitra				= addslashes($this->input->post('alamatmitra'));
		$kelompokmitra			= addslashes($this->input->post('kelompokmitra'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_pengabdian";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_pengabdian";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$alamatmitra'  ,'$kelompokmitra','$jenis',
				'$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."',
				'$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$alamatmitra'  ,'$kelompokmitra', '$jenis',
				 '$bidang', '$tse', '$sumber', '$institusi', '$jumlah','','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pengabdiann WHERE idpengabdian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_pengabdian WHERE idpengabdian=$idu")->result();
			$a['page']		= "f_pengabdian";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$query="UPDATE pengabdiann SET judulpenelitian='$judulpenelitian',mitra='$mitra',
				alamatmitra='$alamatmitra',kelompokmitra='$kelompokmitra',jenis='$jenis',bidang='$bidang', 
				tse='$tse', sumber='$sumber',institusi='$institusi', 
				jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE idpengabdian = 
				'$idpengabdian'";

				$this->db->query($query);
				
			}else{
				
				$query = "UPDATE pengabdiann SET judulpenelitian='$judulpenelitian', 
				mitra='$mitra', alamatmitra='$alamatmitra',kelompokmitra='$kelompokmitra',jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi',
				 jumlah='$jumlah',keterangan='$keterangan' WHERE idpengabdian = '$idpengabdian'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			// die($query);
			redirect('index.php/pkm/pengabdian');
		}  

		else {
			$a['data']		= $this->db->query("SELECT * FROM v_pengabdian where ket='ketua'ORDER BY 
			idpengabdian  DESC LIMIT $awal, $akhir ")->result();
			$a['page']		= "l_pengabdian";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}

	public function detail_anggotapengabdian($id){
		if(isset($id) && !empty($id)){
			$a['id'] = $id;
			$a['page']	= "f_detail_anggotapengabdian";
			$a['anggota'] = $this->db->select("*")->from("pengabdiann")->join("detail_anggotapengabdian",
			"detail_anggotapengabdian.idpengabdian=pengabdiann.idpengabdian")->join("dosen","dosen.nidn=detail_anggotapengabdian.nidn")->
			where("pengabdiann.idpengabdian",$id)->get();
			$this->load->view('pkm/l_pkm', $a);
		}else{
			$this->pengabdian();
		}
	}

	public function simpan_anggotapengabdian(){
		if(isset($_POST) && !empty($_POST)){
			$data['nidn'] = $this->input->post('dosen');
			$data['idpengabdian'] = $this->input->post('id'); 

			$cek = $this->db->get_where("detail_anggotapengabdian",$data);
			if($cek->num_rows()>0){
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Dosen Sudah Terdaftar </div>");
			
				redirect('index.php/pkm/detail_anggotapengabdian/'.$this->input->post('id'));
			}else{
				$data_['idpengabdian'] = $this->input->post('id');
				$data_['nidn'] = $this->input->post('dosen');
				$data_['ket'] = 'anggota';
				$this->db->insert("detail_anggotapengabdian",$data_);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Dosen Berhasil Ditambahkan </div>");
				redirect('index.php/pkm/detail_anggotapengabdian/'.$this->input->post('id'));
			}
		}else{
			$this->pengabdian();
		}
	}

	public function hapus_anggotapengabdian($idp,$nidn){
		$where = array(
			'idpengabdian' => $idp,
			'nidn' => $nidn,
		);
		$this->db->delete("detail_anggotapengabdian",$where);
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Dosen Berhasil Dihapus </div>");
				redirect('index.php/pkm/detail_anggotapengabdian/'.$idp);
	}

	public function detail_luaran($id){
		if(isset($id) && !empty($id)){
			$a['id'] = $id;
			$a['page']		= "f_detail_luaran";
			$a['anggota'] = $this->db->select("*")->from("pengabdiann")->join("detail_luaranpengabdian",
			"detail_luaranpengabdian.idpengabdian=pengabdiann.idpengabdian")->join("luaran","luaran.idluaran=detail_luaranpengabdian.idluaran")->
			where("pengabdiann.idpengabdian",$id)->get();
			$this->load->view('pkm/l_pkm', $a);
		}else{
			$this->pengabdian();
		}
	}
	
	public function simpan_luaran(){
		if(isset($_POST) && !empty($_POST)){
			$data['idluaran'] = $this->input->post('luaran');
			$data['idpengabdian'] = $this->input->post('id'); 

			$cek = $this->db->get_where("detail_luaranpengabdian",$data);
			if($cek->num_rows()>0){
				$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Data Luaran Sudah Terdaftar </div>");
			
				redirect('index.php/pkm/detail_luaran/'.$this->input->post('id'));
			}else{
				$data_['idpengabdian'] = $this->input->post('id');
				$data_['idluaran'] = $this->input->post('luaran');
				$this->db->insert("detail_luaranpengabdian",$data_);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Luaran Berhasil Ditambahkan </div>");
				redirect('index.php/pkm/detail_luaran/'.$this->input->post('id'));
			}
		}else{
			$this->pengabdian();
		}
	}

	public function hapus_luaran($idp,$idluaran){
		$where = array(
			'idpengabdian' => $idp,
			'idluaran' => $idluaran,
		);
		$this->db->delete("detail_luaranpengabdian",$where);
		$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Luaran Berhasil Dihapus </div>");
				redirect('index.php/pkm/detail_luaran/'.$idp);
	}

	/// JURNAL PKM
	public function jurnal_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn='$nidn'")->num_rows();
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
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
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
			$a['data']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_jurnal_pkm";
		} else if ($mau_ke == "add") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$a['page']		= "f_jurnal_pkm";
		}  else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL,'$idp', '$nidn', '$judul','$namajurnal',
				 '$jenis', '$peranpenulis', '$tahun','$volume', '$nomor', '$url', '$issn', '".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO jurnal_pkm VALUES (NULL, '$idp', '$nidn', '$judul','$namajurnal',
				'$jenis', '$peranpenulis', '$tahun','$volume', '$nomor', '$url', '$issn','','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/detail_jurnalpkm/'.$this->input->post('idp'));
		}

		else if ($mau_ke == "del") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$idp = $this->session->userdata('idpengabdian');

			$this->db->query("DELETE FROM jurnal_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			
			redirect('index.php/pkm/detail_jurnalpkm/'.$idp);
		}

		else if ($mau_ke == "edt") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdian",$where);
			$a['datpil']		= $this->db->query("SELECT * FROM v_jurnalpkm WHERE id='$idu'")->result();
			$a['page']		= "f_jurnal_pkm";
		}

		else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				// die(print_r($up_data));
				$query = "UPDATE jurnal_pkm SET idpengabdian='$idp',nidn='$nidn', judul='$judul', 
				namajurnal='$namajurnal',jenis='$jenis',peranpenulis='$peranpenulis',tahun='$tahun',
				volume='$volume',no='$nomor',url='$url',issn='$issn',file='$up_data[file_name]', 
				keterangan='$keterangan' WHERE id = '$id'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data 
				Berhasil DiUbah</div>");
			}else{
				// die('blah');
				$query = "UPDATE jurnal_pkm SET idpengabdian='$idp',nidn='$nidn', judul='$judul', 
				namajurnal='$namajurnal',jenis='$jenis',peranpenulis='$peranpenulis',tahun='$tahun',
				volume='$volume',no='$nomor',url='$url',issn='$issn',
				keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	
			}
			redirect('index.php/pkm/detail_jurnalpkm/'.$this->input->post('idp'));
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');	
		// 	$a['data']		= $this->db->query("SELECT * FROM v_jurnal WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_jurnaldosen";
		// }
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// JURNAL PKM
	
	public function detail_jurnalpkm($id){
		if(isset($id) && !empty($id)){
			$sess['idpengabdian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data'] = $this->db->query("SELECT * from v_jurnalpkm ORDER BY nidn
			DESC  ")->result();
			$a['page'] = "l_jurnal_pkm";
			$this->load->view('pkm/l_pkm', $a);
			}
	}

	
	
	/// SEMINAR PKM
	public function seminar_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn='$nidn'")->num_rows();
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
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
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
			$a['data']		= $this->db->query("SELECT * FROM v_seminarpkm WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_seminar_pkm";
		} else if ($mau_ke == "add") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$a['page']	= "f_seminar_pkm";
		}  else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$idp','$nidn', '$judul', 
				'$tahunprosiding', '$peranpenulis','$volume', '$nomor', '$isbn',
				 '$url', '$jenisprosiding','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO seminar_pkm VALUES (NULL, '$idp','$nidn', '$judul', 
				'$tahunprosiding',  '$peranpenulis','$volume', '$nomor', '$isbn',
				 '$url', '$jenisprosiding','','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/detail_seminarpkm/'.$this->input->post('idp'));
		} else if ($mau_ke == "del") {

			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$idp = $this->session->userdata('idpengabdian');

			$this->db->query("DELETE FROM seminar_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");	

			redirect('index.php/pkm/detail_seminarpkm/'.$idp);

		}

		else if ($mau_ke == "edt") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
				$a['data']	= $this->db->get_where("pengabdiann",$where);
			$a['datpil']		= $this->db->query("SELECT * FROM v_seminar WHERE id=$idu")->result();
			$a['page']		= "f_seminar_pkm";
		}

		else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();

				$this->db->query("UPDATE seminar_pkm SET idpengabdian='$idp', nidn='$nidn', namaprosiding='$judul', 
				tahunprosiding='$tahunprosiding',peranpenulis='$peranpenulis',
				volume='$volume',no='$nomor',isbn='$isbn',url='$url',
				jenisprosiding='$jenisprosiding',file='$up_data[file_name]', 
				keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE seminar_pkm SET idpengabdian='$idp', nidn='$nidn', namaprosiding='$judul',
				 tahunprosiding='$tahunprosiding',peranpenulis='$peranpenulis',
				 volume='$volume',no='$nomor',isbn='$isbn',url='$url',
				 jenisprosiding='$jenisprosiding','', keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");	
			}

			redirect('index.php/pkm/detail_seminarpkm/'.$this->input->post('idp'));
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');	
		// 	$a['data']		= $this->db->query("SELECT * FROM v_seminar WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_seminardosen";
		// }
		
		$this->load->view('pkm/l_pkm', $a);
	}

	public function detail_seminarpkm($id){
		if(isset($id) && !empty($id)){
			$sess['idpengabdian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data'] = $this->db->query("SELECT * from v_seminarpkm ORDER BY nidn
			DESC  ")->result();
			$a['page'] = "l_seminar_pkm";
			$this->load->view('pkm/l_pkm', $a);
			}
	}
	/// SEMINAR PKM
	/// BUKU PKM
	public function buku_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');
		$total_row		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn = '$nidn' ")->num_rows();
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
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
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
		$tanggal = date('Y-m-d H:i:s');

		$this->load->library('upload', $config);

		$nidn = $this->session->userdata('admin_nidn');
		if ($mau_ke == "cari") {
			$a['data']		= $this->db->query("SELECT * FROM v_bukupkm WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_buku_pkm";
		} else if ($mau_ke == "add") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$a['page']		= "f_buku_pkm";
		}  else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL,'$idp', '$nidn', '$judul', 
				'$penerbit', '$isbn', '$halaman', '".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO buku_pkm VALUES (NULL, '$idp','$nidn', '$judul',
				 '$penerbit', '$isbn', '$halaman', '','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/detail_bukupkm/'.$this->input->post('idp'));

		}else if ($mau_ke == "del") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$idp = $this->session->userdata('idpengabdian');

			$this->db->query("DELETE FROM buku_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");	

			redirect('index.php/pkm/detail_bukupkm/'.$idp);

		}else if ($mau_ke == "edt") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$a['datpil']		= $this->db->query("SELECT * FROM v_bukupkm WHERE id=$idu")->result();
			$a['page']		= "f_buku_pkm";

		} else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE buku_pkm SET idpengabdian='$idp',nidn='$nidn', judul='$judul', 
				penerbit='$penerbit', isbn='$isbn', halaman='$halaman',file='$up_data[file_name]', keterangan='$keterangan' WHERE id = '$id'");
			}else{
				$query="UPDATE buku_pkm SET idpengabdian='$idp',nidn='$nidn', judul='$judul', 
				penerbit='$penerbit', isbn='$isbn', halaman='$halaman' ,keterangan='$keterangan' WHERE id = '$id'";

				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");
			}
			redirect('index.php/pkm/detail_bukupkm/'.$this->input->post('idp'));
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');
		// 	$a['data']		= $this->db->query("SELECT * FROM v_buku WHERE nidn = $nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_bukudosen";
		// }
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// BUKU PKM
	
	public function detail_bukupkm($id){
		if(isset($id) && !empty($id)){
			$sess['idpengabdian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data'] = $this->db->query("SELECT * from v_bukupkm ORDER BY nidn
			DESC  ")->result();
			$a['page'] = "l_buku_pkm";
			$this->load->view('pkm/l_pkm', $a);
			}
	}

	/// HKI
	public function hki_pkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_hkipkm WHERE nidn='$nidn'")->num_rows();
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
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn=$nidn and judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_hki_pkm";
		} else if ($mau_ke == "add") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			
			$a['page']		= "f_hki_pkm";
		} else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL,'$idp', '$nidn', '$judul', '$jenis',
				 '$nomorpendaftaran', '$status', '$nohki','".$up_data['file_name']."','$keterangan','$tanggal')");
			} else {
				$this->db->query("INSERT INTO hki_pkm VALUES (NULL,'$idp', '$nidn', '$judul', '$jenis', 
				'$nomorpendaftaran', '$status', '$nohki','','$keterangan','$tanggal')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Disimpan. ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/detail_hkipkm/'.$this->input->post('idp'));

		} else if ($mau_ke == "del") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$idp = $this->session->userdata('idpengabdian');

			$this->db->query("DELETE FROM hki_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus </div>");

			redirect('index.php/pkm/detail_hkipkm/'.$idp);

		}else if ($mau_ke == "edt") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
		
			$a['datpil']		= $this->db->query("SELECT * FROM v_hkipkm WHERE id=$idu")->result();
			$a['page']		= "f_hki_pkm";

		}else if ($mau_ke == "act_edt") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE hki_pkm SET idpengabdian='$idp', nidn='$nidn', judul='$judul',
				 jenis='$jenis', nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki',file='$up_data[file_name]', status='$status', keterangan='$keterangan' WHERE id = '$id'");
			}else{	
				$query="UPDATE hki_pkm SET idpengabdian='$idp', nidn='$nidn', judul='$judul', jenis='$jenis',
				 nomorpendaftaran='$nomorpendaftaran', status='$status', nohki='$nohki', status='$status','', keterangan='$keterangan' WHERE id = '$id'";
		
			$this->db->query($query);
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil Diubah </div>");	
			}		

			redirect('index.php/pkm/detail_hkipkm/'.$this->input->post('idp'));
		
		}

		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');	
		// 	$a['data']		= $this->db->query("SELECT * FROM v_hki WHERE nidn=$nidn ORDER BY id DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_hkidosen";
		// }
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// HKI

	public function detail_hkipkm($id){
		if(isset($id) && !empty($id)){
			$sess['idpengabdian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data'] = $this->db->query("SELECT * from v_hkipkm ORDER BY nidn
			DESC  ")->result();
			$a['page'] = "l_hki_pkm";
			$this->load->view('pkm/l_pkm', $a);
			}
	}
	
	/// PUBLIKASI ILMIAH PKM
	public function publikasipkm() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn='$nidn'")->num_rows();
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
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
		$id 					= addslashes($this->input->post('id'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judul					= addslashes($this->input->post('judul'));
		$institusi				= addslashes($this->input->post('institusi'));
		$tempat					= addslashes($this->input->post('tempat'));
		$tanggal				= addslashes($this->input->post('tanggal'));
		$status				= addslashes($this->input->post('status'));
		$cari					= addslashes($this->input->post('q'));
		//upload config 
		$config['upload_path'] 		= './upload/publikasipkm';
		$config['allowed_types'] 	= 'gif|jpg|png|pdf|doc|docx';
		$config['max_size']			= '10000';
		$config['max_width']  		= '13000';
		$config['max_height'] 		= '13000';
		$date = date('Y-m-d H:i:s');
		$this->load->library('upload', $config);
		
		if ($mau_ke == "cari") {
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_publikasi_pkm";
		} else if ($mau_ke == "add") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
		
			$a['page']	= "f_publikasi_pkm";
		}  else if ($mau_ke == "act_add") {
			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL,'$idp', '$nidn', '$judul', 
				'$institusi', '$tanggal', '$tempat','".$up_data['file_name']."','$status','$date')");
			} else {
				$this->db->query("INSERT INTO publikasiilmiah_pkm VALUES (NULL,'$idp', '$nidn', '$judul', 
				'$institusi', '$tanggal', '$tempat','','$status','$date')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			redirect('index.php/pkm/detail_publikasipkm/'.$this->input->post('idp'));

		} else if ($mau_ke == "del") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$idp = $this->session->userdata('idpengabdian');

			
			$this->db->query("DELETE FROM publikasiilmiah_pkm WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/detail_publikasipkm/'.$idp);
		}
		else if ($mau_ke == "edt") {
			$where['idpengabdian'] = $this->session->userdata('idpengabdian');
			$a['data']	= $this->db->get_where("pengabdiann",$where);
			$a['datpil']	= $this->db->query("SELECT * FROM v_publikasipkm WHERE id=$idu")->result();
			$a['page']	= "f_publikasi_pkm";

		}else if($mau_ke == "act_edt") {

			$idp = $this->input->post('idp');
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("UPDATE publikasiilmiah_pkm SET idpengabdian='$idp',nidn='$nidn', judul='$judul', 
				institusi='$institusi', tanggal='$tanggal', tempat='$tempat',file='$up_data[file_name]',
				 status='$status' WHERE id = '$id'");
			}else{
				
				$query = "UPDATE publikasiilmiah_pkm SET idpengabdian='$idp', nidn='$nidn', judul='$judul', 
				institusi='$institusi', tanggal='$tanggal', tempat='$tempat',status='$status' 
				WHERE id = '$id'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			redirect('index.php/pkm/detail_publikasipkm/'.$this->input->post('idp'));
		}  
		
		// else {
		// 	$nidn = $this->session->userdata('admin_nidn');	
		// 	$a['data']		= $this->db->query("SELECT * FROM v_publikasipkm WHERE nidn=$nidn ORDER BY nidn DESC LIMIT $awal, $akhir ")->result();
		// 	$a['page']		= "l_publikasidosen_pkm";
		// }
		
		$this->load->view('pkm/l_pkm', $a);
	}
	/// PUBLIKASI ILMIAH PKM

	public function detail_publikasipkm($id){
		if(isset($id) && !empty($id)){
			$sess['idpengabdian'] = $id;
			$this->session->set_userdata($sess);
			$nidn = $this->session->userdata('admin_nidn');
			$a['data'] = $this->db->query("SELECT * from v_publikasipkm Where idpengabdian='$id' ORDER BY nidn
			DESC  ")->result();
			$a['page'] = "l_publikasi_pkm";
			$this->load->view('pkm/l_pkm', $a);
			}
	
	}


	public function pengabdianpublikasi() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/pengabdian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	 	
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$mitra					= addslashes($this->input->post('mitra'));
		$alamat					= addslashes($this->input->post('alamatmitra'));
		$kelompokmitra			= addslashes($this->input->post('kelompokmitra'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_pengabdiandosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_pengabdiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				
				'$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."',
				'$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				 '$bidang', '$tse', '$sumber', '$institusi', '$jumlah','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pengabdiann WHERE idpengabdian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_pengabdian WHERE idpengabdian=$idu")->result();
			$a['page']		= "f_pengabdiandosen";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$query="UPDATE pengabdiann SET judulpenelitian='$judulpenelitian', 
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra',jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi', 
				jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE idpengabdian = 
				'$idpengabdian'";

				$this->db->query($query);
				
			}else{
				
				$query = "UPDATE pengabdiann SET judulpenelitian='$judulpenelitian',
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra', jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi',
				 jumlah='$jumlah', keterangan='$keterangan' WHERE idpengabdian = '$idpengabdian'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			// die($query);
			redirect('index.php/pkm/pengabdian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("pengabdiann")->
			join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("detail_luaranpengabdian","detail_luaranpengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("luaran","luaran.idluaran=detail_luaranpengabdian.idluaran")->
			where("detail_anggotapengabdian.ket","ketua")->
			where("pengabdiann.keterangan","Disetujui")->
			where("luaran.namaluaran","Publikasi")->
			order_by("date","DESC")->get()->result();
			$a['page']		= "l_pengabdianpublikasi";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}

	public function pengabdianhki() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/pengabdian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	 	
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$mitra					= addslashes($this->input->post('mitra'));
		$alamat					= addslashes($this->input->post('alamatmitra'));
		$kelompokmitra			= addslashes($this->input->post('kelompokmitra'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_pengabdiandosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_pengabdiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				
				'$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."',
				'$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				 '$bidang', '$tse', '$sumber', '$institusi', '$jumlah','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pengabdiann WHERE idpengabdian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_pengabdian WHERE idpengabdian=$idu")->result();
			$a['page']		= "f_pengabdiandosen";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$query="UPDATE pengabdiann SET judulpenelitian='$judulpenelitian', 
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra',jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi', 
				jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE idpengabdian = 
				'$idpengabdian'";

				$this->db->query($query);
				
			}else{
				
				$query = "UPDATE pengabdiann SET judulpenelitian='$judulpenelitian',
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra', jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi',
				 jumlah='$jumlah', keterangan='$keterangan' WHERE idpengabdian = '$idpengabdian'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			// die($query);
			redirect('index.php/pkm/pengabdian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("pengabdiann")->
			join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("detail_luaranpengabdian","detail_luaranpengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("luaran","luaran.idluaran=detail_luaranpengabdian.idluaran")->
			where("detail_anggotapengabdian.ket","ketua")->
			where("pengabdiann.keterangan","Disetujui")->
			where("luaran.namaluaran","HKI")->order_by("date","DESC")->get()->result();
			$a['page']		= "l_pengabdianhki";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	
	public function pengabdianbuku() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/pengabdian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	 	
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$mitra					= addslashes($this->input->post('mitra'));
		$alamat					= addslashes($this->input->post('alamatmitra'));
		$kelompokmitra			= addslashes($this->input->post('kelompokmitra'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_pengabdiandosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_pengabdiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				
				'$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."',
				'$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				 '$bidang', '$tse', '$sumber', '$institusi', '$jumlah','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pengabdiann WHERE idpengabdian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_pengabdian WHERE idpengabdian=$idu")->result();
			$a['page']		= "f_pengabdiandosen";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$query="UPDATE pengabdiann SET judulpenelitian='$judulpenelitian', 
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra',jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi', 
				jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE idpengabdian = 
				'$idpengabdian'";

				$this->db->query($query);
				
			}else{
				
				$query = "UPDATE pengabdiann SET judulpenelitian='$judulpenelitian',
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra', jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi',
				 jumlah='$jumlah', keterangan='$keterangan' WHERE idpengabdian = '$idpengabdian'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			// die($query);
			redirect('index.php/pkm/pengabdian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("pengabdiann")->
			join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("detail_luaranpengabdian","detail_luaranpengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("luaran","luaran.idluaran=detail_luaranpengabdian.idluaran")->
			where("detail_anggotapengabdian.ket","ketua")->
			where("pengabdiann.keterangan","Disetujui")->
			where("luaran.namaluaran","Buku Ajar")->order_by("date","DESC")->get()->result();
			$a['page']		= "l_pengabdianbuku";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}

	public function pengabdianjurnal() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/pengabdian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	 	
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$mitra					= addslashes($this->input->post('mitra'));
		$alamat					= addslashes($this->input->post('alamatmitra'));
		$kelompokmitra			= addslashes($this->input->post('kelompokmitra'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_pengabdiandosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_pengabdiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				
				'$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."',
				'$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				 '$bidang', '$tse', '$sumber', '$institusi', '$jumlah','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pengabdiann WHERE idpengabdian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_pengabdian WHERE idpengabdian=$idu")->result();
			$a['page']		= "f_pengabdiandosen";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$query="UPDATE pengabdiann SET judulpenelitian='$judulpenelitian', 
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra',jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi', 
				jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE idpengabdian = 
				'$idpengabdian'";

				$this->db->query($query);
				
			}else{
				
				$query = "UPDATE pengabdiann SET judulpenelitian='$judulpenelitian',
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra', jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi',
				 jumlah='$jumlah', keterangan='$keterangan' WHERE idpengabdian = '$idpengabdian'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			// die($query);
			redirect('index.php/pkm/pengabdian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("pengabdiann")->
			join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("detail_luaranpengabdian","detail_luaranpengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("luaran","luaran.idluaran=detail_luaranpengabdian.idluaran")->
			where("detail_anggotapengabdian.ket","ketua")->
			where("pengabdiann.keterangan","Disetujui")->
			where("luaran.namaluaran","Artikel Jurnal")->order_by("date","DESC")->get()->result();
			$a['page']		= "l_pengabdianjurnal";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	public function pengabdianseminar() {
		if ($this->session->userdata('admin_valid') == FALSE && $this->session->userdata('admin_id') == "") {
			redirect("index.php/pkm/login_pkm");
		}
		
		/* pagination */	
		$nidn = $this->session->userdata('admin_nidn');	
		$total_row		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn='$nidn'")->num_rows();
		$per_page		= 10;
		
		$awal	= $this->uri->segment(4); 
		$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
		
		//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $per_page;
		
		$a['pagi']	= _page($total_row, $per_page, 4, base_url()."index.php/pkm/pengabdian/p");
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
	 	
		$cari					= addslashes($this->input->post('q'));

		//ambil variabel Postingan
		$idpengabdian 			= addslashes($this->input->post('idpengabdian'));
		$nidn					= addslashes($this->input->post('nidn'));
		$judulpenelitian		= addslashes($this->input->post('judulpenelitian'));
		$mitra					= addslashes($this->input->post('mitra'));
		$alamat					= addslashes($this->input->post('alamatmitra'));
		$kelompokmitra			= addslashes($this->input->post('kelompokmitra'));
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
			$nidn = $this->session->userdata('admin_nidn');	
			$a['data']		= $this->db->query("SELECT * FROM v_pengabdian WHERE nidn=$nidn AND judul LIKE '%$cari%' ORDER BY nidn DESC")->result();
			$a['page']		= "l_pengabdiandosen";
		} else if ($mau_ke == "add") {
			$a['page']		= "f_pengabdiandosen";
		}  else if ($mau_ke == "act_add") {
		
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				
				'$bidang', '$tse', '$sumber', '$institusi', '$jumlah', '".$up_data['file_name']."',
				'$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			} else {
				$this->db->query("INSERT INTO pengabdiann VALUES (NULL,'$judulpenelitian',
				'$mitra','$kelompokmitra','$alamat', '$jenis', 
				 '$bidang', '$tse', '$sumber', '$institusi', '$jumlah','$keterangan','$tanggal')");
				$this->db->query("INSERT INTO detail_anggotapengabdian VALUES ('$id','$nidn','ketua')");
			}	
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiSimpan ".$this->upload->display_errors()."</div>");
			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pengabdiann WHERE idpengabdian = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiHapus</div>");			
			redirect('index.php/pkm/pengabdian');
		}

		else if ($mau_ke == "edt") {
			$a['datpil']		= $this->db->query("SELECT * FROM v_pengabdian WHERE idpengabdian=$idu")->result();
			$a['page']		= "f_pengabdiandosen";
		} else if($mau_ke == "act_edt") {
			if ($this->upload->do_upload('file_surat')) {
				$up_data	 	= $this->upload->data();
				
				$query="UPDATE pengabdiann SET judulpenelitian='$judulpenelitian', 
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra',jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi', 
				jumlah='$jumlah',file='$up_data[file_name]', keterangan='$keterangan' WHERE idpengabdian = 
				'$idpengabdian'";

				$this->db->query($query);
				
			}else{
				
				$query = "UPDATE pengabdiann SET judulpenelitian='$judulpenelitian',
				mitra='$mitra',alamatmitra='$alamat',kelompokmitra='$kelompokmitra', jenis='$jenis', 
				bidang='$bidang',  tse='$tse', sumber='$sumber',institusi='$institusi',
				 jumlah='$jumlah', keterangan='$keterangan' WHERE idpengabdian = '$idpengabdian'";
				
				$this->db->query($query);
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\" id=\"alert\">Data Berhasil DiUbah</div>");			
			}
			// die($query);
			redirect('index.php/pkm/pengabdian');
		}  

		else {
			$nidn = $this->session->userdata('admin_nidn');	
			//$a['data']		= $this->db->query("SELECT * FROM v_penelitian WHERE nidn 	= '$nidn' ORDER BY idpenelitian DESC LIMIT $awal, $akhir ")->result();
			$a['data'] = $this->db->select("*")->from("pengabdiann")->
			join("detail_anggotapengabdian","detail_anggotapengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("detail_luaranpengabdian","detail_luaranpengabdian.idpengabdian=pengabdiann.idpengabdian")->
			join("luaran","luaran.idluaran=detail_luaranpengabdian.idluaran")->
			where("detail_anggotapengabdian.ket","ketua")->
			where("pengabdiann.keterangan","Disetujui")->
			where("luaran.namaluaran","Artikel Prosiding")->order_by("date","DESC")->get()->result();
			$a['page']		= "l_pengabdianseminar";
		}
		
		$this->load->view('pkm/l_pkm', $a);
	}
	
}
