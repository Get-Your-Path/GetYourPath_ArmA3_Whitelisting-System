<html>
	<head>
		<title>Whitelist</title>
	</head>
	<body>
		<?php

		function uidtoguid($uid)
		{
			$temp = '';

			for ($i = 0; $i < 8; $i++) {
				$temp .= chr($uid & 0xFF);
				$uid >>= 8;
			}

			$return = md5('BE' . $temp);
			return $return;
		}
		
		function connectDBForum()
		{
			$servername = ""; //XenForo 2.1 Host Database
			$username = ""; //XenForo 2.1 Username Database
			$password = ""; //XenForo 2.1 Password Database
			$dbname = ""; //XenForo 2.1 Name Database

			global $connF;
			$connF = new mysqli($servername, $username, $password, $dbname);
		}
		
		function connectDBGameServer()
		{
			$servername = ""; //Gameserver Host Database
			$username = ""; //Gameserver Username Database
			$password = ""; //Gameserver Password Database
			$dbname = ""; //Gameserver Name Database

			global $connG;
			$connG = new mysqli($servername, $username, $password, $dbname);
		}
		
		connectDBForum();
		connectDBGameServer();
	
		$connFPing = mysqli_ping($connF);
		$connGPing = mysqli_ping($connG);
			
		if ($connFPing && $connGPing) 
		{
			$query = "SELECT forumid FROM whitelist";
			$result = $connG->query($query);
			$whitelisted = array();
				
			while ($row = mysqli_fetch_assoc($result))
			{
				array_push($whitelisted,$row["forumid"]);
			};

			$shouldwhitelist = array();
			$namearray = array();
			$query = "SELECT user_id,username FROM xf_user WHERE (secondary_group_ids LIKE '36%' OR secondary_group_ids LIKE '%,36%') AND ((secondary_group_ids LIKE '37%' OR secondary_group_ids LIKE '%,37%') OR (user_group_id = 37)) AND user_id IN (SELECT user_id FROM xf_user_connected_account WHERE provider = 'steam')";
			$result = $connF->query($query);
				
			while ($row = mysqli_fetch_assoc($result))
			{
				array_push($shouldwhitelist,$row["user_id"]);
				array_push($namearray,$row["username"]);
			};			
				
			$whitelistedP = 0;
			$unwhitelistedP = 0;
				
			foreach ($shouldwhitelist as $element)
			{
				if (!in_array($element,$whitelisted))
				{
					$element = mysqli_real_escape_string($connF,$element);
					$query = "SELECT provider_key FROM xf_user_connected_account WHERE provider = 'steam' AND user_id = '$element'";
					$result = $connF->query($query);
					$uid = array();
					while ($row = mysqli_fetch_assoc($result))
					{
						array_push($uid,$row["provider_key"]);
					};
					$uid = $uid[0];
						
					$uid = mysqli_real_escape_string($connG,$uid);
					$guid = mysqli_real_escape_string($connG,uidtoguid($uid));
					$element = mysqli_real_escape_string($connG,$element);
						
					$query = "INSERT INTO whitelist (uid,beguid,forumid) VALUES ('$uid','$guid','$element')";
					$result = $connG->query($query);
					if ($result)
					{
						$handle = fopen("whitelistLog.txt", "a");
						$date = date("Y/m/d") . date("h:i:sa");
						$name = $namearray[array_search($element,$shouldwhitelist)];
						$data = "{$date} Succesfully whitelisted {$name} | forumID {$element} | UID {$uid}\n";
						fwrite($handle, $data);
						fclose($handle);
						$whitelistedP++;
					}
				}
			}
				
			foreach ($whitelisted as $element)
			{
				if (!in_array($element,$shouldwhitelist))
				{
					$element = mysqli_real_escape_string($connG,$element);
					$query = "DELETE FROM whitelist WHERE forumid = '$element'";
					$result = $connG->query($query);
					if ($result)
					{
						$handle = fopen("whitelistLog.txt", "a");
						$date = date("Y/m/d") . date("h:i:sa");
						$data = "{$date} Succesfully unwhitelisted a player | forumID {$element} | UID {$uid}\n";
						fwrite($handle, $data);
						fclose($handle);
						$unwhitelistedP++;
					}					
				}					
			}
				
			$handle = fopen("whitelistLog.txt", "a");
			$date = date("Y/m/d") . date("h:i:sa");
			$data = "{$date} Finished updating whitelist table | Whitelisted {$whitelistedP} players | Unwhitelisted {$unwhitelistedP} players\n";
			fwrite($handle, $data);
			fclose($handle);			
				
		} else
		{
			$handle = fopen("whitelistLog.txt", "a");
			$date = date("Y/m/d") . date("h:i:sa");
			$data = "{$date} Whitelisting failed | Unable to ping to game or forum SQL database\n";
			fwrite($handle, $data);
			fclose($handle);			
		}	

		var_dump($uid);
		var_dump($guid);
		var_dump($element);
		
		?>
	</body>
</html>