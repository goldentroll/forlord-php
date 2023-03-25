<?php

error_reporting(0);

ini_set('max_execution_time', 300);
Class MemberCommission_model extends CI_Model {


	public function __construct() {
		parent::__construct();

	    $this->load->model('dashboard_model');

		}

	public function process($memberid,$table,$field)
	{

		$mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

		if ($mlsetting->Id == '6' || $mlsetting->Id == '7' ) {
			$usermlmdetail = $this->common_model->GetRow("".$field."='".$memberid."'",$table);

			$user_directid = $this->common_model->GetRow("".$field."='".$memberid."'",'arm_members');
		}else{
			$usermlmdetail = $this->common_model->GetRow("".$field."='".$memberid."'",$table);
		}

		
		$userdetail = $this->common_model->GetRow("MemberId='".$usermlmdetail->MemberId."'","arm_members");
		// echo $this->db->last_query();
		$user=$this->common_model->GetRow("MemberId='".$usermlmdetail->MemberId."'","arm_memberpayment");

		if($mlsetting->Id=='5')
		{
			$boardpackage = $this->common_model->GetRow("PackageId='".$userdetail->PackageId."'","arm_boardplan");
		}
		elseif ($mlsetting->Id=='4') 
		{
			$binarypackage = $this->common_model->GetRow("PackageId='".$userdetail->PackageId."'","arm_pv");
		}
		else
		{
			$package = $this->common_model->GetRow("PackageId='".$userdetail->PackageId."'","arm_package");
			$levelvalue = explode(",",$package->LevelCommissions);

		}



		$dcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND Status='1'",$mlsetting->TableName);
			
		//check xup direct commission status
		
		if($mlsetting->DirectCommissionStatus==1 && $mlsetting->Id==6 && $mlsetting->MTMPayStatus=='0')
		{
			if($mlsetting->DirectCommissionType==2)
				{
					
				 $dcommission = $package->PackageFee * $package->DirectCommission / 100;	

					
				}
				else
				{
					$dcommission =$package->DirectCommission;
				}

				//check member active or not in matrix 
				$dcheckmatmem = $this->common_model->GetRow("MemberId='".$user_directid->DirectId."' AND Status='1'",$mlsetting->TableName);

				if($dcheckmatmem)
				$dresult = $this->directcommission($user_directid->DirectId,$dcommission,$memberid,$package->PackageId);
		}

		//check xup level commission status
		
		if($mlsetting->LevelCommissionStatus==1 && $mlsetting->Id==6 && $mlsetting->MTMPayStatus=='0')
		{
			

			$userid =$usermlmdetail->SpilloverId;

			for($i=0;$i<count($levelvalue);$i++)
			{	
				$g=$i+1;
				$commission=0;
				if($mlsetting->LevelCommissionType==2)
				{
					
					$lcommission = $package->PackageFee * $levelvalue[$i] / 100;	
					
				}
				
				else
				{
					$lcommission =$levelvalue[$i];
				}
				

					if($mlsetting->RepeatCommissionStatus)
					{
						// echo"<br>". $commission .'> 0 && '.$usermlmdetail->DirectId.'!='.$userid.' && '.$userid.'!='.'0';
						if($lcommission > 0 && $usermlmdetail->DirectId != $userid && $userid!='0')
						{
						// echo"<br>". $lcommission .'> 0 && '.$usermlmdetail->DirectId.'!='.$userid.' && '.$userid.'!='.'0';
							//check member active or not in matrix 
							
							$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
							if($lcheckmatmem)
							$dresult = $this->levelcommission($userid,$lcommission,$g,$usermlmdetail->MemberId,$package->PackageId);
						}
					}
					else
					{
						if($lcommission > 0 && $userid!='0')
						{	
							//check member active or not in matrix 
							$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
							if($lcheckmatmem)
							$dresult = $this->levelcommission($userid,$lcommission,$g,$usermlmdetail->MemberId,$package->PackageId);
						}
					}
					
				//change SpilloverId 
				$memberdetail = $this->common_model->GetRow("".$field."='".$userid."'",$table);
				
				if($memberdetail)
				{
					$userid = $memberdetail->SpilloverId;
				}
				else
				{
					$userid='0';
				}
					
			}
		}
				
		//Check board matrix direct commission
		
		if($mlsetting->DirectCommissionStatus==1 && $mlsetting->Id==5)
		{
			if($mlsetting->DirectCommissionType==2)
			{
				
			 $dcommission = $boardpackage->PackageFee * $boardpackage->DirectCommission / 100;				
			}
			
			else
			{
				$dcommission =$boardpackage->DirectCommission;
			}

			//check member active or not in matrix 
			$dcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND Status='1'",$mlsetting->TableName);

			if($dcheckmatmem)
				$dresult = $this->directcommission($usermlmdetail->DirectId,$dcommission,$memberid,$boardpackage->PackageId);
		}


		
		//Check board matrix level commission
		if($mlsetting->LevelCommissionStatus==1 && $mlsetting->Id==5)
		{	


			$blevelvalue = explode(",",$boardpackage->LevelCommission);

			// $Spil =$usermlmdetail->SpilloverId;

			$chk_board = $this->db->query("select * from arm_boardmatrix where BoardMemberId='".$Spil."'")->row();

			// $userid = $chk_board->MemberId;

			$userid =$usermlmdetail->SpilloverId;

			for($i=0;$i<count($blevelvalue);$i++)
			{	
				$g=$i+1;


				$commission=0;
				if($mlsetting->LevelCommissionType==2)
				{
					
					$lcommission = $boardpackage->PackageFee * $blevelvalue[$i] / 100;	
					
				}
				
				else
				{
					$lcommission = $blevelvalue[$i];
				}

				$check_board = $this->db->query("select * from arm_boardmatrix where BoardMemberId='".$userid."'")->row();
				/*echo $this->db->last_query();
				echo "<br>";

				echo "send_user:".$check_board->MemberId;
				echo "<br>";*/

				$send_user = $check_board->MemberId;
				

				if($mlsetting->RepeatCommissionStatus=="1")
				{
					

					if($lcommission > 0 && $usermlmdetail->DirectId!=$send_user && $send_user!='0')
					{
						// echo"<br>". $lcommission .'> 0 && '.$usermlmdetail->DirectId.'!='.$userid.' && '.$userid.'!='.'0';
						//check member active or not in matrix 
						$lcheckmatmem = $this->common_model->GetRow("MemberId='".$send_user."' AND Status='1'",$mlsetting->TableName);
					

						if($lcheckmatmem)
						$dresult = $this->levelcommission($send_user,$lcommission,$g,$memberid,$boardpackage->PackageId);
					}
				}
				else
				{

					

					if($lcommission > 0 && $userid!='0')

					{	
						//check member active or not in matrix 
						$lcheckmatmem = $this->common_model->GetRow("MemberId='".$send_user."' AND Status='1'",$mlsetting->TableName);

						if($lcheckmatmem)
						{
							
							$dresult = $this->levelcommission($send_user,$lcommission,$g,$memberid,$boardpackage->PackageId);

						}
					}
				}
					
				//change SpilloverId 
				$memberdetail = $this->common_model->GetRow("BoardMemberId='".$userid."'",$table);
				
				if($memberdetail)
				{
					$userid = $memberdetail->SpilloverId;
				}
				else
				{
					$userid='0';
				}
					
			}

		}

		//Check board matrix board commission
		if($mlsetting->BoardCommissionStatus=="1"  && $mlsetting->Id==5)
		{

			


			$boarddet = $this->common_model->GetResults("BoardCommissionStatus='0' AND MemberCount='2'","arm_boardmatrix");
			for ($i=0; $i < count($boarddet) ; $i++) 
			{
				$bpdet = $this->common_model->GetRow("PackageId='".$boarddet[$i]->BoardId."'",'arm_boardplan');
		
				$check = $this->checkboard(array($boarddet[$i]->BoardMemberId),$boarddet[$i]->BoardId,1,$bpdet->BoardWidth,$bpdet->BoardDepth);
				if($check)
				{
					//check member active or not in matrix 
					$bcheckmatmem = $this->common_model->GetRow("MemberId='".$boarddet[$i]->MemberId."' AND Status='1'",$mlsetting->TableName);
					if($bcheckmatmem)
					{
						if($mlsetting->BoardCommissionType==2)
						{
							
							$bcommission = $bpdet->PackageFee * $bpdet->BoardCommission / 100;	
						}
						
						else
						{
							$bcommission = $bpdet->BoardCommission;
						}
						
							$bresult = $this->boardcommission($boarddet[$i]->MemberId,$bcommission,$bpdet->PackageName);
							$ubresult = $this->db->query("UPDATE arm_boardmatrix SET BoardCommissionStatus='1' WHERE BoardMemberId='".$boarddet[$i]->BoardMemberId."'");
						
						/* level commmission moving board*/
						// $send_level = $this->secondlevel($boarddet[$i]->BoardMemberId);

					}
				}

			}


		}


        //forced matrix matrix complete commission process

		if($mlsetting->MatrixCommission=="2"  && $mlsetting->Id=="1" && $mlsetting->Matrixcommissionstatus=="1")
		{

			$boarddet = $this->common_model->GetResults("MemberCount='".$mlsetting->MatrixWidth."'","arm_forcedmatrix");
			if($boarddet)
			{
				for ($i=0; $i < count($boarddet); $i++) 
				{
					
					$check = $this->checkmatrix(array($boarddet[$i]->MemberId),1,$mlsetting->MatrixWidth,$mlsetting->MatrixDepth);
					
					if($check)
					{
						
						//check member active or not in matrix 
						$bcheckmatmem = $this->common_model->GetRow("MemberId='".$boarddet[$i]->MemberId."' AND Status='1'",$mlsetting->TableName);
						$historymatmem=$this->common_model->GetRow("MemberId='".$boarddet[$i]->MemberId."' AND TypeId='4' AND Description='Matrix Completed Commission for package payment' AND Status='0'" ,'arm_history');
						if($bcheckmatmem)
						{
							if(!$historymatmem)
						    {
	                            $bresult = $this->matrixcommission($boarddet[$i]->MemberId,$package->MatrixCompletionCommission);
	                        }
						}
					}

				}
			}


		}


		//forced matrix level complete commission process
		
		if($mlsetting->MatrixCommission==1 && $mlsetting->Id==1 && $mlsetting->Matrixcommissionstatus==1)
		{	
			
			$lccount = $this->common_model->GetRowCount("SpilloverId='".$usermlmdetail->DirectId."'",$table);
			
			if($mlsetting->MatrixWidth<=$lccount)
			{	
				//check member active or not in matrix 
				$lcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND Status='1'",$mlsetting->TableName);

				if($lcheckmatmem)
				{
					$historymatmem=$this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND TypeId='4' AND Description='Level Completed Commission for package payment' AND Status='0'" ,'arm_history');
					
					if(!$historymatmem)
					{
						$this->matrixlevelcommission($usermlmdetail->DirectId,$package->LevelCompletedCommission);
					}
					

				}	

				
			}


		}
		//Check Binary own commission 

		

		if($mlsetting->OwnCommissionStatus==1 && $mlsetting->Id==4)
		{

			if($mlsetting->OwnCommissionType==2)
			{
				
				$commission = $binarypackage->PackageFee * $binarypackage->OwnCommission / 100;	
			}
			
			else
			{
				$commission =$binarypackage->OwnCommission;
			}

			


			if($commission!=0)
			{
				$owncommission=$this->owncommission($memberid,$commission);
			}

		}

		



		//Check Binary matrix direct commission

		if($mlsetting->DirectCommissionStatus==1 && $mlsetting->Id==4)
		{

			if($mlsetting->DirectCommissionType==2)
			{
				
				$dcommission = $binarypackage->PackageFee * $binarypackage->DirectCommission / 100;	
			}
			
			else
			{
				$dcommission =$binarypackage->DirectCommission;
			}

			//check member active or not in matrix 
			$dcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."'",$mlsetting->TableName);
			
			if($dcheckmatmem)
				$dresult = $this->directcommission($usermlmdetail->DirectId,$dcommission,$memberid,$binarypackage->PackageId);

		}

		// binary pair commission 

		if($mlsetting->PvStatus==1 && $mlsetting->Id==4)
		{
		
			if($binarypackage->PairCommissionType==2)
			{
				
			 $pvcommission = $binarypackage->PackageFee * $binarypackage->PairCommission / 100;	

				
			}
		
			else
			{
				$pvcommission =$binarypackage->PairCommission;
			}
			//check member active or not in matrix
     
			$pcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."'",$mlsetting->TableName);
			
			if($pcheckmatmem)
			{
				// $pcset = $this->pointvalue($usermlmdetail->DirectId,"arm_binarymatrix",1,$pvcommission);
				//$pcset = $this->pointvalue1($memberid,$usermlmdetail->DirectId,"arm_binarymatrix",1,$binarypackage);
				// $dresult = $this->paircommission();
			}
		}



		// if($mlsetting->CommissionProcess==0 && $mlsetting->Id==4 && $mlsetting->Id!=5 && $mlsetting->Id!=6 )
		// {
			
		// 	$dresult = $this->paircommission();
		// }

		//Check odd/even matrix direct commission

		if($mlsetting->DirectCommissionStatus==1 && $mlsetting->Id==7 )
		{
			if($mlsetting->DirectCommissionType==2)
				{
					
				 $dcommission = $package->PackageFee * $package->DirectCommission / 100;	

					
				}
				else
				{
					$dcommission =$package->DirectCommission;
				}

				//check member active or not in matrix 
				$dcheckmatmem = $this->common_model->GetRow("MemberId='".$user_directid->DirectId."' AND Status='1'",$mlsetting->TableName);

				if($dcheckmatmem)
				$dresult = $this->directcommission($user_directid->DirectId,$dcommission,$memberid,$package->PackageId);
		}
		

		//check direct commission status for Force,UniLevel,MonoLine Matrix  
		
		if($mlsetting->DirectCommissionStatus==1 && $mlsetting->Id!=4 && $mlsetting->Id!=5 && $mlsetting->Id!=6&& $mlsetting->Id!=9 && $mlsetting->Id!=7 )
		{


			if($mlsetting->DirectCommissionType==2)
			{
				
		      $dcommission = $package->PackageFee * $package->DirectCommission / 100;						
					
				
			}
			else
			{
				$dcommission=$package->DirectCommission;
			}
			//check member active or not in matrix 
			$dcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND Status='1'",$mlsetting->TableName);

			if($dcheckmatmem)
				$dresult = $this->directcommission($usermlmdetail->DirectId,$dcommission,$memberid,$package->PackageId);
		}


		if($mlsetting->OwnCommissionStatus==1)
		{
			if($mlsetting->OwnCommissionType==2)
			{
				$commission=$package->PackageFee * $package->OwnCommission / 100;
			}
			else
			{
				$commission=$package->OwnCommission;
			}
			if($commission!=0)
			{
				$owncommission=$this->owncommission($memberid,$commission);
			}
			
		}



		//check level commission status for Force,UniLevel,MonoLine,oddeven Matrix

	
		
		if($mlsetting->LevelCommissionStatus==1 && $mlsetting->Id!=4 && $mlsetting->Id!=5 && $mlsetting->Id!=6 &&  $mlsetting->Id!=9)
		{
			 
			$userid =$usermlmdetail->SpilloverId;
		

			for($i=0;$i<count($levelvalue);$i++)
			{	
				
				$g=$i+1;
				
				$commission=0;
				if($mlsetting->LevelCommissionType==2)
				{
					
					$lcommission = $package->PackageFee * $levelvalue[$i] / 100;
						
					
					
				}
				else
				{
					$lcommission =$levelvalue[$i];					
				}
			
				
				if($mlsetting->RepeatCommissionStatus)
				{

						

		if($lcommission > 0 && $usermlmdetail->DirectId!=$userid && $userid!='0')
		{

		    // echo"<br>". $lcommission .'> 0 && '.$usermlmdetail->DirectId.'!='.$userid.' && '.$userid.'!='.'0';
		//check member active or not in matrix 
		$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
		 // echo $this->db->last_query();
		 // echo "<br>";
		if($lcheckmatmem)
		$dresult = $this->levelcommission($userid,$lcommission,$g,$memberid,$package->PackageId);
		}


				}
				
				else
				{
					
					if($lcommission > 0)
					{	
						
						//check member active or not in matrix 
						$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
						// echo $this->db->last_query();
						// echo "<br>";
						
						if($lcheckmatmem)
						$dresult = $this->levelcommission($userid,$lcommission,$g,$memberid,$package->PackageId);
					
					}
				}
					
				//change SpilloverId 
				$memberdetail = $this->common_model->GetRow("".$field."='".$userid."'",$table);
				
				if($memberdetail)
				{
					$userid = $memberdetail->SpilloverId;
				}
				else
				{
					$userid='0';
				}
					
			}
		}



		//binary matrix level commission

		if($mlsetting->LevelCommissionStatus==1 && $mlsetting->Id==4)
		{

			 
			$userid =$usermlmdetail->SpilloverId;
			$levelvalue = explode(",",$binarypackage->pv);
		

			for($i=0;$i<count($levelvalue);$i++)
			{	
				
				$g=$i+1;
				
				$commission=0;
				if($mlsetting->LevelCommissionType==2)
				{
					
					$lcommission = $binarypackage->PackageFee * $levelvalue[$i] / 100;
						
					
					
				}
				else
				{
					$lcommission =$levelvalue[$i];					
				}
			
				
				if($mlsetting->RepeatCommissionStatus)
				{
						

							if($lcommission > 0 && $usermlmdetail->DirectId!=$userid && $userid!='0')
							{

								    // echo"<br>". $lcommission .'> 0 && '.$usermlmdetail->DirectId.'!='.$userid.' && '.$userid.'!='.'0';
								//check member active or not in matrix 
								$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
								 // echo $this->db->last_query();
								 // echo "<br>";
								if($lcheckmatmem)
								$dresult = $this->levelcommission($userid,$lcommission,$g,$memberid,$binarypackage->PackageId);
							}


				}
				
				else
				{
					
					if($lcommission > 0)
					{	
						
						//check member active or not in matrix 
						$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
						// echo $this->db->last_query();
						// echo "<br>";
						
						if($lcheckmatmem)
						$dresult = $this->levelcommission($userid,$lcommission,$g,$memberid,$package->PackageId);
					
					}
				}
					
				//change SpilloverId 
				$memberdetail = $this->common_model->GetRow("".$field."='".$userid."'",$table);
				
				if($memberdetail)
				{
					$userid = $memberdetail->SpilloverId;
				}
				else
				{
					$userid='0';
				}
					
			}
		}
	 

		//check level complete commission status
		
		if($mlsetting->MatrixCommission==1 && $mlsetting->Matrixcommissionstatus==1 && $mlsetting->Id!=4 && $mlsetting->Id!=1 && $mlsetting->Id!=5 && $mlsetting->Id!=9)
		{	       

				$lccount = $this->common_model->GetRowCount("SpilloverId='".$usermlmdetail->DirectId."'",$table);

				if($mlsetting->MatrixDepth<=$lccount)
				{	
				//check member active or not in matrix 
				$lcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND Status='1'",$mlsetting->TableName);

					if($lcheckmatmem)
					{
					$historymatmem=$this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND TypeId='4' AND Description='Level Completed Commission for package payment' AND Status='0'" ,'arm_history');

					if(!$historymatmem)
					{
					$this->matrixlevelcommission($usermlmdetail->DirectId,$package->LevelCompletedCommission);
					}


			}	


		}


		}
		

		//check matrix complete commission status

		/*if($mlsetting->MatrixCommission==2 && $mlsetting->Id!=4 && $mlsetting->Id!=1 && $mlsetting->Id!=5 && $mlsetting->Id!=9)
		{	
			
			$lccount = $this->common_model->GetRowCount("SpilloverId='".$usermlmdetail->DirectId."'",$table);
			if($mlsetting->MatrixWidth<=$lccount)
			{	
				$users =array($usermlmdetail->DirectId);
				$matrixstatus = $this->checkmatrix($users,1,$mlsetting->MatrixWidth,$mlsetting->ContentValue);
				
				if($matrixstatus)
				{
					//check member active or not in matrix 
					$lcheckmatmem = $this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND Status='1'",$mlsetting->TableName);
					if($lcheckmatmem)

						$historymatmem=$this->common_model->GetRow("MemberId='".$usermlmdetail->DirectId."' AND TypeId='4' AND Description='Matrix Completed Commission for package payment' AND Status='0'" ,'arm_history');
					
					if(!$historymatmem)
					{
						$this->matrixlevelcommission($usermlmdetail->DirectId,$package->LevelCompletedCommission);
					}
						// $this->matrixcommission($usermlmdetail->DirectId,$package->MatrixCompletionCommission);
				}
			}

		}*/



	} //function

	public function secondlevel($boardid)
	{

	
		 $getids = $this->db->query("select * from arm_boardmatrix where BoardMemberId='".$boardid."'")->row();

		 $spil_id = $getids->SpilloverId;
		 $package_board = $getids->BoardId;
		 $memberid  = $getids->MemberId;

		 $userdetail = $this->db->query("select * from arm_members where MemberId='".$memberid."'")->row();


		 $checkboard = $this->db->query("select * from arm_boardplan where PackageId='".$package_board."'")->row();
		
		 $mlsetting = $this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");

		 /*direct commissions*/


			if($mlsetting->DirectCommissionStatus==1 && $mlsetting->Id==5)
			{
				if($mlsetting->DirectCommissionType==2)
				{
					
				 $dcommission = $checkboard->PackageFee * $checkboard->DirectCommission / 100;				
				}
				
				else
				{
					$dcommission =$checkboard->DirectCommission;
				}
				//check member active or not in matrix 
				$dcheckmatmem = $this->common_model->GetRow("MemberId='".$userdetail->DirectId."' AND Status='1'",$mlsetting->TableName);

				if($dcheckmatmem)
					$dresult = $this->directcommission($userdetail->DirectId,$dcommission,$memberid,$checkboard->PackageId);
			}

			/* Own commissions */


			if($mlsetting->OwnCommissionStatus==1)
			{
				if($mlsetting->OwnCommissionType==2)
				{
					$commission=$checkboard->PackageFee * $checkboard->OwnCommission / 100;
				}
				else
				{
					$commission=$checkboard->OwnCommission;
				}
				if($commission!=0)
				{
					$owncommission=$this->owncommission($memberid,$commission);
				}
				
			}


			/* level commissions*/



			if($mlsetting->LevelCommissionStatus==1)
			{

				$blevelvalue = explode(",",$checkboard->LevelCommission);
				$userid = $spil_id;


				for($ii=0;$ii<count($blevelvalue);$ii++)
				{	
					$gg=$ii+1;
					$commission=0;
					if($mlsetting->LevelCommissionType==2)
					{
						
						$lcommissions = $checkboard->PackageFee * $blevelvalue[$ii] / 100;	
						
					}
					
					else
					{
						$lcommissions = $blevelvalue[$ii];
					}
					

					if($mlsetting->RepeatCommissionStatus=="1")
					{
						// echo"<br>". $commission .'> 0 && '.$usermlmdetail->DirectId.'!='.$userid.' && '.$userid.'!='.'0';
						if($lcommissions > 0 && $userdetail->DirectId!=$userid && $userid!='0')
						{
							
							//check member active or not in matrix 
							$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'","arm_boardmatrix");
							if($lcheckmatmem)
							$dresult = $this->levelcommission($userid,$lcommissions,$gg,$memberid,$checkboard->PackageId);
						}
					}
					else
					{

						if($lcommissions > 0 && $userid!='0')

						{	
							//check member active or not in matrix 
							$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
							if($lcheckmatmem)
							$dresult = $this->levelcommission($userid,$lcommissions,$gg,$memberid,$checkboard->PackageId);
						}
					}
						
					//change SpilloverId 
					 $memberdetail = $this->common_model->GetRow("BoardMemberId='".$userid."'",$table);
					
					if($memberdetail)
					{
						$userid = $memberdetail->SpilloverId;
					}
					else
					{
						$userid='0';
					}
						
				}

			}


	}


	public function checkmatrix($users,$status,$wcount,$level)
	{
		
		for($i=0;$i<$level;$i++)
		{

			$usids = implode(",", $users);
			//chkcount correct count
			if($i){ $chkcount = count($users) * $wcount; }else{$chkcount=$wcount;}

			$cmdetails = $this->common_model->GetResults("SpilloverId IN (".$usids.")","arm_forcedmatrix");
			 //echo"<pre>"; print_r($cmdetails); echo"</pre>";				 		
			//chkcount current members spillover count
			$mcount = count($cmdetails);
			
			if($chkcount <=$mcount && $status==1)
			{
				for($ii=0;$ii<count($cmdetails);$ii++)
				{ 
					if(!in_array($cmdetails[$ii]->MemberId, $users))
					{
						array_push($users, $cmdetails[$ii]->MemberId);
					}
				}
			}

			else
			{
				$status=0;
			}
				
		}
		return $status;

	} //function

	






	// Member direct commission process here


	public function directcommission($userid,$commission,$memberid,$packageid)
	{
		
	   $userbal = $this->common_model->Getcusomerbalance($userid);
	   $user=$this->common_model->GetRow("MemberId='".$memberid."'",'arm_members');
	   $user_rank=$this->common_model->GetRow("MemberId='".$userid."'",'arm_members');

	   $mlsetting = $this->db->query("select * from arm_matrixsetting where MatrixStatus='1'")->row();

	   if($mlsetting->Id=="5")
	   {
	   	 $checkpackage = $this->db->query("select * from arm_boardplan where PackageId='".$packageid."'")->row();

	   }
	   else if($mlsetting->Id=="4")
	   {
	    $checkpackage = $this->db->query("select * from arm_pv where PackageId='".$packageid."'")->row();

	   }
	   else
	   {
	    $checkpackage = $this->db->query("select * from arm_package where PackageId='".$packageid."'")->row();

	   }

		$username=$user->UserName;
		$trnid = 'DCOM'.rand(1111111,9999999);
		$date = date('y-m-d h:i:s');
		$data = array(
			'MemberId'=>$userid,
			'Credit'=>$commission,
			'Balance'=>$userbal+$commission,
			'Description'=>"Direct Commission From ".$username." For ".$checkpackage->PackageName,
			'TransactionId'=>$trnid,
			'DateAdded'=>$date,
			'Rankname'=>$user_rank->rank
		);

		if($userid=='1')
		{
			$data['TypeId']='11';
		}
		else
		{
			$data['TypeId']='4';
		}
		
		if($commission!=0)
		{
			
			$userdetails = $this->common_model->SaveRecords($data,'arm_history');

	
			if($userdetails)
			{
				$description="Direct Commission From ".$username." For ".$checkpackage->PackageName;
				$this->Sendmail_func($userid,$description,$commission);
				$checkmembersbal=$this->common_model->Getcusomerbalance($userid);
				// echo $this->db->last_query();
				$memberbal=number_format($checkmembersbal);   
				 
				// echo $checkmembersbal;
				$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				$checkrank=$checkmatrix->RankStatus;
				
				if($checkrank==1)
				{
					$cond="balanceAmount='".$memberbal."' AND Status='1'";
					$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
					
					// $balancerank=$checkbalrank->balanceAmount;
					
					if($checkbalrank!="")
					{
						$rank=$checkbalrank->Rank;
						 		
							$user=$userid;
							$trnid = 'RAN'.rand(1111111,9999999);
							$date = date('y-m-d h:i:s');
							$data = array(
								'MemberId'=>$user,						
								'Balance'=>$checkmembersbal,
								'Description'=>"Prmoted to achieve for target balance".' '.$rank,
								'TransactionId'=>$trnid,
								'TypeId'=>'23',
							    'Rankname'=>$checkbalrank->rank_id,
								'DateAdded'=>$date
							);
						
							$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
						   if($rankdetails)
						   {
						  	 	$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$user."'");
						   }

								
						
					}
				}
			}
		
		}
		$message = "Direct Commission Earned ".$commission;
		// $smsres = $this->sendbulksms($userid,$message);


	} //function
	
	// Member level commission process here

	public function levelcommission($userid,$commission,$lvl,$memberid,$packid)
	{
		

	  /*	echo "userid:".$userid;

		echo "<br>";*/
	$memberdet = $this->db->query("select * from arm_members where MemberId='".$memberid."'")->row();

	$memberdet_upline = $this->db->query("select * from arm_members where MemberId='".$userid."'")->row();

	$MemberRank = $this->db->query("select * from arm_members where MemberId='".$memberdet_upline->DirectId."'")->row();

		$mlsetting = $this->db->query("select * from arm_matrixsetting where MatrixStatus='1'")->row();

	   if($mlsetting->Id=="5")
	   {
	   	 $checkpackage = $this->db->query("select * from arm_boardplan where PackageId='".$packid."'")->row();

	   }
	   else if($mlsetting->Id=="4")
	   {
	    $checkpackage = $this->db->query("select * from arm_pv where PackageId='".$packid."'")->row();

	   }
	   else
	   {
	    $checkpackage = $this->db->query("select * from arm_package where PackageId='".$packid."'")->row();

	   }


		$userbal = $this->common_model->Getcusomerbalance($memberdet_upline->DirectId);
		$trnid = 'LCOM'.rand(1111111,9999999);
		$date = date('y-m-d h:i:s');

		$data = array(
			'MemberId'=>$memberdet_upline->DirectId,
			'Credit'=>$commission,
			'Balance'=>$userbal+$commission,
			'Description'=>'Indirect Commission Earned from '.$memberdet->UserName.' for this '.$checkpackage->PackageName. ' package payment',
			'TransactionId'=>$trnid,
			'Rankname'=>$MemberRank->rank,
			'DateAdded'=>$date
		);

		$data1 = array(
		'MemberId'=>$memberdet_upline->DirectId,
		'Credit'=>$commission,
		'Balance'=>$userbal+$commission,
		'Description'=>'Indirect Commission Earned from '.$memberdet->UserName.' for this '.$checkpackage->PackageName. ' package payment',
		'TransactionId'=>$trnid,
		'Rankname'=>$MemberRank->rank,
		'DateAdded'=>$date,
		'TypeId'=>'30'
		);


		if($memberdet_upline->DirectId=='1')
		{
			$data['TypeId']='11';
		}
		else
		{
			$data['TypeId']='4';
		}
	
	if($commission!="" && $commission>0)
	{

		$userdetails = $this->common_model->SaveRecords($data,'arm_history');
		$userdetails = $this->common_model->SaveRecords($data1,'arm_history');
	}
		if($userdetails)
		{

        $this->ProductLevelCommissions($memberdet_upline->DirectId,$packid,0,$memberdet_upline->DirectId);

        $memberdet_get = $this->db->query("select * from arm_members where MemberId='".$memberdet_upline->DirectId."'")->row();


        $this->dashboard_model->check_rank($memberdet_upline->DirectId);
        // $this->rank_commision($memberdet_get->DirectId,0);

			$description='Indirect Commission Earned from '.$memberdet->UserName.' for this '.$checkpackage->PackageName. ' package payment';
			$this->Sendmail_func($memberdet_upline->DirectId,$description,$commission);

			$checkmembersbal=$this->common_model->Getcusomerbalance($memberdet_upline->DirectId);
			$memberbal=number_format($checkmembersbal);   

			$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			$checkrank=$checkmatrix->RankStatus;
			if($checkrank==1)
			{
				$cond="balanceAmount='".$memberbal."' AND Status='1'";
				$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
				
				if($checkbalrank!="")
				{
					$rank=$checkbalrank->Rank;

					
						$trnid = 'RAN'.rand(1111111,9999999);
						$date = date('y-m-d h:i:s');
						$data = array(
							'MemberId'=>$memberdet_upline->DirectId,						
							'Balance'=>$checkmembersbal,
							'Description'=>"Prmoted to achieve for target balance".' '.$rank,
							'Rankname'=>$checkbalrank->rank_id,
							'TransactionId'=>$trnid,
							'TypeId'=>'23',
							'DateAdded'=>$date
						);
						
						
						$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
						if($rankdetails)
						{
							$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$memberdet_upline->DirectId."'");
						}
					
				}
			}
		}

		$message = "Level".$lvl." Commission Earned ".$commission;
		// $smsres = $this->sendbulksms($userid,$message);

	} //function



