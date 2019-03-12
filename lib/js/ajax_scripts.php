<?
include("../core.lib.php");
$obj_tools_db = new cls_tools_db;

switch($GPC['action']){
	case "multilist":
		$ids=$GPC['ids'];
		$prod2ven=$GPC['prod2ven'];
		$controles=explode(",",$GPC['controles']);
		
		header('Content-Type: text/xml');
		echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';
		echo '<multipulls>';
		
		foreach($controles as $tipo){
			switch($tipo){
				case "prod2gz":
					echo '<prod2gz>';
					
					$selected_ids=array();
					$query="SELECT * FROM mm_products_to_geo_zones WHERE products_id='$ids' ";
					$res_array = $obj_tools_db->_SQL_tool(SELECT, "ajax_scripts", $query);
					for($i=0, $cant=count($res_array); $i<$cant; $i++){
						$selected_ids[]=$res_array[$i]['geo_zone_id'];
					}
					
					$query="SELECT gz.geo_zone_id, gz.geo_zone_name FROM mm_geo_zones gz 
						WHERE gz.vendor_id IN(".$prod2ven.") GROUP BY geo_zone_id ORDER BY gz.geo_zone_name ";
					$res_array = $obj_tools_db->_SQL_tool(SELECT, "ajax_scripts", $query);
					for($i=0, $cant=count($res_array); $i<$cant; $i++){
						$selected=(in_array($res_array[$i]['geo_zone_id'],$selected_ids))?'true':'';
						echo '<option val="'.$res_array[$i]['geo_zone_id'].'" selected="'.$selected.'" >'.$res_array[$i]['geo_zone_name'].'</option>';	
					}
											
					echo '</prod2gz>';
				break;
				case "prod2buss":
					echo '<prod2buss>';
					
					$selected_ids=array();
					$query="SELECT * FROM mm_products_to_bussiness_units WHERE products_id='$ids' ";
					$res_array = $obj_tools_db->_SQL_tool(SELECT, "ajax_scripts", $query);
					for($i=0, $cant=count($res_array); $i<$cant; $i++){
						$selected_ids[]=$res_array[$i]['bussiness_unit_id'];
					}
					
					$query="SELECT b.bussiness_unit_id, b.bussiness_unit_name FROM 
						mm_bussiness_units b WHERE b.vendor_id IN(".$prod2ven.") GROUP BY bussiness_unit_id ORDER BY b.bussiness_unit_name ";
					$res_array = $obj_tools_db->_SQL_tool(SELECT, "ajax_scripts", $query);
					for($i=0, $cant=count($res_array); $i<$cant; $i++){
						$selected=(in_array($res_array[$i]['bussiness_unit_id'],$selected_ids))?'true':'';
						echo '<option val="'.$res_array[$i]['bussiness_unit_id'].'" selected="'.$selected.'" >'.$res_array[$i]['bussiness_unit_name'].'</option>';	
					}
					
					echo '</prod2buss>';
				break;
			}
		}
		
		echo '</multipulls>';
	break;
	
	case "step1_temp_price":
		$obj_currencies = new cls_currencies;
		$obj_service = new cls_service;
		
		$cat_n_plan=explode(",",$GPC['cat_n_plan']);
		$total=0;
		if(is_array($cat_n_plan)){
			$subquery='';
			foreach($cat_n_plan as $category_id => $plan_master_id){
				if($category_id && $plan_master_id){
					$query="SELECT SUM(plan_to_categories_price) AS tmp_price FROM mm_plan_to_categories WHERE category_id='$category_id' AND plan_master_id='$plan_master_id' ";
					$res_array = $obj_tools_db->_SQL_tool(SELECT_SINGLE, "ajax_scripts", $query);
					$total+=$res_array['tmp_price'];
					
				}
			}
		}
		echo $obj_currencies->format($total); 
	break;
	
	case "step1_refresh_credits":
		$obj_currencies = new cls_currencies;
		$obj_fund = new cls_fund;
		$cPath=$GPC['cPath'];
		$bussiness_id=$GPC['bussiness_id'];
		
		$credits=$obj_fund->get_amount_avalaible($_SESSION['customer_vendor_id'],$_SESSION['customer_company_id'],$cPath,$bussiness_id);
		echo $obj_currencies->format($credits);		
	break;
	
	case "step1_refresh_credits2":
		$obj_currencies = new cls_currencies;
		$obj_xml = new cls_xml_coams;
		$arr_temp = array();
		$var_funds=$GPC['varfunds'];
		$credits_avaliable = 0;
		$obj_xml->filter_array_xml($_SESSION['sec_funds'], "ProgramName", $var_funds);
		if (!empty($obj_xml->arr_search)){
			foreach($obj_xml->arr_search as $key=>$value) {
				if (strlen($key) > 19){
					if (substr($key, 0, 20) == 'AvailableFundBalance'){
						$credits_avaliable = $credits_avaliable + $value;
					}
				}
			}
		}else{
			$credits_avaliable = "0.00";
		}
		unset($_SESSION['var_fund_s']);
		$_SESSION['var_fund_s'] = '';
		$arr_temp['name'] = $var_funds;
		$arr_temp['value'] = $credits_avaliable;
		$_SESSION['var_fund_s'] = $arr_temp;
		echo $obj_currencies->format($credits_avaliable);		
	break;
	
	case "countynames":
		$obj_zones = new cls_zones;
		$zones = explode(",",$GPC['zones']);
		echo '<select name="camp_country[]" size="3" multiple="multiple" id="camp_country[]" class="normal required input2">';
		$obj_zones->contries_by_zone_names($zones);
		if($obj_zones->conties_by_geo_zones){
			$res_array=$obj_zones->conties_by_geo_zones;
			for($i=0, $cant=count($res_array); $i<$cant; $i++){
				echo '<option value="'.$res_array[$i]['countries_name'].'">'.$res_array[$i]['countries_name'].'</option>';
			}
		} else {
			echo '<option value="">&nbsp;</option>';
		}
		echo '</select>';		
	break;
	
	case "checkuser":
		$login=$GPC['login'];
		$bfor=$GPC['bfor'];
		if($login!="" && $login!=$bfor){
			$sql="SELECT customers_login FROM mm_customers WHERE customers_login='$login' ";
			$rs=mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($rs)>0){
				echo "WARNING (WMIX0012)\nUser already registered";
			}else{
				echo "1";
			}
		}
	break;
	
	case "remember_pass":
		$login=$GPC['login'];
		
		$query="SELECT customers_question FROM mm_customers WHERE customers_login='$login' and customers_status_id='1' ";
		//die($query);
		$res_array = $obj_tools_db->_SQL_tool(SELECT_SINGLE, "ajax_scripts", $query);
		if($res_array){
			echo '
			<tr>
				<td colspan="4" class="normal"><span class="invoice">'.$objLan->get_value_name("txt_reset_password").':</span><br />
				'.$objLan->get_value_name("txt_instruction_question").'<br /><br /></td>
			   </tr>			 
			 <tr>
				<td align="right" valign="top" class="normal"><strong>'.$objLan->get_value_name("txt_security_question").':</strong>		</td>
				<td width="23%" valign="top" nowrap="nowrap" class="normal">'.ucfirst($res_array['customers_question']).'</td>
				<td colspan="2" valign="top">&nbsp;</td>
			  </tr>
			 <tr>
				<td align="right" valign="top" class="normal"><strong>*'.$objLan->get_value_name("txt_your_answer").'</strong>		</td>
				<td width="23%" valign="top" nowrap="nowrap"><input name="answer" type="text" id="answer" class="input2 required" /></td>
				<td colspan="2" valign="top"><input name="customers_id" id="customers_id" type="hidden" value="'.$res_array['customers_id'].'" /></td>
			  </tr>					  
			 <tr>
			   <td align="right" valign="top" class="normal">&nbsp;</td>
			   <td valign="top" nowrap="nowrap" align="center"><br /><input name="search" type="submit" id="search" value="'.$objLan->get_value_name("txt_continue").'" class="button" onclick="" />
				&nbsp;&nbsp;<input name="cancel" type="button" id="cancel" value="'.$objLan->get_value_name("txt_Cancel").'" class="button" onclick="javascript: window.location = \''.DOMAIN_ROOT.'index.php\'" /></td>
			   <td colspan="2" valign="top">&nbsp;</td>
			 </tr>					  			
			<script language="javascript">
			document.form_rempass.action="javascript:validansweruser(\''.DOMAIN_ROOT.'lib/js/ajax_scripts.php\');"
			</script>				
			
			


			  ';
		} else {
			echo '
		<tr>
			<td colspan="4" class="normal"><span class="invoice">'.$objLan->get_value_name("txt_reset_password").'</span><br />
			'.$objLan->get_value_name("txt_instruction_userid").'<br /><br /></td>
		   </tr>			 
		 <tr>
			<td align="right" valign="top" class="normal"><strong>*'.$objLan->get_value_name("txt_mixandmatch").'</strong>				</td>
			<td width="23%" valign="top" nowrap="nowrap"><input name="userlogin" type="text" id="userlogin" class="required input2" />				</td>
			<td colspan="2" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
				<td  valign="top">&nbsp;</td>
				<td  valign="top" align="left" colspan="3" class="errormsg">'.$objLan->get_value_name("txt_id_incorrect").'</td>
		  </tr>
		 <tr>
		   <td align="right" valign="top" class="normal">&nbsp;</td>
		   <td valign="top" nowrap="nowrap" align="center"><br /><input name="search" type="submit" id="search" value="'.$objLan->get_value_name("txt_continue").'" class="button" onclick="" />
			&nbsp;&nbsp;<input name="cancel" type="button" id="cancel" value="'.$objLan->get_value_name("txt_Cancel").'" class="button" onclick="javascript: window.location = \''.DOMAIN_ROOT.'index.php\'" /></td>
		   <td colspan="2" valign="top">&nbsp;</td>
		   </tr>				  
		  ';
		}

		break;
	
	case "validansweruser":

				   
		$login=$GPC['login'];
		$answer=strtolower(trim($GPC['answer']));
		if(!isset($_SESSION['cust_tryleft'])){ $_SESSION['cust_tryleft'] = 2; }  
		
		$query="SELECT customers_id, customers_question, customers_answer FROM mm_customers WHERE customers_login='$login'  ";
		$res_array = $obj_tools_db->_SQL_tool(SELECT_SINGLE, "ajax_scripts", $query);
		
		if($answer == $res_array['customers_answer']){
			echo '
			<tr>
				<td colspan="4" class="normal"><span class="invoice">'.$objLan->get_value_name("txt_reset_password").'</span><br />
				'.$objLan->get_value_name("txt_instruction_newpass").'<br /><br /></td>
			   </tr>			 
			 <tr>
				<td align="right" valign="top" class="normal"><strong>*'.$objLan->get_value_name("txt_new_pass").':</strong>		</td>
				<td width="23%" valign="top" nowrap="nowrap"><input name="new_pass" type="password" id="new_pass" minLength="5" class="minlength input2"  />	</td>
				<td colspan="2" valign="top"><input name="customers_id" id="customers_id" type="hidden" value="'.$res_array['customers_id'].'" /></td>
			  </tr>
			 <tr>
				<td align="right" valign="top" class="normal"><strong>*'.$objLan->get_value_name("txt_confirm_new_pass").':</strong>		</td>
				<td width="23%" valign="top" nowrap="nowrap"><input name="retyped_pass" type="password" id="retyped_pass" value="" class="required input2"/>	</td>
				<td colspan="2" valign="top">&nbsp;</td>
			  </tr>				  			
			 <tr>
			   <td align="right" valign="top" class="normal">&nbsp;</td>
			   <td valign="top" nowrap="nowrap" align="center"><br /><input name="search" type="submit" id="search" value="'.$objLan->get_value_name("txt_save").'" class="button" />
				&nbsp;&nbsp;<input name="cancel" type="button" id="cancel" value="'.$objLan->get_value_name("txt_Cancel").'" class="button" onclick="javascript: window.location = \''.DOMAIN_ROOT.'index.php\'" /></td>
			   <td colspan="2" valign="top">&nbsp;</td>
			 </tr>				
			<script language="javascript">
			document.form_rempass.action="javascript:savenewpass(\''.DOMAIN_ROOT.'lib/js/ajax_scripts.php\');"
			</script>
			  ';
			unset($_SESSION['cust_tryleft']);
		} else {
			if($_SESSION['cust_tryleft']>0){
				echo '
				<tr>
					<td colspan="4" class="normal"><span class="invoice">'.$objLan->get_value_name("txt_reset_password").'</span><br />
					'.$objLan->get_value_name("txt_instruction_question").'<br /><br /></td>
				   </tr>			 
				 <tr>
					<td align="right" valign="top" class="normal"><strong>'.$objLan->get_value_name("txt_security_question").':</strong>		</td>
					<td width="23%" valign="top" nowrap="nowrap" class="required normal">'.ucfirst($res_array['customers_question']).'</td>
					<td colspan="2" valign="top">&nbsp;</td>
				  </tr>
				 <tr>
					<td align="right" valign="top" class="normal"><strong>*'.$objLan->get_value_name("txt_your_answer").':</strong>		</td>
					<td width="23%" valign="top" nowrap="nowrap"><input name="answer" type="text" id="answer" class="input2" /></td>
					<td colspan="2" valign="top"><input name="customers_id" id="customers_id" type="hidden" value="'.$res_array['customers_id'].'" /></td>
				  </tr>		
				  <tr>
						<td  valign="top">&nbsp;</td>
						<td  valign="top" align="left" colspan="3" class="errormsg">'.$objLan->get_value_name("txt_inv_answer1").$_SESSION['cust_tryleft'].$objLan->get_value_name("txt_inv_answer2").'</td>
				  </tr>					  
				 <tr>
				   <td align="right" valign="top" class="normal">&nbsp;</td>
				   <td valign="top" nowrap="nowrap" align="center"><br /><input name="search" type="submit" id="search" value="'.$objLan->get_value_name("txt_continue").'" class="button" onclick="" />
					&nbsp;&nbsp;<input name="cancel" type="button" id="cancel" value="'.$objLan->get_value_name("txt_Cancel").'" class="button" onclick="javascript: window.location = \''.DOMAIN_ROOT.'index.php\'" /></td>
				   <td colspan="2" valign="top">&nbsp;</td>
				 </tr>					  			
				<script language="javascript">
				document.form_rempass.action="javascript:validansweruser(\''.DOMAIN_ROOT.'lib/js/ajax_scripts.php\');"
				</script>
				

				';
				$_SESSION['cust_tryleft']--;

			} else {
				$query="UPDATE mm_customers SET customers_status_id='3' WHERE customers_login='$login'  ";
				$res_array = $obj_tools_db->_SQL_tool(UPDATE, "ajax_scripts", $query);
				
				echo '
					<tr>
						<td colspan="4" class="normal"><span class="invoice">'.$objLan->get_value_name("txt_reset_password").'</span><br />
						<br /><br /></td>
					   </tr>			
					  <tr>
							<td  valign="top">&nbsp;</td>
							<td  valign="top" align="left" colspan="3" class="errormsg">'.$objLan->get_value_name("txt_account_suspend").'</td>
					  </tr>				
				  ';
				  unset($_SESSION['cust_tryleft']);
			}
		}		  
		break;

	case "savenewpass":

		$obj_customer = new cls_customer;
		$customers_id=$GPC['userid'];
		$new_password=$GPC['newpass'];
		$obj_customer->change_pass_by_admin($new_password,$customers_id);
		echo '
		<tr>
			<td colspan="4" class="normal"><span class="invoice">'.$objLan->get_value_name("txt_reset_password").'</span><br />
			<br /><br /></td>
		   </tr>			
		  <tr>
				<td  valign="top">&nbsp;</td>
				<td  valign="top" align="left" colspan="3" class="normal">'.$objLan->get_value_name("txt_changepassok").'</td>
		  </tr>			
		  <tr>
				<td  valign="top">&nbsp;</td>
				<td  valign="top" align="center" colspan="3" class="normal"><br><br><input name="continue" type="button" id="continue" value="'.$objLan->get_value_name("txt_back").'" class="button" onclick="javascript: window.location = \''.DOMAIN_ROOT.'index.php\'" /></td>
		  </tr>			  	
	  ';
	break;	
	
}
?>