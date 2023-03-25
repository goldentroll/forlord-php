<?php

  class Cron {

        public function __construct() 
        {
            $this->running_time = date('Y-m-d H:i:s');
           
        }

     
        public function Jobs($jobdata) {

            $CI =& get_instance();
            // pr($jobdata);
            foreach ($jobdata as $row) {
                
                if($row){
                    $status = $this->dailyCalculateFunc($row);
                    // if($row->periord_name='daily') {
                    //     $status = $this->dailyCalculateFunc($row);
                    // } else {
                    //     $status = $this->CalculateFunc($row);
                    // }
                    // $this->$func_name($row);
                }

                
            }
        }

        private function DifferenceDate($rundate, $duration) {
            if($duration> 0) {
                $today = date("Y-m-d H:i:s");

                $diff1 = abs(strtotime($today) - strtotime($rundate));
                
                $years = floor($diff1 / (365*60*60*24));
                $months = floor(($diff1 - $years * 365*60*60*24) / (30*60*60*24));
                $months2 = floor(($diff1 - $years * 365*60*60*24) / (30*60*60*24*2));
                $months3 = floor(($diff1 - $years * 365*60*60*24) / (30*60*60*24*3));
                $months6 = floor(($diff1 - $years * 365*60*60*24) / (30*60*60*24*6));
                $days = floor(($diff1 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                $customdays = floor(($diff1 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24*$duration));
                $bi_weeks = floor(($diff1 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24*3));
                $weeks = floor(($diff1 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24*7));
                $hours = floor(($diff1 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60));


                // switch ($period_id) {
                //     case '5':
                //         $period = "1 hour";
                //         // $hours = round((strtotime($today) - strtotime($rundate))/3600,0);
                //         $diff = $hours;
                //         break;

                //     case '1':
                //         $period = "1 day";
                //         // $days = round((strtotime($today) - strtotime($rundate)));
                //         $diff = $days;
                //         break;

                //     case '2':
                //         $period = "7 days";
                //         // $diff = round((strtotime($today) - strtotime($rundate))/(60*60*24*7),0);
                //         $diff = $weeks;
                //         break;

                //     case '3':
                //         $period = "1 month";
                //         // $diff = round((strtotime($today) - strtotime($rundate))/(60*60*24*7),0);
                //         $diff = $months;
                //         break;

                //     case '4':
                //         $period = "1 year";
                //         $diff = $years;
                //         break;

                //     case '6':
                //         $period = "3 days";
                //         $diff = $bi_weeks;
                //         break;

                //     case '7':
                //         $period = "2 months";
                //         $diff = $months2;
                //         break;

                //     case '8':
                //         $period = "3 months";
                //         $diff = $months3;
                //         break;

                //     case '9':
                //         $period = "6 months";
                //         $diff = $months6;
                //         break;

                //     case '10':
                //         $period = $duration." days";
                //         $diff = $customdays;
                //         break;
                // }

                $period = $duration." days";
                $diff = $days;
                
                $count = $period.','.$diff;
                return $count;
            }

        }

        private function interestCalc($data) {
            $CI =& get_instance();
             
        
                $interest =  $data->amount * ($data->interest / 100);
        
            return $interest;
        }

        private function updateHistory($data, $new_run_date) {

            $CI =& get_instance();
       $userbal = $CI->common_model->Getcusomerbalance($data->MemberId);

       $package=$CI->common_model->GetRow("id='".$data->id."'","deposit");
       $packageid=$package->PackageId;
       $packageidname=$CI->common_model->GetRow('PackageId='.$packageid.'',"arm_hyip");

       $packagename=$packageidname->PackageName;
        // calculate deposit interest
            $interest = $this->interestCalc($data);

                  // // $accept_date = $new_run_date;
                  //       $date = $accept_date;
                  //         $date = strtotime($accept_date);
                  //        $date = strtotime("+ 1 day" , $date);
                  //        $next_run_date = date('Y-m-d H:i:s', $date);

            $history_data = array(
                "MemberId" => $data->MemberId,
                "DateAdded"     =>    $new_run_date,
                // "payment_id"    =>  $data->payment_id,
                "TransactionId" => "TRAN".strtoupper(uniqid()),
                "depositid" =>  $data->id
            );

            if($data->mechureddate) {

                // 31-8-16 >= 30-8-16
                 // echo $new_run_date;
                 // echo $data->mechureddate
                if($new_run_date >= $data->mechureddate) {

                    if($data->interest < number_format(100, 2)) {
                        if($data->status=='1') {
                            $return_amount = $data->amount * ($data->amount / 100 );
                            $history_data["Credit"]    =  $return_amount;
                               $history_data["Balance"]   =  $history_data['Credit']+$userbal;
                            $history_data["TypeId"]   =  "24";
                            $history_data["Description"] = 'Deposit amount is Matured';    
                        } else {
                            $history_data["Credit"]    =  $data->amount;
                               $history_data["Balance"]   =  $history_data['Credit']+$userbal;
                            $history_data["TypeId"]   =  "24";
                            $history_data["Description"] = 'Deposit amount is Matured';    
                        }
                    }
                    $query_status = $CI->db->insert('arm_history',$history_data);

                } else  {
                    $history_data["Credit"]    =  $interest;
                    $history_data["TypeId"]   =  "23";
                        $history_data["Balance"]   =  $history_data['Credit']+$userbal;
                    $history_data["Description"] = "Earning From ".$packagename." (Invested amount) ".$data->amount."";
                    $query_status = $CI->db->insert('arm_history',$history_data);
                    // echo $CI->db->last_query();
                }

            } else {
                

                $history_data["Credit"]    =  $interest;
                $history_data["TypeId"]   =  "23";
                   $history_data["Balance"]   =  $history_data['Credit']+$userbal;
                 $history_data["Description"] = "Earning From ".$packagename." (Invested amount) ".$data->amount."";
                $query_status = $CI->db->insert('arm_history',$history_data);
             

            }
             // pr($history_data);
             
        }

        private  function dailyCalculateFunc($data) {

            $CI =& get_instance();

            $count_data = $this->DifferenceDate($data->next_run_date, $data->duration);
            if($count_data) {
                $countdatas = explode(',', $count_data);
                $period = $countdatas[0];

                if($countdatas[1]==0) {
                    $iteration = 1;    
                } else {
                    $iteration = $countdatas[1] + 1;
                }


                for ($i=1; $i <= $iteration; $i++) {

                    $CI->db->select('*');
                    $CI->db->where('id',$data->id);
                    $query=$CI->db->get('deposit');
                    $inves_data = $query->row();
                    
                    if($i=='1') {
                        
                        $new_run_date = $data->next_run_date;

                    } else {
                        $new_run_date = $inves_data->next_run_date;
                        
                    }

                    // if($data->delay_earning){

                    //     $delay_earning = '+ '.$data->delay_earning.' day';
                    //     $deposit_date = $inves_data->invest_date;
                        
                    //     $date1 = strtotime($delay_earning, $deposit_date);
                    //     $delay_run_date = date('Y-m-d H:i:s', $date1);

                    //     if($delay_run_date > $new_run_date) {

                    //         $deposit_data = array(
                    //             "run_date"     =>  $new_run_date,
                    //         );
                    //         $CI->db->where('depositid',$data->depositid);
                    //         $query_status = $CI->db->update('deposit',$deposit_data);

                    //     } else {

                    //         // update history and release deposit
                    //         $this->updateHistory($data, $new_run_date);
                    //     }

                    // } else

                    if($data->workingdays=='1') {

                      
                        $work_day = date('N', strtotime($new_run_date));

                        if($work_day=='6' || $work_day=='7') {

                           
                            $deposit_data = array(
                                "next_run_date"     =>  $new_run_date,
                            );
                            $CI->db->where('id',$data->id);
                           
                            $query_status = $CI->db->update('deposit',$deposit_data);

                        } else {
                          

                            // calculate deposit interest
                            //$interest = $this->interestCalc($data);

                            // update history and release deposit
                            $this->updateHistory($data, $new_run_date);
                        }
                

                    } else {
                       

                        // calculate deposit interest
                        //$interest = $this->interestCalc($data);

                        // update history and release deposit
                        $this->updateHistory($data, $new_run_date);

                    }
                    

                    // $add_date = "+".$i." ".$period;
                    $add_date = "+ ".$period;
                    $today = strtotime($new_run_date);
                    $date = strtotime($add_date, $today);

                    $next_run_date = date('Y-m-d H:i:s', $date);  

                    /* check investment is matured ? */
                    if($data->mechureddate) {
                      
                        if($new_run_date >= $data->mechureddate) {


                            $cron_data = array(
                                "next_run_date"     =>  $new_run_date,
                                "status"  =>   '2'
                            );
                            $CI->db->where('id',$data->id);
                            $query_status = $CI->db->update('deposit',$cron_data);
                           
                            return true;
                            exit;
                            // $i = $iteration + 1;
                            
                        } else {

                          

                        $accept_date = $new_run_date;
                        $date = $accept_date;
                          $date = strtotime($accept_date);
                         $date = strtotime("+ 1 day" , $date);
                         $next_run_date1 = date('Y-m-d H:i:s', $date);

                            $cron_data = array(
                                "next_run_date"     =>  $next_run_date1
                            );    
                            $CI->db->where('id',$data->id);
                            $query_status = $CI->db->update('deposit',$cron_data);
                        }

                    } else {
                       
                           $accept_date = $new_run_date;
                        $date = $accept_date;
                          $date = strtotime($accept_date);
                         $date = strtotime("+ 1 day" , $date);
                         $next_run_date1 = date('Y-m-d H:i:s', $date);
                        $cron_data = array(
                            "next_run_date"     =>  $next_run_date1
                        );    
                        $CI->db->where('id',$data->id);
                        $query_status = $CI->db->update('deposit',$cron_data);
                    }
                    
                }
            }
            
        }

        private  function CalculateFunc($data) {

            $CI =& get_instance();

            $count_data = $this->DifferenceDate($data->periord_id, $data->next_run_date);

            $countdatas = explode(',', $count_data);
            $period = $countdatas[0];

            if($countdatas[1]==0) {
                $iteration = 1;    
            } else {
                $iteration = $countdatas[1] + 1;
            }

            
            for ($i=1; $i <= $iteration; $i++) {

                $CI->db->select('run_date');
                $CI->db->where('depositid',$data->depositid);
                $query=$CI->db->get('deposit');
                $inves_data = $query->row();
                
                if($i=='1') {
                    
                    $new_run_date = $data->run_date;

                } else {
                    $new_run_date = $inves_data->run_date;
                    
                }

                // calculate deposit interest 
                if($data->compound_rate) {

                    // $insterest_amount =  100 * (20 / 100) => 20 ;
                    $deposit_interest =  $data->compound * ($data->rate / 100);
                    $compound_interest = $deposit_interest * ($data->compound_rate / 100);
                    // $interest = 20 * (20 / 100) => 4;

                    $interest = $deposit_interest - $compound_interest;
                    $compound = $data->compound + $compound_interest;

                    $deposit_data = array(
                        "compound"     =>  $compound
                    );
                    $CI->db->where('depositid',$data->depositid);
                    $query_status = $CI->db->update('deposit',$deposit_data);


                } else {
                    $interest =  $data->amount * ($data->rate / 100);
                }
                

                $history_data = array(
                    "uusersid" => $data->uusersid,
                    "date"     =>  $new_run_date,
                    // "payment_id"    =>  $data->payment_id,
                    "transactionid" => "TRAN".strtoupper(uniqid()),
                    "depositid" =>  $data->depositid
                );
                

                if($new_run_date==$data->mature_date) {
                    if($data->rate < number_format(100, 2)) {

                        if($data->rtn_principal_status=='1') {
                            $return_amount = $data->amount * ($data->rtn_principal / 100 );
                            $history_data["amount"]    =  $return_amount;
                            $history_data["type"]   =  "release_deposit";
                            $history_data["description"] = 'Deposit amount is Matured';    
                        } else {
                            $history_data["amount"]    =  $data->amount;
                            $history_data["type"]   =  "release_deposit";
                            $history_data["description"] = 'Deposit amount is Matured';    
                        }
                        $query_status = $CI->db->insert('history',$history_data);
                        
                    }
                } else {
                    $history_data["amount"]    =  $interest;
                    $history_data["type"]   =  "interest";
                    $history_data["description"] = 'Interest Earning for investment';
                    $query_status = $CI->db->insert('history',$history_data);
                }
                

                // $add_date = "+".$i." ".$period;
                $add_date = "+ ".$period;
                $today = strtotime($new_run_date);
                $date = strtotime($add_date, $today);
                $next_run_date = date('Y-m-d H:i:s', $date);  

                /* check investment is matured ? */
                if($new_run_date==$data->mature_date)
                {
                    $cron_data = array(
                        "run_date"     =>  $new_run_date,
                        "status"  =>   'matured'
                    );
                    $CI->db->where('depositid',$data->depositid);
                    $query_status = $CI->db->update('deposit',$cron_data);
                    return true;
                    exit;
                    // $i = $iteration + 1;
                    
                } else {
                    $cron_data = array(
                        "run_date"     =>  $next_run_date
                    );    
                    $CI->db->where('depositid',$data->depositid);
                    $query_status = $CI->db->update('deposit',$cron_data);
                }
                // pr($cron_data);
                
                
            }
        }

    /*    
        private function weekly() {
            echo 'weekly';
        }

        private function monthly() {
            echo 'monthly';
        }

        private function yearly() {
            echo 'yearly';
        }
       

        private  function hourly($data) {
            
            $today = date("Y-m-d H:i:s");
            $hourdiff = round((strtotime($today) - strtotime($data->run_date))/3600,0);
            $count  = $hourdiff;

            for ($i=1; $i <= $count; $i++) {

                $add_date = "+".$i." hour";
                $today = strtotime($data->run_date);
                $date = strtotime($add_date, $today);
                $next_run_date = date('Y-m-d H:i:s', $date);  

                // calculate deposit interest 
                $insterest =  $data->amount * ($data->rate/100);

                $CI =& get_instance();
                $history_data = array(
                    "uusersid" => $data->uusersid,
                    "amount"    =>  $insterest,
                    "type"   =>  "interest",
                    "description" => 'Interest Earning for investment',
                    "date"     =>  $next_run_date,
                    "payment_id"    =>  $data->payment_id,
                    "transactionid" => "TRAN".strtoupper(uniqid()),
                    "depositid" =>  $data->depositid
                );
                
                $query_status = $CI->db->insert('history',$history_data);

                $cron_data = array(
                    "run_date"     =>  $next_run_date
                );
                $CI->db->where('depositid',$data->depositid);
                $query_status = $CI->db->update('deposit',$cron_data);
                
            }

        }

    */
    }
?>