public function ProductLevelCommissions($userid="",$packid="",$i='',$memberid="")
{


$indirect_level =  $this->db->query("SELECT * FROM arm_package where PackageId='".$packid."'")->row();

$level = $indirect_level->ProductLevelCommissions;
$explode = explode(',', $level);
$check_count =  count($explode);

$checkpackage = $this->db->query("select * from arm_pv where PackageId='".$packid."'")->row();

$memberdet = $this->db->query("select * from arm_members where MemberId='".$userid."'")->row();

$memberde_upline = $this->db->query("select * from arm_members where MemberId='".$memberid."'")->row();


$get_level = $explode[$i];


if($get_level>0)
{
$j = $i+1;

$userbal = $this->common_model->Getcusomerbalance($memberdet->DirectId);
$trnid = 'LCOM'.rand(1111111,9999999);
$date = date('y-m-d h:i:s');
$data = array(
'MemberId'=>$memberdet->DirectId,
'Credit'=>$get_level,
'Balance'=>$userbal+$get_level,
'Description'=>'Indirect Level '.$j.' Commission Earned from '.$memberde_upline->UserName,
'TransactionId'=>$trnid,
'Rankname'=>$memberdet->rank,
'DateAdded'=>$date
);

$userbal = $this->common_model->Getcusomerbalance($memberdet->DirectId);

$data1 = array(
'MemberId'=>$memberdet->DirectId,
'Credit'=>$commission,
'Balance'=>$userbal,
'Description'=>'Indirect Level '.$j.' Commission Earned from '.$memberde_upline->UserName,
'TransactionId'=>$trnid,
'Rankname'=>$memberdet->rank,
'DateAdded'=>$date,
'TypeId'=>'30'
);

if($commission!="" && $commission>0)
{
$userdetails = $this->common_model->SaveRecords($data1,'arm_history');
}
if($userid=='1')
{
$data['TypeId']='11';
}
else
{
$data['TypeId']='4';
}

if($commission!="" && $commission>0)
{
$userdetails = $this->common_model->SaveRecords($data,'arm_history');
}
$this->dashboard_model->check_rank($memberdet->DirectId);

if($get_level>0)
{
$i++;
$memberdet_upline = $this->db->query("select * from arm_members where MemberId='".$userid."'")->row();
$this->ProductLevelCommissions($memberdet_upline->DirectId,$packid,$i,$memberid);
}

}

}

