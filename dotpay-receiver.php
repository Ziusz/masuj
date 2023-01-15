<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	require("config.php");
	
	$sign = $dotpay_pin;
	if(isset($_POST['id'])) $sign .= $_POST['id'];
	if(isset($_POST['operation_number'])) $sign .= $_POST['operation_number'];
	if(isset($_POST['operation_type'])) $sign .= $_POST['operation_type'];
	if(isset($_POST['operation_status'])) $sign .= $_POST['operation_status'];
	if(isset($_POST['operation_amount'])) $sign .= $_POST['operation_amount'];
	if(isset($_POST['operation_currency'])) $sign .= $_POST['operation_currency'];
	if(isset($_POST['operation_withdrawal_amount'])) $sign .= $_POST['operation_withdrawal_amount'];
	if(isset($_POST['operation_commission_amount'])) $sign .= $_POST['operation_commission_amount'];
	if(isset($_POST['is_completed'])) $sign .= $_POST['is_completed'];
	if(isset($_POST['operation_original_amount'])) $sign .= $_POST['operation_original_amount'];
	if(isset($_POST['operation_original_currency'])) $sign .= $_POST['operation_original_currency'];
	if(isset($_POST['operation_datetime'])) $sign .= $_POST['operation_datetime'];
	if(isset($_POST['operation_related_number'])) $sign .= $_POST['operation_related_number'];
	if(isset($_POST['control'])) $sign .= $_POST['control'];
	if(isset($_POST['description'])) $sign .= $_POST['description'];
	if(isset($_POST['email'])) $sign .= $_POST['email'];
	if(isset($_POST['p_info'])) $sign .= $_POST['p_info'];
	if(isset($_POST['p_email'])) $sign .= $_POST['p_email'];
	if(isset($_POST['credit_card_issuer_identification_number'])) $sign .= $_POST['credit_card_issuer_identification_number'];
	if(isset($_POST['credit_card_masked_number'])) $sign .= $_POST['credit_card_masked_number'];
	if(isset($_POST['credit_card_expiration_year'])) $sign .= $_POST['credit_card_expiration_year'];
	if(isset($_POST['credit_card_expiration_month'])) $sign .= $_POST['credit_card_expiration_month'];
	if(isset($_POST['credit_card_brand_codename'])) $sign .= $_POST['credit_card_brand_codename'];
	if(isset($_POST['credit_card_brand_code'])) $sign .= $_POST['credit_card_brand_code'];
	if(isset($_POST['credit_card_unique_identifier'])) $sign .= $_POST['credit_card_unique_identifier'];
	if(isset($_POST['credit_card_id'])) $sign .= $_POST['credit_card_id'];
	if(isset($_POST['channel'])) $sign .= $_POST['channel'];
	if(isset($_POST['channel_country'])) $sign .= $_POST['channel_country'];
	if(isset($_POST['geoip_country'])) $sign .= $_POST['geoip_country'];
	if(isset($_POST['payer_bank_account_name'])) $sign .= $_POST['payer_bank_account_name'];
	if(isset($_POST['payer_bank_account'])) $sign .= $_POST['payer_bank_account'];
	if(isset($_POST['payer_transfer_title'])) $sign .= $_POST['payer_transfer_title'];
	if(isset($_POST['blik_voucher_pin'])) $sign .= $_POST['blik_voucher_pin'];
	if(isset($_POST['blik_voucher_amount'])) $sign .= $_POST['blik_voucher_amount'];
    if(isset($_POST['blik_voucher_amount_used'])) $sign .= $_POST['blik_voucher_amount_used'];
    if(isset($_POST['channel_reference_id'])) $sign .= $_POST['channel_reference_id'];
    if(isset($_POST['operation_seller_code'])) $sign .= $_POST['operation_seller_code'];
	$signature = hash('sha256', $sign);
	if($_POST['control'] == $dotpay_control){
		if($_POST['operation_amount'] == $_POST['operation_original_amount']){
			if($_POST['operation_currency'] == $_POST['operation_original_currency']){
				if($_POST['operation_type'] == "payment"){
					if($_POST['signature'] == $signature){
						if($_POST['operation_status'] == "completed"){					
							$user = DB::queryFirstRow("SELECT id FROM users WHERE email=%s", $_POST['email']);					
							$company = DB::queryFirstRow("SELECT activated_to FROM companies WHERE owner_id=%i", $user['id']);		
							$payment = DB::queryFirstRow("SELECT dotpay_id FROM payments WHERE dotpay_id=%s", $_POST['operation_amount']);	
							if(empty($payment)){
								switch($_POST['operation_amount']){
									case "100.00":
										$date = date('Y-m-d H:i:s', strtotime($company['activated_to'].' + 1 month'));
										break;
									case "300.00":
										$date = date('Y-m-d H:i:s', strtotime($company['activated_to'].' + 3 month'));
										break;
									case "1200.00":
										$date = date('Y-m-d H:i:s', strtotime($company['activated_to'].' + 12 month'));
										break;
									default:
										exit;
								}
								DB::insert('payments', array(
									'user_id' => $user['id'],
									'dotpay_id' => $_POST['operation_number'],
									'date' => $_POST['operation_datetime'],
									'amount' => $_POST['operation_amount']
								));	
								$update = DB::query("UPDATE companies SET activated_to=%t WHERE owner_id=%i", $date, $user['id']);
							}
						}
					}
				}
			}
		}
	}
	exit;
}
?>