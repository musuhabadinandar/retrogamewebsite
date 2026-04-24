<?php
	header("content-type: text/xml");

	include_once('../templates/config.php');
	include_once('../templates/lib.php');
	include_once('../templates/includes/Array2XML.php');

	$captchaImagesBase64 = array(
		'1' => 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAIAAADYYG7QAAAFCElEQVRYhbVZS3bUSBCMzCq1Ws/gPUtuYJsd73GQudachWtgOIAXM2B28DAscKtVlTGLlKrl/koeOhbtaqnUGZUZlZkqCwAA//zzbzcgpS7nbGYksQ8iMh7sfo4Hh0AypZRzJqmqb9++BfD+/XsB8OXL167r/PZAKOWczE4Q8vEWIREhWa7vhZm5rfV6nXMWkbqu3717JyKR/PvrV6iqquac3QoAEk5/opN2B0fcY2Zd17Vt27atE1LVu7s7kvHbt79CMEDMzG+oakriTEg7QOlJjFTVqW993Yuc82q1cnm4h1S1ruvHx8eHh4eoGmM0ETEz140Zm6aJ8YWq+JW9v75XOsd947dSSr9+/fr+/ftqtXI2Hpy2bVNK0b974EECqOvFy5cvlstlf3EyXDon76rqer3+/Pnz3d1dSimEEGNUVQBmFkVEVCHinggxNs2yrhdFm2Vlhdxcort+uri4eP369e/fv+/v72OMVVXFGEMIZhZdh6oaYwQgKotFRdIFfnL3zoWvhGRd169evfr582fXdYvFIoTgtmJhrSFEEVV3ho2f/+Pwbb9cLpumIRlC8JBtCDlcTqQd3lt/DK4Hj9Q4Dlpun8kZx7GbP+OBiQDhMyfyfIbYttLpEw1tQAzbH6RMtzTLvyJuZZNLy+cOIfH49Vb8yYmYw0mAzewxpwMhG2afW1e7tW+bkBNw/tNlcXV1DeDTp4/PplXGezxE9rRcQydxfX01PDh1BUUJux7SffP7ssYJuL6+ur39WB6bjCcp97SGfAFTtv3t7W0RnMgcVQsxOQ8Jhx4Nc5Q0J2RScsp+UZcCLoBx4xWRGWZmbcnSOgDw/mcgtFU0SMCeu+2nz6ZTwU5DEQez0vcFIiVrDTOPmbm5uSnjN29u0KtqKkrNKLGL6C1TSEA5itcQw2P48GGce4hpTh06vsH4QAxALJ0rAQH7jbX5VW6l+SNWZoVsEPV2uYwApLRx/U1OD9nYxmQ2GNjTyyUghUXE0xJKCKDTnf9cyCAGAdRXvjdk/vfsvdrggSIdGW37UQBHSd3O0OCPMZYEnngIg++MY26bXXAuRhQS+zwEsiShnodMz87Pw5EqGQf9AIB4FyRbu+xMoCfDrVOKreLqFHoNnZUOwNIdHGk/hhpCwZxu+jl0iOEUqWezyUNblEghgHPKyDmU0nGihUXvyWNHGX+OFrbK/hNCdC7knBL2bHDsm/1vHZ7GbSPt8xChmyeJcjqFrcRIQEVUNYQAMK3y8dOn/wkvHSkloD8GKoj+Dq8iohpCCCHEqGa2Xnc4R/kgIBARM67aDpAQKtLKAVB/ghaCimrQoKoi2jRNjJXZwVPYzVLnZAcR0GhEynnVtjlTQ+yv0kQUQAzBj4t6ADAjICEEkoQdNzGqQid5CQAomS1nIxFjEDCLkAaaqgISQ9AQgqo4QZJ+vGVmOZvxMCERwfD6OclBG8aqUlVVr2UzMycURLwfAlW1f1W1HtmOshlarD61e5sOnnCTiAAhANicmuWc/TRaFSISV6vHplmKwAmy9CYiGsKRpZdY9Z3dHPmrqqr5MX3OOaWUkoUgwS0+PDy4slXVSNuO1EFLQzt8dNKBx2iWc87ZUsrrdQvYclk3TRMBVFXVtuuu6wbvlUw95ZfnZlHBpmOnGXPOqlgs6rquLy8v4/39/cXFBckfP34A8H8xTF9wSf2TVoBeZkOIRRVVFUMIVVVdXl6KyH+nEnQMnsSFjgAAAABJRU5ErkJggg==',
		'2' => 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAIAAADYYG7QAAAFIUlEQVRYhbVZS3LbSAx9QDdFsZx4n2VuMPEyVTnIXGvOkmtE8gG8yCTOLqk4WcSi2I03C5BNSdaH8lgol90im8Rr4OEjWAAA+Pz5326QlLqcs5mRxD4Rkc3F09+bi0NCMqWUcyapqu/fvwfw8eNHAfD167eu6/z2ACjlnMxOAPL1DiARIVmu7xUzc13r9TrnLCJ1XX/48EFEIvnPt29QVVXNObsWACQc/kQjPV0cMY+ZdV3Xtm3btg5IVe/u7kjG79//DsEAMTO/oaopiSMh7QCkLR+pqkPf+bhXcs6r1crp4RZS1bquHx8fHx4eomqM0UTEzJw3ZmyaJsZXquJX9r59L3WO28ZvpZR+//7948eP1WrlaNw5bdumlKJ/dseDBFDXs9evX83n8/7iZHHqnLyrquv1+suXL3d3dymlEEKMUVUBmFkUEVGFiFsixNg087qeFW6WkxVw5wJ9aqerq6u3b9/++fPn/v4+xlhVVYwxhGBm0XmoqjFGAKIym1UkneAno/dc8ZOQrOv6zZs3v3796rpuNpuFEFxXLKg1hCii6sawzedfXDzs5/N50zQkQwjushGQi9OJtMOx9WLifHBPbfpBy+0LGeO4PM2f8cBGgPCdE3E+g2w76XSLQ6MQQ/iDlOmazrKviGsZc2n5/QSQuP96Lf7kRDkHkwDj7k1MB1w27J6i4927d2W9XC6ng8K+2qd7gUi/+/SPo7m9Xd7eLh3clKeewirrPRYie1jOoSmyuXPKU4UJTy2012Ujh06+erFYYjt/TksfW8XnNIf8ANPD/ubmxhfL5WLKMQCI9CE2JQ8Jhx4NE8LeaTSYagoYL899TtnvslLABTCO7xU5wYmbm78ALBa359a90joA8P5nALRTNEjAzgr7Asvl06fFFDxDKO82FHFQK31fIFKy1rDzGKjFYor6g1JqRvFdRK+ZQgLKDX8NPpwuU302dHyD8gEYgFg6VwIC9oE1uoo7af6IlumAvPvAGPDjjYiSE4ZaB3C6yzZ1TEaDAT29XAJSUERsl1BCAPW3X7JBklKfAPWT73WZ/714rzZYoFBHNsJ+w4GeAdhH/os3+JuySQlsWQiD7Yyb2MYouBQiCol9FgJZklCPQ6bX+efJkSoZB/4AgIBeRXZMehmhJ8OdKcVOcXUIPYcuCgegF3wcbT+GGkLBOd30c+AQwxSpRzPmoR1IpBDAJWnkGErpONHCorfksVHGy8HCTtnfAkTHQp5Twp4t3LTN/p7a07iN1L4MELp6kijTKewkRgIqoqohBIBplY9Pn/6neOlIKQH9GKhI9O/wKiKqIYQQQoxqZut1h0uUDwICETHjqu0ACaEirQyA+glaCCqqQYOqimjTNDFWZgensONRz8kOIqDRiJTzqm1zpobYX6WJKIAYgo+LegFgRkBCCCQJO65iowqdxCUAoGS2nI1EjEHALEIaaKoKSAxBQwiq4gBJ+njLzHI242FAIoLh6+ckA42IVaWqqp7LZmYOKIh4PwSqejdNWi/ZjqIZWqw+tfdf2XnCTCIChABgnJrlnH0arQoRiavVY9PMReAAWXoTEQ3hyNGLr/rO7hz6q6qq+Zg+55xSSslCkOAaHx4enNmqaqTteuqgpqEdPrrpwGM0yznnbCnl9boFbD6vm6aJAKqqatt113WD9UqmnvLmc7OoYOzYacacsypms7qu6+vr63h/f391dUXy58+fAPxfDNMPXFL/pBOgp9ngYlFFVcUQQlVV19fXIvIfEXQyYTxVTuoAAAAASUVORK5CYII=',
		'3' => 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAIAAADYYG7QAAAFKUlEQVRYhbVZS3LbSAx9QDdFsZx4n2VuMLJ3qcpB5lpzllzDlg/gRSZxdknFySKWxG68WYBsyvpSHgvlkvhpEq+Bh49gAQDg8+d/215SanPOZkYSu0RE1g+2P9cP9gnJlFLOmaSqfvjwAcCnT58EwNev39q29ds9oJRzMjsCyI83AIkIyXJ9p5iZ61qtVjlnEanr+uPHjyISyX++fYOqqmrO2bUAIOHwRxpp++CAecysbdvlcrlcLh2Qqt7f35OM37//HYIBYmZ+Q1VTEkdC2h5Iz3ykqg5943Sn5JwXi4XTwy2kqnVdPz09PT4+RtUYo4mImTlvzNg0TYxvVMWv7Hz7Tuocto3fSin9/v37x48fi8XC0bhzlstlSin6uTseJIC6nrx9+2Y6nXYXR4tT5+hdVV2tVl++fLm/v08phRBijKoKwMyiiIgqRNwSIcammdb1pHCz7KyAOxXotp0uLi7ev3//58+fh4eHGGNVVTHGEIKZReehqsYYAYjKZFKRdIIfjd5TxXdCsq7rd+/e/fr1q23byWQSQnBdsaDWEKKIqhvD1p9/dfGwn06nTdOQDCG4ywZALk4n0vbH1quJ88E9te4HLbfPZIzDsp0/456FAOErR+J8Adk20ukzDg1C9OEPUsZrOsm+Iq5lyKXlcwuQuP86Lf7kSDkFkwDD6nVMe1zWrx6vYzableP5fD4W11bt051ApFs99s/R3N3N7+7mDu7w+m1Y5XiHhcgOlnNojMznd3huzsPPFiZsW2inywYOjQQE4OpqcNnt7fxYEnlWfI5zyDdwUtjP57d+MJtdXV3NyuleRNKF2Jg8JOx7NLw07I+5TEpO2e2yUsAFMA5vFxnFpKurvwDc3AzBddSupXUA4P1PD2ijaJCAnRr2Nzfz6+vZ9fWsP709xj/2obzZUMRerXR9gUjJWv3KUaBub4+QZqeUmlF8F9FpppCAcs1fvQ/Hy9io7Du+XnkPDEAsnSsBAbvAGlzFjTR/QMspaYI9qTfLZUTJCX2tA/gCl52UtHr09HIJSEER8byEEgKov/2cDZKU+gSo73yny/z77L1ab4FCHVkL+zUHegZgF/mv3uCvyzol8MxC6G1nXMc2RMG5EFFI7LIQyJKEOhwyvs6/TA5UydjzBwAE9CqyYdLzCD0ZbkwpNoqrQ+g4dFY4AL3g42D70dcQCk7ppl8Ch+inSB2aIQ9tQCKFAM5JI8dQSseRFhadJQ+NMl4PFjbK/jNAdCzkKSXsxcJ12+zuqT2N20Dt8wChqyeJMp3CRmIkoCKqGkIAmBb58PTpf4qXjpQS0I2BikT/Da8iohpCCCHEqGa2WrU4R/kgIBARMy6WLSAhVKSVAVA3QQtBRTVoUFURbZomxsps7xR22Oop2UEENBqRcl4slzlTQ+yu0kQUQAzBx0WdADAjICEEkoQdVrFWhY7iEgBQMlvORiLGIGAWIQ00VQUkhqAhBFVxgCR9vGVmOZtxPyARQf/zc5SBBsSqUlVVx2UzMwcURLwfAlW9myatk2wH0fQtVpfau5/sPGImEQFCADBMzXLOPo1WhYjExeKpaaYicIAsvYmIhnBg68VXXWd3Cv1VVdV8TJ9zTimlZCFIcI2Pj4/ObFU10jY9tVdT3w4fXLTnMZrlnHO2lPJqtQRsOq2bpokAqqpaLldt2/bWK5l6zJtPzaKCoWOnGXPOqphM6rquLy8v48PDw8XFBcmfP38C8H8xjN9wSf2jdoCOZr2LRRVVFUMIVVVdXl6KyH98zDZns5VwOQAAAABJRU5ErkJggg=='
	);

	$user = new user($_SESSION['user_id']);

	$map = new map($user->map->id);

	if ($_GET['action'] == 'encounter') {
		$battle = mysql_fetch_object(mysql_query("SELECT * FROM `battles` WHERE `user_id` = '" . $user->id . "'"));

		if ($battle->opponent_id == 0) {
			mysql_query("DELETE FROM `wild_monsters` WHERE `mid` = '" . $battle->oppmon1 . "'");
			mysql_query("DELETE FROM `battles` WHERE `id` = '" . $battle->id . "'");
		}

		if ($_GET['x'] != $user->map->x || $_GET['y'] != $user->map->y) {
			$user->map->x = (int) $_GET['x'];
			$user->map->y = (int) $_GET['y'];

			mysql_query("UPDATE `users` SET `map` = '" . json_encode($user->map) . "' WHERE `id` = '" . $user->id . "'");

			$userMonster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . array_values(array_filter($user->team))[0] . "'"));

			$userMonsterBase = new monster($userMonster->id);

			if (rand(1, 100) <= 60) {
				$map_monsters = array();

				foreach ($map->grass as $grass) {
					$x1 = $grass->x / 16;
					$y1 = $grass->y / 16;

					$width = $grass->width / 16;
					$height = $grass->height / 16;

					$x2 = $x1 + ($width + 1);
					$y2 = $y1 + ($height + 1);

					if ($user->map->x >= $x1 && $user->map->x <= $x2 - 2) {
						if ($user->map->y + 2 >= $y1 && $user->map->y + 2 <= $y2) {
							foreach ($grass->encounters as $monster) {
								$map_monsters = array_merge($map_monsters, array_fill(0, $monster->rate * 100, $monster));
							}
						}
					}
				}

				$map_monster_rand = $map_monsters[rand(0, count($map_monsters) - 1)];
			}

			if ($map_monster_rand->id > 0) {
				$opponent_monster_base = new monster($map_monster_rand->id);

				$opponent_monster_base_name = $opponent_monster_base->name;

				$opponent_monster_level = rand($map_monster_rand->min_level, $map_monster_rand->max_level);

				if (rand(1, 10000) / 100 < $opponent_monster_base->gender_rate->female) {
					$opponent_monster_gender = 'F';
				} else {
					$opponent_monster_gender = 'M';
				}

				if (rand(1, 4096) == 1) {
					$opponent_monster_special = 1;
				}

				if ($opponent_monster_special) {
					$opponent_monster_base_name = get_monster_special_name($opponent_monster_special) . ' ' . $opponent_monster_base_name;
				}

				$opponent_monster_moves = array();
				$opponent_monster_rand_moves = array();
				foreach ($opponent_monster_base->moves as $move) {
					if ($move->level >= 1 && $move->level <= $opponent_monster_level) {
						array_push($opponent_monster_moves, $move);
					}
				}
				for ($i = 0, $size = min(count($opponent_monster_moves), 4); $i < $size; $i++) {
					$rand = rand(0, count($opponent_monster_moves) - 1);
					array_push($opponent_monster_rand_moves, $opponent_monster_moves[$rand]->id);
					unset($opponent_monster_moves[$rand]);
					$opponent_monster_moves = array_values($opponent_monster_moves);
				}

				mysql_query("INSERT INTO `wild_monsters` (`id`, `name`, `level`, `hp`, `gender`, `special`, `moves`) VALUES ('" . $opponent_monster_base->id . "', 'Wild " . $opponent_monster_base->name . "', '$opponent_monster_level', '" . calc_hp($opponent_monster_base->hp, $opponent_monster_level) . "', '$opponent_monster_gender', '$opponent_monster_special', '" . json_encode($opponent_monster_rand_moves) . "')");
				$opponent_monster_mid = mysql_insert_id();

				$messages['round'] = array(
					array(
						'id' => 1,
						'msgs' => array(
							'msg' => array(
								array(
									'@cdata' => 'MSG|You have encountered a Wild ' . $opponent_monster_base_name . '!'
								),
								array(
									'@cdata' => 'MSG|You sent out your first Pokemon ' . $userMonsterBase->name . '.'
								)
							)
						)
					)
				);

				mysql_query("INSERT INTO `battles` (`round`, `battletype`, `stage`, `wild`, `pvp`, `selmon1`, `selmon2`, `selmon3`, `selmon4`, `selmon5`, `selmon6`, `oppmon1`, `oppmon2`, `oppmon3`, `oppmon4`, `oppmon5`, `oppmon6`, `user_id`, `opponent_id`, `messages`) VALUES ('1', '1', '2', '1', '0', '" . $userMonster->mid . "', '0', '0', '0', '0', '0', '" . $opponent_monster_mid . "', '0', '0', '0', '0', '0', '" . $user->id . "', '0', '" . json_encode($messages) . "')");
			}
		}
	} else if ($_GET['action'] == 'trainer') {
		$battle = mysql_fetch_object(mysql_query("SELECT * FROM `battles` WHERE `user_id` = '" . $user->id . "'"));

		if ($battle->opponent_id == 0) {
			mysql_query("DELETE FROM `wild_monsters` WHERE `mid` = '" . $battle->oppmon1 . "'");
			mysql_query("DELETE FROM `battles` WHERE `id` = '" . $battle->id . "'");
		}

		if ($_SESSION['battle']['trainer']['id'] > 0) {
			$user->map->x = (int) $_GET['x'];
			$user->map->y = (int) $_GET['y'];

			mysql_query("UPDATE `users` SET `map` = '" . json_encode($user->map) . "' WHERE `id` = '" . $user->id . "'");

			$userMonster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . array_values(array_filter($user->team))[0] . "'"));

			$userMonsterBase = new monster($userMonster->id);

			$opponent_monster_base = new monster($_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['id']);

			if ($opponent_monster_base->id) {
				$opponent_monster_level = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['level'];

				$opponent_monster_gender = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['gender'];

				$opponent_monster_special = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['special'];

				$opponent_monster_moves = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['skills'];

				mysql_query("INSERT INTO `wild_monsters` (`id`, `name`, `level`, `hp`, `gender`, `special`, `moves`) VALUES ('" . $opponent_monster_base->id . "', 'Wild " . $opponent_monster_base->name . "', '$opponent_monster_level', '" . calc_hp($opponent_monster_base->hp, $opponent_monster_level) . "', '$opponent_monster_gender', '$opponent_monster_special', '" . json_encode($opponent_monster_moves) . "')");
				$opponent_monster_mid = mysql_insert_id();

				$messages['round'] = array(
					array(
						'id' => 1,
						'msgs' => array(
							'msg' => array(
								array('@cdata' => 'MSG|You have agreed to battle the Trainer')
							)
						)
					)
				);

				mysql_query("INSERT INTO `battles` (`round`, `battletype`, `stage`, `wild`, `pvp`, `selmon1`, `selmon2`, `selmon3`, `selmon4`, `selmon5`, `selmon6`, `oppmon1`, `oppmon2`, `oppmon3`, `oppmon4`, `oppmon5`, `oppmon6`, `user_id`, `opponent_id`, `messages`) VALUES ('2', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '" . $opponent_monster_mid . "', '0', '0', '0', '0', '0', '" . $user->id . "', '0', '" . json_encode($messages) . "')");
			}
		}
	}

	$battle = mysql_fetch_object(mysql_query("SELECT * FROM `battles` WHERE `user_id` = '" . $user->id . "'"));

	if ($battle->id) {
		$results = array(
			'battle' => '',
			'trainer' => '',
			'opponent' => '',
			'messages' => '',
			'inventory' => '',
			'images' => ''
		);

		$userMonster = null;
		$opponent_monster = null;

		$results['battle'] = array(
			'round' => $battle->round,
			'battletype' => $battle->battletype,
			'stage' => $battle->stage,
			'wild' => $battle->wild,
			'pvp' => $battle->pvp
		);

		if ($user->id) {
			$results['trainer'] = array(
				'user' => array(
					'@cdata' => $user->username
				),
				'app' => array(
					'@cdata' => ''
				),
				'money' => array(
					'@cdata' => $user->money
				),
				'fieldofplay' => '',
				'lineup' => array()
			);
		}

		if ($battle->selmon1) {
			$userMonster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . $battle->selmon1 ."'"));
		}

		if ($userMonster->id > 0) {
			$results['trainer']['fieldofplay'] = array();

			$userMonsterBase = new monster($userMonster->id);

			$userMonsterBase->IVs = json_decode($userMonsterBase->IVs);
			$userMonsterBase->EVs = json_decode($userMonsterBase->EVs);

			if ($userMonster->name) {
				$userMonsterName = $userMonster->name;
			} else {
				$userMonsterName = $userMonsterBase->name;
			}

			if ($userMonster->special == 1) {
				$userMonsterSprite = $userMonsterBase->sprites->animated_back_shiny;
			} else {
				$userMonsterSprite = $userMonsterBase->sprites->animated_back;
			}

			$mon = array(
				'f1' => $userMonster->mid,
				'f2' => $userMonsterBase->name,
				'f3' => $userMonster->level,
				'f4a' => $userMonster->special,
				'f4b' => get_monster_special_name($userMonster->special),
				'f5' => $userMonster->gender,
				'f6' => 1,
				'f7a' => $userMonster->hp,
				'f7b' => calc_hp($userMonsterBase->hp, $userMonster->level, $userMonsterBase->IVs->hp, $userMonsterBase->EVs->hp),
				'f8' => array(
					'@cdata' => $userMonsterSprite
				),
				'f9a' => (int) $userMonsterBase->type,
				'f9b' => (int) $userMonsterBase->type2,
				'skills' => array(
					'skill' => array()
				),
				'index' => 0,
				'f11' => $userMonster->exp,
				'f12' => $userMonsterName,
				'f13' => 0
			);

			foreach (json_decode($userMonster->moves, true) as $skill_id) {
				$skill_base = new skill($skill_id);
				$skill = array(
					'id' => $skill_base->id,
					'name' => $skill_base->name,
					'scope' => $skill_base->scope
				);
				$mon['skills']['skill'][] = $skill;
			}

			$results['trainer']['fieldofplay']['mon'][] = $mon;
		}

		$team_monster_index = 0;

		foreach (array_filter($user->team) as $monsterID) {
			$monster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . $monsterID ."'"));

			if ($monster->mid == 0) {
				continue;
			}

			$monster_base = new monster($monster->id);

			if ($monster->name) {
				$monster_name = $monster->name;
			} else {
				$monster_name = $monster_base->name;
			}

			if ($monster->special == 1) {
				$monster_sprite = $monster_base->sprites->animated_back_shiny;
			} else {
				$monster_sprite = $monster_base->sprites->animated_back;
			}

			$mon = array(
				'f1' => $monster->mid,
				'f2' => $monster_base->name,
				'f3' => $monster->level,
				'f4a' => $monster->special,
				'f4b' => get_monster_special_name($monster->special),
				'f5' => $monster->gender,
				'f6' => 1,
				'f7a' => $monster->hp,
				'f7b' => calc_hp($monster_base->hp, $monster->level, $monster_base->IVs->hp, $monster_base->EVs->hp),
				'f8' => array(
					'@cdata' => $monster_sprite
				),
				'f9a' => (int) $monster_base->type,
				'f9b' => (int) $monster_base->type2,
				'skills' => array(
					'skill' => array()
				),
				'index' => $team_monster_index,
				'f11' => $monster->exp,
				'f12' => $monster_name,
				'f13' => 0
			);

			$team_monster_index++;

			foreach (json_decode($monster->moves, true) as $skillID) {
				if ($skillID == 0) {
					continue;
				}

				$skill_base = new skill($skillID);

				$skill = array(
					'id' => $skill_base->id,
					'name' => $skill_base->name,
					'scope' => $skill_base->scope
				);

				$mon['skills']['skill'][] = $skill;
			}

			$results['trainer']['lineup']['mon'][] = $mon;
		}

		$results['opponent'] = array(
			'user' => array('@cdata' => ''),
			'app' => array('@cdata' => ''),
			'money' => array('@cdata' => ''),
			'fieldofplay' => array(),
			'lineup' => ''
		);

		if ($battle->wild == 1) {
			$results['opponent']['user'] = 'Wild Monster';
			$results['opponent']['app'] = '.';
			$results['opponent']['money'] = 0;

			$opponent_monster = mysql_fetch_object(mysql_query("SELECT * FROM `wild_monsters` WHERE `mid` = '" . $battle->oppmon1 . "'"));

			$opponent_monster_base = new monster($opponent_monster->id);

			if ($opponent_monster->name) {
				$opponent_monster_name = $opponent_monster->name;
			} else {
				$opponent_monster_name = $opponent_monster_base->name;
			}

			if ($opponent_monster->special == 1) {
				$opponent_monster_sprite = $opponent_monster_base->sprites->animated_front_shiny;
			} else {
				$opponent_monster_sprite = $opponent_monster_base->sprites->animated_front;
			}

			$results['opponent']['fieldofplay']['mon'][] = array(
				'f1' => $opponent_monster->id,
				'f2' => $opponent_monster_base->name,
				'f3' => $opponent_monster->level,
				'f4a' => $opponent_monster->special,
				'f4b' => get_monster_special_name($opponent_monster->special),
				'f5' => $opponent_monster->gender,
				'f6' => 0,
				'f7a' => $opponent_monster->hp,
				'f7b' => calc_hp($opponent_monster_base->hp, $opponent_monster->level, $opponent_monster_base->IVs->hp, $opponent_monster_base->EVs->hp),
				'f8' => array(
					'@cdata' => $opponent_monster_sprite
				),
				'f9a' => (int) $opponent_monster_base->type,
				'f9b' => (int) $opponent_monster_base->type2,
				'index' => 6,
				'f11' => $opponent_monster_base->id,
				'f12' => $opponent_monster_name,
				'f13' => 0
			);
		}
		else if ($battle->opponent_id == 0) {
			$opponent_monster = mysql_fetch_object(mysql_query("SELECT * FROM `wild_monsters` WHERE `mid` = '" . $battle->oppmon1 . "'"));

			$opponent_monster_base = new monster($opponent_monster->id);

			if ($opponent_monster->name) {
				$opponent_monster_name = $opponent_monster->name;
			} else {
				$opponent_monster_name = $opponent_monster_base->name;
			}

			if ($opponent_monster->special == 1) {
				$opponent_monster_sprite = $opponent_monster_base->sprites->animated_front_shiny;
			} else {
				$opponent_monster_sprite = $opponent_monster_base->sprites->animated_front;
			}

			array_push($results['opponent']['fieldofplay'],
				array(
					'mon' => array(
						'f1' => $opponent_monster->id,
						'f2' => $opponent_monster_base->name,
						'f3' => $opponent_monster->level,
						'f4a' => $opponent_monster->special,
						'f4b' => get_monster_special_name($opponent_monster->special),
						'f5' => $opponent_monster->gender,
						'f6' => 0,
						'f7a' => $opponent_monster->hp,
						'f7b' => calc_hp($opponent_monster_base->hp, $opponent_monster->level, $opponent_monster_base->IVs->hp, $opponent_monster_base->EVs->hp),
						'f8' => array(
							'@cdata' => $opponent_monster_sprite
						),
						'f9a' => (int) $opponent_monster_base->type,
						'f9b' => (int) $opponent_monster_base->type2,
						'index' => 6,
						'f11' => $opponent_monster_base->id,
						'f12' => $opponent_monster_name,
						'f13' => 0
					)
				)
			);
		}

		$results['messages'] = json_decode($battle->messages, true);

		if ($_GET['selatk'] > 0 || $_GET['selitem'] > 0 || $_GET['selmon'] > 0) {
			$results['battle']['round'] += 1;

			if ($battle->opponent_id == 0) {
				$userMonsterIndex = 0;
				$opponent_monster_index = 6;

				foreach ($user->team as $monsterID) {
					if ($monsterID == 0) {
						continue;
					}

					$monster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . $monsterID ."'"));

					if ($monster->mid == 0) {
						continue;
					}

					$userMonsterIndex++;

					if ($userMonster->mid == $monsterID) {
						break;
					}
				}

				$opponent_monster_base = new monster($opponent_monster->id);

				$userMonsterAbilityBase = @mysql_fetch_object(@mysql_query("SELECT * FROM `abilities` WHERE `id` = '" . $userMonsterBase->abilities[$userMonster->ability]->id . "'"));
				$opponent_monster_ability_base = @mysql_fetch_object(@mysql_query("SELECT * FROM `abilities` WHERE `id` = '" . $opponent_monster_base->abilities[$opponent_monster->ability]->id . "'"));

				$opponent_monster_moves = json_decode($opponent_monster->moves, true);

				$userMonsterSkill = null;
				$opponent_monster_skill = null;

				$userMonsterMaxHP = calc_hp($userMonsterBase->hp, $userMonster->level, $userMonsterBase->IVs->hp, $userMonsterBase->EVs->hp);
				$userMonsterAttack = calc_attack($userMonsterBase->attack, $userMonster->level, $userMonsterBase->IVs->attack, $userMonsterBase->EVs->attack, $userMonster->nature);
				$userMonsterDefense = calc_defense($userMonsterBase->defense, $userMonster->level, $userMonsterBase->IVs->defense, $userMonsterBase->EVs->defense, $userMonster->nature);
				$userMonsterSpeed = calc_speed($userMonsterBase->speed, $userMonster->level, $userMonsterBase->IVs->speed, $userMonsterBase->EVs->speed, $userMonster->nature);

				$opponent_monster_max_hp = calc_hp($opponent_monster_base->hp, $opponent_monster->level, $opponent_monster_base->IVs->hp, $opponent_monster_base->EVs->hp);
				$opponent_monster_attack = calc_attack($opponent_monster_base->attack, $opponent_monster->level, $opponent_monster_base->IVs->attack, $opponent_monster_base->EVs->attack);
				$opponent_monster_defense = calc_defense($opponent_monster_base->defense, $opponent_monster->level, $opponent_monster_base->IVs->defense, $opponent_monster_base->EVs->defense);
				$opponent_monster_speed = calc_speed($opponent_monster_base->speed, $opponent_monster->level, $opponent_monster_base->IVs->speed, $opponent_monster_base->EVs->speed);

				$userMonsterDamage = 0;
				$opponent_monster_damage = 0;

				$opponent_monster_catch_value = 0;
				$opponent_monster_catched = false; 

				$userMonsterMessages = array();
				$opponent_monster_messages = array();

				$battle_round_messages = array();

				if ($_GET['selatk'] > 0) {
					$userMonsterSkill = new skill($_GET['selatk']);

					if ($userMonsterSkill->power > 0) {
						$userMonsterDamage = calc_damage($userMonster->level, $userMonsterAttack, $userMonsterSkill->power, $opponent_monster_defense);
					}

					$opponent_monster_skill = new skill($opponent_monster_moves[rand(0, count($opponent_monster_moves) - 1)]);
				} else if ($_GET['selitem'] > 0) {
					if ($user->items->{$_GET['selitem']} > 0) {
						$user_item = new item($_GET['selitem']);

						if ($user_item->id && $user->get_item($user_item->id) > 0) {
							$user->add_item($user_item->id, -1);

							$userMonsterMessages[] = array('@cdata' => 'MSG|You used a ' . $user_item->name . '.');

							switch ($user_item->type) {
								case 'pokeball':
									if (!$battle->wild) {
										$userMonsterMessages[] = array('@cdata' => 'MSG|You cannot steal another trainers Pokemon!');
										break;
									}

									if ($user_item->power == -1) {
										$user_pokeball_catch_value = 255;
									} else {
										$user_pokeball_catch_value = floor((((((3 * $opponent_monster_max_hp) - (2 * $opponent_monster->hp)) * $opponent_monster_base->capture_rate) * $user_item->power) / (3 * $opponent_monster_max_hp)) * 1);
									}

									if ($user_pokeball_catch_value >= 255) {
										$opponent_monster_catched = true;
									} else {
										$user_pokeball_catch = floor(65536 / pow(255 / $user_pokeball_catch_value, 3 / 16));

										for ($i = 0; $i < 3; $i++) {
											if (rand(0, 65535) > $user_pokeball_catch) {
												$opponent_monster_catched = false;
												break;
											}

											$opponent_monster_catched = true;
										}
									}

									if ($opponent_monster_catched == true) {
										$userMonsterMessages[] = array('@cdata' => 'MSG|You caught the level ' . $opponent_monster->level . ' ' . $opponent_monster_base->name . '!');
									} else {
										$userMonsterMessages[] = array('@cdata' => 'MSG|Augh, almost had it!');
									}

									break;
							}
						} else {
							$userMonsterMessages[] = array('@cdata' => 'MSG|You do not have any of those items.');
						}
					}

					if ($opponent_monster_catched != true) {
						$opponent_monster_skill = new skill($opponent_monster_moves[rand(0, count($opponent_monster_moves) - 1)]);
					}
				} else if ($_GET['selmon']) {
					$userMonsterSwap = null;

					foreach (array_filter($user->team) as $mon_id) {
						if ($_GET['selmon'] == $mon_id) {
							$userMonsterSwap = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . $mon_id ."'"));

							$userMonsterSwapBase = new monster($userMonsterSwap->id);

							if ($battle->selmon1 > 0) {
								$userMonsterMessages[] = array('@cdata' => 'MSG|You withdrew ' . $userMonsterBase->name . ' and sent out ' . $userMonsterSwapBase->name . '.');

								if ($opponent_monster_catched != true) {
									$opponent_monster_skill = new skill($opponent_monster_moves[rand(0, count($opponent_monster_moves) - 1)]);
								}
							} else {
								$userMonsterMessages[] = array('@cdata' => 'MSG|You sent out ' . $userMonsterSwapBase->name . ' to battle.');
							}

							$battle->selmon1 = $mon_id;

							$results['battle']['stage'] = 2;

							mysql_query("UPDATE `battles` SET `selmon1` = '" . $battle->selmon1 . "', `stage` = '" . $results['battle']['stage'] . "' WHERE `id` = '" . $battle->id . "'");

							break;
						}
					}

					if ($userMonsterSwap->id) {
						$userMonster = $userMonsterSwap;

						$results['trainer']['fieldofplay'] = array();

						$userMonsterBase = new monster($userMonster->id);

						$userMonsterBase->IVs = json_decode($userMonsterBase->IVs);
						$userMonsterBase->EVs = json_decode($userMonsterBase->EVs);

						if ($userMonster->name) {
							$userMonsterName = $userMonster->name;
						} else {
							$userMonsterName = $userMonsterBase->name;
						}

						if ($userMonster->special == 1) {
							$userMonsterSprite = $userMonsterBase->sprites->animated_back_shiny;
						} else {
							$userMonsterSprite = $userMonsterBase->sprites->animated_back;
						}

						$mon = array(
							'f1' => $userMonster->mid,
							'f2' => $userMonsterBase->name,
							'f3' => $userMonster->level,
							'f4a' => $userMonster->special,
							'f4b' => get_monster_special_name($userMonster->special),
							'f5' => $userMonster->gender,
							'f6' => 1,
							'f7a' => $userMonster->hp,
							'f7b' => calc_hp($userMonsterBase->hp, $userMonster->level, $userMonsterBase->IVs->hp, $userMonsterBase->EVs->hp),
							'f8' => array(
								'@cdata' => $userMonsterSprite
							),
							'f9a' => (int) $userMonsterBase->type,
							'f9b' => (int) $userMonsterBase->type2,
							'skills' => array(
								'skill' => array()
							),
							'index' => 0,
							'f11' => $userMonster->exp,
							'f12' => $userMonsterName,
							'f13' => 0
						);

						foreach (json_decode($userMonster->moves, true) as $skill_id) {
							$skill_base = new skill($skill_id);
							$skill = array(
								'id' => $skill_base->id,
								'name' => $skill_base->name,
								'scope' => $skill_base->scope
							);
							$mon['skills']['skill'][] = $skill;
						}

						$results['trainer']['fieldofplay']['mon'][] = $mon;
					}

					$userMonsterMessages[] = array('@cdata' => 'SWAP|' . $userMonsterIndex . '|' . $userMonster->hp);
				}

				if ($userMonsterBase->id < 1) {
					$userMonsterMessages[] = array('@cdata' => 'SWAP|You have a Pokemon on the field which cannot battle.');
					$userMonsterMessages[] = array('@cdata' => 'SWAP|Please select another Pokemon to battle before proceeding.');

					$results['battle']['stage'] = 1;
				}

				if ($opponent_monster_skill->power > 0) {
					$opponent_monster_damage = calc_damage($opponent_monster->level, $opponent_monster_attack, $opponent_monster_skill->power, $userMonsterDefense);
				}

				if ($opponent_monster_catched == true) {
					$results['battle']['stage'] = 3;

					$userMonsterMessages[] = array('@cdata' => 'DEFEAT|' . $opponent_monster_index);
					$userMonsterMessages[] = array('@cdata' => 'MSG|' . $opponent_monster_base->name . ' was added to your team!');

					$userMonsterCapturedId = generate_user_monster($opponent_monster_base->id, $opponent_monster->level, '', $user->id);

					$user->pokedex->{$opponent_monster_base->id}->normal += 1;

					mysql_query("UPDATE `users` SET `pokedex` = '" . json_encode($user->pokedex) . "' WHERE `id` = '" . $user->id . "'");

					if (count(array_filter($user->team)) < 6) {
						for ($i = 0; $i < 6; $i++) {
							if ($user->team[$i] != 0) {
								continue;
							}
							$user->team[$i] = $userMonsterCapturedId;
							break;
						}

						mysql_query("UPDATE `users` SET `team` = '" . json_encode($user->team) . "' WHERE `id` = '" . $user->id . "'");
					} else {
						$user->billsPC[] = $userMonsterCapturedId;

						mysql_query("UPDATE `users` SET `billsPC` = '" . json_encode($user->billsPC) . "' WHERE `id` = '" . $user->id . "'");
					}
				}
				
				if ($results['battle']['stage'] == 2) {
					$battleMonster1 = null;
					$battleMonster2 = null;

					$battleMonster1Base = null;
					$battleMonster2Base = null;

					$battleMonster1AbilityBase = null;
					$battleMonster2AbilityBase = null;

					$battleMonster1Index = null;
					$battleMonster2Index = null;

					$battleMonster1Skill = null;
					$battleMonster2Skill = null;

					$battleMessages1 = null;
					$battleMessages2 = null;

					if ($userMonsterSpeed < $opponent_monster_speed) {
						$battleMonster1 = $opponent_monster;
						$battleMonster2 = $userMonster;

						$battleMonster1Base = $opponent_monster_base;
						$battleMonster2Base = $userMonsterBase;

						$battleMonster1AbilityBase = $opponent_monster_ability_base;
						$battleMonster2AbilityBase = $userMonsterAbilityBase;

						$battleMonster1Index = $opponent_monster_index;
						$battleMonster2Index = $userMonsterIndex;

						$battleMonster1Skill = $opponent_monster_skill;
						$battleMonster2Skill = $userMonsterSkill;

						$battleMessages1 = $opponent_monster_messages;
						$battleMessages2 = $userMonsterMessages;
					} else {
						$battleMonster1 = $userMonster;
						$battleMonster2 = $opponent_monster;

						$battleMonster1Base = $userMonsterBase;
						$battleMonster2Base = $opponent_monster_base;

						$battleMonster1AbilityBase = $userMonsterAbilityBase;
						$battleMonster2AbilityBase = $opponent_monster_ability_base;

						$battleMonster1Index = $userMonsterIndex;
						$battleMonster2Index = $opponent_monster_index;

						$battleMonster1Skill = $userMonsterSkill;
						$battleMonster2Skill = $opponent_monster_skill;

						$battleMessages1 = $opponent_monster_messages;
						$battleMessages2 = $userMonsterMessages;
					}

					$battleMonster1MaxHP = calc_hp($battleMonster1Base->hp, $battleMonster1Base->level, $battleMonster1Base->IVs->hp, $battleMonster1Base->EVs->hp);
					$battleMonster1Attack = calc_attack($battleMonster1Base->attack, $battleMonster1->level, $battleMonster1Base->IVs->attack, $battleMonster1Base->EVs->attack, $battleMonster1->nature);
					$battleMonster1Defense = calc_defense($battleMonster1Base->defense, $battleMonster1->level, $battleMonster1Base->IVs->defense, $battleMonster1Base->EVs->defense, $battleMonster1->nature);

					$battleMonster2MaxHP = calc_hp($battleMonster2Base->hp, $battleMonster2->level, $battleMonster2Base->IVs->hp, $battleMonster2Base->EVs->hp);
					$battleMonster2Attack = calc_attack($battleMonster2Base->attack, $battleMonster2->level, $battleMonster2Base->IVs->attack, $battleMonster2Base->EVs->attack, $battleMonster2->nature);
					$battleMonster2Defense = calc_defense($battleMonster2Base->defense, $battleMonster2->level, $battleMonster2Base->IVs->defense, $battleMonster2Base->EVs->defense, $battleMonster2->nature);

					if ($battleMonster1Skill->id > 0) {
						if ($battleMonster1->hp > 0) {
							$battleMonster1SkillPower = $battleMonster1Skill->power;

							$battleMonster1SkillLoop = 1;

							if ($battleMonster1Skill->id == 24) {
								$battleMonster1SkillLoop = 2;
							}

							while ($battleMonster1SkillLoop > 0) {
								if ($battleMonster1Skill->scope == 7) {
									$battleMessages2[] = array('@cdata' => 'MSG|' . $battleMonster1Base->name . ' used ' . $battleMonster1Skill->name);
								} else {
									$battleMessages2[] = array('@cdata' => 'MSG|' . $battleMonster1Base->name . ' used ' . $battleMonster1Skill->name . ' on ' . $battleMonster2Base->name);
								}

								if ($battleMonster2->id > 0) {
									switch ($battleMonster1AbilityBase->id) {
										case 66:
											if ($battleMonster1Skill->type == 10 && $battleMonster1SkillPower > 0 && $battleMonster1->hp <= $battleMonster1MaxHP / 3) {
												$battleMonster1Damage *= 1.5;

												$battleMessages2[] = array('@cdata' => 'MSG|' . $battleMonster1Base->name . ' was helped by it\'s ability ' . $battleMonster1AbilityBase->name);
											}

											break;

										case 79:
											if ($battleMonster1SkillPower > 0) {
												if ($battleMonster1->gender == $battleMonster2->gender) {
													$battleMonster1SkillPower += $battleMonster1SkillPower / 100 * 25;
												} else {
													$battleMonster1SkillPower -= $battleMonster1SkillPower / 100 * 25;
												}

												$battleMessages2[] = array('@cdata' => 'MSG|' . $battleMonster1Base->name . ' was helped by it\'s ability ' . $battleMonster1AbilityBase->name);
											}

											break;
									}

									$battleMonster1SkillTypeEffect = calc_type_effect($battleMonster1Skill->type, $battleMonster2Base->type, $battleMonster2->type2);

									if ($battleMonster1SkillPower > 0) {
										if ($battleMonster1SkillTypeEffect == 0) {
											$battleMessages2[] = array('@cdata' => 'MSG|The attack had no effect!');
										} else if ($battleMonster1SkillTypeEffect < 1) {
											$battleMessages2[] = array('@cdata' => 'MSG|The attack wasn\'t very effective.');
										} else if ($battleMonster1SkillTypeEffect > 1) {
											$battleMessages2[] = array('@cdata' => 'MSG|The attack was super effective!');
										}
									}

									$battleMonster1Damage = floor(calc_damage($battleMonster1->level, $battleMonster1Attack, $battleMonster1SkillPower, $battleMonster2Defense) * $battleMonster1SkillTypeEffect);

									if ($battleMonster1SkillPower == 0) {
										switch ($battleMonster1Skill->id) {
											case 45:
												$battleMessages2[] = array('@cdata' => 'MSG|' . $battleMonster2Base->name . '\'s Attack decreased.');
												break;
											case 81:
												$battleMessages2[] = array('@cdata' => 'MSG|' . $battleMonster2Base->name . '\'s Speed decreased dramatically.');
												break;
										}
									} else {
										$battleMonster2->hp = max($battleMonster2->hp - $battleMonster1Damage, 0);

										$battleMessages2[] = array('@cdata' => 'ATTACK|' . $battleMonster1Index . '|' . $battleMonster2Index . '|' . $battleMonster1Skill->name . '|' . $battleMonster1Skill->animation);
										$battleMessages2[] = array('@cdata' => 'HPCHANGE|' . $battleMonster2Index . '|'. $battleMonster1Damage. '|' . $battleMonster2->hp);

										if ($battleMonster2->hp < 1) {
											$battleMessages2[] = array('@cdata' => 'MSG|' . $battleMonster2Base->name . ' Fainted.');
											$battleMessages2[] = array('@cdata' => 'DEFEAT|' . $battleMonster2Index . '');

											break;
										}
									}
								}

								$battleMonster1SkillLoop--;
							}
						}
					}

					if ($battleMonster2Skill->id > 0) {
						if ($battleMonster2->hp > 0) {
							$battleMonster2SkillPower = $battleMonster2Skill->power;

							$battleMonster2SkillLoop = 1;

							if ($battleMonster2Skill->id == 24) {
								$battleMonster2SkillLoop = 2;
							}

							while ($battleMonster2SkillLoop > 0) {
								if ($battleMonster2Skill->scope == 7) {
									$battleMessages1[] = array('@cdata' => 'MSG|' . $battleMonster2Base->name . ' used ' . $battleMonster2Skill->name);
								} else {
									$battleMessages1[] = array('@cdata' => 'MSG|' . $battleMonster2Base->name . ' used ' . $battleMonster2Skill->name . ' on ' . $battleMonster1Base->name);
								}

								if ($battleMonster1->id > 0) {
									switch ($battleMonster2AbilityBase->id) {
										case 66:
											if ($battleMonster2Skill->type == 10 && $battleMonster2SkillPower > 0 && $battleMonster2->hp <= $battleMonster2MaxHP / 3) {
												$battleMonster2Damage *= 1.5;

												$battleMessages1[] = array('@cdata' => 'MSG|' . $battleMonster2Base->name . ' was helped by it\'s ability ' . $battleMonster2AbilityBase->name);
											}

											break;

										case 79:
											if ($battleMonster2SkillPower > 0) {
												if ($battleMonster1->gender == $battleMonster2->gender) {
													$battleMonster2SkillPower += $battleMonster2SkillPower / 100 * 25;
												} else {
													$battleMonster2SkillPower -= $battleMonster2SkillPower / 100 * 25;
												}

												$battleMessages1[] = array('@cdata' => 'MSG|' . $battleMonster2Base->name . ' was helped by it\'s ability ' . $battleMonster2AbilityBase->name);
											}

											break;
									}

									$battleMonster2SkillTypeEffect = calc_type_effect($battleMonster2Skill->type, $battleMonster1Base->type, $battleMonster1Base->type2);

									if ($battleMonster2SkillPower > 0) {
										if ($battleMonster2SkillTypeEffect == 0) {
											$battleMessages1[] = array('@cdata' => 'MSG|The attack had no effect!');
										} else if ($battleMonster2SkillTypeEffect < 1) {
											$battleMessages1[] = array('@cdata' => 'MSG|The attack wasn\'t very effective.');
										} else if ($battleMonster2SkillTypeEffect > 1) {
											$battleMessages1[] = array('@cdata' => 'MSG|The attack was super effective!');
										}
									}

									$battleMonster2Damage = floor(calc_damage($battleMonster2->level, $battleMonster2Attack, $battleMonster2SkillPower, $battleMonster1Defense) * $battleMonster2SkillTypeEffect);

									if ($battleMonster2SkillPower == 0) {
										switch ($battleMonster2Skill->id) {
											case 45:
												$battleMessages1[] = array('@cdata' => 'MSG|' . $battleMonster1Base->name . '\'s Attack decreased.');
												break;
											case 81:
												$battleMessages1[] = array('@cdata' => 'MSG|' . $battleMonster1Base->name . '\'s Speed decreased dramatically.');
												break;
										}
									} else {
										$battleMonster1->hp = max($battleMonster1->hp - $battleMonster2Damage, 0);

										$battleMessages1[] = array('@cdata' => 'ATTACK|' . $battleMonster2Index . '|' . $battleMonster1Index . '|' . $battleMonster2Skill->name . '|' . $battleMonster2Skill->animation);
										$battleMessages1[] = array('@cdata' => 'HPCHANGE|' . $battleMonster1Index . '|'. $battleMonster2Damage. '|' . $battleMonster1->hp);

										if ($battleMonster1->hp < 1) {
											$battleMessages1[] = array('@cdata' => 'MSG|' . $battleMonster1Base->name . ' Fainted.');
											$battleMessages1[] = array('@cdata' => 'DEFEAT|' . $battleMonster1Index . '');

											break;
										}
									}
								}

								$battleMonster2SkillLoop--;
							}
						}
					}

					if ($userMonsterSpeed < $opponent_monster_speed) {
						$userMonster = $battleMonster2;
						$opponent_monster = $battleMonster1;

						$userMonsterMessages = $battleMessages2;
						$opponent_monster_messages = $battleMessages1;
					} else {
						$userMonster = $battleMonster1;
						$opponent_monster = $battleMonster2;

						$userMonsterMessages = $battleMessages2;
						$opponent_monster_messages = $battleMessages1;
					}

					if ($opponent_monster->hp < 1) {
						$results['battle']['stage'] = 3;
					} else if ($userMonster->hp < 1) {
						foreach ($user->team as $monsterID) {
							if ($monsterID == 0) {
								continue;
							}

							$monster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '" . $monsterID ."'"));

							if ($monster->mid == 0) {
								continue;
							}

							if ($monster->hp > 0) {
								$userMonster = $monster;

								$results['battle']['stage'] = 1;

								break;
							}
						}

						if ($userMonster->hp < 1) {
							$results['battle']['stage'] = 4;

							$battle_round_messages[] = array('@cdata' => 'MSG|You have a Pokemon on the field which cannot battle.');
							$battle_round_messages[] = array('@cdata' => 'MSG|Please select another Pokemon to battle before proceeding.');
						}
					}
				}

				mysql_query("UPDATE `user_monsters` SET `hp` = '" . $userMonster->hp . "' WHERE `mid` = '" . $userMonster->mid . "'");
				mysql_query("UPDATE `wild_monsters` SET `hp` = '" . $opponent_monster->hp . "' WHERE `mid` = '" . $opponent_monster->mid . "'");

				if ($opponent_monster_catched != true) {
					if ($results['battle']['stage'] == 3) {
						if ($userMonster->level < 100) {
							if ($userMonster->helditem != 768) {
								$userMonsterAddExp = floor((($opponent_monster_base->base_exp * $opponent_monster->level) * 1 * 1.5) / 7);
							}

							if ($user->premium) {
								$userMonsterAddPremiumExp = floor(((($opponent_monster_base->base_exp * $opponent_monster->level) * 1 * 1.5) / 7) / 100 * 15);
							}

							$userMonster->exp += $userMonsterAddExp + $userMonsterAddPremiumExp;

							if ($userMonster->exp > get_next_exp($userMonster->level, $userMonsterBase->exp_growth)) {
								$userMonster->level += 1;

								if ($userMonster->level >= 100) {
									$userMonster->exp = get_next_exp($userMonster->level, $userMonsterBase->exp_growth);
								}

								$userMonsterMaxHP = calc_hp($userMonsterBase->hp, $userMonster->level, $userMonsterBase->IVs->hp, $userMonsterBase->EVs->hp);

								$userMonster->hp = floor(($userMonsterMaxHP / 2) + ($userMonsterMaxHP - calc_hp($userMonsterBase->hp, $userMonster->level - 1, $userMonsterBase->IVs->hp, $userMonsterBase->EVs->hp)));

								$battle_round_messages[] = array('@cdata' => 'MSG|' . $userMonsterBase->name . ' has grown to level ' . $userMonster->level . '.');
								$battle_round_messages[] = array('@cdata' => 'LEVELUP|' . $userMonsterIndex . '-' . $userMonster->level);

								foreach ($userMonsterBase->evolutions as $evolution) {
									if ($evolution->level > 0 && $userMonster->level >= $evolution->level) {
										$userMonsterEvolvedBase = new monster($evolution->to);

										if ($userMonsterEvolvedBase->id >= 0) {
											$battle_round_messages[] = array('@cdata' => 'MSG|' . $userMonsterBase->name . ' is ready to evolve.');

											if ($userMonster->gender == 'F') {
												$battle_round_messages[] = array('@cdata' => 'MUTATE|' . $userMonsterEvolvedBase->id . '-/images/monsters/standard/female/' . $userMonsterEvolvedBase->id . '.png|' . $userMonsterIndex);
											} else {
												$battle_round_messages[] = array('@cdata' => 'MUTATE|' . $userMonsterEvolvedBase->id . '-/images/monsters/standard/' . $userMonsterEvolvedBase->id . '.png|' . $userMonsterIndex);
											}
										}

										break;
									}
								}
							} else {
								if ($userMonsterAddExp) {
									$battle_round_messages[] = array('@cdata' => 'MSG|' . $userMonsterBase->name . ' was awarded ' . $userMonsterAddExp . ' EXP.');
								}

								if ($userMonsterAddPremiumExp) {
									$battle_round_messages[] = array('@cdata' => 'MSG|' . $userMonsterBase->name . ' was awarded ' . $userMonsterAddPremiumExp . ' Premium EXP.');
								}
							}
						}

						mysql_query("UPDATE `user_monsters` SET `level` = '" . $userMonster->level . "', `exp` = '" . $userMonster->exp . "', `hp` = '" . $userMonster->hp . "' WHERE `mid` = '" . $userMonster->mid . "'");

						if ($battle->wild) {
							$opponent_monster_drop_item_id = 0;
							$opponent_monster_drop_count = 0;

							switch ($opponent_monster_base->id) {
								case 10:
									if (rand(1, 10000) <= 500) {
										$opponent_monster_drop_item_id = 4;
										$opponent_monster_drop_count = 1;
									}
									break;

								case 11:
									if ($user->map->id == 176 && rand(1, 10000) <= 500) {
										$opponent_monster_drop_item_id = 1002;
										$opponent_monster_drop_count = 1;
									}
									break;

								case 16:
									if (rand(1, 10000) <= 3000) {
										$opponent_monster_drop_item_id = 780;
										$opponent_monster_drop_count = 1;
									}
									break;

								case 41:
									if (rand(1, 10000) <= 2000) {
										$opponent_monster_drop_item_id = 765;
										$opponent_monster_drop_count = 1;
									}
									break;

								case 161:
									if (rand(1, 10000) <= 500) {
										$opponent_monster_drop_item_id = 4;
										$opponent_monster_drop_count = 1;
									}
									break;

								case 270:
									if (rand(1, 10000) <= 3000) {
										$opponent_monster_drop_item_id = 780;
										$opponent_monster_drop_count = 1;
									}
									break;

								case 278:
									if (rand(1, 10000) <= 3000) {
										$opponent_monster_drop_item_id = 759;
										$opponent_monster_drop_count = 1;
									}
									break;
							}

							if ($opponent_monster_drop_item_id > 0 && $opponent_monster_drop_count > 0) {
								$opponent_monster_drop_item = new item($opponent_monster_drop_item_id);

								$user->add_item($opponent_monster_drop_item->id, $opponent_monster_drop_count);

								$battle_round_messages[] = array('@cdata' => 'MSG|You received ' . $opponent_monster_drop_count . ' ' . $opponent_monster_drop_item->name);
							} else {
								$user_add_money = rand(5, 30);

								$user->add_money($user_add_money);

								$battle_round_messages[] = array('@cdata' => 'MSG|You received ' . $user_add_money . '¢');
							}

							$user->statistics->monster->kill_count->{$opponent_monster_base->id} += 1;

							mysql_query("UPDATE `users` SET `statistics` = '" . json_encode($user->statistics) . "' WHERE `id` = '" . $user->id . "'");
						} else {
							if (count($_SESSION['battle']['trainer']['monsters']) > 1) {
								$_SESSION['battle']['trainer']['swap'] += 1;

								if ($_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['id']) {
									mysql_query("DELETE FROM `wild_monsters` WHERE `mid` = '" . $opponent_monster->mid . "'");

									$opponent_monster_base = new monster($_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['id']);

									if ($opponent_monster_base->id) {
										$opponent_monster_level = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['level'];

										$opponent_monster_gender = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['gender'];

										$opponent_monster_special = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['special'];

										$opponent_monster_moves = $_SESSION['battle']['trainer']['monsters'][$_SESSION['battle']['trainer']['swap']]['skills'];

										mysql_query("INSERT INTO `wild_monsters` (`id`, `name`, `level`, `hp`, `gender`, `special`, `moves`) VALUES ('" . $opponent_monster_base->id . "', 'Wild " . $opponent_monster_base->name . "', '$opponent_monster_level', '" . calc_hp($opponent_monster_base->hp, $opponent_monster_level) . "', '$opponent_monster_gender', '$opponent_monster_special', '" . json_encode($opponent_monster_moves) . "')");
										$opponent_monster_mid = mysql_insert_id();

										$battle_round_messages[] = array('@cdata' => 'MSG|The trainer sent out ' . $opponent_monster_base->name);
										$battle_round_messages[] = array('@cdata' => 'SWAP|' . $opponent_monster_index . '|' . calc_hp($opponent_monster_base->hp, $opponent_monster_level));

										$battle->oppmon1 = $opponent_monster_mid;

										mysql_query("UPDATE `battles` SET `selmon1` = '" . $battle->selmon1 . "', `oppmon1` = '" . $battle->oppmon1 . "' WHERE `id` = '" . $battle->id . "'");

										$opponent_monster = mysql_fetch_object(mysql_query("SELECT * FROM `wild_monsters` WHERE `mid` = '" . $battle->oppmon1 . "'"));

										if ($opponent_monster->name) {
											$opponent_monster_name = $opponent_monster->name;
										} else {
											$opponent_monster_name = $opponent_monster_base->name;
										}

										if ($opponent_monster->special == 1) {
											$opponent_monster_sprite = $opponent_monster_base->sprites->animated_front_shiny;
										} else {
											$opponent_monster_sprite = $opponent_monster_base->sprites->animated_front;
										}

										$results['opponent']['fieldofplay'] = array(
											array(
												'mon' => array(
													'f1' => $opponent_monster->id,
													'f2' => $opponent_monster_base->name,
													'f3' => $opponent_monster->level,
													'f4a' => $opponent_monster->special,
													'f4b' => get_monster_special_name($opponent_monster->special),
													'f5' => $opponent_monster->gender,
													'f6' => 0,
													'f7a' => $opponent_monster->hp,
													'f7b' => calc_hp($opponent_monster_base->hp, $opponent_monster->level),
													'f8' => array(
														'@cdata' => $opponent_monster_sprite
													),
													'f9a' => (int) $opponent_monster_base->type,
													'f9b' => (int) $opponent_monster_base->type2,
													'index' => 6,
													'f11' => $opponent_monster_base->id,
													'f12' => $opponent_monster_name,
													'f13' => 0
												)
											)
										);

										$results['battle']['stage'] = 2;
									}
								}
							}

							if ($results['battle']['stage'] == 3) {
								$battle_round_messages[] = array('@cdata' => 'MSG|You have won the match!');

								$tokenRandom = md5(uniqid(rand(), true));
								$_SESSION['token'][$tokenRandom] = $_SESSION['battle']['trainer']['id'] . '^2';

								$battle_round_messages[] = array('@cdata' => 'SCRIPT|' . $tokenRandom);

								unset($_SESSION['battle']['trainer']);
							}
						}
					} else if ($results['battle']['stage'] == 4) {
						if ($user->map->id >= 2) {
							$user->map->id = 3;
							$user->map->x = 26;
							$user->map->y = 42;
						} else {
							$user->map->id = 1;
							$user->map->x = 23;
							$user->map->y = 46;
						}

						mysql_query("UPDATE `users` SET `map` = '" . json_encode($user->map) . "' WHERE `id` = '" . $user->id . "'");

						foreach (array_filter($user->team) as $mon_id) {
							$userMonster = mysql_fetch_object(mysql_query("SELECT * FROM `user_monsters` WHERE `mid` = '$mon_id'"));

							$userMonsterBase = new monster($userMonster->id);

							$userMonster->hp = calc_hp($userMonsterBase->hp, $userMonster->level, $userMonster->IVs->hp, $userMonster->EVs->hp);

							mysql_query("UPDATE `user_monsters` SET `hp` = '" . $userMonster->hp . "' WHERE `mid` = '" . $userMonster->mid . "'");
						}
					}
				}

				array_unshift($results['messages']['round'],
					array(
						'id' => $results['battle']['round'],
						'msgs' => array(
							'msg' => array_merge($userMonsterMessages, $opponent_monster_messages, $battle_round_messages)
						)
					)
				);

				mysql_query("UPDATE `battles` SET `round` = '" . $results['battle']['round'] . "', `stage` = '" . $results['battle']['stage'] . "', `messages` = '" . json_encode($results['messages']) . "' WHERE `id` = '" . $battle->id . "'");
			}
		} else if ($_GET['mutate'] == 'true') {
			$results['battle']['round'] += 1;

			$userMonsterMessages = array();

			foreach ($userMonsterBase->evolutions as $evolution) {
				if ($evolution->level > 0 && $userMonster->level >= $evolution->level) {
					$userMonsterEvolvedBase = new monster($evolution->to);

					if ($userMonsterEvolvedBase->id >= 0) {
						$userMonster->id = $userMonsterEvolvedBase->id;

						mysql_query("UPDATE `user_monsters` SET `id` = '" . $userMonster->id . "' WHERE `mid` = '" . $userMonster->mid . "'");

						$userMonsterMessages[] = array('@cdata' => 'MSG|Your Pokemon evolved into ' . $userMonsterEvolvedBase->name . '.');

						$userMonsterMessages[] = array('@cdata' => 'SFX|coinchange');
					}

					break;
				}
			}

			array_unshift($results['messages']['round'],
				array(
					'id' => $results['battle']['round'],
					'msgs' => array(
						'msg' => $userMonsterMessages
					)
				)
			);

			mysql_query("UPDATE `battles` SET `round` = '" . $results['battle']['round'] . "', `stage` = '" . $results['battle']['stage'] . "', `messages` = '" . json_encode($results['messages']) . "' WHERE `id` = '" . $battle->id . "'");
		}

		if ($user->items) {
			foreach ($user->items as $itemId => $itemCount) {
				$item = new item($itemId);

				if ($item->type != 'pokeball' && $item->type != 'potion') {
					continue;
				}

				$results['inventory']['item'][] = array(
						'id' => $item->id,
						'name' => $item->name,
						'file' => $item->file,
						'scope' => array('@cdata' => ''),
						'qty' => $itemCount
				);
			}
		}
	}

	$xml = Array2XML::createXML('results', $results);
	die(preg_replace('~\s*(<([^-->]*)>[^<]*<!--\2-->|<[^>]*>)\s*~', '$1', $xml->saveXML()));
?>
