<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satker extends CI_Controller {

	/**
	 * code by rifqie rusyadi
	 * email rifqie.rusyadi@gmail.com
	 */
	
	public $folder = 'referensi/satker/';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('satker_m', 'data');
		signin();
		admin();
	}
	
	//halaman index
	public function index()
	{
		$data['head'] 		= 'Master Satuan Kerja';
		$data['record'] 	= $this->data->get_all();
		$data['content'] 	= $this->folder.'default';
		$data['style'] 		= $this->folder.'style';
		$data['js'] 		= $this->folder.'js';
		
		$this->load->view('template/default', $data);
	}
	
	public function created()
	{
		$data['head'] 		= 'Tambah Master Satuan Kerja';
		$data['record'] 	= $this->data->get_new();
		$data['content'] 	= $this->folder.'form';
		$data['style'] 		= $this->folder.'style';
		$data['js'] 		= $this->folder.'js';
		$data['satker']		= $this->data->get_satker();
		
		$this->load->view('template/default', $data);
	}
	
	public function updated($id=null)
	{
		
		$data['head'] 		= 'Ubah Master Satuan Kerja';
		$data['record'] 	= $this->data->get_id($id);
		$data['content'] 	= $this->folder.'form';
		$data['style'] 		= $this->folder.'style';
		$data['js'] 		= $this->folder.'js';
		$data['satker']		= $this->data->get_satker();
		
		$this->load->view('template/default', $data);
	}
	
	public function ajax_list()
    {
        $record	= $this->data->get_datatables();
        $data 	= array();
        $no 	= $_POST['start'];
		
        foreach ($record as $row) {
            $no++;
            $col = array();
            $col[] = '<input type="checkbox" class="data-check" value="'.$row->id.'">';
            $col[] = $row->kode;
			$col[] = $row->satker;
			//add html for action
            $col[] = '<a class="btn btn-xs btn-flat btn-warning" onclick="edit_data();" href="'.site_url('referensi/satker/updated/'.$row->id).'" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-xs btn-flat btn-danger" data-toggle="tooltip" title="Hapus" onclick="deleted('."'".$row->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
            $data[] = $col;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->data->count_all(),
                        "recordsFiltered" => $this->data->count_filtered(),
                        "data" => $data,
                );
        
		echo json_encode($output);
    }
	
	public function ajax_save()
    {
        $kode = $this->data->get_kode();
		$data = array(
				'parent_id' => $this->input->post('parent'),
				'kode' => $kode,
				'satker' => $this->input->post('satker'),
				'upt' => $this->input->post('upt'),
				'alamat' => $this->input->post('alamat'),
				'email' => $this->input->post('email'),
				'telpon' => $this->input->post('telpon')
            );
        
        if($this->validation()){
            $insert = $this->data->insert($data);
			helper_log("add", "Menambah Master Satuan Kerja");
        }
    }
    
    public function ajax_update($id=null)
    {
        $data = array(
				'parent_id' => $this->input->post('parent'),
				'satker' => $this->input->post('satker'),
				'upt' => $this->input->post('upt'),
				'alamat' => $this->input->post('alamat'),
				'email' => $this->input->post('email'),
				'telpon' => $this->input->post('telpon')
            );
		
        if($this->validation($id)){
            $this->data->update($data, $id);
			helper_log("edit", "Merubah Master Satuan Kerja");
        }
    }
    
    public function ajax_delete($id=null)
    {
        $this->data->delete($id);
		helper_log("trash", "Menghapus Master Satuan Kerja");
        echo json_encode(array("status" => TRUE));
    }
    
    public function ajax_delete_all()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->data->delete($id);
			helper_log("trash", "Menghapus Master Satuan Kerja");
        }
        echo json_encode(array("status" => TRUE));
    }
	
	private function validation($id=null)
    {
        //$id = $this->input->post('id');
		$data = array('success' => false, 'messages' => array());
        
		if(!isset($id)){
			$this->form_validation->set_rules("satker", "Satuan Kerja", "trim|required");
			$this->form_validation->set_rules("parent", "Satuan Kerja Induk", "trim");
		}else{
			$this->form_validation->set_rules("satker", "Satuan Kerja", "trim|required");
			$this->form_validation->set_rules("parent", "Satuan Kerja Induk", "trim");
		}
        
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        
        if($this->form_validation->run()){
            $data['success'] = true;
        }else{
            foreach ($_POST as $key => $value) {
                $data['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($data);
        return $this->form_validation->run();
    }
	
	public function ajax_csfr()
    {
        echo json_encode(array("token" => $this->security->get_csrf_token_name(), "key"=>$this->security->get_csrf_hash()));
    }
}
