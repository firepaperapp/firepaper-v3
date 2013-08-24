<form name="loginform" id="loginform" action="<?php echo SITE_HTTP_URL ?>admin/login" method="post">
<table width="285" cellspacing="0" cellpadding="0" border="0" align="center">
  <tbody>
 	<tr>
  	  <td>
		<div id="Login_Container">
	 	   <table width="412" cellspacing="0" cellpadding="0" border="0" align="center">
			 <tbody>
				<tr>
				   <td valign="top">&nbsp;</td>
				</tr>
			    <tr>
				   <td valign="top">
					  <table width="412" cellspacing="0" cellpadding="0" border="0">
					     <tbody>
							<!--<tr>
						       <td valign="top" height="19"><img width="411" height="22" border="0" alt="" src="http://192.168.10.149/classified/images/login_Curb_TP.gif"></td>
					        </tr>-->
							<tr>
							   <td valign="top">
					              <div class="main-signup">
								   	  <table width="411" cellspacing="0" cellpadding="0" border="0" align="center">
					                    <tbody>
										   <tr>
								  			  <td height="5">
						    					 <div class="cffffff err" style="text-align:center;"><strong><?php $this->Session->flash();?></strong></div>
												 <?php if(isset($err) && ($err == 1)) { ?>
												 <div class="cffffff err" style="text-align:center;"><strong><?php echo $this->Utility->display_message($errMsg,'error',1);	?></strong></div>
 												 <?php } ?>
											  </td>
									  	   </tr>
										   <tr>
											  <td valign="top" height="22">&nbsp;</td>
										   </tr>
                                           <tr>
                                              <td valign="top">
											  <table width="270" cellspacing="0" cellpadding="0" border="0" align="center">
                                                 <tbody>
													<tr>
					                                   <td height="30" class="font_17 colorBlck">Email or Username</td>
									                </tr>
					                                <tr>
														<td valign="top" height="35"><label>
														<input type="text" maxlength="255" value="" class="input" id="loginName" name="data[Admin][username]" gtbfieldid="2"></label></td>
					                                </tr>
									                <tr>
					                                    <td height="30" class="font_17 colorBlck">Password</td>
										            </tr>
		 										    <tr>
														<td valign="top" height="35"><input type="password" value="" class="input" label="" id="password" name="data[Admin][password]"></td>
												    </tr>
													<tr>
					                                    <td valign="top">
															<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:10px;">
						                                      <tbody>
																<tr>
							                                      <!-- <td width="9%" height="35"><label>
													               <input type="checkbox" id="remcookie" value="1" name="data[Admin][remcookie]"></label></td>-->
						                                           <td width="91%" class="font_12 colorBlck"><!-- keep me signed in |--> <a href="<?php echo SITE_HTTP_URL ?>admin/forgotpassword" style="color:black;">Forgot password?</a><br/></td>
																</tr>
															  </tbody>
															</table>
														</td>
					                                </tr>
  												    <tr>
														<td valign="top"><div class=""><input type="submit" value="Login" class="bgc5e3f8 b333333" label=""></div></td>
													</tr>
			                                     </tbody>
										     </table>
										    </td>
		                                   </tr>
										   <tr>
											  <td valign="top" height="22">&nbsp;</td>
										   </tr>
										</tbody>
									  </table>
								 </div>
								</td>
							  </tr>
							 <!-- <tr>
								<td valign="top" height="19"><img width="411" height="22" border="0" alt="" src="http://192.168.10.149/classified/img/login_Curb_BT.gif"></td>
							  </tr>-->
							</tbody>
						</table>
					</td>
		          </tr>
				</tbody>
			</table>
		</div>
   	 </td>		
   </tr>
 </tbody>
</table>
</form>