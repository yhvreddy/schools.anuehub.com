<?php
class Model_dashboard extends CI_Model{

    //insert new data to table
    public function insertdata($tablename,$insertdata){
        $this->db->insert($tablename,$insertdata);
        $return = $this->db->insert_id();
        return $return;
    }

    //select data
    public function selectdata($tablename,$conduction,$orderby = NULL){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
        $this->db->order_by($orderby, "DESC");
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //Or conduction
	public function selectwithorconduction($tablename,$conduction,$whereconduction = NULL,$orderby = NULL,$limit = NULL){
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where($conduction);
		if(!empty($whereconduction)) {
			$this->db->where($whereconduction);
		}
		$this->db->order_by($orderby, "DESC");
		$this->db->limit($limit);
		$returndata = $this->db->get();
		return $returndata->result();
	}

    public function selectorderby($tablename,$conduction,$orderby=''){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
        $this->db->order_by($orderby);
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //record data
    public function sedetails($branchid,$schoolid,$regid){
        $students = $this->selectdata('sms_admissions',array('branch_id'=>$branchid,'school_id'=>$schoolid,'id_num'=>$regid));
        if(count($students) != 0){
            return $students[0];
        }else{
            $employee = $this->selectdata('sms_employee',array('branch_id'=>$branchid,'school_id'=>$schoolid,'id_num'=>$regid));
            return $employee[0];
        }
    }

    //select data by conduction
    public function selecteddata($tablename,$conduction,$orderby='',$limit='',$limitto=''){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
        $this->db->order_by($orderby);
        $this->db->limit($limit,$limitto);
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //select custom data
    public function customquery($query){
        $dataquery = $this->db->query($query);
        $result = $dataquery->result();
        return $result;
    }

    //join tables
    public function jointables($select,$from,$join){
        $this->db->select($select);
        $this->db->from($from);
        $this->db->join($join);
        $result = $this->db->get();
    }

    //update data
    public function updatedata($setdata,$wheredata,$tablename){
        $this->db->set($setdata);
        $this->db->where($wheredata);
        $this->db->update($tablename);
        //return $this->db->last_query();
        $return = $this->db->affected_rows();
        return $return;
    }

    //delete data
    public function deletedata($wheredata,$tablename){
        $this->db->where($wheredata);
        $this->db->delete($tablename);
        $return = $this->db->affected_rows();
        return $return;
    }

    //Time or date ago
    public function daysago($date = NULL) {
        $timestamp = strtotime($date);

        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60","60","24","30","12","10");

        $currentTime = time();
        if($currentTime >= $timestamp) {
            $diff     = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . "(s) ago ";
        }
    }
    
    //Two Dates differences
    public function datediff($startingdate = NULL,$endingdate = NULL){
        $date1 = date_create($startingdate);
        $date2 = date_create($endingdate);
        //difference between two dates
        $diff = date_diff($date1,$date2);

        $text       = 'The difference is ';
        $year       =  $diff->y;
        $month      =  $diff->m;
        $days       =  $diff->d;
        $hours      =  $diff->h;
        $minutes    =  $diff->i;
        $secound    =  $diff->s;

        $daysdiff   =  $diff->format("%a");

        return $data = array('text'=>$text,'year'=>$year,'month'=>$month,'days'=>$days,'hours'=>$hours,'min'=>$minutes,'sec'=>$secound,'diff'=>$daysdiff);

        //count days
        //echo 'Days Count - '.$diff->format("%a");
    }
    
    //Days time remaining
    public function remaining($datetime){
        //Convert to date
        $datestr=$datetime;//Your date
        $date=strtotime($datestr);//Converted to a PHP date (a second count)

        //Calculate difference
        $diff=$date-time();//time returns current time in seconds
        $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
        $hours=round(($diff-$days*60*60*24)/(60*60));

        //Report
        //echo "$days days $hours hours remain<br />";
        return $data = array('days'=>$days,'hours'=>$hours);
    }

    //check licence 
    public function checklicence($regid,$id){
        $this->db->select('*');
        $this->db->from('sms_productkeys');
        $this->db->where(array('reg_id'=>$regid,'id'=>$id));
        $returndata = $this->db->get();
        return $returndata->result();
    }

    //syllabus types
    public function syllabustypes($schoolid,$branchid){
        //default syllabus
        $syllabus = $this->selectdata('sms_scl_types',array('status'=>1));
        $schoolsyllubas = $this->selectdata('sms_schoolinfo',array('school_id'=>$schoolid,'branch_id'=>$branchid));
        $scltypes = explode(',', $schoolsyllubas['0']->scl_types);
        $i=0;
        $typesyllabus = array();
        foreach ($syllabus as $value) {
            @$scltype = $scltypes[$i];
            if(in_array($value->id, $scltypes)){
                $typesyllabus[$value->id] = $value->type;
            }
        $i++;}
        return $typesyllabus;
    }

    //list of classes by syllabus
    public function classeslist($schoolid,$branchid,$typesyllabus){
        $classlist = $this->selectdata('sms_class',array('school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$typesyllabus)); 
        $classlist = unserialize($classlist['0']->class);
        $i=0;
        $listofclass = array();
        foreach ($classlist as $value) {
            $listofclass[] = $value;
        $i++;}
        return $listofclass;
    }

    //login secrity keypin veriy on high actions
    public function fourDigitspin(){ ?>
        <style type="text/css">
            .autotabbed-container {
              max-width: 680px;
              margin: 0 auto;
            }

            .autotabbed {
              width: 320px;
              /*float: left;*/
              margin: 5px auto;
              padding: 10px;
              background: rgba(255, 255, 255, 0.05);
              border: 1px solid rgba(255, 255, 255, 0.2);
              font-size: 1.3em;
              text-align: center;
            }
            .autotabbed h3, .autotabbed input {
              margin: 0 0 10 0px;
              font-size: 1em;
            }

            #autotab-toggle {
              display: block;
              width: 180px;
              margin: 10px auto;
              padding: 5px 10px;
              color: red;
              background: rgba(255, 0, 0, 0.1);
              border: 1px solid red;
              border-radius: 100px;
              text-align: center;
            }
            #autotab-toggle .on {
              display: none;
            }
            #autotab-toggle .off {
              display: inline;
            }
            #autotab-toggle.on {
              color: #0c0;
              background: rgba(0, 255, 0, 0.1);
              border-color: #090;
            }
            #autotab-toggle.on .on {
              display: inline;
            }
            #autotab-toggle.on .off {
              display: none;
            }

