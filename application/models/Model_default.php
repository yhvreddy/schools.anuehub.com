<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_default extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }


	//country name

	public function countryName($conduction){
		$countryname = $this->selectdata('sms_countries',$conduction);
		return $countryname[0];
	}

	//state name

	public function stateName($conduction){
		$statenames = $this->selectdata('sms_states',$conduction);
		return $statenames[0];
	}
	//city name
	public function cityName($conduction){
		$citynames = $this->selectdata('sms_cities',$conduction);
		return $citynames[0];
	}

    //insert new data to table
    public function insertdata($tablename,$insertdata){
        $this->db->insert($tablename,$insertdata);
        $return = $this->db->affected_rows();
        return $return;
    }
    
    //insert new data to table get last insert id
    public function insertid($tablename,$insertdata){
        $this->db->insert($tablename,$insertdata);
        $return = $this->db->insert_id();
        return $return;
    }

    //rows count
    public function rowcount($tablename){
        $this->db->select('*');
        $this->db->from($tablename);
        $returndata = $this->db->get();
        $num = $returndata->num_rows();
        return $num;
    }

    //rows count with conduction
    public function rowcountcondition($tablename,$conduction){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
        $returndata = $this->db->get();
        $num = $returndata->num_rows();
        return $num;
    }

    //select data all
    public function select($tablename,$orderby=NULL){
        $this->db->select('*');
        $this->db->from($tablename);
		$this->db->order_by($orderby);
        $returndata = $this->db->get();
        return $returndata->result();
    }
    
    public function selectdata($tablename,$conduction=NULL,$orderby=NULL){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
		$this->db->order_by($orderby);
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //maual select
    public function manualselect($query){
        $dataquery = $this->db->query($query);
        $result = $dataquery->result();
        return $result;
    }

    //select data all with conduction
    public function selectconduction($tablename,$conduction,$orderby=NULL){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
		$this->db->order_by($orderby);
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //select data by conduction
    public function selectorderby($tablename,$conduction,$orderby=''){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
        $this->db->order_by($orderby);
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //select data by conduction
    public function selectorderbylimit($tablename,$conduction,$orderby='',$limit='',$limitto=NULL){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
        $this->db->order_by($orderby);
        $this->db->limit($limit,$limitto);
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //update data
    public function updatedata($tablename,$updatedata,$conduction){
        $this->db->where($conduction);
        $this->db->update($tablename,$updatedata);
        //echo $this->db->last_query();
        $return = $this->db->affected_rows();
        return $return;
    }
    
    //delete data peramently
    public function deleterecord($tablename,$conduction){
        $this->db->where($conduction);
        $this->db->delete($tablename);
        $return = $this->db->affected_rows();
        return $return;
    }

    //login session 
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginMe($userid,$password,$type=""){
        $sql = "SELECT * FROM `sms_regusers` WHERE (username ='$userid' OR reg_id = '$userid' OR mailid = '$userid') AND password = '$password' AND accmode = '1' AND status = '1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result) != 0){
            $data['userdata'] = $result;
        }else{
            $usql = "SELECT * FROM `sms_users` WHERE (username ='$userid' OR id_num = '$userid' OR mail_id = '$userid') AND password = '$password' AND status = '1' AND accmode = '1'";
            $uquery = $this->db->query($usql);
            $uresult = $uquery->result();
            $data['userdata'] = $uresult;
        }
        if(!empty($data)){
            return $data;
        } else {
            return array();
        }
    }

    function loginlockscreen($userid,$password,$type=""){
        $sql = "SELECT * FROM `sms_regusers` WHERE (username ='$userid' OR reg_id = '$userid' OR mailid = '$userid') AND password = '$password' AND accmode = '1' AND status = '1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result) != 0){
            $data['userdata'] = $result;
        }else{
            $usql = "SELECT * FROM `sms_users` WHERE (username ='$userid' OR id_num = '$userid') AND password = '$password' AND status = '1' AND accmode = '1'";
            $uquery = $this->db->query($usql);
            $uresult = $uquery->result();
            $data['userdata'] = $uresult;
        }
        if(!empty($data)){
            return $data;
        } else {
            return array();
        }
    }
    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    
    public function checkUserExist($userId){
    	$regusers = $this->manualselect("select * from sms_regusers where mailid = '$userId' OR username = '$userId'");
    	if(count($regusers) != 0){
			$result = $regusers;
		}else{
    		$users = $this->manualselect("select * from sms_users where username = '$userId' OR mail_id = '$userId'");
    		$result = $users;
		}
        return $result;
    }

    //owner account
    public function ownaccountcnt(){
        $this->db->where('status','1');
        $data = $this->db->get('sms_regusers');
        return $data->result();
    }

    public function mailcheck($Emailid = ''){
        $this->db->where(array('mailid'=>$Emailid));
        $data = $this->db->get('sms_regusers');
        return $data->result();
    }

    public function mobilecheck($Mobile = ''){
        $this->db->where(array('mobile'=>$Mobile));
        $data = $this->db->get('anu_users');
        return $data->result();
    }

    public function syllabustypes($schoolid,$branchid){
        //default syllabus
        $syllabus = $this->selectdata('sms_scl_types',array('status'=>1));
        $schoolsyllubas = $this->selectdata('sms_schoolinfo',array('school_id'=>$schoolid,'branch_id'=>$branchid));
        $scltypes = explode(',', $schoolsyllubas['0']->scl_types);
        $i=0;
        $typesyllabus = array();
        foreach($syllabus as $value){
            @$scltype = $scltypes[$i];
            if(in_array($value->id, $scltypes)){
                $typesyllabus[$value->id] = $value->type;
            }
        $i++;}
        return $typesyllabus;
    }
}
