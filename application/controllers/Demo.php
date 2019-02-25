<?php 

class Demo extends CI_Controller {	
	
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('common_functions');
        
    }

    public function index(){
    	echo "Thois is a demo!!";
    }

    public function display($a=50, $b=50){
    	$query=$this->db->query("SELECT * FROM contact_master");
    	$result=$query->result();

    	$data['contact']=$result;
        load_view('test', $data);
    }

    public function insert(){
    	$data = array(
    		'c_name' => 'abc' ,
    		'c_designation' => 'test',
    		 );
    	$this->db->insert('contact_master', $data);
    	$this->display();
    }

    public function update(){
    	$data = array(
    		'c_name' => 'abc edit' ,
    		'c_designation' => 'test edit',
    		 );
    	$this->db->where('c_id', '43');
    	$this->db->update('contact_master', $data);
    	$this->display();
    }

    public function delete(){
    	$this->db->where('c_id', '44');
    	$this->db->delete('contact_master');
    	$this->display();
    }
}

?>