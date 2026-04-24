<?php
	header("content-type: text/xml");

	include_once('../templates/config.php');
	include_once('../templates/lib.php');

	$user = new user($_SESSION['user_id']);

	$monposition = $_GET['userTeam'];

	$monposition = max(0, $monposition - 1);

	$user_monster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . $user->team[$monposition] . "'"));

	$user_monster_base = new monster($user_monster->id);

	if ($_GET['userMonsters'] == 0) {
		$user->team[$monposition] = 0;

		$user->billsPC[] = (int)$user_monster->mid;

		$user->billsPC = array_values(array_filter($user->billsPC));

		@mysql_query("UPDATE `users` SET `team` = '" . json_encode($user->team) . "', `billsPC` = '" . json_encode($user->billsPC) . "' WHERE `id` = '" . $user->id . "'");

		$results = '<id>' . $user_monster->mid . '</id>';
		$results .= '<monposition>' . ($monposition + 1) . '</monposition>';
	} else {
		for ($i = 0, $size = count($user->billsPC); $i < $size; $i++) {
			$billsPC_monster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . $user->billsPC[$i] . "'"));

			if ($billsPC_monster->mid) {
				$billsPC_mons_id = $billsPC_monster->id;
			}

			if ($billsPC_monster->mid == $_GET['userMonsters']) {
				$billsPC_monster_base = new monster($billsPC_monster->id);

				$results = '<id>0</id>';
				if ($billsPC_monster->name) {
					$results .= '<title> ' . $billsPC_monster_base->name . ' (' . $billsPC_monster->gender . ') Lvl ' . $billsPC_monster->level . ' (' . $billsPC_monster->name . ')</title>';
				} else {
					$results .= '<title> ' . $billsPC_monster_base->name . ' (' . $billsPC_monster->gender . ') Lvl ' . $billsPC_monster->level . '</title>';
				}
				$results .= '<name>' . $billsPC_monster_base->name . '</name>';
				$results .= '<img>' . $billsPC_monster_base->sprites->animated_front . '</img>';
				$results .= '<lvl>' . $billsPC_monster->level . '</lvl>';

				if ($billsPC_monster->mid > 0) {
					$user->team[$monposition] = (int)$billsPC_monster->mid;
				} else {
					$user->team[$monposition] = 0;
				}

				if ($user_monster->mid > 0) {
					if ($user->billsPC[$i] == 0) {
						$user->billsPC[$i] = (int)$user_monster->mid;
					} else {
						$user->billsPC[] = (int)$user_monster->mid;
					}
				} else {
					$user->billsPC[$i] = 0;
				}

				$user->billsPC = array_values(array_filter($user->billsPC));

				@mysql_query("UPDATE `users` SET `team` = '" . json_encode($user->team) . "', `billsPC` = '" . json_encode($user->billsPC) . "' WHERE `id` = '" . $user->id . "'");

				$results .= "<monposition>" . ($monposition + 1) . "</monposition>";
			}
		}
	}

	if (!$results) {
		if ($user->billsPC[0]) {
			$results = '<id>' . $user->billsPC[0] . '</id>';
		} else {
			$results = '<id>0</id>';
		}
		$results .= '<monposition>7</monposition>';
	}
	$results .= '<message>success:You have successfully updated your team.</message>';

	die('<response>' . $results . '</response>');
?>