            .explain {
              max-width: 800px;
              margin: 20px auto;
            }

            .clear {
              height: 0;
              overflow: hidden;
              clear: both;
            }
        </style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="autotabbed-container">
          
            <div id="example4" class="autotabbed" style="float:none;">
                <input type="tel" class="text-center inputs" id="Num_one" style="height: 40px;width: 40px;" placeholder="2" name="pin_1" required="" maxlength="1" size="1" />
                <input type="tel" class="text-center inputs" id="Num_two" style="height: 40px;width: 40px;" placeholder="1" name="pin_2" required="" maxlength="1" size="1" />
                <input type="tel" class="text-center inputs" id="Num_three" style="height: 40px;width: 40px;" placeholder="2" name="pin_3" required="" maxlength="1" size="1" />
                <input type="tel" class="text-center inputs" id="Num_four" style="height: 40px;width: 40px;" placeholder="6" name="pin_4" required="" maxlength="1" size="1" />
            </div>
          
            <div class="clear"></div>

			<h6 id="ErrorMessageFourDigitspin" class="text-center text-warning"></h6>

			<script>
				$(".inputs").keyup(function (e) {
					//alert('++++++++');
					if ((e.which == 8 || e.which == 46)) {
						$(this).prev('.inputs').focus().val($(this).prev().val());
					}else{
						if (this.value.length == this.maxLength) {
							$(this).next('.inputs').focus();
						}
					}
				});
			</script>
        </div>
    <?php }

     public function norecords($image = NULL,$width = NULL,$height = NULL){ 
        if(empty($image) || $image == NULL || $image == ''){
            $image_link = base_url('assets/images/norecordfound.png');
        }else{
            $image_link = $image;
        }
        ?>
         <center>
             <img src="<?=$image_link?>" alt="No Recounds Found" class="img-responsive" style="width:80%;margin:40px auto">
         </center>
     <?php }

     public function Notifications(){
         extract($_REQUEST);
         $send_date = date('Y-m-d');
         $not_sql = $this->db->query("SELECT * FROM `order_products` WHERE `order_item_emp_id` = $uid AND `vendor_item_confirm_satus` = 0 AND `order_item_uid` != 'vendor'");
         $count = $not_sql->num_rows;
        ?>
        <link rel="stylesheet" type="text/css" href="../fonts/font-awesome.min.css">
        <b id="productAlert">
         <?php if($count > 0) { ?>
          <span class="badge badge-success" style="margin-top: -26px;color:white;display: inline;position: absolute;margin-left: 25px;background:#ef704c"><?=$count;?></span>
          <?php } ?>
        </b>
      <?php  }

      //gen admission batch
      public function adminssionbatch(){
        //admission batch
        $fromyear = date('Y');
        $toyear   = date('y',strtotime('+1year'));
        $batch = $fromyear.'-'.$toyear;
        return $batch;
      }

      //syllabus type
      public function syllabusname($conduction){
        $this->db->select('*');
        $this->db->from('sms_scl_types');
        $this->db->where($conduction);
        $returndata = $this->db->get();
        return $returndata->result();
      }

    // setter getter function
    public function setLimit($limit) {
        $this->_limit = $limit;
    }

    public function setPageNumber($pageNumber) {
        $this->_pageNumber = $pageNumber;
    }

    public function setOffset($offset) {
        $this->_offset = $offset;
    }
    
    // Count all record of table "app_articals" in database.
    public function datalistcount($tablename,$conduction) {
        $this->db->from($tablename);
        $this->db->where($conduction); 
        return $this->db->count_all_results();
    }

    // Fetch data according to per_page limit.
    public function dataselelctlist($tablename,$conduction,$orderby) {       
        $this->db->select('*');
        $this->db->from($tablename); 
        $this->db->where($conduction); 
        $this->db->order_by($orderby);        
        $this->db->limit($this->_pageNumber, $this->_offset);
        $query = $this->db->get();
        return $query->result();
    }

}
