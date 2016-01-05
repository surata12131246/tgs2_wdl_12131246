<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
    {
        parent::__construct();   
        $this->load->model('Categories_model','datamodel');     
		$this->load->library('upload');
		$this->load->helper(array('form', 'url'));
		$this->load->library('image_lib');
		
		
    }
	   
	public function index()
	{
		$data['title']='List Of Categories';	
		$data['array_categories'] = $this->datamodel->get_categories();
		$this->mytemplate->loadBackend('categories',$data);
	}

	public function form($mode,$id='')
	{
		$data['title']=($mode=='insert')? 'Add Categories' : 'Update Categories' ;				
		$data['categories'] = ($mode=='update') ? $this->datamodel->get_categories_by_id($id) : '';				
		$this->mytemplate->loadBackend('frmcategories',$data);	
	}

	public function process($mode,$id='')
	{
		
		if(($mode=='insert') || ($mode=='update'))
		{
			$this->do_upload();
			$result = ($mode=='insert') ? $this->datamodel->insert_entry($this->upload->file_name) : $this->datamodel->update_entry($this->upload->file_name) ;
			echo "SUKSES";
		}
		
		else if($mode=='delete'){
			$result = $this->datamodel->hapus($id);			
			echo "GAGAL";
		}	
		//if ($result) redirect(site_url('backend/categories'),'location');
	}
	
	public function do_upload()
        {
            //membuat main image
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']    = '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		//$config['create_thumb']  = TRUE;
		$config['encrypt_name']  = TRUE;
	
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$nama = $this->upload->file_name;
		
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_form', $error);
		}
		else
		{
		
			//$this->thumb_image($this->upload->file_name);
		
		//redirect(site_url('backend/categories'),'location');
		$config['source_image'] = '/uploads/'.$this->upload->file_name;
		$config['wm_text'] = '12131246';
		$config['wm_type'] = 'text';
		$config['wm_font_path'] = './system/fonts/texb.ttf';
		$config['wm_font_size'] = '24';
		$config['wm_font_color'] = '000000';
		$config['wm_vrt_alignment'] = 'center';
		$config['wm_hor_alignment'] = 'center';
		$config['wm_padding'] = '20'; 

		$this->image_lib->initialize($config);

		$this->image_lib->watermark();
	
			
		}
        }
	
	private function dependensi($id)
	{
		return $this->datamodel->cek_dependensi($id);
	}
	
	

	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

