	
			
			
			
			
			
		if ($_SESSION['dealer']['ID'] != "") {

				// Send Mail
				
				$mailer = new BaseMailer();

				$mailer -> From = "no-reply@aseanfnb.valse.com.my";

				$mailer -> AddReplyTo = "admin@baseanfnb.valse.com.my";

				$mailer -> FromName = "Aseanfnb";

				$mailer -> Subject = "[Aseanfnb] Order Confirmation #" . $orderID;

				$mailer -> AddAddress($_SESSION['dealer']['Email'], '');

				$mailer -> AddBCC('decweng.chan@valse.com.my', '');

				$mailer -> IsHTML(true);

				$mailer -> Body = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


                  <title>Order Confirmation #' . $orderID . '</title>


                  


                  <div style="width: 550px; border:1px solid #ddd; padding:10px; margin:10px">


                  <table style="font-family:Arial,sans-serif; font-size:12px;


                    color:#333; width: 550px;">


                    <tbody>


                      <tr>


                        <td align="left" style="font-size:16px; font-weight:bold; text-transform:uppercase"><img src="http://bitdstrategy.com/themes/valse/img/logo_mail.png" /></td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left">Hello <strong style="color:#FB7D00;">' . $_SESSION['dealer']['Name'] . '</strong>,<br /><br />Thank you for your payment. Your order has been processed. ' . $backorder_remarks . '<br />&nbsp;</td>


                      </tr>


                      <tr>


                        <td style="background-color:#333; color:#FFF; font-size:


                          12px; font-weight:bold; padding: 0.5em


                          1em;" align="left">Order details</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="left" colspan="2" style="color:#333; padding:0.6em 0.8em;"> Order: <strong><span


                              style="color:#FB7D00;">#' . $orderID . '</span></strong> placed on <strong>' . $result[0]['OrderDate'] . '</strong>


                        </td>


                      </tr>


                      <tr>


                        <td align="left">


                          <table style="width:100%; font-family:Arial,sans-serif; font-size:12px; color:#374953;">


                           <tbody>


                              <tr>


                                <td colspan="2" style="background-color:#efefef; color:#333; padding:0.6em 0.8em;"><strong>' . $result[0]['Item'] . '</strong><br />


                                    ' . $result[0]['Description'] . '


                                </td>


                              </tr>


                              <tr style="text-align:right; font-weight:bold;">


                                <td style="width:80%; background-color:#333; color:#FFFFFF; padding:0.6em 0.8em;">Total paid</td>


                                <td style="background-color:#333; color:#fff; padding:0.6em 0.8em;">RM' . $result[0]['Total'] . '</td>


                              </tr>


                            </tbody>


                          </table>


                        </td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td align="center">You can review your orders in the <a moz-do-not-send="true"


                            href="http://aseanfnb.valse.com.my/merchant/order/index"


                            style="color:#FB7D00; font-weight:bold;


                            text-decoration:none;">"Order History"</a> page</td>


                      </tr>


                      <tr>


                        <td>&nbsp;</td>


                      </tr>


                      <tr>


                        <td style="border-top: 1px solid #ddd;" align="center"> <a moz-do-not-send="true" href="" style="color:#FB7D00; font-weight:bold; text-decoration:none;">Chopin Society Malaysia</a>


                        </td>


                      </tr>


                    </tbody>


                  </table>


                  </div>';

				$mailer -> Send();

			

		} else {

			// Failed / Cancelled Order

			$sql = "UPDATE `order` SET `Status` = '3', PaymentMethod = '" . $gateway . "',  Remarks = 'Transaction ID: " . $trxID . "' WHERE ID = '$orderID' AND MerchantID = '" . $clientID . "'";

			$this -> dbconnect -> query($sql);

		}	