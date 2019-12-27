<?php
class Model_integrate extends CI_Model{



    //userdata
    public function selectdata($tablename,$conduction=NULL){
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($conduction);
        $returndata = $this->db->get();
        return $returndata->result();
    }
    //accedamic year
    public function academicyear($id){
        $academic = $this->selectdata('sms_academic_years',array('sno'=>$id,'academic_status'=>1));
        return $academic;
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

    public function userdata(){
        $usertype = $this->session->userdata['type'];
        $regid  =   $this->session->userdata['regid'];
        $id     =   $this->session->userdata['id'];
        if($usertype == 'admin' || $usertype == 'superadmin' || $usertype == 'super-admin'){
            $data = $this->selectdata('sms_regusers',array('reg_id'=>$regid,'sno'=>$id));
            $data = $data[0];
        }else{
            $data[] = '';
            $schoolid   =   $this->session->userdata['school']->school_id;
            $branchid   =   $this->session->userdata['school']->branch_id;
            $data = $this->sedetails($branchid,$schoolid,$regid);
        }
        return $data;
    }

    //clean string without any special chars
    public function cleanstring($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    //password hash
    public function secured_hash($input){
        $output = password_hash($input,PASSWORD_DEFAULT);
        return $output;
    }

    //check hashpassword
    public function verifyhashpassword($plantext,$hash){
        if (password_verify($plantext, $hash)) {
            return 1;
        } else {
            return 0;
        }
    }

    // Genereate scrial Keys
    public function genserialkey(){
        $template = 'xx99-xx99-xx99-xxxx';
        $k = strlen($template);
        $sernum = "";
        for($i = 0; $i < $k; $i++){
            switch($template[$i]){
                case 'x': $sernum .= chr(rand(65,90)); break;
                case '9': $sernum .= rand(0,9); break;
                case '-': $sernum .= '-'; break;    
            }
        }
        return $sernum;
    }

    //save generated keys
    public function generateproductkeys(){
        $serialkey = $this->genserialkey();
        $this->db->query("INSERT INTO `sms_productkeys`(`licencekey`) VALUES ('$serialkey')");
        $return = $this->db->affected_rows();
        return $return;
    }

    //geting first litter from each word
    public function initials($str) {
        $ret = '';
        foreach (explode(' ', $str) as $word)
            @$ret .= strtoupper($word[0]);
        return $ret;
    }

    //ramdom number gen--
    public function generateRandom($min, $max) {
        if (function_exists('random_int')):
            return random_int($min, $max); // more secure
        elseif (function_exists('mt_rand')):
            return mt_rand($min, $max); // faster
        endif;
        return rand($min, $max); // old
    }

    //ramdom char---
    public function random_string($length) {
        $key = '';
        $keys = array_merge(range('A', 'Z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $key;
    }

    //genrate letters A-Z
    public function generatletters($totallength=NULL){
        $len = -1;
        $length = '';
        for ($char = 'A'; $char <= 'Z'; $char++) {
            $len++;
            if ($len == $totallength) {
                break;
            }
            $length .= $char.',';
        }

        return json_encode(trim($length,','));
    }

    //create dir's
    public function createdir($branch_id,$school_id){
        //create dir
        $admission      = './uploads/files/admissions/';
        $enquery        = './uploads/files/enquery/';
        $employee       = './uploads/files/employee/';
        $invoices       = './uploads/files/invoices/';
        $notice         = './uploads/files/notice/';
        $others         = './uploads/files/others/';
        //$schooldata     = './uploads/files/schooldata/';
        $logoimages     = './uploads/files/schooldata/logos/';
        $documents      = './uploads/files/schooldata/documents/';

        $qremployees    = './uploads/files/qrcode/employees/';
        $qradmission    = './uploads/files/qrcode/std_admissions/';
        $qrenquery      = './uploads/files/qrcode/std_enquery/';
        $qrother        = './uploads/files/qrcode/other/';
    

        //logos
        if(is_dir($logoimages.$branch_id)){
            if(is_dir($logoimages.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($logoimages.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($logoimages.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($logoimages.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //documents
        if(is_dir($documents.$branch_id)){
            if(is_dir($documents.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($documents.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($documents.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($documents.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //admissions
        if(is_dir($admission.$branch_id)){
            if(is_dir($admission.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($admission.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($admission.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($admission.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //employee
        if(is_dir($employee.$branch_id)){
            if(is_dir($employee.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($employee.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($employee.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($employee.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //enquery
        if(is_dir($enquery.$branch_id)){
            if(is_dir($enquery.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($enquery.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($enquery.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($enquery.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //invoices
        if(is_dir($invoices.$branch_id)){
            if(is_dir($invoices.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($invoices.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($invoices.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($invoices.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //notice
        if(is_dir($notice.$branch_id)){
            if(is_dir($notice.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($notice.$branch_id.'/'.$school_id,777);
            }
        }else{
            $bdir = mkdir($notice.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($notice.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //other
        if(is_dir($others.$branch_id)){
            if(is_dir($others.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($others.$branch_id.'/'.$school_id,777);
            }
        }else{
            $bdir = mkdir($others.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($others.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //schooldata
        /*if(is_dir($schooldata.$branch_id)){
            if(is_dir($schooldata.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($schooldata.$branch_id.'/'.$school_id,777);
            }
        }else{
            $bdir = mkdir($schooldata.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($schooldata.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }*/

        //qr employee
        if(is_dir($qremployees.$branch_id)){
            if(is_dir($qremployees.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($qremployees.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($qremployees.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($qremployees.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //qr admission
        if(is_dir($qradmission.$branch_id)){
            if(is_dir($qradmission.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($qradmission.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($qradmission.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($qradmission.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //qr enquery
        if(is_dir($qrenquery.$branch_id)){
            if(is_dir($qrenquery.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($qrenquery.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($qrenquery.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($qrenquery.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }

        //qr other
        if(is_dir($qrother.$branch_id)){
            if(is_dir($qrother.$branch_id.'/'.$school_id)){ }else{
                $sdir = mkdir($qrother.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }else{
            $bdir = mkdir($qrother.$branch_id,0777, TRUE);
            if($bdir){
                $sdir = mkdir($qrother.$branch_id.'/'.$school_id,0777, TRUE);
            }
        }
    }                

    //sms function
    public function smssendingfunction($apikey,$mobilenumber,$senderschoolid,$sendmessage){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender= echo $senderschoolid&route=4&mobiles= echo $mobilenumber&authkey= echo $apikey&encrypt=&country=0&message= echo $sendmessage&flash=&unicode=&schtime=&afterminutes=&response=json&campaign=",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }

        curl_close($curl);
    }

    //geneate serialkey
    public function sernum(){
        $template = 'xx99-xx99-xx99-xxxx';
        $k = strlen($template);
        $sernum = "";
        for($i = 0; $i < $k; $i++){
            switch($template[$i]){
                case 'x': $sernum .= chr(rand(65,90)); break;
                case '9': $sernum .= rand(0,9); break;
                case '-': $sernum .= '-'; break;    
            }
        }
        return $sernum;
    }

    public function gluttarNotification($title='',$text = NULL,$image = NULL){ ?>
       <script type="text/javascript">
            $(document).ready(function(){
               $.gritter.add({
                    title:"<?=$title?>",
                    text:"<?=$text?>",
                    <?php if($image != ''){ ?>
                        image:"<?=$image?>", //assets/img/user/user-12.jpg
                    <?php } ?>
                    sticky:false,
                    time:'',
                    //fade_in_speed: 100,
                    //fade_out_speed: 100,
                    class_name:"my-sticky-class"
                });
               return false;
            });
        </script> 
    <?php }

    //Time or date ago
    public function daysago($date = NULL) {
        $timestamp = strtotime($date);

        $strTime = array("second", "min", "hour", "day", "month", "year");
        $length = array("60","60","24","30","12","10");

        $currentTime = time();
        if($currentTime >= $timestamp) {
            $diff = time()- $timestamp;
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
        foreach($syllabus as $value){
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
        if(count($classlist) != 0){
            $classlist = unserialize($classlist['0']->class);
            $i=0;
            $listofclass = array();
            foreach ($classlist as $value) {
                $listofclass[] = $value;
            $i++;}
        }else{
            $listofclass = array();
        }
        return $listofclass;
    }

    //list of sections by class
	public function classSectionslist($schoolid,$branchid,$typesyllabus,$classname){
		$classlist = $this->selectdata('sms_section',array('school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$typesyllabus,'class'=>$classname));
		if(count($classlist) != 0){
			$classlist 	= 	unserialize($classlist['0']->section);
			$classlist	=	implode(',',$classlist);
			$classname	=	str_replace('"','',$classlist);
			$classlist	=	explode(',',$classname);
			$i=0;
			$listofclass = array();
			foreach ($classlist as $value) {
				$listofclass[] = $value;
				$i++;}
		}else{
			$listofclass = array();
		}
		return $listofclass;
	}

    //Qrcode Generate
    public function qrcodeGen($qrdata,$saveimagepath){
        
        $this->load->library('ciqrcode');
        $qr_image=rand().'.png';
        $params['data'] = $qrdata;
        $params['level'] = 'H';
        $params['size'] = 8;
        $params['savename'] = FCPATH.$saveimagepath.$qr_image;
        if($this->ciqrcode->generate($params))
        {
            $qrimage = array('url'=>$qr_image,'image'=>$qr_image);
            return $qrimage;	
        }
        
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
        <div class="autotabbed-container">
            <div id="example4" class="autotabbed" style="float:none;">
                <input type="tel" class="text-center" placeholder="2" name="pin_1" required="" maxlength="1" size="1" />
                <input type="tel" class="text-center" placeholder="1" name="pin_2" required="" maxlength="1" size="1" />
                <input type="tel" class="text-center" placeholder="2" name="pin_3" required="" maxlength="1" size="1" />
                <input type="tel" class="text-center" placeholder="6" name="pin_4" required="" maxlength="1" size="1" />
            </div>
            <div class="clear"></div>
        </div>
    <?php }

    //no records found        
    public function norecords(){ ?>
         <center>
             <img src="<?=base_url()?>assets/images/norecordfound.png" alt="No Recounds Found" class="img-responsive" style="width:60%;margin:40px auto">
         </center>
    <?php }


    //mail attachments
	public function attachedfiles($attachment,$extension,$name){
    	?>
		<li class="fa-file">
			<div class="document-file">
				<a href="<?=base_url($attachment)?>" target="_blank">
					<?php if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif'){ ?>
						<span data-toggle="tooltip" title="<?=strtolower($name)?>"><img src="<?=base_url($attachment)?>" class="img-responsive" style="width: 100%"></span>
					<?php }else if($extension == 'pdf'){ ?>
						<i class="fas fa-file-pdf" data-toggle="tooltip" title="<?=strtolower($name)?>"></i>
					<?php }else if($extension == 'doc' || $extension == 'docx' || $extension == 'docm'){ ?>
						<i class="fas fa-file-word" data-toggle="tooltip" title="<?=strtolower($name)?>"></i>
					<?php }else if($extension == 'ppt' || $extension == 'ppsx' || $extension == 'pptx' || $extension == 'pptm'){ ?>
						<i class="fas fa-file-powerpoint" data-toggle="tooltip" title="<?=strtolower($name)?>"></i>
					<?php }else if($extension == 'csv' || $extension == 'xlsx' || $extension == 'xlsm'){ ?>
						<i class="far fa-file-excel" data-toggle="tooltip" title="<?=strtolower($name)?>"></i>
					<?php }else if($extension == 'zip' || $extension == 'rar' || $extension == '7z' || $extension == 'TAR'){ ?>
						<i class="fas fa-file-archive" data-toggle="tooltip" title="<?=strtolower($name)?>"></i>
					<?php }else if($extension == 'txt'){ ?>
						<i class="far fa-file-alt" data-toggle="tooltip" title="<?=strtolower($name)?>"></i>
					<?php }else{ ?>
						<i class="far fa-copy" data-toggle="tooltip" title="<?=strtolower($name)?>"></i>
					<?php } ?>
				</a>
			</div>
			<div class="document-name"><a href="javascript:;"><?=strtolower($name)?></a></div>
		</li>
		<?php
	}
}
