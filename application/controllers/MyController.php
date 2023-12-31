<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
        $data['title'] = "Beranda";
		$this->load->view('templates/header', $data);
        $this->load->view('beranda');
        $this->load->view('templates/footer');
	}

	// ------------------------------UNTUK BUKU------------------------------

    public function daftarBuku()
	{
        // $data['data_buku'] = $this->db->get('tb_buku')->result_array();
		$this->load->model('Model_buku');
		$this->load->model('Model_penerbit');
		$data['data_buku'] = $this->Model_buku->get_all_buku()->result_array();
		$data['title'] = "Daftar Buku";
		$data['data_penerbit'] = $this->Model_penerbit->get_all_penerbit()->result_array();
        
		$this->load->view('templates/header', $data);
        $this->load->view('daftarBuku');
		$this->load->view('templates/modal');
        $this->load->view('templates/footer');
	}

	public function simpan_buku()
	{
		$data = array(
			'judul_buku' => $this->input->post('judulBuku'), 
			'tahun_terbit' => $this->input->post('tahunTerbit'), 
			'kode_penerbit' => $this->input->post('Penerbit')
		);
		$this->Model_buku->simpan_buku($data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
  		Data Buku Berhasil Disimpan!
		</div>');
		redirect('MyController/daftarBuku');
	}

	public function hapus_buku()
	{
		$kode = $this->uri->segment(3);
		$this->Model_buku->hapus_buku($kode);
		$this->session->set_flashdata('pesan','<div class="alert alert-success" role="alert"> Data berhasil dihapus</div>');
		redirect('MyController/daftarBuku');
	}

	public function update_buku()
	{
		// $kode = $this->uri->segment(3);
		$data = array(
			'judul_buku' => $this->input->post('judulBuku'), 
			'tahun_terbit' => $this->input->post('tahunTerbit'), 
			'kode_penerbit' => $this->input->post('kodePenerbit')
		);
		$kode = $this->input->post('kodeBuku');
		$this->Model_buku->update_buku($data, $kode);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
  		Data Buku Berhasil Diupdate!
		</div>');
		redirect('MyController/daftarBuku');
	}

	public function show_edit_page()
	{
		$this->load->model('Model_buku');
		$this->load->model('Model_penerbit');
		$kode = $this->uri->segment(3);

		$data['data_buku'] = $this->Model_buku->get_buku_by_kode($kode)->row_array();
		$data['data_penerbit'] = $this->Model_penerbit->get_all_penerbit()->result_array();
		$data['title'] = "Daftar Penerbit";
		$this->load->view('templates/header', $data);
		$this->load->view('edit_buku');
		$this->load->view('templates/footer');
	}


	//----------------------------UNTUK PENERBIT-----------------------------

	public function daftarPenerbit()
    {
		$this->load->model('Model_penerbit');
		$data['data_penerbit'] = $this->Model_penerbit->get_all_penerbit('tb_penerbit')->result_array();
        $data['title'] = "Daftar Penerbit";
		$this->load->view('templates/header', $data);
        $this->load->view('daftarPenerbit');
		$this->load->view('templates/modal_penerbit');
        $this->load->view('templates/footer');
	}

	public function simpan_penerbit()
	{
		
		$data = array(
			'nama_penerbit' => $this->input->post('namaPenerbit'), 
			'alamat_penerbit' => $this->input->post('alamatPenerbit'), 
			
		);
		$this->Model_penerbit->simpan_penerbit($data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
  		Data Penerbit Berhasil Disimpan!
		</div>');

		redirect('MyController/daftarPenerbit');
	}

	public function hapus_penerbit()
	{
		$kode = $this->uri->segment(3);
		$this->Model_penerbit->hapus_penerbit($kode);
		// $this->session->set_flashdata('pesan','<div class="alert alert-success" role="alert"> Data berhasil dihapus</div>');
		redirect('MyController/daftarPenerbit');
	}

	public function update_penerbit()
	{
		$data = array(
			'nama_penerbit' => $this->input->post('namaPenerbit'), 
			'alamat_penerbit' => $this->input->post('alamatPenerbit'), 
		);
		$kode = $this->input->post('kodePenerbit');
		$this->Model_penerbit->update_penerbit($data, $kode);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
  		Data Penerbit Berhasil Diupdate!</div');
		
		redirect('MyController/daftarPenerbit');
	}

	public function show_edit_page_penerbit()
	{
		$this->load->model('Model_penerbit');
		$kode = $this->uri->segment(3);
		$data['data_penerbit'] = $this->Model_penerbit->get_penerbit_by_kode($kode)->row_array();
		$data['title'] = "Daftar Penerbit";
		$this->load->view('templates/header', $data);
		$this->load->view('edit_penerbit');
		$this->load->view('templates/footer');
	}

}