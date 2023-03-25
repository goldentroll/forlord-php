<?php

  class Cronjob 
  {

        public function __construct() 
        {
            $this->running_time = date('Y-m-d H:i:s');
            // $CI->load->common_model();
        }

     
        public function Jobs($jobdata)
       {

            $CI =& get_instance();

            foreach ($jobdata as $row)
            {
                // echo "<pre>"; print_r($row); echo "</pre>";
                if($row){
                    $status = $this->dailyCalculateFunc($row);
                }              
            }
        }

        public function dailyCalculateFunc($data)
        {
           $current_date=date('Y-m-d H:i:s');  

           $cron_date=$data->next_run_date;
           if($cron_date==$current_date)
           {

                $history_data = array(
                "MemberId" => $data->MemberId,
                "DateAdded"     =>    $cron_date,
                // "payment_id"    =>  $data->payment_id,
                "TransactionId" => "TRAN".strtoupper(uniqid()),
                "depositid" =>  $data->id
               );
                $history_data["Credit"]    =  $interest;
                $history_data["TypeId"]   =  "23";
                $history_data["Balance"]   =  $history_data['Credit']+$userbal;
                $history_data["Description"] = "Earning From ".$packagename." (Invested amount) ".$data->amount."";
                $query_status = $CI->db->insert('arm_history',$history_data);
           }
           else
           {
               $con="PackageId='".$data->PackageId."'";
               $check_packdet=$CI->db->query("select * from arm_hyip where PackageId='".$data->PackageId."'");
               echo "<pre>"; print_r($check_packdet); echo "</pre>";
             
               // if($check_packdet->row())
               // {
               //    $duration=$check_packdet->duration;

               //    $diff=date_diff($current_date,$cron_date);

               //    echo $diff;
               // }
           }


        }

     
    }
?>