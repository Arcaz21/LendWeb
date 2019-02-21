<?php

$payment = $transact['payment'];
$accubal = $transact['accubal'];
$advbal = $transact['advbal'];
$daily = $transact['daily'];
$balance = $transact['accountbalance'];

if($accubal == 0.00 && $accubal == 0.00){
	if($payment == $balance){
		$transact['payment'] = $payment;
        $transact['AccuBal'] = "0.00";
        $transact['AdvBal'] = "0.00";
        $transact['description'] = "Normal Payment";;    
        $transact['status'] = "partial";
        $transact['balance'] = ($balance-$payment);
        print_r($transact);
	}else{
		if($payment>$balance){
			echo "ERROR";
		}else{
			if($payment == $daily){
				echo "DONE!";
				$transact['payment'] = $payment;
		        $transact['AccuBal'] = "0.00";
		        $transact['AdvBal'] = "0.00";
		        $transact['description'] = "Normal Payment";;    
		        $transact['status'] = "partial";
		        $transact['balance'] = ($balance-$payment);
		        print_r($transact);
			}else{
				if($payment>$daily){
					$transact['payment'] = $payment;
			        $transact['AccuBal'] = "0.00";
			        $transact['AdvBal'] = $payment-$daily;
			        $transact['description'] = "Advance Payment";
			        $transact['status'] = "partial";
			        $transact['balance'] = ($balance-$payment);
			        print_r($transact);
				}else{
					$transact['payment'] = $payment;
			        $transact['AccuBal'] = $daily-$payment;
			        $transact['AdvBal'] = "0.00";
			        $transact['description'] = "Accumulated Payment";   
			        $transact['status'] = "partial";
			        $transact['balance'] = ($balance-$payment);
			        print_r($transact);
				}
			}
		}	
	}
}
if($advbal != 0.00){
	//has advance
	if(($advbal+$payment) == $balance){
		$transact['payment'] = $payment;
        $transact['AccuBal'] = "0.00";
        $transact['AdvBal'] = "0.00";
        $transact['description'] = "Normal Payment";    
        $transact['status'] = "partial";
        $transact['balance'] = ($balance-($advbal+$payment));
        print_r($transact);
	}else{
		if(($advbal+$payment)>$balance){
			echo "ERROR";
		}else{
			if(($advbal+$payment) == $daily){
				$transact['payment'] = $payment;
		        $transact['AccuBal'] = "0.00";
		        $transact['AdvBal'] = "0.00";
		        $transact['description'] = "Normal Payment";
		        $transact['status'] = "partial";
		        $transact['balance'] = ($balance-($advbal+$payment));
		        print_r($transact);
			}else{
				if(($advbal+$payment)>$daily){
					$transact['payment'] = $payment;
			        $transact['AccuBal'] = "0.00";
			        $transact['AdvBal'] = (($advbal+$payment)-$daily);
			        $transact['description'] = "Advance Payment";   
			        $transact['status'] = "partial";
			        $transact['balance'] = ($balance-($advbal+$payment));
			        print_r($transact);
				}else{
					$transact['payment'] = $payment;
			        $transact['AccuBal'] = $daily-($advbal-$payment);
			        $transact['AdvBal'] = "0.00";
			        $transact['description'] = "Accumulated Payment";    
			        $transact['status'] = "partial";
			        $transact['balance'] = ($balance-($advbal+$payment));
			        print_r($transact);
				}
			}
		}
	}
}else{
	if($accubal != 0.00){
		//has accumulated
		if(abs($accubal-$payment) == $balance){
			$transact['payment'] = $payment;
	        $transact['AccuBal'] = "0.00";
	        $transact['AdvBal'] = "0.00";
	        $transact['description'] = "ACCOUNT DONE!";    
	        $transact['status'] = "full";
	        $transact['balance'] = ($balance-abs($accubal-$payment));
	        print_r($transact);
		}else{
			if(abs($accubal-$payment)>$balance){
				echo "ERROR";
			}else{
				if(abs($accubal-$payment)==$daily){
					$transact['payment'] = $payment;
			        $transact['AccuBal'] = "0.00";
			        $transact['AdvBal'] = "0.00";
			        $transact['description'] = "Normal Payment";    
			        $transact['status'] = "partial";
			        $transact['balance'] = ($balance-abs($accubal-$payment));
			        print_r($transact);
				}else{
					if(abs($accubal-$payment)>$daily){
						$transact['payment'] = $payment;
				        $transact['AccuBal'] = "0.00";
				        $transact['AdvBal'] = abs(abs($accubal-$payment)-$daily);
				        $transact['description'] = "Advance Payment";    
				        $transact['status'] = "partial";
				        $transact['balance'] = ($balance-abs($accubal-$payment));
				        print_r($transact);
					}else{
						$transact['payment'] = $payment;
				        $transact['AccuBal'] = abs(abs($accubal-$payment)-$daily);;
				        $transact['AdvBal'] = "0.00";
				        $transact['description'] = "Accumulated Payment";    
				        $transact['status'] = "partial";
				        $transact['balance'] = ($balance-abs($accubal-$payment));
				        print_r($transact);
					}
				}
			}
		}
	}
}




?>