<?php
 function getFrontAgentsMonthsReport($filename, $agent, $ID, $padding)
	{
		$result = array();

		$year = $_SESSION['agent_'.$filename]['Year'];
		/*echo $year;
		exit;*/

		/*$sql = "SELECT group_concat(`ID` separator ',') AS IDs FROM agent";

		foreach ($this->dbconnect->query($sql) as $row){

			$IDs = $row['IDs'];

		}*/
		//echo $IDs;
		//$ID = explode(",", $IDs);
		$ID['count'] = count($ID);

		/*Debug::displayArray($ID);
		exit;*/
		//for ($i=1; $i <= 12; $i++) {

		$crud = new CRUD();



				for ($i=1; $i <= 12; $i++) {



				if($i == 1) {


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}
				    //case "1":
				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-01-01 00:00:00' AND t.Date <= '{$year}-01-31 23:59:59' AND t.Status = '2'";

		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			       }
            $result[$i]['month'] = "January";
			$result[$i]['year'] = $year;
				 /*Debug::displayArray($result);
				 exit;*/
				    }elseif($i == 2){



		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";
			foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				    $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-02-01 00:00:00' AND t.Date <= '{$year}-02-28 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}    //break;

			$result[$i]['month'] = 'February';
			$result[$i]['year'] = $year;

				    }elseif($i == 3){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

				        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-03-01 00:00:00' AND t.Date <= '{$year}-03-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


			}

			$result[$i]['month'] = 'March';
			$result[$i]['year'] = $year;

				    }elseif($i == 4){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-04-01 00:00:00' AND t.Date <= '{$year}-04-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);
				        //break;

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}

			$result[$i]['month'] = 'April';
			$result[$i]['year'] = $year;

					}elseif($i == 5){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-05-01 00:00:00' AND t.Date <= '{$year}-05-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			  }

				$result[$i]['month'] = 'May';
				$result[$i]['year'] = $year;

					}elseif($i == 6){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-06-01 00:00:00' AND t.Date <= '{$year}-06-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				    $result[$i]['month'] = 'June';
					$result[$i]['year'] = $year;

					}elseif($i == 7){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-07-01 00:00:00' AND t.Date <= '{$year}-07-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);
			}
				     $result[$i]['month'] = 'July';
					 $result[$i]['year'] = $year;

					}elseif($i == 8){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-08-01 00:00:00' AND t.Date <= '{$year}-08-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

					$result[$i]['month'] = 'August';
					$result[$i]['year'] = $year;

					}elseif($i == 9){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-09-01 00:00:00' AND t.Date <= '{$year}-09-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}

				   $result[$i]['month'] = 'September';
				   $result[$i]['year'] = $year;

					}elseif($i == 10){


			for ($z=0; $z < $ID['count']; $z++) {


		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}


			        $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-10-01 00:00:00' AND t.Date <= '{$year}-10-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

			}
				        //break;
				    $result[$i]['month'] = 'October';
					$result[$i]['year'] = $year;

					}elseif($i == 11){

				for ($z=0; $z < $ID['count']; $z++) {



		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-11-01 00:00:00' AND t.Date <= '{$year}-11-30 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);

				               }

					$result[$i]['month'] = 	'November';
					$result[$i]['year'] = $year;

					}elseif($i == 12){


		for ($z=0; $z < $ID['count']; $z++) {

		        $sql = "SELECT Profitsharing FROM agent WHERE ID = '".$ID[$z][0]."'";

				foreach ($this->dbconnect->query($sql) as $row)
				{
				$Profitsharing = $row['Profitsharing'];

				}

			        	 $sql = "SELECT t.Debit as t_Debit, t.Credit as t_Credit, t.Bonus as t_Bonus, t.Commission as t_Commission FROM transaction AS t, member AS m WHERE m.Agent = '".$ID[$z][0]."' AND t.MemberID = m.ID AND t.Date >= '{$year}-12-01 00:00:00' AND t.Date <= '{$year}-12-31 23:59:59' AND t.Status = '2'";
		        //echo $sql.'<br />';
		        foreach ($this->dbconnect->query($sql) as $row)
				{


					$In += $row['t_Debit'];
					$Out += $row['t_Credit'];
					$Bonus += $row['t_Bonus'];
					$Commission += $row['t_Commission'];
					//$i += 1;


				}



			$profit = $In -  $Out - $Bonus - $Commission;

			$Total = $In - $Out - $Bonus - $Commission;

			$Percentage = $profit * ($Profitsharing/100);


			$result[$i][$z]['Agent'] = AgentModel::getAgent($ID[$z][0]);
                        $result[$i][$z]['Padding'] = AgentModel::getAgent($ID[$z][1]);
			$result[$i][$z]['In'] = Helper::displayCurrency($In);
			$result[$i][$z]['Out'] = Helper::displayCurrency($Out);
			$result[$i][$z]['Bonus'] = Helper::displayCurrency($Bonus);
			$result[$i][$z]['Commission'] = Helper::displayCurrency($Commission);
			$result[$i][$z]['Profit'] = Helper::displayCurrency($profit);
			$result[$i][$z]['Profitsharing'] = number_format((float)$Profitsharing, 2, '.', '');
			$result[$i][$z]['Percentage'] = Helper::displayCurrency($Percentage);

			/*'In'=> Helper::displayCurrency($In),'Out'=> Helper::displayCurrency($Out),'Bonus'=> Helper::displayCurrency($Bonus),'Commission'=> Helper::displayCurrency($Commission), 'Profit' => Helper::displayCurrency($profit), 'Profitsharing' => number_format((float)$Profitsharing, 2, '.', ''), 'Percentage' => Helper::displayCurrency($Percentage));*/

			unset($profit);
			unset($In);
			unset($Out);
	        unset($Commission);
	        unset($Bonus);
			unset($Total);
			unset($Percentage);
			unset($Profitsharing);


				}
				$result[$i]['month'] = 'December';
				$result[$i]['year'] = $year;

				}



			//}

        }
        /*Debug::displayArray($result);
        exit;*/
        $result['padding'] = $padding;
        $result['count'] = $ID['count'];
		return $result;

	}

