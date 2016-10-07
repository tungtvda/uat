<?php
class massReplace {
    public function MemberRegisterProcess()
    {

        if(is_array($_SESSION['member']['token'])===FALSE)
            {
               $_SESSION['member']['token'] = array();
            }

            if (in_array($_POST['form_token'], $_SESSION['member']['token'])===FALSE) {

                array_push($_SESSION['member']['token'], $_POST['form_token']);

                 /*Debug::displayArray($_SESSION['member']);
                 exit;*/
            /*if($_POST['form_token']==$_SESSION['form_token'])
            {*/

            $tmp_time = time();
            $tmp_time += 3;
            $form_token = $tmp_time.'-'.time();
            $_SESSION['form_token'] = $form_token;
            $_SESSION['form_token'] = $tmp_time.'-'.time();


        $_POST['MobileNo'] = $_POST['MobilePrefix'].$_POST['MobileNo'];

        // Set reseller code session
        $reseller_id_list = AgentModel::getAgentListArray();
        $decoded_reseller_code = $_SESSION['reseller_code'];

        if (is_numeric($decoded_reseller_code))
        {
            if (in_array($decoded_reseller_code, $reseller_id_list))
            {
            }
            else
            {
                exit();
            }
        }
        else {
            exit();
        }


        if($_POST['Username']=='')
        {
            //Empty username consider error
            $i_username = 1;
        }
        
        if($_POST['Email']=='')
        {
            //Empty username consider error
            $i_email = 1;
        }
        
        if($_POST['Username']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Username = '".$_POST['Username']."' AND Agent = '".$_SESSION['reseller_code']."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_username = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_username] = array(
                'Username' => $row['Username']);

                $i_username += 1;
            }

            
        }
        
         if($_POST['Email']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Agent = '".$_SESSION['reseller_code']."' AND Email = '".$_POST['Email']."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_email = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_email] = array(
                'Email' => $row['Email']);

