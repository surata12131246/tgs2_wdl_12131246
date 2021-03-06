<?php

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function index()
        {
                $this->mytemplate->loadBackend('upload_form', array('error' => ' ' ));
        }

        public function do_upload()
        {
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);
				
                if ( ! $this->upload->do_upload())
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->mytemplate->loadBackend('upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
						$this->thumb();
                        $this->mytemplate->loadBackend('upload_success', $data);
                }
        }
		
		public function thumb()
        {
			$config['image_library'] = 'gd2';
			$config['source_image'] = '/uploads/ban-sepeda-motor-terbaru.jpg';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 75;
			$config['height']       = 50;

			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
		}
		
}
?>