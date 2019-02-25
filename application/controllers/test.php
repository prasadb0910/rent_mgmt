<?php
class Test extends CI_Controller {

	public function __construct() {
        parent::__construct();
       
        $this->load->helper('common_functions');
        $this->load->model('contact_model');
        $this->load->model('document_model');
    }

    public function testversion(){
         echo CI_VERSION;
    }

	public function index(){

		echo "this is test";

        session_start();
        
        echo json_encode($_SESSION);

	}

	public function abc(){

        $data['userdata'] = $this->session->all_userdata();
		$this->load->view('test1');
	}

	 public function display($a=50, $b=50){
    	$query=$this->db->query("SELECT * FROM contact_master");
    	$result=$query->result();

    	$data['contact']=$result;
        load_view('test2', $data);
    }

	public function insert(){

    $data  = array
    	(
    		'c_id'=>'49',
    		'c_name'=> 'xyz',
    		);
    $this->db->insert('contact_master', $data);
    $this->display();
	}

	public function update(){

    $data  = array
    	(
    		'c_id'=>'48',
    		'c_name'=> 'xyz',
    		);
    $this->db->insert('contact_master', $data);
   
	}

	public function delete(){

		$this->db->where('c_name','wer');
		$this->db->delete('contact_master');
		$this->display();
	}

	public function save(){

        $data['userdata'] = $this->session->all_userdata();
		$this->load->view('test2',$data);
	}
    
      public function due_postdate(){

        $currentdate = date("Y-m-d");

        $sql = "Select * from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.net_amount from (select * from rent_txn where txn_status = 'Approved') A left join (select * from rent_schedule where status = '1' and (invoice_no is null or invoice_no='') and event_type!='Deposit' ) B on (A.txn_id = B.rent_id) where B.sch_id is not null) as E Where E.event_date>='2016-05-10'";
        $query = $this->db->query($sql);
        $result = $query->result();
        /*echo $this->db->last_query();*/
        if(count($result)>0){

            for($i=0; $i<count($result); $i++){
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
                $invoice_issuer = $result[$i]->invoice_issuer;
                $invoice_date = $result[$i]->invoice_date;
                $event_date = $result[$i]->event_date;

                $invoice_no = $this->generate_invoice_no($invoice_issuer, $event_date);

                $day = date('d', strtotime($invoice_date));
                $month = date('m', strtotime($event_date));
                $year = date('Y', strtotime($event_date));
                
                $event_date = $year.'-'.$month.'-'.$day;

                if($month==2){
                    if($day>28){
                        if($year%4==0){
                            $event_date = $year.'-'.$month.'-29';
                        } else {
                            $event_date = $year.'-'.$month.'-28';
                        }
                    }
                } else if($month==4 || $month==6 || $month==9 || $month==11){
                    if($day>30){
                        $event_date = $year.'-'.$month.'-30';
                    }
                }

                 $invoice_no;
                 '<br/>';

                $sql = "update rent_schedule set invoice_no = '$invoice_no', invoice_date = '$event_date' where sch_id = '$sch_id'";
                $this->db->query($sql);
            }
        }

        $sql = "select * from actual_other_schedule where txn_status = 'Approved' and
                (invoice_no is null or invoice_no='')  and event_date='2016-05-10' GROUP BY id";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $property_id = $result[$i]->property_id;
                $sch_id = $result[$i]->id;
                $event_date = $result[$i]->event_date;

                $owners = $this->purchase_model->get_property_owners($property_id);
                if(count($owners)>0){
                    $invoice_issuer = $owners[0]->pr_client_id;
                } else {
                    $invoice_issuer = $result[$i]->approved_by;
                }

                $owner_name = $owners[0]->owner_name;
                $owner_email = $owners[0]->c_emailid1;

                $tenent = $this->purchase_model->get_contact_personname($property_id);
                if(count($owners)>0){
                    $tenent_name = $tenent[0]->owner_name;
                    $tenent_email = $tenent[0]->c_emailid1;
                } 


                $invoice_no = $this->generate_invoice_no($invoice_issuer, $event_date);

                 $invoice_no;
                 '<br/>';

                $sql = "update actual_other_schedule set invoice_no = '$invoice_no', invoice_date = '$event_date' where id = '$sch_id'";
                $this->db->query($sql);
            }
        }

    }
}
?>