public function rank_commision($userid,$i,$userids)
{


if($i==0)
{
 

	$user = $this->db->query("SELECT * FROM `arm_members` where memberId='".$userid."'")->row();

	if($user->rank!="")
	{
	$urank = $user->rank;
	}
	else
	{
	$urank = '0';
	}


	$users_id = $this->db->query("SELECT * FROM `arm_members` where memberId='".$userids."'")->row();

	if($users_id->rank!="")
	{
	$uranka = $users_id->rank;
	}
	else
	{
	$uranka = '0';
	}


$all_rank = $this->db->query("SELECT * FROM `arm_ranksetting` where Status='1'  and rank_id='".$user->rank."' ")->row();


if($uranka=="0")
{

 $get_user_indirect = $this->db->query("SELECT sum(Credit) as userEran  FROM `arm_history` where TypeId='30' and `Description` LIKE '%Indirect%' and MemberId ='".$userids."'")->row();
}
else
{

 $get_user_indirect = $this->db->query("SELECT sum(Credit) as userEran  FROM `arm_history` where TypeId='31' and MemberId ='".$userids."' and Rankname ='".$uranka."'")->row();
}

	//print_r($uranka);
	echo "<pre>";
	echo "userid ".$userid;
	echo "<pre>";
	echo "userid ".$userids;
	echo "<pre>";
	echo $this->db->last_query();


if($all_rank && $get_user_indirect->userEran >= $all_rank->elig_earn)
{

  $user_indirect_delete = $this->db->query("DELETE FROM `arm_history` WHERE TypeId='30'  and MemberId ='".$userids."'");
  $user_indirect_delete1 = $this->db->query("DELETE FROM `arm_history` WHERE TypeId='31'  and MemberId ='".$userids."'");

	$date = date('y-m-d h:i:s');

	$txnid = "RAK".rand(1111111,9999999);
	$bal = $this->common_model->Getcusomerbalance($userid);

	$data1 = array(
	'MemberId'=>$userid,
	'TransactionId'=>$txnid,
	'DateAdded'=>$date,
	'Description'=>"You have earned ".$all_rank->Rank." rank commission",
	'Credit'=>$all_rank->bonus_amt,
	'Balance'=>$bal+$all_rank->bonus_amt,
	'Rankname'=>$all_rank->rank_id,
	'TypeId'=>"27"
	);

	$data2 = array(
	'MemberId'=>$userid,
	'TransactionId'=>$txnid,
	'DateAdded'=>$date,
	'Description'=>"You have earned ".$all_rank->Rank." rank commission",
	'Credit'=>$all_rank->bonus_amt,
	'Balance'=>$bal+$all_rank->bonus_amt,
	'Rankname'=>$all_rank->rank_id,
	'TypeId'=>"31"
	);


    $result1 = $this->common_model->SaveRecords($data2,'arm_history');
	$result1 = $this->common_model->SaveRecords($data1,'arm_history');
	$insert_id = $this->db->insert_id();

	$datas = array(
	'MemberId'=>$userid,
	'DirectId'=>$user->DirectId,
	'type_id'=>'3',
	'status'=>'1',
	'date'=> date('Y-m-d'),
	'history_id'=>$insert_id
	);

    $arm_notification = $this->common_model->SaveRecords($datas,'arm_notification');
	$this->common_model->level_commision($userid,$all_rank->rank_id,'0');
	


    if($user->DirectId)
    {
    	$j++;
    	$this->dashboard_model->check_rank($userid);
       // $this->MemberCommission_model->rank_commision($user->DirectId,0,$userid,$j);
    }
	

}

}

}

	// Member level completed commission process here

	public function matrixlevelcommission($userid,$commission)
	{
		$userbal = $this->common_model->Getcusomerbalance($userid);
		$trnid = 'MLCOM'.rand(1111111,9999999);
		$date = date('y-m-d h:i:s');
		$data = array(
			'MemberId'=>$userid,
			'Credit'=>$commission,
			'Balance'=>$userbal+$commission,
			'Description'=>'Level completed Commission for package payment',
			'TransactionId'=>$trnid,
			// 'TypeId'=>'4',
			'DateAdded'=>$date
		);
		if($userid=='1')
		{
			$data['TypeId']='11';
		}
		else
		{
			$data['TypeId']='4';
		}
	
		$userdetails = $this->common_model->SaveRecords($data,'arm_history');
		if($userdetails)
		{
			$description='Level completed Commission for package payment';
			$this->Sendmail_func($userid,$description,$commission);

			$checkmembersbal=$this->common_model->Getcusomerbalance($userid);
			$memberbal=number_format($checkmembersbal);   

			$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			$checkrank=$checkmatrix->RankStatus;
			if($checkrank==1)
			{
				$cond="balanceAmount='".$memberbal."' AND Status='1'";
				$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
			
				if($checkbalrank!="")
				{
					$rank=$checkbalrank->Rank;

						$trnid = 'RAN'.rand(1111111,9999999);
						$date = date('y-m-d h:i:s');
						$data = array(
							'MemberId'=>$userid,						
							'Balance'=>$checkmembersbal,
							'Description'=>"Prmoted to achieve for target balance".' '.$rank,
							'Rankname'=>$checkbalrank->rank_id,

							'TransactionId'=>$trnid,
							'TypeId'=>'23',
							'DateAdded'=>$date
						);
						$con="MemberId='".$userid."' and Balance='".$userbal."'";
						$checkrank=$this->common_model->GetRowCount($con,"arm_history");
						
						$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
						if($rankdetails)
						{
							$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$userid."'");
						}
											
					
				}
			}
		}

		$message = "Level completed Commission Earned ".$commission;
		// $smsres = $this->sendbulksms($userid,$message);


	} //function


	// Member matrix completed commission process here

	public function matrixcommission($userid,$commission)
	{
		$userbal = $this->common_model->Getcusomerbalance($userid);
		$trnid = 'MCCOM'.rand(1111111,9999999);
		$date = date('y-m-d h:i:s');
		$data = array(
			'MemberId'=>$userid,
			'Credit'=>$commission,
			'Balance'=>$userbal+$commission,
			'Description'=>'matrix completed Commission for package payment',
			'TransactionId'=>$trnid,
			// 'TypeId'=>'4',
			'DateAdded'=>$date
		);

		 if($userid=='1')
		 {
		 	$data['TypeId']='11';
		 }
		 else
		 {
		 	$data['TypeId']='4';
		 }
		
		$userdetails = $this->common_model->SaveRecords($data,'arm_history');
		if($userdetails)
		{
			$description='matrix completed Commission for package payment';
			$this->Sendmail_func($userid,$description,$commission);

			$checkmembersbal=$this->common_model->Getcusomerbalance($memberid);
			$memberbal=number_format($checkmembersbal);   

			$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			$checkrank=$checkmatrix->RankStatus;
			if($checkrank==1)
			{
				$cond="balanceAmount='".$memberbal."' AND Status='1'";
				$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
				// $balancerank=$checkbalrank->balanceAmount;
				if($checkbalrank!="")
				{
					$rank=$checkbalrank->Rank;

					
						$trnid = 'RAN'.rand(1111111,9999999);
						$date = date('y-m-d h:i:s');
						$data = array(
							'MemberId'=>$userid,						
							'Balance'=>$checkmembersbal,
							'Description'=>"Prmoted to achieve for target balance".' '.$rank,
							'Rankname'=>$checkbalrank->rank_id,

							'TransactionId'=>$trnid,
							'TypeId'=>'23',
							'DateAdded'=>$date
						);
						
						$con="MemberId='".$userid."' and Balance='".$userbal."'";
						$checkrank=$this->common_model->GetRowCount($con,"arm_history");
						
						$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
						if($rankdetails)
						{
							$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$userid."'");
						}
												
					
				}
			}
		}

		$message = "matrix completed Commission Earned ".$commission;
		// $smsres = $this->sendbulksms($userid,$message);

	} //function

	// binary Pv 

	public function pointvalue($memberid,$table,$level,$amount)
	{
		
		$udetail = $this->common_model->GetRow("MemberId='".$memberid."'",$table);

		if(count($udetail) > 0)
		{
			$spilloverid = $udetail->SpilloverId;
			$sdetail = $this->common_model->GetRow("MemberId='".$spilloverid."'",$table);
			
			$leftid = $sdetail->LeftId;
			$rightid = $sdetail->RightId;			
			
			if($memberid == $leftid)
			{
				$supdate = $this->common_model->UpdateRecord("LeftPv=LeftPv+'".$amount."'","MemberId='".$spilloverid."'",$table);
			}
			else
			{
				$supdate = $this->common_model->UpdateRecord("RightPv=RightPv+'".$amount."'","MemberId='".$spilloverid."'",$table);
			}
			
			// commission details
			
			$desc  = 'PV Earnings for Level '.$level;
			$date = date('Y-m-d H:i:s');
			$txnid = 'PVE'.rand(100000,1000000);
			$userbal = $this->common_model->Getcusomerbalance($spilloverid);
			$data = array(
				'MemberId'=>$spilloverid,
				// 'TypeId'=>'4',
				'Credit'=>$amount,
				'Balance'=>$userbal+$amount,
				'Description'=>$desc,
				'TransactionId'=>$txnid,
				'DateAdded'=>$date
			);
			if($spilloverid=='1')
			{
				$data['TypeId']='11';
			}
			else
			{
				$data['TypeId']='4';
			}
			$pvresult = $this->common_model->SaveRecords($data,"arm_history");
			if($pvresult)
			{
				$checkmembersbal=$this->common_model->Getcusomerbalance($memberid);
				$memberbal=number_format($checkmembersbal);   

				$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
				$checkrank=$checkmatrix->RankStatus;
				if($checkrank==1)
				{
					$cond="balanceAmount='".$memberbal."' AND Status='1'";
					$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
					// $balancerank=$checkbalrank->balanceAmount;
					if($checkbalrank!="")
					{
							$rank=$checkbalrank->Rank;

						
							$trnid = 'RAN'.rand(1111111,9999999);
							$date = date('y-m-d h:i:s');
							$data = array(
								'MemberId'=>$userid,						
								'Balance'=>$checkmembersbal,
								'Description'=>"Prmoted to achieve for target balance".' '.$rank,
								'Rankname'=>$checkbalrank->rank_id,

								'TransactionId'=>$trnid,
								'TypeId'=>'23',
								'DateAdded'=>$date
							);
							
							$con="MemberId='".$userid."' and Balance='".$userbal."'";
							$checkrank=$this->common_model->GetRowCount($con,"arm_history");
							// if($checkrank==0)
							// {
								$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
								if($rankdetails)
								{
									$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$userid."'");
								}
								
							// }
						
					}
				}
			}

			$message = $desc." Earned ".$amount;
			// $smsres = $this->sendbulksms($spilloverid,$message);

			if(!$spilloverid)
			{
				$level++;
				$this->pointvalue($spilloverid,$table,$level,$amount);
			}
		}
	}

	// level pv value depend for separate package
	public function pointvalue1($userids,$memberid,$table,$level,$binarypackage)
	{
		$pvlist = explode(",", $binarypackage->pv);
		$userdt = $this->common_model->GetRow("MemberId='".$userids."'","arm_members");
		foreach ($pvlist as $key => $value) {

			$amount = $value;

			
			$udetail = $this->common_model->GetRow("MemberId='".$userids."'",$table);

			$spilloverid = $udetail->SpilloverId;
			$sdetail = $this->common_model->GetRow("MemberId='".$spilloverid."'",$table);
			if($sdetail)
			{
				$leftid = $sdetail->LeftId;
				$rightid = $sdetail->RightId;
			}
			
						
			
			if($memberid == $leftid)
			{
				$supdate = $this->common_model->UpdateRecord("LeftPv=LeftPv+'".$amount."'","MemberId='".$spilloverid."'",$table);
			}
			else
			{
				$supdate = $this->common_model->UpdateRecord("RightPv=RightPv+'".$amount."'","MemberId='".$spilloverid."'",$table);
			}
			
			// commission details
			$desc  = 'PV Earnings for Level '.$level." From ".$userdt->UserName;
			$date = date('Y-m-d H:i:s');
			$txnid = 'PVE'.rand(100000,1000000);
			$userbal = $this->common_model->Getcusomerbalance($spilloverid);
			$data = array(
				'MemberId' => $spilloverid,
				// 'TypeId' => '4',
				'Credit' => $amount,
				'Balance' => $userbal+$amount,
				'Description' => $desc,
				'TransactionId' => $txnid,
				'DateAdded' => $date
			);

			if($spilloverid!=0)
			{
				if($spilloverid=='1')
				{
					$data['TypeId']='11';
				}
				else
				{
					$data['TypeId']='4';
				}
				$pvresult = $this->common_model->SaveRecords($data,"arm_history");
				if($pvresult)
				{
					$checkmembersbal=$this->common_model->Getcusomerbalance($spilloverid);
					$memberbal=number_format($checkmembersbal);   

					$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
					$checkrank=$checkmatrix->RankStatus;
					if($checkrank==1)
					{
						$cond="balanceAmount='".$memberbal."' AND Status='1'";
						$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
						
						if($checkbalrank!="")
						{
							$rank=$checkbalrank->Rank;

							
								$trnid = 'RAN'.rand(1111111,9999999);
								$date = date('y-m-d h:i:s');
								$data = array(
									'MemberId'=>$spilloverid,						
									'Balance'=>$checkmembersbal,
									'Description'=>"Prmoted to achieve for target balance".' '.$rank,
									'TransactionId'=>$trnid,
									'TypeId'=>'23',
									'DateAdded'=>$date
								);
								
								$con="MemberId='".$spilloverid."' and Balance='".$checkmembersbal."'";
								$checkrank=$this->common_model->GetRowCount($con,"arm_history");
								
								 $rankdetails = $this->common_model->SaveRecords($data,'arm_history');
								 if($rankdetails)
								 {
								 	$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$spilloverid."'");
								 }
									
								
							
						}
					}
				}

				$message = $desc." Earned ".$amount;
				// $smsres = $this->sendbulksms($spilloverid,$message);
           }

			if($spilloverid!=0)
			{
				$level++;
				$userids = $spilloverid;
			}
		}
		
	}



	public function paircommission()
	{
		
		$mmset = $this->common_model->GetRow("Id='4' AND MatrixStatus='1'","arm_matrixsetting");
		$pair = explode(':',$mmset->MatchingPair);
		


		$pairdetails = $this->common_model->GetResults("leftdowncount>='".$pair[0]."'AND rightdowncount>='".$pair[1]."' ","arm_binarymatrix");
		
		if($pairdetails)
		{
			foreach ($pairdetails as $pairs) {
				
				$leftpv = $pairs->LeftPv;
				$rightpv = $pairs->RightPv;
				
				$userid = $pairs->MemberId;
				$mmdet = $this->common_model->GetRow("MemberId='".$pairs->MemberId."'","arm_members");
				$pcdet = $this->common_model->GetRow("PackageId='".$mmdet->PackageId."'","arm_pv");

				
				$hsp = $this->common_model->GetRowCount("TypeId='4' AND MemberId='".$pairs->MemberId."' AND Description like '%Pairing Commission%' AND DATE(DateAdded) = '".date('Y-m-d')."' ",'arm_history');
				
				if($hsp < $pcdet->DailyMaximumPairs)
				{
		

					$pvarray = array('left'=> $leftpv,'right'=> $rightpv);
					$minvalue = min($pvarray);
					$maxvalue = max($pvarray);
					$minarray = array_keys($pvarray,$minvalue, true);
					
					$maxarray = array_keys($pvarray,$maxvalue, true);

					$pair_count = $this->common_model->GetRowCount("TypeId='4' AND MemberId='".$pairs->MemberId."' AND Description like '%Pairing Commission%' ",'arm_history');
						
					if($pairs->leftdowncount < $pairs->rightdowncount) {
	                	// $count = $pairs->leftdowncount - $pairs->rightdowncount;
	                	$count1 = $pairs->leftdowncount;
	                } else {
	                	// $count = $pairs->rightdowncount - $pairs->leftdowncount;
	                	$count1 = $pairs->rightdowncount;
	                }
					
					
					if($minarray[0] == 'left')
					{
						$value=0;
						if($mmset->CarryForward==1)
						$value = $rightpv - $leftpv;
						
						if($pcdet->PairCommissionType == 1)
						{
							$commission =$pcdet->PairCommission;
						}
						else
						{
							$commission = $pcdet->PackageFee*($pcdet->PairCommission / 100);
						}
		                
						if($pair_count < $count1){
							
							$userbal = $this->common_model->Getcusomerbalance($pairs->MemberId);	
							$desc  = 'Pairing Commission';
							$date = date('Y-m-d H:i:s');
							$txnid = 'PVE'.rand(100000,1000000);
							$data = array(
								'MemberId'=>$pairs->MemberId,
								// 'TypeId'=>'4',
								'Credit'=>$commission,
								'Balance'=>$userbal+$commission,
								'Description'=>$desc,
								'TransactionId'=>$txnid,
								'DateAdded'=>$date
							);
							if($pairs->MemberId=='1')
							{
								$data['TypeId']='11';
							}
							else
							{
								$data['TypeId']='4';
							}

							$pcresult = $this->common_model->SaveRecords($data,"arm_history");
							if($pcresult)
							{
								$description=$desc;
								$this->Sendmail_func($pairs->MemberId,$description,$commission);

								$checkmembersbal=$this->common_model->Getcusomerbalance($pairs->MemberId);
								$memberbal=number_format($checkmembersbal);   

								$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
								$checkrank=$checkmatrix->RankStatus;
								if($checkrank==1)
								{
									$cond="balanceAmount='".$memberbal."' AND Status='1'";
									$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
									
									if($checkbalrank!="")
									{
										$rank=$checkbalrank->Rank;

										
											$trnid = 'RAN'.rand(1111111,9999999);
											$date = date('y-m-d h:i:s');
											$data = array(
												'MemberId'=>$pairs->MemberId,						
												'Balance'=>$checkmembersbal,
												'Description'=>"Prmoted to achieve for target balance".' '.$rank,
												'Rankname'=>$checkbalrank->rank_id,

												'TransactionId'=>$trnid,
												'TypeId'=>'23',
												'DateAdded'=>$date
											);
											
											
											$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
											if($rankdetails)
											{
												$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$pairs->MemberId."'");
											}
											
										
									}
								}
							}
						
							$message = $desc." Earned ".$commission;
							// $smsres = $this->sendbulksms($userid,$message);
								
							if($pcresult)
							{
								$update = $this->common_model->UpdateRecord("RightPv = '".$value."' AND LeftPv = 0","MemberId = '".$pairs->MemberId."' ","arm_binarymatrix");
							}

							
							/*$mmdet = $this->common_model->GetRow("MemberId='".$userid."'","arm_members");
							$pack =$mmdet->PackageId;
							$match = $this->common_model->GetRow("PackageId='".$pack."'","arm_pv");
							$match_bonus =$match->MatchingBonus;
							$levelvalue = explode(",",$match->MatchingBonus);*/
							$userid = $pairs->MemberId;
						    //$this->matchingbonus($userid,$commission,1);
						    $this->match($userid);
						}
						
					}
					else
					{
						$value=0;
						if($mmset->CarryForward==1)
						$value = $leftpv - $rightpv;
						
						if($pcdet->PairCommissionType == 1)
						{
							$commission = $pcdet->PairCommission;
						}
						else
						{
							$commission = $pcdet->PackageFee*($pcdet->PairCommission / 100);
						}
		                
		                if($pair_count < $count1)
		                {
						
							$userbal = $this->common_model->Getcusomerbalance($pairs->MemberId);	
							$desc  = 'Pairing Commission';
							$date = date('Y-m-d H:i:s');
							$txnid = 'PVE'.rand(100000,1000000);
							$data = array(
								'MemberId'=>$pairs->MemberId,
								// 'TypeId'=>'4',
								'Credit'=>$commission,
								'Balance'=>$userbal+$commission,
								'Description'=>$desc,
								'TransactionId'=>$txnid,
								'DateAdded'=>$date
							);
							
							 if($pairs->MemberId=='1')
							 {
							 	$data['TypeId']='11';
							 }
							 else
							 {
							 	$data['TypeId']='4';
							 }
							$pcresult = $this->common_model->SaveRecords($data,"arm_history");
							// $this->db->last_query();
								
							// 		 exit;
							if($pcresult)
							{
								$description=$desc;
								$this->Sendmail_func($pairs->MemberId,$description,$commission);
								
								$update = $this->common_model->UpdateRecord("LeftPv = '".$value."' AND  RightPv= 0","MemberId = '".$pairs->MemberId."' ","arm_binarymatrix");
								$checkmembersbal=$this->common_model->Getcusomerbalance($pairs->MemberId);
								$memberbal=number_format($checkmembersbal);   

								$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
								$checkrank=$checkmatrix->RankStatus;
								if($checkrank==1)
								{
									$cond="balanceAmount='".$memberbal."' AND Status='1'";
									$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
									// $balancerank=$checkbalrank->balanceAmount;
									if($checkbalrank!="")
									{
										$rank=$checkbalrank->Rank;

										
											$trnid = 'RAN'.rand(1111111,9999999);
											$date = date('y-m-d h:i:s');
											$data = array(
												'MemberId'=>$pairs->MemberId,						
												'Balance'=>$checkmembersbal,
												'Description'=>"Prmoted to achieve for target balance".' '.$rank,
												'Rankname'=>$checkbalrank->rank_id,

												'TransactionId'=>$trnid,
												'TypeId'=>'23',
												'DateAdded'=>$date
											);
											
											$con="MemberId='".$pairs->MemberId."' and Balance='".$checkmembersbal."'";
											$checkrank=$this->common_model->GetRowCount($con,"arm_history");
											
											$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
											if($rankdetails)
											{
												$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$pairs->MemberId."'");
											}

												
											
									}
								}
							}

							$userid = $pairs->MemberId;
				    		//$this->matchingbonus($userid,$commission,1);
				    		$this->match($userid);
						
						}

					}

				}
            }
			

		}
	}


	public function match($userid)
	{

		$mlsetting = $this->db->query("select * from arm_matrixsetting where MatrixStatus='1'")->row();
		$mmdet = $this->common_model->GetRow("MemberId='".$userid."'","arm_members");
		$pcdet = $this->common_model->GetRow("PackageId='".$mmdet->PackageId."'","arm_pv");			
		$spdet = $this->common_model->GetRow("MemberId='".$userid."'","arm_binarymatrix");

		if($pcdet->PairCommissionStatus==1 && $mlsetting->Id==4)
		{

			 
			$userid =$spdet->SpilloverId;
			$levelvalue = explode(",",$pcdet->MatchingBonus);
		

			for($i=0;$i<count($levelvalue);$i++)
			{	
				
				$g=$i+1;
				
				$commission=0;
				if($pcdet->PairCommissionType==2)
				{
					
					//$lcommission = $binarypackage->PackageFee * $levelvalue[$i] / 100;
					$lcommission =$levelvalue[$i];	
															
				}
				else
				{
					$lcommission =$levelvalue[$i];					
				}
			
									
					if($lcommission > 0)
					{	
												
						//check member active or not in matrix 
						$lcheckmatmem = $this->common_model->GetRow("MemberId='".$userid."' AND Status='1'",$mlsetting->TableName);
						// echo $this->db->last_query();
						// echo "<br>";
						
						if($lcheckmatmem)
						{
						   $dresult = $this->match_bonus($userid,$lcommission,$g,$mmdet->PackageId);
						}
					
					}
				
					
				//change SpilloverId 
				$memberdetail = $this->common_model->GetRow("MemberId='".$userid."'","arm_binarymatrix");
				
				if($memberdetail)
				{
					$userid = $memberdetail->SpilloverId;
				}
				else
				{
					$userid='0';
				}
					
			}
		}
	}



	public function match_bonus($userid,$commission,$lvl,$packid)
	{
		
		$userbal = $this->common_model->Getcusomerbalance($userid);
		$trnid = 'LCOM'.rand(1111111,9999999);
		$date = date('y-m-d h:i:s');
		$data = array(
			'MemberId'=>$userid,
			'Credit'=>$commission,
			'Balance'=>$userbal+$commission,
			'Description'=>'Matching Bonus Earnings for level '.$lvl,
			'TransactionId'=>$trnid,
			// 'TypeId'=>'4',
			'DateAdded'=>$date
		);
		if($userid=='1')
		{
			$data['TypeId']='11';
		}
		else
		{
			$data['TypeId']='4';
		}
	
		$userdetails = $this->common_model->SaveRecords($data,'arm_history');
	
		if($userdetails)
		{
			$description='Matching Bonus Earnings for level '.$lvl;
			$this->Sendmail_func($userid,$description,$commission);

			$checkmembersbal=$this->common_model->Getcusomerbalance($userid);
			$memberbal=number_format($checkmembersbal);   

			$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			$checkrank=$checkmatrix->RankStatus;
			if($checkrank==1)
			{
				$cond="balanceAmount='".$memberbal."' AND Status='1'";
				$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
				
				if($checkbalrank!="")
				{
					$rank=$checkbalrank->Rank;

					
						$trnid = 'RAN'.rand(1111111,9999999);
						$date = date('y-m-d h:i:s');
						$data = array(
							'MemberId'=>$userid,						
							'Balance'=>$checkmembersbal,
							'Description'=>"Prmoted to achieve for target balance".' '.$rank,
							'Rankname'=>$checkbalrank->rank_id,

							'TransactionId'=>$trnid,
							'TypeId'=>'23',
							'DateAdded'=>$date
						);
						
						
						$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
						if($rankdetails)
						{
							$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$userid."'");
						}
					
				}
			}
		}

		/*$message = "Level".$lvl." Commission Earned ".$commission;
		$smsres = $this->sendbulksms($userid,$message);*/

	} //function




	public function leftcount1($MemberId,$array,$total)
	{
		
		$leftid=$this->common_model->GetRow("MemberId='".$MemberId."'","arm_binaryhyip");
		if($leftid!="")
		{
			$leftcountids=array($leftid->LeftId);
		
		array_push($array,$leftid->LeftId);
		foreach ($leftcountids as $downid) {
			
			$this->db->where('SpilloverId', $downid);
			$spil_qry = $this->db->get("arm_binaryhyip");
			// echo $this->db->last_query();
			// echo "<br>";
			foreach ($spil_qry->result() as $spil) {
				array_push($array,$spil->MemberId);

			}
			
		}
		
	
		$ar=array_unique($array);
		// pr($ar);
		$leftids=implode(",",$ar);
		// echo $leftids;

		foreach ($ar as $key) {
			 // pr($key);
			if($key!=0)
			{
		$query = $this->db->query("SELECT * FROM arm_binaryhyip WHERE MemberId =".$key."");
		// echo $this->db->last_query();
		// echo "<br>";		
		$leftid = $query->row()->LeftId;
			}
	
		// echo $leftid;

		if($leftid!=0)
		{
			$amount=$this->common_model->GetRow("MemberId='".$leftid."'","arm_binaryhyip");
		 // echo $this->db->last_query();
		if($amount->LeftCarryForward)
	    {
	    	
	    $total+=$amount->LeftCarryForward;
	
	    }
		

		}

		}
		
	
	    return $total;

		}
	
		
		
	}

	public function leftcount($MemberId)
	{
		$array = array($MemberId);
		$total="";
		
		$totalleftamount=$this->leftcount1($MemberId,$array,$total);
	
	   return $totalleftamount;
		
	}


	public function rightcount1($MemberId,$array,$total)
	{
		
		$rightid=$this->common_model->GetRow("MemberId='".$MemberId."'","arm_binaryhyip");
		if($rightid!="")
		{
		$rightcountids=array($rightid->RightId);
		
		array_push($array,$rightid->RightId);
		foreach ($rightcountids as $downid) {
			
			$this->db->where('SpilloverId', $downid);
			$spil_qry = $this->db->get("arm_binaryhyip");
			// echo $this->db->last_query();
			// echo "<br>";
			foreach ($spil_qry->result() as $spil) {
				array_push($array,$spil->MemberId);

			}
			
		}
		
	
		$ar=array_unique($array);
		 // pr($ar);
		$rightids=implode(",",$ar);
		// echo $leftids;
		foreach ($ar as $key) {
			 // pr($key);
			if($key!=0)
			{
				$query = $this->db->query("SELECT * FROM arm_binaryhyip WHERE MemberId =".$key."");
		
				
		$rightid = $query->row()->RightId;
			}
		
		// echo $leftid;

		if($rightid!=0)
		{
			$amount=$this->common_model->GetRowdeposit("MemberId='".$rightid."'","arm_binaryhyip");
		  // echo $this->db->last_query();
		if($amount->RightCarryForward)
	    {
	    	
	    $total+=$amount->RightCarryForward;
	
	    }
		

		}

		}
		
	
	    return $total;

		}
	
	
		
	}

	public function rightcount($MemberId)
	{
		$array = array($MemberId);
		 $total="";
		 $totalrightamount=$this->rightcount1($MemberId,$array,$total);
			return $totalrightamount;
		
	}

	

	// from paircommission base matching bonus by level 

	public function matchingbonus($userid,$commission,$level)
	{

		$mmdet = $this->common_model->GetRow("MemberId='".$userid."'","arm_members");

		 $pcdet = $this->common_model->GetRow("PackageId='".$mmdet->PackageId."'","arm_pv");
		
		    $mbonus = explode(",",$pcdet->MatchingBonus);
			$j= $level-1;
			$spdet = $this->common_model->GetRow("MemberId='".$userid."'","arm_binarymatrix");

			if(count($spdet) > 0)
			{
				$spilloverid = $spdet->SpilloverId;
				
				if($spilloverid)
				{
					
				
	                if(count($mbonus) > 1)
	                {
						$amount = $mbonus[$j];
						$userbal = $this->common_model->Getcusomerbalance($spilloverid);

						$desc  = 'Matching Bonus Earnings for level '.$level;
						$date = date('Y-m-d H:i:s');
						$txnid = 'MBE'.rand(100000,1000000);
						$data = array(
							'MemberId'=>$spilloverid,
							// 'TypeId'=>'4',
							'Credit'=>$amount,
							'Balance'=>$userbal+$amount,
							'Description'=>$desc,
							'TransactionId'=>$txnid,
							'DateAdded'=>$date
						);
						if($spilloverid=='1')
						{
							$data['TypeId']='11';
						}
						else
						{
							$data['TypeId']='4';
						}
						$pcresult = $this->common_model->SaveRecords($data,"arm_history");
						if($pcresult)
						{
							$description=$desc;
							$this->Sendmail_func($spilloverid,$description,$commission);

							$checkmembersbal=$this->common_model->Getcusomerbalance($spilloverid);
							$memberbal=number_format($checkmembersbal);   

							$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
							$checkrank=$checkmatrix->RankStatus;
							if($checkrank==1)
							{
								$cond="balanceAmount='".$memberbal."' AND Status='1'";
								$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
								// $balancerank=$checkbalrank->balanceAmount;
								if($checkbalrank!="")
								{
									$rank=$checkbalrank->Rank;

									
										$trnid = 'RAN'.rand(1111111,9999999);
										$date = date('y-m-d h:i:s');
										$data = array(
											'MemberId'=>$spilloverid,						
											'Balance'=>$checkmembersbal,
											'Description'=>"Prmoted to achieve for target balance".' '.$rank,
											'Rankname'=>$checkbalrank->rank_id,

											'TransactionId'=>$trnid,
											'TypeId'=>'23',
											'DateAdded'=>$date
										);
										
										
										$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
										if($rankdetails)
										{
											$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$spilloverid."'");
										}

											
									
									
								}
							}
						}

						// send sms 
						$message = "Matching Bonus for level".$level." Earned ".$commission;
						$smsres = $this->sendbulksms($spilloverid,$message);

						$level++;
						$this->matchingbonus($spilloverid,$commission,$level);
					}
					else
					{

						$amount = $commission * $mbonus[0] / 100;
						$userbal = $this->common_model->Getcusomerbalance($spilloverid);

						$desc  = 'Matching Bonus Earnings for level '.$level;
						$date = date('Y-m-d H:i:s');
						$txnid = 'MBE'.rand(100000,1000000);
						$data = array(
							'MemberId'=>$spilloverid,
							// 'TypeId'=>'4',
							'Credit'=>$amount,
							'Balance'=>$userbal+$amount,
							'Description'=>$desc,
							'TransactionId'=>$txnid,
							'DateAdded'=>$date
						);
						if($spilloverid=='1')
						{
							$data['TypeId']='11';
						}
						else
						{
							$data['TypeId']='4';
						}

						$pcresult = $this->common_model->SaveRecords($data,"arm_history");
						if($pcresult)
						{
							$description=$desc;
							$this->Sendmail_func($spilloverid,$description,$commission);

							$checkmembersbal=$this->common_model->Getcusomerbalance($spilloverid);
							$memberbal=number_format($checkmembersbal);   

							$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
							$checkrank=$checkmatrix->RankStatus;
							if($checkrank==1)
							{
								$cond="balanceAmount='".$memberbal."' AND Status='1'";
								$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
								
								if($checkbalrank!="")
								{
									  $rank=$checkbalrank->Rank;
									
										$trnid = 'RAN'.rand(1111111,9999999);
										$date = date('y-m-d h:i:s');
										$data = array(
											'MemberId'=>$spilloverid,						
											'Balance'=>$checkmembersbal,
											'Description'=>"Prmoted to achieve for target balance".' '.$rank,
								            'Rankname'=>$checkbalrank->rank_id,

											'TransactionId'=>$trnid,
											'TypeId'=>'23',
											'DateAdded'=>$date
										);
										
									
									   $rankdetails = $this->common_model->SaveRecords($data,'arm_history');

									   if($rankdetails)
									   {
									   		$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$spilloverid."'");
									   }
										
								}
							}
						}
						// send sms 
						$message = "Matching Bonus for level".$level." Earned ".$commission;
						$smsres = $this->sendbulksms($spilloverid,$message);

						$level++;
					
						$this->matchingbonus($spilloverid,$commission,$level);

					}
			
				}
				
			}

		
		
	}

	// check board complete or not in board matrix here 

	public function checkboard($users,$boardid,$status,$wcount,$level)
	{

		for($i=0;$i<$level;$i++)
		{
			
			$usids = implode(",", $users);
				//chkcount correct count
			if($i){ $chkcount = count($users) * $wcount; } else { $chkcount=$wcount; }

			$cmdetails = $this->common_model->GetResults("BoardId='".$boardid."' AND SpilloverId IN (".$usids.")","arm_boardmatrix");
			// echo"<pre>"; print_r($cmdetails); echo"</pre>";
			//chkcount current members spillover count
			$mcount = count($cmdetails);
			
			if($chkcount <=$mcount && $status==1)
			{
				for($ii=0;$ii<count($cmdetails);$ii++)
				{ 
					if(!in_array($cmdetails[$ii]->BoardMemberId, $users))
					{
						array_push($users, $cmdetails[$ii]->BoardMemberId);
					}
				}
			}
			else
			{
				$status=0;
			}
				
		}
		return $status;
	}


	public function owncommission($userid,$commission)
	{
		$userbal = $this->common_model->Getcusomerbalance($userid);
		$trnid = 'OCOM'.rand(1111111,9999999);
		$date = date('y-m-d h:i:s');
		$data = array(
					'MemberId'=>$userid,
					'Credit'=>$commission,
					'Balance'=>$userbal+$commission,
					'Description'=>'Own Commission',
					'TransactionId'=>$trnid,
					'TypeId'=>'4',
					'DateAdded'=>$date
						 );
		

		$userdetailss = $this->common_model->SaveRecords($data,'arm_history');
		$description='Own Commission';
		$this->Sendmail_func($userid,$description,$commission);
		// echo $this->db->last_query();
		
	} //function
	
	
	// calculates board complete commission here

	public function boardcommission($userid,$commission,$bdname)
	{
		$userbal = $this->common_model->Getcusomerbalance($userid);
		$trnid = 'BCOM'.rand(1111111,9999999);
		$date = date('y-m-d h:i:s');
		$data = array(
			'MemberId'=>$userid,
			'Credit'=>$commission,
			'Balance'=>$userbal+$commission,
			'Description'=>'Board Commission for '.$bdname.' Board Completed',
			'TransactionId'=>$trnid,
			// 'TypeId'=>'4',
			'DateAdded'=>$date
		);
		if($userid=='1')
		{
			$data['TypeId']='11';
		}
		else
		{
			$data['TypeId']='4';
		}

		$userdetails = $this->common_model->SaveRecords($data,'arm_history');
		if($userdetails)
		{
			$description='Board Commission for '.$bdname.' Board Completed';
			$this->Sendmail_func($userid,$description,$commission);

			$checkmembersbal=$this->common_model->Getcusomerbalance($userid);
			$memberbal=number_format($checkmembersbal);   

			$checkmatrix=$this->common_model->GetRow("MatrixStatus='1'","arm_matrixsetting");
			$checkrank=$checkmatrix->RankStatus;
			if($checkrank==1)
			{
				$cond="balanceAmount='".$memberbal."' AND Status='1'";
				$checkbalrank=$this->common_model->GetRow($cond,"arm_ranksetting");
				// $balancerank=$checkbalrank->balanceAmount;
				// $rank=$checkbalrank->Rank;
				if($checkbalrank!="")
				{
					$rank=$checkbalrank->Rank;

					
					$trnid = 'RAN'.rand(1111111,9999999);
					$date = date('y-m-d h:i:s');
					$data = array(
						'MemberId'=>$userid,						
						'Balance'=>$checkmembersbal,
						'Description'=>"Prmoted to achieve for target balance".' '.$rank,
						'TransactionId'=>$trnid,
						'Rankname'=>$checkbalrank->rank_id,

						'TypeId'=>'23',
						'DateAdded'=>$date
					);
					
					$rankdetails = $this->common_model->SaveRecords($data,'arm_history');
					if($rankdetails)
					{
						$update_ranks = $this->db->query("update arm_members set rank='".$checkbalrank->rank_id."' where MemberId='".$userid."'");
					}
					
				}
			}
		}

		// send sms 
		$message = "Board Commission for ".$bdname." Earned ".$commission;
		$smsres = $this->sendbulksms($SpilloverId,$message);
	}



	function sendbulksms($mno,$message)
	{
		$sms_details = $this->db->query("SELECT KeyValue, ContentValue FROM arm_setting WHERE Page='smssetting'");

		$this->db->where('Page','smssetting');
		$this->db->select('KeyValue, ContentValue');
		$sms_details = $this->db->get('arm_setting');
		
		foreach ($sms_details->result() as $row) {
			$sms[$row->KeyValue] = $row->ContentValue;
		}

		$username = $sms['smsauthuser'];
		$password = $sms['smsauthpassword'];

		/*
		* Your phone number, including country code, i.e. +44123123123 in this case:
		*/
		$msisdn = $sms['senderno'];

		/*
		* Please see the FAQ regarding HTTPS (port 443) and HTTP (port 80/5567)
		*/
		// $url = 'https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0';
		$url = $sms['smsauthurl'];
		$port = 443;


		$post_body = $this->unicode_sms($username, $password, $message, $msisdn);
		$result='';
		$result =  $this->send_message($post_body, $url, $port);
		return true;
	}

	function unicode_sms ( $username, $password, $message, $msisdn ) {
		$post_fields = array (
			'username' => $username,
			'password' => $password,
			'message'  => $this->string_to_utf16_hex( $message ),
			'msisdn'   => $msisdn,
			'dca'      => '16bit'
		);

		return $this->make_post_body($post_fields);
	}

	function string_to_utf16_hex( $string ) {
		return bin2hex(mb_convert_encoding($string, "UTF-16", "UTF-8"));
	}

	function make_post_body($post_fields) {
		$stop_dup_id = $this->make_stop_dup_id();
		if ($stop_dup_id > 0) {
			$post_fields['stop_dup_id'] = $this->make_stop_dup_id();
		}
		$post_body = '';
		foreach( $post_fields as $key => $value ) {
			$post_body .= urlencode( $key ).'='.urlencode( $value ).'&';
		}
		$post_body = rtrim( $post_body,'&' );

		return $post_body;
	}
	function make_stop_dup_id() {
		return 0;
	}
	function send_message($post_body, $url, $port ) {
		/*
		* Do not supply $post_fields directly as an argument to CURLOPT_POSTFIELDS,
		* despite what the PHP documentation suggests: cUrl will turn it into in a
		* multipart formpost, which is not supported:
		*/

		$ch = curl_init( );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_PORT, $port );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_body );
		// Allowing cUrl funtions 20 second to execute
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
		// Waiting 20 seconds while trying to connect
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 );

		$response_string = curl_exec( $ch );
		$curl_info = curl_getinfo( $ch );

		$sms_result = array();
		$sms_result['success'] = 0;
		$sms_result['details'] = '';
		$sms_result['transient_error'] = 0;
		$sms_result['http_status_code'] = $curl_info['http_code'];
		$sms_result['api_status_code'] = '';
		$sms_result['api_message'] = '';
		$sms_result['api_batch_id'] = '';

		if ( $response_string == FALSE ) {
			$sms_result['details'] .= "cURL error: " . curl_error( $ch ) . "\n";
		} elseif ( $curl_info[ 'http_code' ] != 200 ) {
			$sms_result['transient_error'] = 1;
			$sms_result['details'] .= "Error: non-200 HTTP status code: " . $curl_info[ 'http_code' ] . "\n";
		}
		else {
			$sms_result['details'] .= "Response from server: $response_string\n";
			$api_result = explode( '|', $response_string );
			$status_code = $api_result[0];
			$sms_result['api_status_code'] = $status_code;
			$sms_result['api_message'] = $api_result[1];
			if ( count( $api_result ) != 3 ) {
			  $sms_result['details'] .= "Error: could not parse valid return data from server.\n" . count( $api_result );
			} else {
				if ($status_code == '0') {
					$sms_result['success'] = 1;
					$sms_result['api_batch_id'] = $api_result[2];
					$sms_result['details'] .= "Message sent - batch ID $api_result[2]\n";
				}
				else if ($status_code == '1') {
					# Success: scheduled for later sending.
					$sms_result['success'] = 1;
					$sms_result['api_batch_id'] = $api_result[2];
				}
				else {
					$sms_result['details'] .= "Error sending: status code [$api_result[0]] description [$api_result[1]]\n";
				}
			}
		}
		curl_close( $ch );
		return $sms_result;
	}

		function Sendmail_func($post_data,$description,$amount) 
	{
		$cond="MemberId='".$post_data."'";
		$userdata=$this->common_model->GetRow($cond,'arm_members');

		if($post_data) {

			
			$qry_data = $this->common_model->GetSiteSettings('smtpsetting');
			
			foreach ($qry_data as $key) {
				$smtp_data[$key->KeyValue] = $key->ContentValue;
			}

			$config = array();
			$config['protocol'] 		= "sendmail";
		    $config['useragent']        = "CodeIgniter";
		    $config['mailpath']         = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
		    $config['protocol']         = "smtp";
		    $config['smtp_host']        = $smtp_data['smtphost'];
		    $config['smtp_port']        = $smtp_data['smtpport'];
		    $config['mailtype'] 		= 'html';
		    $config['charset']  		= 'utf-8';
		    $config['newline']  		= "\r\n";
		    $config['wordwrap'] 		= TRUE;
			// $this->email->initialize($config);
			$this->email->clear(TRUE);

			//email 
			$message = $this->common_model->GetRow("Page='commission'","arm_emailtemplate");
			$site = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitelogo'","arm_setting");
			$sitename = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='sitename'","arm_setting");
	   	    
		   	$emailcont = urldecode($message->EmailContent);
		   	
		   	$logo = '<img src="'.base_url().$site->ContentValue.'">';
			$emailcont = str_replace('[LOGO]', $logo, $emailcont);
		   	$emailcont = str_replace('[FIRSTNAME]', $userdata->UserName, $emailcont);
		   	$emailcont = str_replace('[DESCRIPTION]', $description, $emailcont);
		   	$emailcont = str_replace('[COMISSION]', currency().$amount, $emailcont);
		   	

		   	
		  	$adminid = $this->common_model->GetRow("Page='sitesetting' AND KeyValue='adminmailid'","arm_setting");
		   	$this->email->from($smtp_data['smtpmail'], $sitename->ContentValue);
		   	$this->email->to($userdata->Email);
			$this->email->subject($message->EmailSubject);
			// $body=;
			$body .=
					'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					    <meta http-equiv="Content-Type" content="text/html; charset='.strtolower(config_item('charset')).'" />
					    <title>Member Order Details</title>
					    <style type="text/css">
					        body {
					            font-family: Arial, Verdana, Helvetica, sans-serif;
					            font-size: 16px;
					        }
					    </style>
					</head>
					<body>

					</body>
					</html>';


	    	$this->email->message($emailcont);    
		    $this->email->set_mailtype("html");
	    	$Mail_status = $this->email->send();
		}
	}





}

?>