                $i_email += 1;
            }

            
        }


        // Check if security question is correct
        $i_security = 0;

        if ($_POST['C1']+$_POST['C2']!=$_POST['SQ'])
        {
            $i_security += 1;
        }

        
        
        if($_POST['BankAccountNo']!='' && $_POST['Bank']!='')
        {
            // Check is username exists
            $sql = "SELECT * FROM member WHERE Bank = '".$_POST['Bank']."' AND BankAccountNo = '".$_POST['BankAccountNo']."' AND Agent = '".$_SESSION['reseller_code']."' AND Agent != '' AND Enabled = '1'";
            

            $result = array();
            $i_bank = 0;
            foreach ($this->dbconnect->query($sql) as $row)
            {
                $result[$i_bank] = array(
                'BankAccountNo' => $row['BankAccountNo']);

                $i_bank += 1;
            }

            
        }



        $error['count'] = $i_username + $i_security + $i_bank + $i_email;



        if ($error['count']>0)
        {
            if ($i_username>0)
            {
                $error['Username'] = 1;
            }

            if ($i_security>0)
            {
                $error['SQ'] = 1;
            }

            if ($i_bank>0)
            {
                $error['Bank'] = 1;
            }
            
            if ($i_email>0)
            {
                $error['Email'] = 1;
            }

            $_SESSION['admin']['member_register_info'] = Helper::unescape($_POST);
        }
        else
        {
            // Insert new member
            $bcrypt = new Bcrypt(9);
            $hash = $bcrypt->hash($_POST['Password']);

            $key = "(Agent, GenderID, Name, FacebookID, NRIC, Passport, Company, Bank, BankAccountNo, DOB, Nationality, Username, Password, PhoneNo, FaxNo, MobileNo, Email, Prompt, DateRegistered, Enabled)";
            $value = "('".$_SESSION['reseller_code']."', '".$_POST['GenderID']."', '".$_POST['Name']."', '".$_POST['FacebookID']."', '".$_POST['NRIC']."', '".$_POST['Passport']."', '".$_POST['Company']."', '".$_POST['Bank']."', '".$_POST['BankAccountNo']."', '".Helper::dateDisplaySQL($_POST['DOB'])."', '".$_POST['Nationality']."', '".$_POST['Username']."', '".$hash."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['MobileNo']."', '".$_POST['Email']."', '0', '".date('YmdHis')."', '1')";

            $sql = "INSERT INTO member ".$key." VALUES ". $value;

            $count = $this->dbconnect->exec($sql);
            $newID = $this->dbconnect->lastInsertId();

            // Create all product wallets for new member
			//$Product = ProductModel::getProductList();

                        $Product = AgentModel::getAgentProducts($_SESSION['reseller_code']);

                        if($Product == 'Null')
                        {

                        }
                        else
                        {
                            /*$Product = explode(',', $Product);

                            $Product['count'] = count($Product);*/

                            for ($i=0; $i <$Product['count'] ; $i++)
                            {
                                $key = "(Total, ProductID, AgentID, MemberID, Enabled)";
                                $value = "('0', '".$Product[$i]."', '".$_SESSION['reseller_code']."', '".$newID."', '1')";

                                $sql = "INSERT INTO wallet ".$key." VALUES ". $value;
                                //echo $sql;
                                //exit;
                                $this->dbconnect->exec($sql);
                            }
                        }

            // Insert new member's first address
            /*$key_address = "(MemberID, Title, Street, Street2, City, State, Postcode, Country, PhoneNo, FaxNo, Email, Enabled)";
            $value_address = "('".$newID."', 'My First Address', '".$_POST['Street']."', '".$_POST['Street2']."', '".$_POST['City']."', '".$_POST['State']."', '".$_POST['Postcode']."', '".$_POST['Country']."', '".$_POST['PhoneNo']."', '".$_POST['FaxNo']."', '".$_POST['Email']."', '1')";

            $sql_address = "INSERT INTO member_address ".$key_address." VALUES ". $value_address;

            $count_address = $this->dbconnect->exec($sql_address);*/

            // Set Status
            $ok = ($count==1) ? 1 : "";

        }

            }
            else
            {

                $ok = "";
            }

        if ($ok=='1')
        {
            if($_SESSION['member']['ID']=='10695'){

            AgentModel::getloopAgentParent($_SESSION['reseller_code']);

            if($_SESSION['platform_agent'] == '54'){
                //Set latest resend time
                $_SESSION['member']['activation_time'] = date('YmdHis');


                $activation_code = $this->getActivationCode($newID);

                if ($this->config['SMS_VERIFY_ON']=='1')
                {
                    $this->sendSMS($activation_code['code'], $_POST['MobileNo']);
                }


            }

            unset($_SESSION['platform_agent']);



            // Set latest resend time
            //$_SESSION['member']['activation_time'] = date('YmdHis');

            #$status = $this->checkActivationCode($newID);
            //$activation_code = $this->getActivationCode($newID);

            //if ($this->config['SMS_VERIFY_ON']=='1')
            //{
                //$this->sendSMS($activation_code['code'], $_POST['MobileNo']);
            //}

            // Set latest resend time
            //$_SESSION['member']['activation_time'] = date('YmdHis');

            #$status = $this->checkActivationCode($newID);
            //$activation_code = $this->getActivationCode($newID);

            //$this->sendSMS($activation_code['code'], $_POST['MobileNo']);



            }

        }

        $this->output = array(
        'config' => $this->config,
        'page' => array('title' => "Registering...", 'template' => 'common.tpl.php'),
        'content' => Helper::unescape($_POST),
        'reseller' => AgentModel::getAgent($_SESSION['reseller_code']),
        'content_param' => array('count' => $count, 'newID' => $newID),
        'status' => array('ok' => $ok, 'error' => $error),
        'meta' => array('active' => "on"));

        return $this->output;
    }

}