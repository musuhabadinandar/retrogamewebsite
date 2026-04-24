<?php
	######################## Home ########################
	if(($page == 'home') OR ($page == '')){
		#Screen
		$txt['pagetitle'] = 'Trabg Chủ';
	}
	
	######################## Page not found ######################
	elseif($page == 'notfound'){
		#Not found page
		$txt['page title'] = 'Trang Không Tồn Tại';
		$txt['notfoundtext'] = '<p> <font color="Red"><big>Xin chào ! tính năng này đang được xây dựng </font></big>.</p>';
	}
	
	######################## Captcha page ######################
	elseif($page == 'captcha'){
		#Not found page
		$txt['pagetitle'] = 'Mã Bảo Vệ';
		$txt['title_text_1'] = 'Để ngăn chặn mọi người gian lận điền vào một mã bảo mật.<br />
								Nếu bạn có lỗi 3x, không có đầu vào hoặc làm mới bạn sẽ offgelogd.<br />
								Cũng được lưu trữ là sau đó bạn 3x sai, nếu điều đó xảy ra teva giúp bạn bị cấm.<br /><br />
								Bạn có';
		$txt['title_text_2'] = 'Nỗ lực trên.';
		$txt['guard_code'] = 'Bảo vệ:';
		$txt['button'] = 'Tới';
		
		#Alerts
		$txt['alert_no_guardcode'] = 'Không có bảo mật nào được hoàn thành.';
		$txt['alert_guardcode_numbers_only'] = 'Bảo mật chỉ chứa chữ số.';
		$txt['alert_guardcode_wrong'] = 'Bảo mật không chính xác
.';
	}
	
	######################## REGISTER ########################
	if($page == 'register'){
		#Alerts
		$txt['alert_already_this_ip'] = 'Bạn đã có một tài khoản với ip Unused Makes này. ';
		$txt['alert_no_firstname'] = 'Không có tên nào sai';
		$txt['alert_firstname_too_long'] = 'Tên quá dài, tối đa 12 ký tự.';
		$txt['alert_no_lastname'] = 'Không Họ';
		$txt['alert_lastname_too_long'] = 'Họ quá dài, tối đa 12 ký tự.';
		$txt['alert_no_country'] = 'Không chọn vùng nào.';
		$txt['alert_no_full_gebdate'] = 'Tất cả các lĩnh vực phải được hoàn thành lúc sinh của bạn.';
		$txt['alert_character_invalid'] = 'Ký tự không khả dụng. ';
		$txt['alert_no_username'] = 'Không có tên người dùng nào được điền. ';
		$txt['alert_username_too_short'] = 'Tên người dùng quá ngắn, ít nhất 3 ký tự.';
		$txt['alert_username_too_long'] = 'Tên người dùng quá dài, tối đa 10 ký tự.';
		$txt['alert_username_exists'] = 'tên này đã có người dùng';
		$txt['alert_username_incorrect_signs'] =' Tên người dùng chứa ký tự không chính xác. ';
		$txt['alert_no_password'] = "Không có mật khẩu nào được nhập. ";
		$txt['alert_passwords_dont_match'] = 'Mật khẩu không phù hợp.';
		$txt['alert_no_email'] = 'Nhập Email. ';
		$txt['alert_email_incorrect_signs'] = 'Không có địa chỉ email hợp lệ.';
		$txt['alert_email_exists'] = 'Email đã tồn tại';
		$txt['alert_no_beginworld'] = 'Không có thế giới bắt đầu được chọn.';
		$txt['alert_world_invalid'] = 'Bắt đầu thế giới không xác định.';
		$txt['alert_1account_condition'] = 'Vui lòng chấp nhận điều kiện, tôi chỉ có 1 tài khoản.';
		$txt['alert_no_offend_condition'] = 'Vui lòng đồng ý với các điều khoản, Im không chửi thề, v.v..';
		$txt['alert_guardcore_invalid'] = 'Mã Bảo Vệ Không Đúng.';
		$txt['success_register'] = 'Tạo Thành Công !!';
		//<br>Your activation code is 2812.';
										  
		#Screen
		$txt['pagetitle'] = 'Register';
		$txt['title_text'] = 'Chào Mừng Bạn Đến VỚi Thế Giới PokeMon ! Hãy Tạo Ngay Tài Khoản <b>Miễn Phí</b> để trải nghiệm!';
		$txt['register_personal_data'] = 'Thông Tin Cá Nhân';
		$txt['register_game_data'] = 'Tài Khoản';
		$txt['register_security'] = 'Mã Bảo Vệ';
		$txt['firstname'] = 'Tên Của Bạn:';
		$txt['lastname'] = 'Họ Tên:';
		$txt['country'] = 'Vùng:';
		$txt['gebdate'] = 'Sinh Nhật:';
		$txt['day'] = 'Ngày';
		$txt['month'] = 'Tháng';
		$txt['year'] = 'Năm';
		$txt['character'] = 'Nhân Vật:';
		$txt['username'] = 'Tài Khoản:';
		$txt['password'] = 'Mật Khẩu:';
		$txt['password_again'] = 'Nhập Lại Mật Khẩu:';
		$txt['email'] = 'E-mail:';
		$txt['beginworld'] = 'Vùng:';
		$txt['1account_rule'] = '*Bạn Đồng Ý Với Điều Khoản Chứ ?';
		$txt['referer'] = 'Nhập Mã Giới Thiệu (Có thể bỏ trống):';
		$txt['not_oblige'] = 'Không bắt buộc.';
		$txt['guardcode'] = 'Mã Bảo Vệ:';
		$txt['captcha'] = 'Hình ảnh bảo mật';
		$txt['button'] = 'Tạo Tài Khoản!';
	}
	
	######################## INFORMATION ########################
	elseif($page == 'information'){
		$txt['pagetitle'] = 'thông tin';
		$txt['link_subpage_game_info'] = 'Thông tin trò chơi';
		$txt['link_subpage_pokemon_info'] = 'Thông tin về Pokemon';
		$txt['link_subpage_attack_info'] = 'Thông tin onval';
		
		if($_GET['category'] == 'game-info'){
			#Screen
			$txt['pagetitle'] .= ' - Thông tin trò chơi';
			$txt['informationpage'] = '<h2>Nội dung</h2>
				<div id="information">
				<ol>
Het				<li><a href="#thegame">Trò Chơi</a></li>
				<li><a href="#rules">Điều Lệ</a></li>
				<li><a href="#begin">Sự bắt đầu</a></li>
				<li><a href="#tips">Mẹo cho trò chơi</a></li>
				<li><a href="#program">Chương trình</a></li>
				<li><a href="#silver&gold">Bạc Và Vàng</a></li>
				<li><a href="#pokemon">Pokemon</a></li>
				<li><a href="#ranks">Cấp Bậc</a></li>
			
				</ol>
				<hr />
				<div id="thegame">
					<h2>the Game</h2>
					Pokémon Z là trò chơi nhiều người chơi trực tuyến. <br />Trò chơi có năm thế giới và 657 pokemon!<br />
					Bất kỳ ai cũng có thể tham gia miễn phí, bạn cũng có thể trả tiền cho các tính năng bổ sung.<br />
					Mục Tiêu Là Trở Thành Trò Chơi PokeMonZ Duy Nhất Và Lớn mạnh Nhất Việt Nam.<br />
				PokeMOnZ Luôn Cập Nhật Tính Năng MỚi.<br /><br />
					<a href="#wrapper">Về đầu trang</a>
				</div>
				<hr />
				<div id="rules">
					<h2>Quy tắc</h2>
					Trước khi tham gia các bạn cần chú ý những điều sau:
					<ul>
						<li>Không quảng cáo web,quảng bá nội dung v.v.</li>
						<li>tài khoản của người chơi cần bảo mật cận thận !.</li>
						<li><strong>Không</strong> cho người khác mượn mật khẩu,Admin không bao giờ yêu cầu các bạn cung cấp mật khẩu.</li>
						<li>không spam.</li>
						<li>Không chửi tục súc phạm thành viên,người chơi.</li>
						<li>Không sử dụng,hack,lợi dụng lỗi game.</li>
					</ul>
					Mọi vi phạm sẽ đều bị khóa nick hoặc nhắc nhở.<br />
				Mong các bạn đọc kĩ quy định của trò chơi !.<br /><br />
					<a href="#wrapper">về trang chủ</a>
				</div>
				<hr />
				<div id="begin">
					<h2>sự khởi đầu</h2>
					Ngay từ đầu Giáo sư Oak sẽ đến với bạn.<br />
					Anh ta sẽ xem lại các quy tắc cùng với bạn và sau đó anh ấy sẽ cung cấp cho bạn một quả trứng Pokemon.<br />
					Bạn có sự lựa chọn giữa một số pokemon của thế giới mà bạn đang ở thời điểm đó.<br />
					Sau khi bạn đã nhận được pokemon, bạn có thể ngay lập tức bắt đầu với Game.<br /><br />
					<a href="#wrapper">Đầu Trang</a>
				</div>
				<hr />
				<div id="tips">
					<h2>Mẹo cho trò chơi</h2>
					<ul>
						<li>Để chơi game thuận tiện nhất các bạn hãy dùng trình duyệt Chorme,CỐc Cốc,Opera V.V,còn chơi trên điện thoại sẽ khó khăn hơn 1 tẹo ! các bạn hãy đợi Admin ra phiên bản dành cho mobile.</li>
						<li>Nếu bạn đang ở trên một máy tính công cộng (ví dụ như ở trường hoặc một cái gì đó). Nhớ mật khẩu của bạn <strong> không </ strong>.</li>
						<li>Ngoài ra khi bạn chơi trên máy tính công cộng: Luôn đăng xuất khi bạn bỏ đi.</li>
						<li>Khi bạn đi nghỉ, họ đặt tất cả số tiền của bạn vào ngân hàng và đưa pokemon của bạn đến nhà trẻ.</li>
						<li>Luôn luôn mua bóng trước khi bạn chiến đấu. Ai biết những gì bạn đột nhiên đi qua.</li>
						<li>Nếu bạn đang tìm kiếm một pokemon, hãy xem thông tin pokemon nơi nó có thể được tìm thấy.</li>
						<li>Trở thành cao cấp, các tính năng bổ sung rất tốt.</li>
						<li>Hãy cố gắng để bắt một ditto sáng bóng, có thể rất hữu ích cho việc chăm sóc ban ngày.
</li>
					</ul><br />
					<a href="#wrapper">Về Trang Chủ</a>
				</div>
				<hr />
				<div id="program">
					<h2>Chương trình
</h2>
				PokemonZ là trò chơi trực tuyến lấy Cốt truyện trong PokeMOn HUyền Thoại của Nhật Bản<br /><br />
					<a href="#wrapper">Lên Đầu</a>
				</div>
				<hr />
				<div id="silver&gold">
					<h2>Vàng Và Bạc</h2>
					Ở thế giới pokemon có 2 loại tiền chính:
					<ul>
						<li><img src="images/icons/silver.png" title="Silver"> = bạc.</li>
						<li><img src="images/icons/gold.png" title="Gold"> = vàng.</li>
					</ul>
				bạc có thể dùng để mua các vật phẩm như ball,trao đổi giữ người  chơi với nhau v.v kiếm dễ dàng.<br />
					là loạn tiền cao cấp,có được khi nạp thẻ hoặc tham gia các sự kiện có thể mua được nhiều thứ:
					<ul>
						<li>Mua Quả Cầu Cao Cấp</li>
						<li>Kẹo hiếm\'s Mua hiếm</li>
						<li>Thay đổi tên người dùng</li>
						<li>Tặng vàng trên các game thủ khác</li>
						<li>Tạo một pokemon sáng bóng từ một pokemon</li>
					</ul><br />
					<a href="#wrapper">Lên Đầu</a>
				</div>
				<hr />
				<div id="pokemon">
					<h2>Pokemon</h2>
				Pokemon Browser MMO có 657 pokemon khác nhau và tất cả những pokemon đó cũng có hình dạng sáng bóng. <br />
Một pokemon sáng bóng là pokemon giống như một con pokemon bình thường nhưng hiếm hơn và màu khác.<br />
					Bạn có thể nhận ra một pokemon sáng bóng
 <img src="images/icons/lidbetaald.png" /> đằng sau tên và màu sắc của Pokemon
.<br /><br />
					<a href="#wrapper">Lên Đầu</a>
				</div>
				<HR />
				<div id="ranks">
					<h2>xếu hạng</h2>
					có tất cả 33 hạng gồm:
					<ol>
					      <li>Huấn Luyện MỚi</li>
						<li>Junior</li>
						<li>Bully</li>
						<li>Casual</li>
						<li>Trainer</li>
						<li>Great Trainer</li>
						<li>Traveller</li>
						<li>Macho</li>
						<li>Gym Leader</li>
						<li>Shiny Trainer</li>
						<li>Elite Trainer</li>
						<li>Commander</li>
						<li>Master</li>
						<li>Shiny Master</li>
						<li>Mystery Trainer</li>
						<li>Professional</li>
						<li>Ranger</li>
						<li>Elite Ranger</li>
						<li>Hero</li>
						<li>King</li>
						<li>Champion</li>
						<li>Legendary</li>
						<li>Untouchable</li>
						<li>God</li>
						<li>Master</li>
						<li>Champion</li>
						<li>God</li>
						<li>Ultimate</li>
						<li>Pokemon Leader</li>
						<li>Champion+</li>
						<li>Ultimate+100</li>
						<li>Pokemon Master</li>
						<li>Master Of PKMA</li>
					</ol><br />
					<a href="#wrapper">Go to top</a>
				</div>
				<HR />
			
				
				</div>
				</div>';
		}
		
		######################## POKEMON INFO ########################
		elseif($_GET['category'] == 'pokemon-info'){
			#Screen
			$txt['pagetitle'] .= ' - Thông tin về Pokemon';
			$txt['choosepokemon'] = 'Chọn pokemon:';
			$txt['choose_a_pokemon'] = 'Chọn một pokemon.';
			$txt['not_rare'] = 'Chung';
			$txt['a_bit_rare'] = 'Không phổ biến';
			$txt['very_rare'] = 'Rất hiếm';
			$txt['not_a_favorite_place'] = 'Không phải là địa điểm yêu thích.';
			$txt['is_his_favorite_place'] = 'Là một nơi yêu thích.';
			$txt['is'] = 'is';
			$txt['lives_in'] = 'Sống ở';
			$txt['how_much_1'] = 'có';
			$txt['how_much_2'] = 'Trong Trò Chơi.';
			$txt['attack&evolution'] = 'Tấn Công & Sự Phát Triển';
			$txt['no_attack_or_evolve'] = 'Đừng phát triển và vượt qua bước đi mới.';
			$txt['level'] = 'Cấp Độ';
			$txt['evolution'] = 'Sự phát triển';
		}
		elseif($_GET['category'] == 'attack-info'){
			#Screen
			$txt['pagetitle'] .= ' - Thông Tin';
			$txt['#'] = '#';
			$txt['name'] = 'Tên';
			$txt['type'] = 'Kiểu';
			$txt['att'] = 'TC';
			$txt['acc'] = 'Acc';
			$txt['effect'] = 'Hiệu ứng';
			$txt['ready'] = 'Sẳn sàng';
		}
	}
	
	######################## STATISTICS ########################
	elseif($page == 'statistics'){
		#Screen
		$txt['pagetitle'] = 'Số liệu thống kê';
		$txt['top6_pokemon_title'] = 'Thống Kê: <span class="smalltext">Dựa trên tất cả các thống kê!</span>';
		$txt['game_data'] = 'Thông tin trò chơi';
		$txt['users_total'] = 'Thành Viên:';
		$txt['silver_in_game'] = 'tổng bạc:';
		$txt['pokemon_total'] = 'tổng pokemon:';
		$txt['matches_played'] = 'Tổng số trận đấu đã chơi:';
		$txt['top5_silver_users'] = '5 người chơi giàu nhất';
		$txt['#'] = '#';
		$txt['who'] = 'Tài Khoản';
		$txt['silver'] = 'Bạc';
		$txt['top5_pokemon_total'] = '5 huấn luyện viên pokemon hàng đầu';
		$txt['number'] = '#';
		$txt['top5_matches_played'] = 'Top Đấu: <span class="smallText"> Trận thắng - trận thua. </ Span>';
		$txt['matches'] = 'Kết quả phù hợp';
		$txt['top10_new_users'] = '10 người dùng mới hàng đầu';
		$txt['when'] = 'Ngày đăng kí';
	}
	######################## RANKINGLIST ########################
	elseif($page == 'rankinglist'){
		#Screen
		$txt['pagetitle'] = 'Danh sách xếp hạng';
		$txt['#'] = '#';
		$txt['username'] = 'tài Khoản';
		$txt['country'] = 'Khu vực';
		$txt['rank'] = 'Xếp Hạng';
		$txt['status'] = 'Trạng Thái';
		$txt['online'] = 'Online';
		$txt['offline'] = 'Offline';
	}
	
	######################## CONTACT ########################
	elseif($page == 'contact'){
		#Alerts
		$txt['alert_email_to_unknown'] = $_POST['sendto'].' không có hiệu lực.';
		$txt['alert_no_name'] = 'Bạn chưa nhập tên của mình.';
		$txt['alert_no_email'] = 'Không có địa chỉ email nào được điền.';
		$txt['alert_email_incorrect_signs'] = 'Địa chỉ E-mail không hợp lệ.';
		$txt['alert_no_subject'] = 'Bạn chưa điền chủ đề.';
		$txt['alert_no_message'] = 'YBạn chưa điền nội dung.';
		$txt['success_contact'] = 'Email đã được gửi thành công.<br />
									Chúng tôi sẽ trả lời lại Email của bạn '.$_POST['email'].'.';
		
		#Screen
		$txt['pagetitle'] = 'Kết Nối';
		$txt['title_text'] = 'Cho phép bạn gửi cho chúng tôi một e-mail. Chúng tôi tìm kiếm email của bạn nhanh nhất có thể để trả lời.<br />
			Vui lòng nhập địa chỉ email thực của bạn. Nếu không, chúng tôi không thể trả lại e-mail của bạn.<br />
		Vì vậy, hãy kiểm tra mọi thứ trước khi cam kết gửi thư cho chúng tôi.';
		$txt['email_to'] = 'Gửi Đến';
		$txt['your_name'] = 'Tên Bạn';
		$txt['your_email'] = 'Email Bạn';
		$txt['subject'] = 'Tiêu Đề';
		$txt['message'] = 'Nội Dung';
		$txt['button'] = 'Gửi Đức Nghĩa';
	}
	
	######################## ACTIVATE ########################
	elseif($page == 'activate'){
	#Alerts
	$txt['alert_no_username'] = 'No username filled.';
	$txt['alert_username_too_short'] = 'Username is too short.';
	$txt['alert_username_too_long'] = 'Username is too long.';
	$txt['alert_username_dont_exist'] = $_POST['inlognaam'].' does not exist.';
	$txt['alert_no_activatecode'] = 'No activation code entered.';
	$txt['alert_activatecode_too_short'] = 'Activation code is too short.';
	$txt['alert_activatecode_too_long'] = 'Activation code is too long.';
	$txt['alert_guardcore_invalid'] = 'Security incorrect.';
	$txt['alert_already_activated'] = $_POST['inlognaam'].' has been activated!';
	$txt['alert_activatecode_wrong'] = 'Wrong code entered.';
	$txt['alert_username_wrong'] = 'Wrong username entered.';
	$txt['success_activate'] = $_POST['inlognaam'].' successfully activated!';
	
	#Screen
	$txt['pagetitle'] = 'Activate account';
	$txt['title_text'] = 'Here you can activate your account.';
	$txt['username'] = 'Username:';
	$txt['activatecode'] = 'Activation code is 2812:';
	$txt['captcha'] = 'Security plaatje.';
	$txt['guardcode'] = 'Security code:';
	$txt['button'] = 'Activate Account';
	}
	
	######################## FORGOT USERNAME ########################
	elseif($page == 'forgot-username'){
		#Alerts
		$txt['alert_no_email'] = 'Địa chỉ email không hợp lệ.';
		$txt['alert_email_dont_exist'] = 'Địa chỉ email không tồn tại.';
		$txt['alert_guardcore_invalid'] = 'Mã bảo mật không chính xác.';
		$txt['success_forgot_username'] = 'Tên người dùng đã được gửi thành công!';
		
		#Screen
		$txt['pagetitle'] = 'Quên tên người dùng';
		$txt['email'] = 'Email';
		$txt['captcha'] = 'Security code.';
		$txt['guardcode'] = 'Bảo Mật';
		$txt['title_text'] = 'Bạn quên tên tài khoản? <br /> hãy nhập email của tài khoản bạn quên chúng tôi sẽ giúp bạn lấy lại.';
		$txt['button'] = 'Lấy Mật Khẩu';
	}
	
	######################## FORGOT PASSWORD ########################
	elseif($page == 'forgot-password'){
		#Alerts
		$txt['alert_no_username'] = 'Không có tên người dùng nào được điền.';
		$txt['alert_username_too_short'] = 'Tên người dùng quá ngắn.';
		$txt['alert_username_too_long'] = 'Tên người dùng quá dài';
		$txt['alert_no_email'] = 'Địa chỉ email không hợp lệ.';
		$txt['alert_guardcore_invalid'] = 'Bảo mật không chính xác.';
		$txt['alert_username_dont_exist'] = 'Tên đăng nhập không tồn tại.';
		$txt['alert_email_dont_exist'] = 'email ko tồn tại';
		$txt['alert_wrong_combination'] = 'Không khớp';
		$txt['success_forgot_password'] = 'Email đã được gửi thành công!';
		
		#Screen
		$txt['pagetitle'] = 'Quyên Mật Khẩu';
		$txt['title_text'] = 'bạn quên mật khẩu? <br />hãy nhập email chúng tôi sẽ giúp bạn lấy lại.';		
		$txt['username'] = 'Tài khoản';
		$txt['email'] = 'E-mail đăng kí';
		$txt['captcha'] = ' mã bảo vệ.';
		$txt['guardcode'] = 'nhập mã bảo vệ';
		$txt['button'] = 'Quên';
	}
	
	######################## ACCOUNT OPTIONS ########################
	elseif($page == 'account-options'){
		#Screen
		$txt['pagetitle'] = 'Cài đặt tài khoản';
		#Titles
		$txt['link_subpage_personal'] = 'Cá nhân';
		$txt['link_subpage_password'] = 'mật khẩu';
		$txt['link_subpage_profile'] = 'cá nhân';
		$txt['link_subpage_restart'] = 'khởi đầu';
		
		if($_GET['category'] == 'personal'){
			#Alerts general
			$txt['alert_not_enough_gold'] = 'Không đủ vàng.';
			$txt['alert_no_username'] = 'Không tìm thấy tên người dùng.';
			$txt['alert_username_too_short'] = 'tài khoản quá ngắn.';
			$txt['alert_username_too_long'] = 'tài khoản quá dài.';
			$txt['alert_username_already_taken'] = 'Tên người dùng đã được sử dụng.';
			$txt['alert_firstname_too_long'] = 'Tên đầu tiên quá dài';
			$txt['alert_lastname_too_long'] = 'Họ quá dài.';
			$txt['alert_character_invalid'] = 'Ký tự không hợp lệ';
			$txt['alert_seeteam_invalid'] = 'Nhóm không xác định.';
			$txt['alert_seebadges_invalid'] = 'Huy hiệu không xác định.';
			$txt['alert_advertisement_invalid'] = 'Quảng cáo không xác định';
			$txt['alert_duel_invalid'] = 'Trận đấu không hợp lệ';
			$txt['success_modified'] = 'Đã sửa đổi thành công!';
			
			#Screen general
			$txt['pagetitle'] .= ' - XXXXX';
			$txt['buy_premium_here'] = 'Mua phí bảo hiểm ở đây!';
			$txt['days_left'] = 'ngày còn lại.';
			$txt['username'] = 'Tài Khoản:';
			$txt['cost_15_gold'] = 'với 15 vàng.';
			$txt['firstname'] = 'tên:';
			$txt['lastname'] = 'họ:';
			$txt['country'] = 'vùng:';
			$txt['character'] = 'nhân vật:';
			$txt['premium_days'] = 'số ngày VIP:';
			$txt['advertisement'] = 'Quảng cáo:';
			$txt['alert_not_premium'] = 'Bạn không phải là thành viên Premium.';
			$txt['on'] = 'On';
			$txt['off'] = 'off';
			$txt['team_on_profile'] = 'XXXXXX:';
			$txt['yes'] = 'Yes';
			$txt['no'] = 'No';
			$txt['badges_on_profile'] = 'Hiển thị huy hiệu trên tiểu sử
';
			$txt['alert_dont_have_badgebox'] = 'Bạn không có hộp huy hiệu
.';
			$txt['duel_invitation'] = 'Duel lời mời
:';
			$txt['alert_not_yet_available'] = 'Chưa có sẵn
.';
			$txt['available_rank_bully'] = 'Xếp hạng có sẵn
:';
			$txt['button_personal'] = 'Cập Nhật';
		}
		elseif($_GET['category'] == 'password'){
			#Alerts password
			$txt['alert_all_fields_required'] = 'Tất cả các trường phải được điền
.';
			$txt['alert_old_new_password_thesame'] = 'Mật khẩu mới của bạn giống với mật khẩu hiện tại của bạn
.';
			$txt['alert_old_password_wrong'] = 'Mật khẩu hiện tại của bạn không tốt.
';
			$txt['alert_password_too_short'] = 'Quá Ngắn';
			$txt['alert_new_controle_password_wrong'] = 'Cũ và mới giống nhau.';
			$txt['success_password'] = 'thành công.';
			
			#Screen password
			$txt['pagetitle'] .= ' - Mật Khẩu';
			$txt['new_password'] = 'Mật khẩu mới:';
			$txt['new_password_again'] = 'Nhật lại mật khẩu mới:';
			$txt['password_now'] = 'Mật khẩu hiện tại
:';
			$txt['button_password'] = 'Cập Nhật!';
		}
		elseif($_GET['category'] == 'profile'){
			#Alerts profile
			$txt['success_profile'] = 'Tiểu sử của bạn đã được cập nhật thành công.';
			
			#Screen profile
			$txt['pagetitle'] .= ' - Cập nhật cá nhân!';
			$txt['link_text_effects'] = '<u><a href="codes.php?category=profile" class="colorbox" title="Text effects for profile"><b>Click</b></a></u> bạn có thể xem cách pimp hồ sơ của bạn
!';
			$txt['button_profile'] = 'Cập Nhật!';
		}
		elseif($_GET['category'] == 'restart'){
			#Alerts restart
			$txt['alert_no_password'] = 'Không có mật khẩu nào được nhập
.';
			$txt['alert_password_wrong'] = 'Mật khẩu nhập vào bị sai
.';
			$txt['alert_no_beginworld'] = 'Mật khẩu nhập lại sai.';
			$txt['alert_world_invalid'] = 'Vùng không xác định
.';
			$txt['success_restart'] = 'Đã khởi động lại thành công trên một vùng mới
!';
			$txt['alert_when_restart'] = 'Bạn có thể chuyển vào

										  <strong><span id=uur3></span></strong> h,
										  <strong><span id=minuten3> </span>&nbsp;minuten</strong> phút and
										  <strong><span id=seconden3></span>&nbsp;giây</strong>.';
			
			#Screen restart
			$txt['pagetitle'] .= ' - Những khởi đầu mới
';
			$txt['restart_title_text'] = '<center>Điền vào mật khẩu của bạn và chọn khu vực bạn muốn chuyển đến
.<br /><br />
										
										Tất cả các pokemon, vật phẩm, bạc và điểm xếp hạng của bạn sẽ bị xóa khi chuyển
.<br />
										<strong>Tanh ấy không thể đảo ngược
!</strong></center>';
			$txt['password_security'] = 'Mật khẩu:';
			$txt['button_restart'] = 'Reset Nikc';
		}
	}
	
	######################## PROMOTION ########################
	elseif($page == 'promotion'){
		$txt['pagetitle'] = 'TT';
		$txt['promotion_text'] = '<p>Bạn có thể giúp POKEDESTINY phát triển! Mời bạn bè của bạn trải nghiệm trực tuyến Pokemon tốt nhất
!<br />
	Đối với mỗi người bạn bạn tuyển dụng, bạn thắng
 <img src="images/icons/gold.png" title="Gold" style="margin-bottom:-3px;" /> 2.<br /><br />
	Mau giới thiệu bạn bè nào
!<br /><br />
		link giới thiệu của bạn:<br /><br /><strong>http://pkmvietnam.top/index.php?page=register&referer='.$_SESSION['naam'].'</strong></p>';
	}
	
	######################## MODIFY ORDER ########################
	elseif($page == 'modify-order'){
		#Screen
		$txt['pagetitle'] = 'Đặt lại Pokemon của bạn
';
		$txt['modify_order_text'] = 'Bạn có thể đặt lại pokemon của mình. <br /> Kéo pokemon đến vị trí thích hợp.';
		$txt['modify_order_text_old'] = 'Ybạn có thể đặt lại pokemon của bạn
.<br /> Nhấp vào các hộp thích hợp để thay đổi vị trí pokemon của bạn
.';
	}
	
	######################## EXTENDED ########################
	elseif($page == 'extended'){
		#Screen
		$txt['pagetitle'] = 'Thông Tin PokeMon
!';
		$txt['catched_with'] = 'Bị bắt với một
';
		$txt['pokemon'] = 'Pokemon:';
		$txt['attack_points'] = 'Tấn Công:';
		$txt['clamour_name'] = 'Tên khai sinh
:';
		$txt['defence_points'] = 'Phòng thủ
:';
		$txt['type'] = 'Kiểu:';
		$txt['level'] = 'Cấp Độ:';
		$txt['speed_points'] = 'tốc độ:';
		$txt['spc_attack_points'] = 'Spc. tc:';
		$txt['mood'] = 'Mood:';
		$txt['spc_defence_points'] = 'Spc. phòng thủ:';
		$txt['attacks'] = 'Attacks:';
		$txt['egg_will_hatch_in'] = 'Trứng sẽ nở tại
:';
		$txt['begin_pokemon'] = 'Pokemon khởi động
';
	}
	
	######################## SELL ########################
	elseif($page == 'sell'){
		#Screen
		$txt['page title'] = 'Mua';
		$txt['colorbox_text'] = "Mở lại cửa sổ này và thông báo này sẽ vẫn ở đây
.";
		$txt['title_text_1'] = 'Bạn thêm nhập tối đa
';
		$txt['title_text_2'] = 'Bạn rất muốn
 pokemon vào danh sách chuyển từ nhà của bạn.
<br />
		                        ';
		$txt['title_text_3'] = 'pokemon trong danh sách chuyển
. ';
		$txt['no_pokemon_in_house'] = 'PokeMon không trong nhà
. ';
		$txt['#'] = '#';
		$txt['pokemon'] = 'Pokemon';
		$txt['clamour_name'] = 'tên';
		$txt['level'] = 'Level';
		$txt['sell'] = 'bán';
		$txt['go_to_transferlist'] = 'Chuyển đến danh sách chuyển
';
	}
	
	######################## RELEASE ########################
	elseif($page == 'release'){
		#Alerts
		$txt['alert_itemplace'] = 'Lưu ý: Bạn không có mặt hàng tại chỗ, vì vậy bạn sẽ nhận được quả bóng của bạn trở lại nếu bạn là một bản phát hành pokemon.

 ';
		$txt['alert_not_your_pokemon'] = 'Đây không phải là pokemon của bạn
.
. ';
		$txt['alert_beginpokemon'] = 'Đây là pokemon bắt đầu của bạn mà bạn không thể phát hành.
 ';
		$txt['alert_no_pokemon_selected'] = 'Bạn chưa chọn pokemon.
 ';
		$txt['success_release'] = 'Bạn đã phát hành thành công pokemon. ';

		# Screen
		$txt['page title'] = 'Cho phép pokemon miễn phí
 ';
		$txt['title_text'] = 'Ở đây bạn có thể phát hành pokemon của bạn. <br/> Bóng mà pokemon bị bắt trở lại các vật phẩm của bạn Ston.
 <br />
		<strong> Điều này không thể ongedOn được thực hiện.
: </ strong>  ';
		$txt['pokemon_team'] = 'Pokemon Đồng Đội';
		$txt['#'] = '#';
		$txt['pokemon'] = 'Pokemon';
		$txt['clamour_name'] = 'tên';
		$txt['level'] = 'Level';
		$txt['release'] = 'Giải phóng
';
		$txt['alert_no_pokemon_in_hand'] = 'Không có pokemon với bạn.
';
		$txt['button'] = 'Giải phóng
';
		$txt['pokemon_at_home'] = 'Pokémon trong nhà bạn
';
		$txt['alert_no_pokemon_at_home'] = 'Không có pokemon nào trong nhà bạn
. ';
	}
	
	######################## ITEMS ########################
	elseif($page == 'items'){
		#Alerts
		$txt['alert_no_amount'] = 'Không có số tiền được chọn
';
		$txt['alert_too_much_items_selected'] = 'Bạn không có nhiều
!';
		$txt['success_items'] = 'Bạn đã bán
 '.$_POST['amount'].'x '.$_POST['name'].'';
	
		#Screen
		$txt['pagetitle'] = 'Vật Phẩm';
		$txt['title_text_1'] = 'Bạn có
 ';
		$txt['title_text_2'] = 'các vị trí mục
.';
		$txt['name'] = 'tên';
		$txt['number'] = 'số lượng';
		$txt['sellprice'] = 'Giá bán
';
		$txt['sell'] = 'bán';
		$txt['use'] = 'sử dụng
';
		$txt['balls'] = 'Balls';
		$txt['potions'] = 'Potions';
		$txt['items'] = 'Vật Phẩm';
		$txt['badge_case_title'] = 'Một trường hợp cho bộ sưu tập huy hiệu của bạn.
';
		$txt['box_title'] = 'Bạn có thể lưu các mục của bạn trong
';
		$txt['spc_items'] = 'Các mặt hàng đặc biệt
';
		$txt['stones'] = 'Đá';
		$txt['tm'] = 'TM';
		$txt['hm'] = 'HM';
		$txt['button_use'] = 'Dùng';
		$txt['button_sell'] = 'Bán';
	
	}
	 
	######################## BADGES ########################
	elseif($page == 'badges'){
		#Screen
		$txt['pagetitle'] = 'Trường hợp huy hiệu';
		$txt['badges'] = 'Huy hiệu';
		$txt['no_badges_from'] = 'k huy hiệu';
	}
	
	######################## HOUSE ########################
	elseif($page == 'house'){
		#Alerts
		$txt['alert_not_your_pokemon'] = 'Đây không phải là pokemon của bạn
. ';
		$txt['alert_house_full'] = 'Ngôi nhà của bạn đã đầy
. ';
		$txt['success_bring'] = 'Bạn đã đưa pokemon của bạn ra trên một cuộc phiêu lưu!';
		$txt['alert_hand_full'] = 'Bạn đã có 6 pokemon trong tay. ';
		$txt['alert_pokemon_on_transferlist'] = 'Pokemon này nằm trong danh sách chuyển nhượng. ';
		$txt['success_get'] = 'Bạn đã truy xuất thành công pokemon của mình. ';
		
		#Screen
		$txt['pagetitle'] = 'Nhà Tôi!';
		$txt['title_text_1'] = 'Hiện tại bạn có một
';
		$txt['title_text_2'] = 'ở đây có thể
';
		$txt['title_text_3'] = 'Pokemon để ở lại
. <br>
	* Pokemon rơi xuống, ở đó bạn có thể nhìn thấy những con Pokemon để rời khỏi nhà của bạn gon
. <br>
	* Pokemon pick, ở đó bạn có thể lấy pokemon đến tay bạn. <br>
Bạn chỉ có thể chọn một Pokemon nếu bạn có ít nhất 1 địa điểm trong tay. ';
		$txt['pokemon_bring_away'] = 'Pokemon thả ra
';
		$txt['pokemon_pick_up'] = 'Pokemon bộ sưu tập
';
		$txt['box'] = 'thùng các - tông
';
		$txt['little_house'] = 'Lều gỗ
';
		$txt['normal_house'] = 'Đá Hut
';
		$txt['big_house'] = 'Biệt thự
';
		$txt['places_over'] = 'khe có sẵn
';
		$txt['#'] = '#';
		$txt['clamour_name'] = 'Tên nick
';
		$txt['level'] = 'Level';
		$txt['bring_away'] = 'Tiền gửi
';
		$txt['take'] = 'Rút tiền
';
		$txt['button_take'] = 'Lựa chọn';
		$txt['button_bring'] = 'Lựa chọn';
		$txt['empty'] = 'Trống';
	}
	
	######################## POKEDEX ########################
	elseif($page == 'pokedex'){
		#Screen
		$txt['pagetitle'] = 'Pokedex';
		$txt['seen'] = 'Đã Xem';
		$txt['had'] = 'Đã';
		$txt['have'] = 'có';
		$txt['#'] = '#';
		$txt['pokemon'] = 'Pokemon';
		$txt['name'] = 'tên';
		$txt['type'] = 'kiểu';
		$txt['status'] = 'Status';
	}
	
	######################## INBOX ########################
	elseif($page == 'inbox'){
		#Alerts
		$txt['alert_nothing_selected'] = 'Bạn chưa chọn mục nào
. ';
		$txt['success_deleted'] = 'Bạn đã xóa tin nhắn thành công
.';
		
		#Screen
		$txt['page title'] = 'Nhắn tin';
		$txt['new_check'] = 'mới';
		$txt['subject'] = 'chủ đề';
		$txt['username'] = 'tới';
		$txt['status'] = 'Status';
		$txt['online'] = 'Online';
		$txt['offline'] = 'Offline';
		$txt['date-time'] = 'Ngày / thời gian';
		$txt['no_messages'] = 'không tin nhắn';
		$txt['button'] = 'xóa';
	}
	
	######################## SEND MESSAGE ########################
	elseif($page == 'send-message'){
		#Alerts
		$txt['alert_no_receiver'] = 'Không có người nhận nào được nhập
.';
		$txt['alert_inbox_full'] = 'Nhắn tin '.$_POST['ontvanger'].' đã đầy.';
		$txt['alert_receiver_blocked'] = 'bạn đã chặn '.$_POST['ontvanger'].' .';
		$txt['alert_has_blocked_you'] = $_POST['ontvanger'].' khóa bạn.';
		$txt['alert_message_to_yourself'] = 'Bạn không thể gửi tin nhắn cho chính mình
.';
		$txt['alert_username_dont_exist'] = $_POST['ontvanger'].' Không tồn tại.';
		$txt['alert_no_subject'] = 'chưa nhập chủ đề.';
		$txt['alert_subject_wrong_signs'] = 'đối tượng không được chứa ký tự
.';
		$txt['alert_text_wrong_signs'] = 'tin nhắn không thể bao gồm
 <.';
		$txt['alert_no_message'] = 'Không có thư nào được nhập
.';
		$txt['success_send_message'] = 'Thư đã được gửi thành công đến
 '.$_POST['ontvanger'].'.';
		
		#Screen
		$txt['pagetitle'] = 'Gửi tin nhắn
';
		//$txt['link_text_effects'] = '<u><a href="codes.php?category=message" class="colorbox" title="Text effects for profile"><b>Here</b></a></u> you can see how your text effects to apply or insert pictures';
		$txt['name_receiver'] = 'tên người nhận:';
		$txt['subject'] = 'Chủ đề:';
		//$txt['more_emoticons'] = 'For more emoticons <a href=\'index.php?page=area-market\'><strong>Klik hier</strong></a>';
		$txt['button'] = 'Gửi Mail!';
	}
	
	######################## SEND MESSAGE ########################
	elseif($page == 'read-message'){
		#Alerts
		$txt['alert_link_incorrect'] = 'Liên kết không hợp lệ
.';
		$txt['alert_not_your_message'] = 'Tthông điệp của anh ấy không dành cho bạn
.';
		$txt['alert_inbox_full'] = 'tin nhắn đã đầy.';
		$txt['alert_receiver_blocked'] = 'Bạn không thể trả lại tin nhắn, bạn có huấn luyện viên này bị chặn
.';
		$txt['alert_has_blocked_you'] = 'Bạn không thể trả lại tin nhắn, huấn luyện viên này đã chặn bạn
.';
		$txt['alert_text_wrong_signs'] = 'tin nhắn có thể không chứa
 <.';
		$txt['alert_no_message'] = 'Không có tin nhắn nào được nhập
.';
		$txt['success_send_message'] = 'tin nhắn đá được gửi thành công';
		
		#Screen
		$txt['pagetitle'] = 'Đọc tin nhắn
';
		$txt['from_player'] = 'Từ huấn luyện viên
:';
		$txt['subject'] = 'Tiêu Đề:';
		$txt['respond'] = 'Gửi tin nhắn lại
';
		$txt['inbox'] = 'Tin Nhắn';
		$txt['block'] = 'Chặn';
		$txt['pagetitle'] = 'Gửi Tin';
		//$txt['link_text_effects'] = '<u><a href="codes.php?category=message" class="colorbox" title="Text effects for profile"><b>Hier</b></a></u> you can see how your text effects to apply or insert pictures.';
		//$txt['more_emoticons'] = 'Voor meer emoticons <a href=\'index.php?page=area-market\'><strong>Klik hier</strong></a>';
		$txt['button'] = 'Gửi Thư!';
	}
	
	######################## EVENTS ########################
	elseif($page == 'events'){
		#Alerts
		$txt['alert_nothing_selected'] = '
Bạn chưa chọn mục nào.';
		$txt['alert_more_events_deleted'] = 'Đã xóa sự kiện thành công';
		$txt['alert_one_event_deleted'] = 'Đã xóa sự kiện thành công.';
		
		#Screen
		$txt['pagetitle'] = 'Sự Kiện';
		$txt['date-time'] = 'Ngày / thời gian';
		$txt['no_events'] = 'không events';
		$txt['button'] = 'xóa';
		$txt['event'] = 'Event';
	}
	
	######################## BUDDYLIST ########################
	elseif($page == 'buddylist'){
		#Alerts
		$txt['success_deleted'] = $_POST['deletenaam'].' không phải là bạn của bạn.';
		$txt['alert_buddy_not_yourself'] = 'Bạn không thể có chính mình như một người bạn.
';
		$txt['alert_username_dont_exist'] = 'Tên đăng nhập không tồn tại
.';
		$txt['alert_already_buddy'] = $_POST['buddynaam'].' đã là bạn của bạn
.';
		$txt['alert_is_blocked'] = $_POST['buddynaam'].' nằm trong danh sách chặn của bạn
.';
		$txt['success_add'] = $_POST['buddynaam'].' bây giờ là bạn của bạn
.';
		
		#Screen
		$txt['pagetitle'] = 'Danh sách bạn bè
';
		$txt['title_text'] = '<img src="images/icons/groep.png" width="16" height="16" /> <strong>Chèn bạn của bạn
\'s tới.</strong>';
		$txt['username'] = 'tài khoản:';
		$txt['#'] = '#';
		$txt['country'] = 'khu vực';
		$txt['status'] = 'Status';
		$txt['actions'] = 'Hành động
';
		$txt['offline'] = 'Offline';
		$txt['online'] = 'Online';
		$txt['send_message'] = 'gửi tin nhắn';
		$txt['donate_silver'] = 'tặng bạc';
		$txt['delete_buddy'] = 'Xóa bạn thân
';
		$txt['no_buddys'] = 'Bạn không có bạn bè
.';
		$txt['button'] = 'thêm vào bạn thân';
	}
	
	######################## POKEMON INFO ########################
	elseif($page == 'blocklist'){
		#Alerts
		$txt['success_deleted'] = $_POST['deletenaam'].' được xóa khỏi danh sách chặn của bạn
.';
		$txt['alert_block_yourself'] = 'Bạn không thể tự chặn mình
.';
		$txt['alert_unknown_username'] = 'Tên người dùng chưa biết.
';
		$txt['alert_already_in_blocklist'] = $_POST['blocknaam'].' hnhư bị chặn.
';
		$txt['alert_is_your_buddy'] = $_POST['blocknaam'].' bạn đã là bạn.
';
		$txt['alert_admin_block'] = 'Bạn không thể chặn quản trị viên
.';
		$txt['success_blocked'] = $_POST['blocknaam'].' đã chặn thành công
.';
		
		#Screen
		$txt['pagetitle'] = 'danh sách chặn';
		$txt['title_text'] = '<img src="images/icons/blokkeer.png" border="0" /> <strong>Khối giảng viên
</strong><br />Nếu bạn đã chặn một huấn luyện viên, bạn không còn có thể gửi tin nhắn cho họ, cũng như không nhận được bất kỳ tin nhắn từ những giảng viên.';
		$txt['username'] = 'Tài KHoản:';
		$txt['button'] = 'Block';
		$txt['*'] = '*';
		$txt['#'] = '#';
		$txt['country'] = 'Khu vực';
		$txt['status'] = 'Status';
		$txt['actions'] = 'Actions';
		$txt['offline'] = 'Offline';
		$txt['online'] = 'Online';
		$txt['block_delete'] = 'Xóa';
		$txt['nobody_blocked'] = 'Bạn chưa chặn bất kỳ ai.
';
	}
	
	######################## SEARCH USER ########################
	elseif($page == 'search-user'){
		#Screen
		$txt['pagetitle'] = 'Tìm một huấn luyện viên
';
		$txt['title_text'] = '<img src="images/icons/groep_magnify.png" border="0" /> <strong>tìm kiếm một huấn luyện viên
</strong>';
		$txt['username'] = 'Tài Khoản';
		$txt['#'] = '#';
		$txt['country'] = 'khu vực';
		$txt['rank'] = 'xếp hạng';
		$txt['status'] = 'Status';
		$txt['offline'] = 'Offline';
		$txt['online'] = 'Online';
		$txt['button'] = 'Search';
	}
	
	######################## PROFILE ########################
	elseif($page == 'profile'){
		#Screen
		$txt['pagetitle'] = 'Profile '.$_GET['player'];
		$txt['offline'] = 'Offline';
		$txt['online'] = 'Online';
		$txt['username'] = 'Tên TK:';
		$txt['name'] = 'tên:';
		$txt['country'] = 'khu vực:';
		$txt['date_started'] = 'Đã Bắt Đàu:';
		$txt['world'] = 'Thế Giới:';
		$txt['silver'] = 'Bạc:';
		$txt['gold'] = 'Vàng:';
		$txt['bank'] = 'Ngân Hàng:';
		$txt['rank'] = 'Xếp Hạng:';
		$txt['rank_number'] = 'Xếp Hạng:';
		$txt['badges_number'] = 'Huy Hiệu:';
		$txt['pokemon'] = 'Pokemon:';
		$txt['win'] = 'trận thắng:';
		$txt['lost'] = 'trận thua:';
		$txt['status'] = 'Trạng Thái:';
		$txt['action'] = 'Hành động:';
		$txt['add_buddy'] = 'Thêm vào danh sách bạn bè của bạn
';
		$txt['send_message'] = 'Gửi Mail';
		$txt['block'] = 'Chặn';
		$txt['spy'] = 'Gián Điệp';
		$txt['steal'] = 'Thép';
		$txt['race'] = 'Cuộc đua
';
		$txt['duel'] = 'Hai';
        $txt['bank_transfer'] = 'Gửi bạc hoặc vàng';
		$txt['email'] = 'E-mail:';
		$txt['ip_registered'] = 'IP đăng kí:';
		$txt['ip_login'] = 'IP đăng nhập:';
		$txt['admin_options'] = 'Admin cài đặt:';
		$txt['edit_profile'] = 'sửa trang cá nhân';
		$txt['make_admin'] = 'admin chế tạo';
		$txt['give_egg'] = 'Tặng trứng';
		$txt['give_pokemon'] = 'Tặng Pokemon';
		$txt['give_pack'] = 'Tặng gói
';
		$txt['team'] = 'Đồng Đội:';
		$txt['badges'] = 'huy Hiệu';
		$txt['no_badges_from'] = 'không huy hiệu';
		$txt['no_profile_insert'] = 'Không có hồ sơ nào được tạo
.';
	}
	
	######################## WORK ########################
	elseif($page == 'work'){
		#Alerts
		$txt['alert_nothing_selected'] = 'Bạn chưa chọn mục nào.';
		$txt['alert_captcha_wrong'] = 'Bảo mật sai
.';
		$txt['and'] = 'và';
		$txt['seconds'] = 'giây';
		$txt['minutes'] = 'phút';
		$txt['minute'] = 'phút';
		$txt['success_work_1'] = 'Bạn đang làm việc
. ';
		$txt['success_work_2'] = 'cho đến khi bạn kết thúc công việc
.';
		
		#Screen
		$txt['pagetitle'] = 'Công việc
';
		$txt['#'] = '#';
		$txt['work_name'] = 'Công Việc';
		$txt['duration'] = 'Thời lượng
';
		$txt['turnover'] = 'Phần thưởng
';
		$txt['chance'] = 'Cơ hội
';
		$txt['button'] = 'Công Việc';
		
		$txt['work_1'] = 'Bán nước chanh trên quảng trường
';
		$txt['work_2'] = 'Trợ giúp trên thị trường
';
		$txt['work_3'] = 'Cung cấp giấy tin tức xung quanh khối
';
		$txt['work_4'] = 'Làm sạch trung tâm Pokemon
';
		$txt['work_5'] = 'Challenge Team Rocket tại một vòng gôn
';
		$txt['work_6'] = 'Tìm kiếm vật có giá trị trong thành phố
';
		$txt['work_7'] = 'Cung cấp cho một cuộc biểu tình pokemon tại quảng trường
';
		$txt['work_8'] = 'Thử nghiệm y khoa cho pokemon của bạn
';
		$txt['work_9'] = 'Hãy để phong cách pokemon miễn phí của bạn trong công viên
';
		$txt['work_10'] = 'Nhân viên trợ giúp Jenny
';
		$txt['work_11'] = 'Hãy để pokemon của bạn ăn cắp
';
		$txt['work_12'] = 'Rob một sòng bạc với Pokemon của bạn
';
	}
	
	######################## TRADERS ########################
	elseif($page == 'traders'){
		#Alerts
		$txt['alert_dont_have_1'] = 'bạn không có
';
		$txt['alert_dont_have_2'] = 'khi bạn
.';
		
		$txt['alert_i_have_1'] = 'Tôi có
';
		$txt['alert_i_have_2'] = 'chỉ đổi chỗ, xin lỗi
.';
		$txt['success_traders_change'] = 'Cảm ơn bạn đã trao đổi, hãy quan tâm
';
		$txt['success_traders_refresh'] = 'Đã làm mới thành công pokemon của bạn
!';
		
		#Screen
		$txt['pagetitle'] = 'Người bán Pokemon
';
		$txt['title_text'] = 'Ở đây bạn có thể giao dịch pokemon với Kayl, Wayne và Remy.
<br />
										Cấp độ của pokemon bạn nhận được dựa trên cấp độ của pokemon bạn giao dịch.
<br /><br />
									Nếu bạn có 2 của cùng một pokemon trên bạn, người đầu tiên bạn có trong túi của bạn sẽ được trao đổi
.';
		$txt['kayl_no_pokemon'] = 'Xin lỗi bạn, tôi có tất cả pokemon mà tôi muốn
.';
		$txt['kayl_text_1'] = 'Hey!<br />
								Bạn có xảy ra một
 <strong>';
		$txt['kayl_text_2'] = '</strong>?<br />
							Nếu bạn muốn tôi đổi tiền cho tôi
 <strong>';
		$txt['kayl_text_3'] = '</strong>.<br /><br />
								Sẽ rất tuyệt nếu bạn có thể trao đổi với tôi
!';
		$txt['button_change'] = 'Giao dịch với
';
		
		$txt['wayne_no_pokemon'] = 'Tôi không thể làm ăn với bạn ngay bây giờ
.';
		$txt['wayne_text_1'] = 'Xin chào, tôi tên là Wayne. <br />
Tôi đang tìm kiếm một <strong>';
		$txt['wayne_text_2'] = '</strong>, bạn có muốn giao dịch cho tôi không
 <strong>';
		$txt['wayne_text_3'] = '</strong>?<br /><br />
								Nếu bạn muốn làm ăn với tôi, tôi sẽ thưởng cho bạn thêm
 <img src="images/icons/silver.png" title="Silver" style="margin-bottom:-3px;"> 100 bạc thưởng.<br />';
								
		$txt['remy_no_pokemon'] = 'Xin lỗi, nhưng tôi không tìm bất kỳ pokemon nào vào lúc này
.';
		$txt['remy_text_1'] = 'Xin chào tôi là Remy
.<br />
							Tôi đã tìm kiếm một thời gian dài cho một
 <strong>';
		$txt['remy_text_2'] = '</strong>, bạn có người bạn đời đó không
?<br />
							Tôi muốn đổi lấy
 <strong>';
		$txt['remy_text_3'] = '</strong>.';
		
		$txt['refresh_pokemon'] = 'Làm mới pokemon
';
		$txt['button_traders_refresh'] = 'Làm mới pokemon
';
	}
	
	######################## RACE INVITE ########################
	elseif($page == 'race-invite'){
		#Alerts
		$txt['alert_no_races_today'] = 'Không có cuộc đua nào được tổ chức hôm nay
.';
		$txt['alert_no_player'] = 'Bạn chưa vào Trainer
.';
		$txt['alert_not_yourself'] = 'Bạn không thể tự mình đua
.';
		$txt['alert_unknown_amount'] = 'Số tiền không hợp lệ
.';
		$txt['alert_no_amount'] = 'Không có tiền vào
.';
		$txt['alert_unknown_what'] = 'chọn xem bạn có muốn đua bạc hay vàng không.
';
		$txt['alert_not_enough_silver_or_gold'] = 'Bạn không có đủ bạc hoặc vàng.';
		$txt['alert_user_unknown'] = 'Tên đăng nhập không tồn tại.';
		$txt['alert_opponent_not_in'] = 'không có trong
';
		$txt['alert_opponent_not_casual'] = 'không phải là hạng bình thường
.';
		$txt['alert_no_admin'] = 'Bạn không thể thách thức một quản trị viên cho một cuộc đua
.';
		$txt['success'] = 'Bạn có '.$_POST['naam'].' thử thách thành công cuộc đua
!';
		
		#Screen
		$txt['pagetitle'] = 'Cuộc Đua';
		$txt['title_text'] = '<img src="images/icons/vlag.png" width="16" height="16" alt="Race" /> <strong>Thách thức một huấn luyện viên cho một cuộc đua 5 km
!</strong> <img src="images/icons/vlag.png" width="16" height="16" alt="Race" />';
		$txt['races_left_today'] = 'Các cuộc đua còn lại cho hôm nay
:';
		//$txt['premium_10_times'] = 'Premium Members can challenge someone 10 times a day, <a href="?page=area-market">word premium hier!</a>.';
		$txt['player'] = 'Tài Khoản:';
		$txt['silver_or_gold'] = 'Bạc Hoặc Vàng:';
		$txt['amount'] = 'Số tiền
:';
		$txt['button'] = 'Mời gọi
!';
		$txt['races_opened'] = 'Các cuộc đua đang mở
';
		$txt['races_deleted_3_days'] = 'Nếu cuộc đua cũ hơn 3 ngày, cuộc đua sẽ tự động bị xóa
.';
		$txt['#'] = '#';
		$txt['opponent'] = 'Phản đối
';
		$txt['price'] = 'Giải thưởng
';
		$txt['when'] = 'cuộc đua trên
';
		$txt['no_races_opened'] = 'Bạn không có cuộc đua nào mở
.';
	}
	
	######################## RACE ########################
	elseif($page == 'race'){
		#Alerts
		$txt['alert_to_low_rank'] = 'Bạn phải có thứ hạng Casual để đua
.';
		$txt['alert_no_pokemon_in_hand'] = 'Bạn không có pokemon với bạn
.';
		$txt['alert_link_invalid'] = 'Liên kết không hợp lệ
.';
		$txt['alert_race_invalid'] = 'Cuộc đua không còn khả dụng
.';
		$txt['alert_not_enough_money'] = 'Bạn không có đủ bạc hoặc vàng.
';
		$txt['success_denied'] = 'Bạn đã từ chối thành công cuộc đua
.';
		$txt['success_accepted'] = 'Race được chấp nhận thành công, bạn sẽ nhận được dưới dạng sự kiện
.';
		
	}
	
	######################## STEAL ########################
	elseif($page == 'steal'){
		#Alerts
		$txt['alert_no_more_steal'] = 'Bạn không thể ăn cắp nữa
.';
		$txt['alert_no_username'] = 'Không có tên người dùng nào được điền.
';
		$txt['alert_steal_from_yourself'] = 'Bạn không thể đánh cắp bản thân
.';
		$txt['alert_username_dont_exist'] = 'Tên đăng nhập không tồn tại
.';
		$txt['alert_username_incorrect_signs'] = 'Tên người dùng chứa các ký tự không hợp lệ
.';
		$txt['alert_admin_steal'] = 'Bạn không thể lấy cắp từ quản trị viên
.';
		$txt['alert_is_not_in'] = $_POST['player'].' không có trong
';
		$txt['alert_too_low_rank'] = $_POST['player'].'s xếp hạng quá thấp để ăn cắp
.';
		$txt['alert_too_low_or_high_rank'] = $_POST['player'].' quá thấp hoặc quá cao
.';
		$txt['alert_steal_failed_1'] = 'Không ăn cắp được
.';
		$txt['alert_steal_failed_2'] = 'mạnh hơn
.';
		
		$txt['alert_steal_jail'] = 'Bạn đã bị bắt bởi sĩ quan Jenny.
<br>';
		$txt['success_stole_1'] = 'Bạn có
';
		$txt['success_stole_2'] = 'bị đánh cắp từ
 '.$_POST['player'];
		
		$txt['alert_steal_jail_text_1'] = 'Bạn bây giờ
';
		$txt['alert_steal_jail_text_2'] = 'phút và';
		$txt['alert_steal_jail_text_3'] = 'giây tù
.';
		
		//Sreen
		$txt['pagetitle'] = 'Steal';
		$txt['title_text'] = '
Bạn có thể để lại pokemon của bạn để ăn cắp từ một đối thủ. <br /> Nếu bạn thành công. Họ lấy càng nhiều tiền càng tốt!
Nếu bạn thất bại, bạn có thể bị đưa vào tù. <br />
Tối đa 1 thứ hạng giữa bạn và đối thủ của bạn. Cấp bậc và dưới đây bạn có thể không bị tước đoạt.<br /><br />';
		
		//$txt['steal_premium_text'] = 'Premiumaccount leden mogen 3 keer per dag iemand beroven. <a href="index.php?page=area-market"><strong>Word hier premium!</strong></a><br><br>';
		$txt['steal_how_much_1'] = ' Bạn có thể nhận được pokemon của bạn để ăn cắp
 <strong>';
		$txt['steal_how_much_2'] = '</strong> times today.';
		$txt['username'] = 'Tài Khoản:';
		$txt['button'] = 'Ăn Cướp!';
	}
	
	######################## SPY ########################
	elseif($page == 'spy'){
		#Alerts
		$txt['alert_no_username'] = 'Không có tên người dùng nào được điền.
.';
		$txt['alert_spy_yourself'] = 'Bạn không thể tự mình theo dõi.';
		$txt['alert_username_dont_exist'] = 'Tên đăng nhập không tồn tại.';
		$txt['alert_not_enough_silver'] = 'Bạn không có đủ bạc.';
		$txt['alert_admin_spy'] = '
Bạn không thể gián điệp trên quản trị viên';
		$txt['alert_spy_failed'] = 'gián điệp thất bại
.';
		$txt['alert_spy_failed_jail_1'] = 'Team Rocket đã bị bắt! <br> Bạn hiện đang
';
		$txt['alert_spy_failed_jail_2'] = 'phút và';
		$txt['alert_spy_failed_jail_3'] = 'giây tù
.';
		$txt['success_spy'] = 'Dò thám đã thành công
!';
		
		#Screen
		$txt['pagetitle'] = 'Spy';
		$txt['username'] = 'tài khoản:';
		$txt['button'] = 'dò thám';
		$txt['world'] = 'thế giới';
		$txt['silver_in_hand'] = 'bạc';
		$txt['team'] = 'đội hình';
		$txt['title_text'] = 'Bạn có thể thuê một Team Rocket Trainer để theo dõi. <br />
Nếu họ thành công, họ sẽ cung cấp thông tin về thế giới nơi một người ngồi, số tiền mà người đó có với anh ta và tất cả thông tin về đội mà anh ấy / cô ấy có. <br />
Nhưng nếu họ thất bại. Team Rocket sẽ được gửi đến nhà tù, và họ sẽ mang bạn đến với họ.<br /><br />
								  Team Rocket gọi cho bất kỳ phiên gián điệp nào
 <img src="images/icons/silver.png" title="Silver" style="margin-bottom:-3px;" /> 100 bạc.';
	}
	
	######################## LVL CHOOSE ########################
	elseif($page == 'lvl-choose'){
		#Alerts
		$txt['success_lvl_choose'] = 'Bây giờ bạn có thể chiến đấu với Pokemon từ lvl
 '.$_POST['lvl'].' Trở lên.';
		
		#Screen
		$txt['pagetitle'] = 'Level select';
		$txt['title_text'] = 'Ở đây bạn có thể chọn pokemon cấp độ nào bạn có thể gặp
.<br />
  								Bạn chỉ có thể sử dụng trang này nếu bạn xếp hạng 18 trở lên
.';
  		$txt['#'] = '#';
		$txt['level'] = 'cấp độ';
		$txt['5-20'] = '5-20';
		$txt['20-40'] = '20-40';
		$txt['40-60'] = '40-60';
		$txt['60-80'] = '60-80';
		$txt['80-100'] = '80-100';
		$txt['button'] = 'Chọn!';
	}
	
	######################## Area markt ########################
	elseif($page == 'area-market'){
		#Screen
		$txt['pagetitle'] = 'Thị trường khu vực
';
		$txt['colorbox_text'] = 'Mở lại cửa sổ này và thông báo này sẽ vẫn ở đây
.';
		$txt['premiumdays'] = 'Ngày cao cấp
';
		$txt['premiumpacks'] = 'Gói đặc biệt
';
		$txt['premiumtext'] = 'Khi bạn mua một gói cao cấp, bạn sẽ là thành viên cao cấp. Hơn bạn có lợi thế trong game!<br />
Một số ví dụ: <br />
- Nhiều không gian hơn trong hộp thư đến và sự kiện. <br />
- Nhiều cơ hội đua và đánh cắp hơn. <br />
- Thêm Wheel of Fortune trong một ngày. <br />
- Bạn có thể chiến đấu với nhau. <br />
- Thời gian trung tâm Pokemon thấp hơn. <br />
- EXP thêm 5%.<br />
- Và còn nhiều nữa
!';
		$txt['valuepacks'] = 'Các gói khác
';
		$txt['valuetext'] = 'Những gói này rất hấp dẫn, ví dụ: bạn có thể mua Master Ball with Gold
.';
		$txt['buy'] = 'Mua';
	}
	
	######################## POKEMON CENTER ########################
	elseif($page == 'pokemoncenter'){
		#Alerts
		$txt['minute'] = 'phút';
		$txt['minutes'] = 'Phút';
		$txt['seconds'] = 'Giây';
		$txt['success_pokecenter'] = 'Pokemon của bạn được khôi phục:';
		
		#Screen
		$txt['pagetitle'] = 'Trung tâm Pokemon';
		$txt['title_text_admin'] = 'Quản trị viên không phải đợi cho đến khi pokemon của họ được chữa lành.';
		$txt['title_text_premium'] = 'hồi Phục PokeMon Cần 10 Giây.';
		$txt['title_text_normal'] = 'Bạn phải đợi 1 phút mỗi lần bạn muốn hồi phục pokemon của mình.<br>VIP hồi HP cho pokemon Chỉ mất 10s.<br><a href="index.php?page=area-market"><strong>Trở thành thành viên cao cấp!</strong></a>';
		$txt['all'] = 'Tất cả';
		$txt['who'] = 'Chọn';
		$txt['health'] = 'Sức khỏe';		$txt['nvt'] = 'Không thể áp dụng';
		$txt['button'] = 'Chữa lành!';
	}
	
	######################## MARKET ########################
	elseif($page == 'market'){
		#Alerts
		$txt['alert_itemplace'] = 'Lưu ý: Bạn không có sẵn mục nào, vì vậy bạn không thể mua bất cứ thứ gì
.';
		$txt['alert_not_enough_money'] = 'Không đủ bạc hoặc vàng.
';
		$txt['alert_itembox_full_1'] = 'Item đã đầy';
		$txt['alert_itembox_full_2'] = 'Lọ Thuốc.';
		$txt['success_market'] = 'Mua';
		$txt['alert_nothing_selected'] = 'Chọn vật phẩm đi bạn.';
		$txt['alert_pokedex_chip'] = 'Bạn không thể mua một con Pokedex mà không có Pokedex
.';
		$txt['alert_not_enough_place'] = 'Item bạn đã full.';
		$txt['alert_hand_full'] = 'Bạn đã có 6 pokemon với bạn
.';
		$txt['alert_not_in_stock'] = 'Sản phẩm tại thời điểm này không khả dụng
.';
		
		#Screen
		$txt['pagetitle'] = 'Chợ';
		$txt['balls'] = 'Bóng PokeMon';
		$txt['potions'] = 'Potions';
		$txt['items'] = 'Vật Phẩm';
		$txt['spc_items'] = 'Các mặt hàng đặc biệt
';
		$txt['stones'] = 'Đá';
		$txt['attacks'] = 'Tấn Công';
		$txt['pokemon'] = 'Pokemon';
		
		if($_GET['shopitem'] == 'balls'){
			$txt['pagetitle'] .= ' - Balls';
			$txt['button_balls'] = 'Mua Bóng';
		}
		elseif($_GET['shopitem'] == 'potions'){
			$txt['pagetitle'] .= ' - Potions';
			$txt['button_potions'] = 'Mua Thuốc';
		}
		elseif($_GET['shopitem'] == 'items'){
			$txt['pagetitle'] .= ' - Items';
			$txt['button_items'] = 'Mua Item';
		}
		elseif($_GET['shopitem'] == 'specialitems'){
			$txt['pagetitle'] .= ' - Special items';
			$txt['button_spc_items'] = 'Mua các mặt hàng đặc biệt
';
		}
		elseif($_GET['shopitem'] == 'stones'){
			$txt['pagetitle'] .= ' - Stones';
			$txt['button_stones'] = 'Mua';
		}
		elseif($_GET['shopitem'] == 'attacks'){
			$txt['pagetitle'] .= ' - Attacks';
			$txt['button_attacks'] = 'Mua';
			$txt['market_attack_types'] = 'Pokemon có thể học các cuộc tấn công này
.';
		}
		elseif($_GET['shopitem'] == 'pokemon'){
			$txt['pagetitle'] .= ' - Pokemon';
			$txt['button_pokemon'] = 'Mua PokeMon';
			$txt['not_rare'] = 'Common';
			$txt['middle_rare'] = 'Uncommon';
			$txt['rare'] = 'Rare';
			$txt['out_of_stock_1'] = 'Tất cả pokemon tại thời điểm này được bán trong
';
			$txt['out_of_stock_2'] = 'Chợ.';
			$txt['success_bought_pokemon'] = '1 trứng PokeMon.';
		}
	}
	
	######################## BANK ########################
	elseif($page == 'bank'){
		#Alerts
		$txt['alert_no_more_storting'] = 'Bạn không thể trả tiền hôm nay.
';
		$txt['alert_nothing_insert'] = 'Không có số tiền nào được nhập.
';
		$txt['alert_amount_unknown'] = 'Đã nhập số tiền không hợp lệ
.';
		$txt['alert_too_less_cash'] = 'Bạn không có nhiều trên tay
.';
		$txt['alert_no_silver_or_gold'] = 'Bạn phải chọn bạc hoặc vàng
.';
		$txt['success_stort'] = $_POST['stort'].' <img src="images/icons/silver.png"  title="Silver" style="margin-bottom:-3px;"> nạp tiền thành công
.';
		$txt['alert_too_less_bank'] = 'Bạn không có nhiều trong ngân hàng
.';
		$txt['success_take'] = $_POST['ophaal'].' <img src="images/icons/silver.png"  title="Silver" style="margin-bottom:-3px;"> đã rút thành công
.';
		$txt['alert_no_receiver'] = 'Không có người nhận nào được nhập
.';
		$txt['alert_send_to_yourself'] = 'Bạn không thể gửi cho chính mình
.';
		$txt['alert_receiver_dont_exist'] = 'Người nhận không tồn tại
.';
		$txt['alert_more_than_10silver'] = 'Bạn phải kết thúc
 <img src="images/icons/silver.png" title="Silver" style="margin-bottom:-3px;"> 10 gửi
.';
		$txt['alert_too_less_money'] = 'Bạn không có nhiều bạc
.';
		$txt['alert_too_less_gold'] = 'Bạn không có nhiều vàng
.';
		$txt['success_send'] = 'Đã gửi thành công bạc hoặc vàng
.';
		
		#Screen
		$txt['pagetitle'] = 'Bank';
		$txt['title_text_1'] = 'bạc trong Người:';
		$txt['title_text_2'] = 'bạc trong kho:';
		$txt['title_text_3'] = 'Bạn vẫn có thể gửi tiền của bạn
';
		$txt['title_text_4'] = 'lần hôm nay
';
		$txt['amount_silver'] = 'bạc:';
		$txt['silver_or_gold'] = 'bạc hoặc vàng:';
		$txt['amount'] = 'Số tiền
:';
		$txt['button_stort'] = 'Gửi Tiền Vào Ngân Hàng';
		$txt['button_take'] = 'rút ra';
		$txt['title_text_send'] = '<font size="4"><hr>Gửi Cho Bạn Bè</font><br>
										<font size="2">Tùy chọn này sẽ khiến bạn mất thêm 5%, vì chi phí giao dịch (chỉ bằng bạc)
</font><br />
										<font size="2">Tối thiểu
 <img src="images/icons/silver.png" title="Silver" style="margin-bottom:-3px;" /> 10 tại một thời điểm
.</font>';
		$txt['username'] = 'tài khoản:';
		$txt['button_send'] = 'Gửi Bạc / Vàng';
	}
	
	######################## HOUSE SELLER ########################
	elseif($page == 'house-seller'){
		#Alerts
		$txt['alert_nothing_selected'] = 'Bạn phải chọn một ngôi nhà
.';
		$txt['alert_you_own_this_house'] = 'Bạn đã có ngôi nhà này rồi
!';
		$txt['alert_not_enough_silver'] = 'Bạn không có đủ bạc cho ngôi nhà này.
';
		$txt['alert_already_have_villa'] = 'Bạn đã có một Biệt thự, bạn không thể có được ngôi nhà tốt hơn
.';
		$txt['alert_you_have_better_now'] = 'Bạn nên mua một cái tốt hơn sau đó bạn có bây giờ.
';
		$txt['success_house_1'] = 'Bạn đã thành công
';
		$txt['success_house_2'] = 'đã mua
.';
		
		#Screen
		$txt['pagetitle'] = 'Nhà bán
';
		$txt['house1'] = 'Thùng các - tông
';
		$txt['house2'] = 'Nhà Nhỏ';
		$txt['house3'] = 'Nhà bình thường
';
		$txt['house4'] = 'Biệt thự
';
		$txt['title_text'] = 'Ở đây người bán nhà, bạn có thể mua một ngôi nhà cho Pokemon của bạn.
<br />
							  Bây giờ bạn có một
';
		$txt['house'] = 'Nhà';
		$txt['price'] = 'Giá bán
';
		$txt['description'] = 'Sự miêu tả';
		$txt['button'] = 'Mua!';
	}
	
	######################## TRAVEL ########################
	elseif($page == 'travel'){
		#Alerts
		$txt['alert_no_world'] = 'Bạn chưa chọn một thế giới
.';
		$txt['alert_already_in_world'] = 'Bạn đã ở
 '.$_POST['wereld'].'.';
		$txt['alert_world_invalid'] = $_POST['wereld'].' không phải là một thế giới hợp lệ
.';
		$txt['alert_not_enough_money'] = 'Bạn không có đủ bạc để
 '.$_POST['wereld'].' đi thuyền
.';
		$txt['success_travel'] = 'Bạn đã đi đến
 '.$_POST['wereld'].', và thua
';
		$txt['alert_not_everything_selected'] = 'Không phải tất cả mọi thứ.';
		$txt['alert_not_your_pokemon'] = 'Pokemon này không phải của bạn
.';
		$txt['alert_no_surf'] = 'Pokemon này không có Surf Attack
.';
		$txt['alert_no_fly'] = 'Pokemon này không biết Fly.
';
		$txt['alert_not_strong_enough'] = 'Pokemon này không đủ mạnh.
';
		$txt['success_surf'] = 'Pokemon của bạn đã thành công
 '.$_POST['wereld'].' surfed.';
		$txt['success_fly'] = 'Pokemon của bạn đã thành công '.$_POST['wereld'].' flown.';
			
		#Screen
		$txt['pagetitle'] = 'Hành trình đến một thế giới khác
';
		$txt['title_text'] = 'Bạn có thể thuê thuyền và đi thuyền đến một thế giới khác
.';
		$txt['#'] = '#';
		$txt['world'] = 'Thế Giới';
		$txt['price'] = 'Giá mỗi pokemon
';
		$txt['price_total'] = 'Tổng giá
';
		$txt['button_travel'] = 'Du lịch
';
		$txt['title_text_surf'] = 'Nếu một pokemon của bạn có thể
 \'Surf\' và nếu mức pokemon là 80+.<br />
								Sau đó, bạn có thể lướt web miễn phí đến một thế giới khác!
';
		$txt['title_text_fly'] = 'Nếu một pokemon của bạn có thể
 \'Fly\' và nếu mức pokemon là 80+
.<br />
								Ở đây bạn có thể bay miễn phí đến một thế giới khác
!';
		$txt['pokemon'] = 'Pokemon';
		$txt['button_surf'] = 'Surf';
		$txt['button_fly'] = 'Fly';
	}
	
	######################## TRANSFERLIST ########################
	elseif($page == 'transferlist'){
		#Screen
		$txt['pagetitle'] = 'Transfer List';
		$txt['colorbox_text'] = 'Mở lại cửa sổ này và thông báo này sẽ vẫn ở đây
.';
		$txt['title_text_1'] = 'Bây giờ bạn
:';
		$txt['title_text_2'] = 'Mẹo: cũng nhìn vào Onvallen của pokemon
.';
		$txt['#'] = '#';
		$txt['pokemon'] = 'Pokemon';
		$txt['clamour_name'] = 'Nickname';
		$txt['level'] = 'Level';
		$txt['price'] = 'Giá bán
';
		$txt['owner'] = 'Chủ nhân
';
		$txt['buy'] = 'Mua';
	}
	
	######################## DAYCARE ########################
	elseif($page == 'daycare'){
		#Alerts
		$txt['alert_not_your_pokemon'] = 'Đây không phải là pokemon của bạn
.';
		$txt['alert_hand_full'] = 'Bạn đã có 6 pokemon với bạn
.';
		$txt['alert_no_eggs'] = 'Không có trứng cho bạn
.';
		$txt['success_egg'] = 'Bạn đã nhận được một quả trứng.
';
		$txt['alert_already_in_daycare'] = 'Pokemon đó đã ở trong nhà trẻ
.';
		$txt['alert_already_lvl_100'] = 'Con Pokemon đó đã lên cấp 100 rồi.
';
		$txt['alert_daycare_full'] = 'Bạn không thể có pokemon nữa tại nhà trẻ.
';
		$txt['success_bring'] = 'Bạn đã đặt pokemon của bạn trong nhà trẻ.
';
		$txt['alert_not_enough_silver'] = 'Bạn không có đủ bạc.
';
		$txt['success_take'] = 'Bạn đã truy xuất pokemon của mình.';
		$txt['alert_no_pokemon'] = 'Bạn phải có một pokemon với bạn khi bạn muốn sử dụng nhà trẻ.
'; 
		
		#Screen
		$txt['pagetitle'] = 'Daycare';
		$txt['egg_text'] = 'Hey!<br /><br />
							  Chúng tôi đã tìm thấy một quả trứng trong nhà trẻ của chúng tôi, bạn có muốn có trứng không?
<br /><br />
							  <input type="submit" name="accept" value="Vâng Cám Ơn" class="text_long"><input type="submit" name="dontaccept" value="không ." class="text_long" style="margin-left:10px;">';
		$txt['normal_user'] = 'Bạn có thể mang một pokemon đến nhà trẻ, các thành viên cao cấp có thể mất 2 pokemon.';
		$txt['premium_user'] = 'Bạn có thể mang 2 pokemon đến nhà trẻ
.';
		$txt['title_text'] = 'Chúng tôi có thể chăm sóc pokemon của bạn. Nó sẽ tiêu tốn của bạn
<img src="images/icons/silver.png" title="Silver" /> 250 bạc khi bạn đến đón chúng
.<br />
			Bạn sẽ phải trả thêm phí
 <img src="images/icons/silver.png" title="Silver" /> 500 bạc nếu pokemon của bạn lên cấp.
<br />
			Pokemon của bạn sẽ không phát triển hoặc học các cuộc tấn công mới cho đến khi bạn đến đón chúng
.';
		$txt['give_pokemon_text'] = 'Pokemon nào bạn muốn đặt trong nhà trẻ?
';
		$txt['button_bring'] = 'Đưa cho
';
		$txt['take_pokemon_text'] = 'Pokemon của bạn trong nhà trẻ
';
		$txt['#'] = '#';
		$txt['name'] = 'Tên';
		$txt['level'] = 'Level';
		$txt['levelup'] = 'Leveled';
		$txt['cost'] = 'Chi phí để truy xuất
';
		$txt['buy'] = 'Mua';
		$txt['button_take'] = 'Take';
	}
	
	######################## NAME SPECIALIST ########################
	elseif($page == 'name-specialist'){
		#Alerts
		$txt['alert_nothing_selected'] = 'Bạn phải chọn một pokemon
.';
		$txt['alert_not_enough_silver'] = 'Bạn không có đủ bạc
.';
		$txt['alert_name_too_long'] = 'Tên không thể dài hơn 12 ký tự
.';
		$txt['alert_not_your_pokemon'] = 'Pokemon này không phải của bạn
.';
		$txt['success_namespecialist'] = 'Tên mới là
:';
		
		#Screen
		$txt['pagetitle'] = 'Tên chuyên gia
';
		$txt['title_text'] = 'Ở đây bạn có thể thay đổi tên của pokemon của bạn
!<br />
							Thay đổi tên pokemon của bạn sẽ khiến bạn mất phí
';
		$txt['#'] = '#';
		$txt['name_now'] = 'Đặt tên ngay bây giờ
';
		$txt['button'] = 'Đổi tên
';
	}
	
	######################## NAME SPECIALIST ########################
	elseif($page == 'shiny-specialist'){
		#Alerts
		$txt['alert_no_pokemon_selected'] = 'Không có pokemon nào được chọn
.';
		$txt['alert_pokemon_is_egg'] = 'Đây là một quả trứng pokemon
.';
		$txt['alert_not_your_pokemon'] = 'Đây không phải là pokemon của bạn
.';
		$txt['alert_already_shiny'] = 'Pokemon đã sáng bóng
!';
		$txt['alert_pokemon_not_in_hand'] = 'Pokemon không ở bên bạn
.';
		$txt['alert_not_enough_gold'] = 'Bạn không có đủ vàng
.';
		$txt['success'] = 'Pokemon giờ đây sáng bóng
!';
		
		#Screen
		$txt['pagetitle'] = 'Shiny Specialist';
		$txt['title_text'] = 'Các nhà khoa học đã phát hiện ra một cái gì đó mới: <br />
                Chúng tôi đã phát hiện ra một cách để làm cho pokemon của bạn sáng bóng! <br />
                Quy trình này rất tinh tế và tốn rất nhiều tiền để tái tạo.<br />
                Chúng tôi có thể làm cho pokemon của bạn sáng bóng với một khoản phí.';
		$txt['#'] = '#';
		$txt['gold_need'] = 'Vàng';
		$txt['button'] = 'Mua!';
	}
	
	######################## JAIL ########################
	elseif($page == 'jail'){
		#Alerts
		$txt['alert_already_broke_out'] = $_POST['naam'].' đã bị hỏng miễn phí
.';
		$txt['alert_already_free'] = $_POST['naam'].' đã được giải phóng
.';
		$txt['success_bust'] = 'Je hebt '.$_POST['naam'].' thành công bị hỏng miễn phí
.';
		$txt['alert_bust_failed_1'] = 'bạn không thành công
 '.$_POST['naam'].' để phá vỡ. Bạn bây giờ là chính họ
';
		$txt['alert_bust_failed_2'] = 'trong nhà tù
.';
		$txt['alert_not_enough_silver'] = 'Bạn không có đủ bạc để
 '.$_POST['naam'].' để mua
.';
		$txt['success_bought'] = 'Bạn có '.$_POST['naam'].' trả tiền để ra tù vì
';
		
		#Screen
		$txt['pagetitle'] = 'Prison';
		$txt['title_text'] = 'Bust medeGame bạn ra tù, nếu thất bại là chính bạn trong tù.
 <br />
							 Nếu bạn thành công, bạn sẽ nhận được điểm xếp hạng và thứ Sáu
!<br />
							  Bạn cũng có thể tắt kopen, điều này chi phí tiền bạc, nhưng bạn biết rằng người đó được phát hành
.';
		$txt['#'] = '#';
		$txt['username'] = 'tài khoản';
		$txt['country'] = 'vùng';
		$txt['time'] = 'thời igan';
		$txt['cost'] = 'Chi phí';
		$txt['buy_out'] = 'Mua lại';
		$txt['bust'] = 'Bust';
		$txt['button_buy'] = 'Mua';
		$txt['button_bust'] = 'Bust';
		$txt['nobody_injail_1'] = 'Hiện tại không có ai trong
';
		$txt['nobody_injail_2'] = 'nhà tù.';
	}
	
	######################## FLIP A COIN ########################
	elseif($page == 'flip-a-coin'){
		#Alerts
		$txt['alert_no_amount'] = 'Bạn đã không nhập bất kỳ khoản tiền nào
.';
		$txt['alert_too_less_silver'] = 'Bạn không có đủ bạc
.';
		$txt['alert_amount_unknown'] = 'Bạn có chắc bạn có nhiều
?';
		$txt['success_win'] = 'Cái đầu. Bạn thắng
 ';
		$txt['success_lose'] = 'Đuôi. Bạn đã thua
 ';
		
		#Screen
		$txt['pagetitle'] = 'Lật một đồng xu
!';
		$txt['title_text'] = 'Nếu đầu của nó, bạn giành chiến thắng. <b> Nếu thắng, bạn thắng gấp đôi số tiền bạn đặt cược
!';
		$txt['button'] = 'Lật!!';
	}
	
	######################## WHO IS IT QUIZ ########################
	elseif($page == 'who-is-it-quiz'){
		#Alerts
		$txt['alert_wait'] = 'Bạn có thể chuyển

							  <strong><span id=uur3></span></strong> hour
							  <strong><span id=minuten3> </span>&nbsp;minuten</strong> và 
							  <strong><span id=seconden3></span>&nbsp;seconden</strong> làm lại bài kiểm tra
.';
		$txt['alert_choose_a_pokemon'] = 'Chọn một pokemon
.';
		$txt['alert_no_answer'] = 'Không có câu trả lời
.';
		$txt['success_win'] = 'You là lời hứa! Bạn có
 <img src="images/icons/silver.png" title="Silver"> thắng 200 bạc! Bạn có thể thử lại sau một giờ
.';
		$txt['success_lose_1'] = 'Không chính xác, câu trả lời là
';
		$txt['success_lose_2'] = 'Hãy thử lại sau một giờ
.';
		
		#Screen
		$txt['pagetitle'] = 'Câu đố là ai
';
		$txt['who_is_it'] = 'Pokemon này là ai
?';
		$txt['title_text'] = '<strong>Câu đố pokemon này là ai!
</strong><br />
							  Bạn có thể thử đoán xem pokemon này là ONCE mỗi giờ
.<br />
							 Nếu bạn đoán đúng, bạn thắng
 <img src="images/icons/silver.png" title="Silver"> 200!';
		$txt['choose_a_pokemon'] = 'Chọn một pokemon
';
		$txt['button'] = 'Đi!';
	}
	
	######################## WHEEL OF FORTUNE ########################
	elseif($page == 'wheel-of-fortune'){
		#Alerts
		$txt['alert_itemplace'] = 'Lưu ý: Bạn không có mục nào còn lại, vì vậy bạn không thể giành được bất kỳ mục nào
.';
		$txt['alert_no_more_wof'] = 'Bạn không còn có thể chơi bánh xe của tài sản ngày hôm nay.
';
		$txt['win_100_silver'] = 'Bạn đã thắng
 <img src="images/icons/silver.png" title="Silver"> 100 bạc!';
		$txt['win_250_silver'] = 'Bạn đã thắng
 <img src="images/icons/silver.png" title="Silver"> 250 bac!';
		$txt['win_5_gold'] = 'bạn đã thằng <img src="images/icons/gold.png" title="gold"> 5 vàng!';
		$txt['win_ball'] = 'Bạn Đã Chiến Thắng';
		$txt['alert_itembox_full'] = 'Hộp Đồ của bạn đã đầy!';
		$txt['lose_jailzone'] = 'OH! KHÔNG! Bạn đã bị gửi vào tù
!';
		$txt['win_spc_item'] = 'WOW! Bạn giành chiến thắng một mục đặc biệt:';
		$txt['win_stone'] = 'Bạn thắng';
		$txt['win_tm'] = 'Bạn thắng';
		$txt['reset_wheel'] = 'Bạn đã thiết lập lại mọi bánh xe của tài sản
.';
		
		#Screen
		$txt['pagetitle'] = 'Vòng quay may mắn
';
		$txt['title_text_1'] = 'Bạn có
';
		$txt['title_text_2'] = 'nỗ lực còn lại hôm nay
.';
		//$txt['premiumtext'] = '<br>Premium members can do this 3 times per day. <a href="index.php?page=area-market"><strong>Become a Premium Member!</strong></a>';
		$txt['button'] = 'Xoay bánh xe!
';
	}
	
	######################## WHEEL OF FORTUNE ########################
	elseif($page == 'lottery'){
		#Alerts
		$txt['alert_premium_only'] = 'Chỉ dành cho thành viên cao cấp
.';
		$txt['alert_no_amount'] = 'Bạn phải điền vào một Ontal
.';
		$txt['alert_unknown_amount'] = 'Số tiền không hợp lệ
.';
		$txt['alert_max_10_tickets'] = 'Bạn chỉ có thể mua 10 vé
!';
		$txt['alert_not_enough_money'] = 'Bạn không có đủ tiền cho nó
 '.$_POST['Ontal'].' thẻ.';
		$txt['alert_no_tickets_left'] = 'Bạn không thể mua vé nữa
!';
		$txt['alert_buys_left_1'] = 'Bạn chỉ có thể
';
		$txt['alert_buys_left_2'] = 'mua vé
!';
		$txt['success_lottery'] = 'Thành công
 '.$_POST['Ontal'].' vé đã mua
.';
		
		#Screen
		$txt['pagetitle'] = 'Lottery';
		$txt['title_text'] = 'Ở đây bạn có thể mua vé cho 5 xổ số khác nhau. <br />
Xổ số được xổ ngẫu nhiên. <br />
Càng có nhiều vé bạn mua, bạn càng có nhiều cơ hội thắng giải!';
		$txt['lottery'] = 'Xổ số
';
		$txt['time'] = 'Thời gian xổ số:';
		$txt['ticket_price'] = 'Giá thẻ:';
		$txt['price_money'] = 'Tiền thưởng:';
		$txt['tickets_sold'] = 'Vé đã bán:';
		$txt['last_winner'] = 'Người chiến thắng cuối cùng:';
		$txt['button'] = 'Mua!';
		$txt['only_premium'] = '* Chỉ khả dụng cho thành viên Premium
.';
		$txt['buy_tickets'] = 'Mua vé
:';
	}

	######################## Forum Categories ########################
	elseif($page == 'forum-categories'){
		#Alerts
		$txt['alert_no_name'] = 'Không có tên nào được nhập
.';
		$txt['alert_name_too_short'] = 'Tên quá ngắn, ít nhất 3 ký tự
.';
		$txt['alert_name_too_long'] = 'Tên quá dài, tối đa 20 ký tự
.';
		$txt['alert_no_icon'] = 'Không có URL biểu tượng nào được nhập
.';
		$txt['alert_icon_doenst_exist'] = 'Biểu tượng không tồn tại
.';
		$txt['alert_name_already_taken'] = 'Tên danh mục đã tồn tại
.';
		$txt['success_add_category'] = 'Đã tạo thành công một danh mục.';
		$txt['success_edit_category'] = 'Chỉnh sửa thành công danh mục
.';
		
		#Screen
		$txt['pagetitle'] = 'Forum';
		$txt['pokemon-area-forum'] = 'Diễn Đàn PokeMon Việt Nam ';
		$txt['#'] = '#';
		$txt['name'] = 'Chuyên Mục';
		$txt['threads'] = 'Chủ Đề';
		$txt['messages'] = 'Bài đăng';
		$txt['last_post'] = 'Bài đăng cuối';
		$txt['nothing_posted'] = 'Không có gì được đăng.';
		$txt['edit_category'] = 'Chỉnh sửa danh mục';
		$txt['add_category'] = 'Thêm thể loại';
		$txt['name_of_category'] = 'Tên danh mục:';
		$txt['icon_url'] = 'Icon URL:';
		$txt['button'] = 'Thêm thể loại
';
	}
	
	######################## Forum threads ########################
	elseif($page == 'forum-threads'){
		#Alerts
		$txt['alert_no_name'] = 'Không có tên nào được nhập.';
		$txt['alert_name_too_short'] = 'Tên quá ngắn, ít nhất 3 ký tự.
';
		$txt['alert_name_too_long'] = 'Tên quá dài, tối đa 20 ký tự
.';
		$txt['alert_name_already_taken'] = 'Tên chủ đề đã tồn tại
.';
		$txt['success_add_thread'] = 'Đã tạo thành công một chủ đề
.';
		$txt['success_edit_thread'] = 'Chỉnh sửa thành công chủ đề.
';
		$txt['success_changed_status'] = 'Đã thay đổi thành công trạng thái chủ đề
.';
		
		#Screen
		$txt['pagetitle'] = 'Forum';
		$txt['pokemon-area-forum'] = 'Diễn Đàn PokeMon Việt Nam';
		$txt['#'] = '#';
		$txt['title'] = 'Chủ Đề';
		$txt['maker'] = 'Người tạo';
		$txt['messages'] = 'CMT';
		$txt['last_post'] = 'Bình Luận Cuối';
		$txt['no_threads'] = 'Không có chủ đề nào trong mục này
.';
		$txt['no_last_post'] = 'Chưa có tin nhắn nào
.';
		$txt['open_thread'] = 'Mở Popic
';
		$txt['close_thread'] = 'đóng Topic';
		$txt['edit_thread'] = 'sửa Topic';
		$txt['thread_is_open'] = 'Chủ Đề đã được mở';
		$txt['thread_is_closed'] = 'Chủ đề đã được đóng';
		$txt['add_thread'] = 'Thêm Chủ Đề.';
		$txt['english_topics'] = 'tạo song chủ đề thì vào chủ đề đó cmt nội dung nha bạn.';
		$txt['name_of_thread'] = 'Tên Chủ Đề';
		$txt['button'] = 'Tạo Chủ Đề';
	}
	
	######################## Forum messages ########################
	elseif($page == 'forum-messages'){
		#Alerts
		$txt['alert_no_text'] = 'Bạn chưa nhập nội dung,chưa thể bình luận.';
		$txt['alert_already_send'] = 'Nội dung bạn vừa nhập đã tồn tại..';
		$txt['success_post_message'] = 'Bình luận thành công.';
		$txt['alert_not_admin'] = 'Đừng Bug.';
		$txt['alert_message_doesnt_exist'] = 'Bình luận không tồn tại';
		$txt['success_edit_message'] = 'chỉnh sửa bình luận thành công.';
		$txt['success_message_delete'] = 'Xóa bình luận thành công.';
		
		#Screen
		$txt['pagetitle'] = 'Forum';
		$txt['pokemon-area-forum'] = 'PokeMon Việt Nam';
		$txt['you_must_be_online'] = 'Bạn chỉ bình luận được khi bạn đang trực tuyến';
		$txt['topic_closed'] = '<h2><font color="red">LƯU Ý : không thể bình luận vì chủ đề bài viết này đã bị <strong>đóng</strong>.</font></h2>';
		$txt['please_talk_english'] = 'Vui lòng bình luận có văn hóa,tôn trọng người chơi khác.';
		$txt['no_messages'] = 'Chưa có bình luận';
		$txt['quote_this_message'] = 'Trích bài viết';
		$txt['edit_this_message'] = 'chỉnh sửa bài viết.';
		$txt['delete_this_message'] = 'xóa bài viết';
		$txt['first_login'] = 'Bạn phải đăng nhập.';
		$txt['topic_closed_no_reply'] = 'bạn không thể trích dẫn,bởi vì chủ đề đã được  <strong>ĐÓNG</strong> bởi ADMIN.';
		$txt['colorbox_text'] = 'Open this window again and this message will still be here.';
		$txt['add_message'] = 'Bình Luận';
		$txt['link_text_effects'] = '<u><a href="/codes.php?category=forum" class="colorbox" title="Text effects for forum"><b>ẤN VÀO ĐÂY</b></a></u> để xem cách dẫn ảnh,bbcode.';
		$txt['button'] = 'Đăng';
	}
	
	######################## Beginning ########################
	elseif($page == 'beginning'){
		#Screen
		$txt['pagetitle'] = 'the begin';
		$txt['title_text'] = '
Chào mừng bạn đến với POKEMONZ VIỆT NAM !. <br />
Tên tôi là Professor Oak. <br />
Đây là các quy tắc của DUCNGHIA. <br /> <br />
* Bạn chỉ có thể có một tài khoản. <br />
* Không nguyền rủa người chơi khác. <br />
* Không quảng cáo các trò chơi khác. <br /> <br />
Nếu bạn không đồng ý về các quy tắc này, bạn sẽ bị cấm khỏi trang web.';
		$txt['button']	= 'I understand';
	}
	
	######################## Choose Pokemon ########################
	elseif($page == 'choose-pokemon'){
		#Alerts
		$txt['alert_no_pokemon'] = 'Bạn chưa chọn một pokemon.';
		$txt['alert_pokemon_unknown'] = 'Pokemon mà bạn đã chọn không khả dụng.';
		$txt['success'] = 'Bạn đã đạt được thành công một pokemon từ Professor Oak.hãy tải lại trang !
';
		
		#Screen
		$txt['pagetitle'] = 'Chọn một Pokemon
';
		$txt['title_text'] = 'Được rồi, đủ nói về tất cả các quy tắc. <br /> <br />
Tôi muốn cung cấp cho bạn một pokemon, bởi vì tôi nghĩ bạn đã sẵn sàng. <br />
Dưới đây là danh sách các pokemon mà tôi có sẵn cho bạn.
Chọn cái bạn muốn:';
		$txt['#'] = '#';
		$txt['starter_pokemon'] = 'Pokemon khởi động';
		$txt['normal_pokemon'] = 'Pokemon bình thường
';
		$txt['baby_pokemon'] = 'Baby Pokemon
';
		$txt['starter_name'] = 'Tên người khởi xướng
';
		$txt['type'] = 'Type';
		$txt['normal_name'] = 'Tên thông thường
';
		$txt['baby_name'] = 'Baby Name';
		$txt['no_pokemon_this_world'] = 'Không có Pokemon Baby nào trong thế giới này.
';
		$txt['button']	= 'Chọn';
	}
	
	######################## Error page ########################
	elseif($page == 'error'){
		#Screen
		$txt['pagetitle'] = 'Error';
		$txt['title_text'] = 'Trang không rồn tại.';
	}
	
	######################## Attack Map ########################
	elseif($page == 'attack/attack_map'){
		#Alerts
		$txt['alert_no_fishing_rod'] = 'Để ra đảo bạn cần có cần câu';
		$txt['alert_no_cave_soff'] = 'Bạn không có HM05 Flash.
';
		$txt['alert_error'] = 'Đã xảy ra lỗi. Vui lòng báo cáo sự cố
 <a href=\"?page=send-message&player=Skank\"><b>Tại đây</b></a>.<br />.Đừng quên cung cấp cho chúng tôi khu vực, khu vực và lỗi
: ';
		$txt['alert_no_pokemon'] = 'Pokemon của bạn không có khả năng chiến đấu.
';
		
		#Screen
		$txt['pagetitle'] = 'Chọn một khu vực để khám phá
!';
		$txt['title_text'] = 'Chọn một nơi mà bạn muốn chiến đấu chống lại một pokemon
!';
	}
	
	######################## Attack Gyms ########################
	elseif($page == 'attack/gyms'){
		#Alerts
		$txt['alert_itemplace'] = 'Lưu ý: Bạn không có chỗ trống cho vật phẩm, vì vậy bạn thắng HM nếu bạn là một chiến binh.
';
		$txt['alert_rank_too_less'] = 'Xếp hạng của bạn không đủ cao cho phòng tập thể dục này.
';
		$txt['alert_wrong_world'] = 'Bạn đang ở trong thế giới sai lầm
.';
		$txt['alert_gym_finished'] = 'Bạn đã đánh bại nhà lãnh đạo phòng tập thể dục này.
';
		$txt['alert_no_pokemon'] = 'Bạn không có pokemon
.';
		$txt['begindood'] = "Tất cả pokemon của bạn đã bị loại
.";
		
		#Screen
		$txt['pagetitle'] = 'Gyms';
		$txt['finished'] = 'Đã hoàn thành
';
		$txt['rank_too_less'] = 'Xếp hạng quá thấp
';
		$txt['leader'] = 'Lãnh đạo
:';
		$txt['from_rank'] = 'Từ thứ hạng';
	}
	
	######################## Attack Duel invite ########################
	elseif($page == 'attack/duel/invite'){
		#Alerts
		$txt['alert_not_yourself'] = 'Bạn không thể chiến đấu với chính mình
.';
		$txt['alert_youre_not_premium'] = 'Bạn không phải là một huấn luyện viên cao cấp, vì vậy bạn không thể chiến đấu.
';
		$txt['alert_unknown_amount'] = 'Số tiền không hợp lệ
.';
		$txt['alert_not_enough_silver'] = 'Bạn không có đủ bạc
.';
		$txt['alert_all_pokemon_ko'] = 'Tất cả pokemon của bạn đã ngất đi.';
		$txt['alert_opponent_not_premium'] = 'không phải là thành viên cao cấp.
';
		$txt['alert_opponent_not_in'] = 'không có trong
';
		$txt['alert_opponent_not_traveller'] = 'không có xếp hạng Travellerspoint
.';
		$txt['alert_opponent_duelevent_off'] = 'đã tắt sự kiện đấu
.';
		$txt['alert_opponent_already_fighting'] = 'đã tham gia vào một cuộc chiến.
';
		$txt['waiting_for_accept'] = 'đang bận, đợi cho đến khi anh ấy / cô ấy chấp nhận
.';
		$txt['alert_opponent_no_silver'] = 'Đối thủ của bạn không có tiền
.';
		$txt['alert_opponent_no_health'] = 'Pokemon đối thủ của bạn đều bị loại.
';
		$txt['alert_user_unknown'] = 'Tên đăng nhập không tồn tại.
';
		
		#Screen
		$txt['pagetitle'] = 'Duel';
		$txt['title_text'] = '<p><img src="images/icons/duel.png" /> <strong>Thách thức một huấn luyện viên để đấu
.</strong> <img src="images/icons/duel.png" /><br />
                Huấn luyện viên phải có sẵn
.</p>';
		$txt['player'] = 'tài khoản:';
		$txt['money'] = 'Số Tiền:';
		$txt['button_duel'] = 'Chiến';
	}
	
	######################## Attack Duel invited ########################
	elseif($page == 'attack/duel/invited'){
		#Alerts
		$txt['alert_not_enough_silver'] = 'Bạn không có đủ bạc.';
		$txt['alert_all_pokemon_ko'] = 'Tất cả pokemon của bạn đã ngất xỉu.';
		$txt['success_accepted'] = 'Ybạn đã chấp nhận trận đấu.';
		$txt['success_cancelled'] = 'Bạn đã hủy trận chiến.';
		$txt['alert_too_late'] = 'bạn đã bị thách đấu với một trận đấu. Bạn đã không may là quá muộn.';
		
		#Screen
		$txt['pagetitle'] = 'Huấn luyện viên chiến đấu';
		$txt['dueltext_1'] = 'Trò chơi này có một cam kết:';
		$txt['dueltext_2'] = 'đã thách đấu bạn với một trận đấu.';
		$txt['accept'] = 'CHấp Nhận';
		$txt['cancel'] = 'Không';
	}
	
	######################## Attack Wild ########################
	elseif($page == 'attack/wild/wild-attack'){
		#Screen
		$txt['you_won'] = 'bạn thắng.';
		$txt['you_lost'] = 'bạn thua.';
		$txt['you_lost_1'] = 'bạn thua <img src=\'images/icons/silver.png\' title=\'Silver\'>';
		$txt['you_lost_2'] = '<br><a href=\'?page=pokemoncenter\'>Nhấn vào đây để đến trung tâm pokemon.</a>';
		$txt['you_first_attack'] = 'Bạn là người đầu tiên tấn công.';
		$txt['opponent_first_attack'] = 'đầu tiên tấn công.';
		$txt['opponents_turn'] = 'đối thủ lần lượt.';
		$txt['your_turn'] = 'Đến lượt bạn tấn công!.';
		$txt['have_to_change_1'] = 'bạn';
		$txt['have_to_change_2'] = 'bị loại, bạn phải thay đổi.';
		$txt['next_time_wait'] = 'Đợi đến khi cuộc chiến kết thúc.';
		$txt['fight_finished'] = 'Chiến đấu hơn.';
		$txt['success_catched_1'] = 'bạn có';
		$txt['success_catched_2'] = 'bị cầm tù!';
		$txt['no_item_selected'] = 'Bạn phải chọn một mục!';
		$txt['potion_no_pokemon_selected'] = 'Bạn phải chọn một pokemon!';
		$txt['busy_with_attack'] = 'Đang Tải';
		$txt['have_already'] = 'Bạn đã có';
		$txt['a_wild'] = 'hoang dã';
		$txt['potion_text'] = 'Bạn muốn cung cấp pokemon nào';
		$txt['*'] = '*';
		$txt['pokemon'] = 'Pokemon';
		$txt['level'] = 'Cấp Độ';
		$txt['health'] = 'Máu';
		$txt['potion_egg_text'] = 'Không thể áp dụng';
		$txt['button_potion'] = 'Give';
		$txt['attack'] = 'Tấn Công';
		$txt['change'] = 'Đổi PokeMon';
		$txt['items'] = 'Vật Phẩm';
		$txt['button_item'] = 'Dùng';
		$txt['must_attack'] = 'bạn phải tấn công';
		$txt['is_ko'] = 'đã ngất xỉu.';
		$txt['flinched'] = 'đã nao núng';
		$txt['sleeps'] = 'ngủ.';
		$txt['awake'] = 'tỉnh táo.';
		$txt['frozen'] = 'Đông cứng.';
		$txt['no_frozen'] = 'không còn bị đóng băng.';
		$txt['not_paralyzed'] = 'không còn bị tê liệt.';
		$txt['paralyzed'] = 'bị tê liệt.';
		$txt['fight_over'] = 'Trận chiến kết thúc.';
		$txt['choose_another_pokemon'] = 'Chọn một pokemon khác.';
		$txt['use_attack_1'] = 'đã sử dụng';
		$txt['use_attack_2'] = ', Pokemon của bạn đã ngất xỉu.<br />';
		$txt['use_attack_2_hit'] = ', đánh trực tiếp.';
		$txt['did'] = 'đã sử dụng';
		$txt['hit!'] = ', đánh!';
		$txt['your_attack_turn'] = '<br />Đến lượt bạn tấn công.';
		$txt['opponent_choose_attack'] = 'chọn một cuộc tấn công.';
		
		$txt['pagetitle'] = 'Một con pokemon hoang dã xuất hiện!';
		
		//Start Fight
		$txt['begindood'] = "Tất cả pokemon của bạn đã ngất xỉu!";
		$txt['opponent_error'] = "Lỗi: Không có đối thủ nào được biết đến.";
		
		//Attack General
		$txt['success_catched_1'] = "bạn có ";
		$txt['success_catched_2'] = "bắt. Cuộc chiến kết thúc.";
		$txt['new_pokemon_dead']   = " không còn có thể chiến đấu nữa. Pokemon của bạn đã ngất đi!";
		$txt['not_your_turn'] = " không phải lượt của bạn.";
		
		//Change Pokemon
		$txt['change_block'] = "Bạn không thể thay đổi pokemon của mình!";
		$txt['change_egg']  = "Bạn không thể chuyển sang một quả trứng!";
		$txt['success_change_1']  = "Bạn chuyển đổi pokemon.";
		$txt['success_change_2'] = "bây giờ có thể chiến đấu.";
		$txt['success_change_you_attack'] = "Bạn đã chuyển pokemon. Bây giờ bạn có thể chiến đấu";
		
		//Use Pokeball
		$txt['ball_choose'] = "Chọn một mục mà bạn sở hữu hoặc chiến đấu.";
		$txt['hand_house_full'] = "Bạn không có không gian cho một pokemon mới.";  
		$txt['ball_have'] = "Bạn có một Pokeball.";
		$txt['ball_amount'] = "Bạn không ";
		$txt['ball_throw_1'] = "Bạn ném một ";
		$txt['ball_throw_2'] = ".  ";
		$txt['ball_success'] = "đã bị bắt.";
		$txt['ball_failure'] = " không bị bắt.";
		$txt['ball_success_2'] = " đã được gửi đến nhà bạn.";
		
		//Use potion
		$txt['potion_choose'] = "Chọn một mục mà bạn sở hữu hoặc chiến đấu.";  
		$txt['potion_have'] = "Bạn có một lọ thuốc.";
		$txt['potion_life_full'] = " đã được chữa lành hoàn toàn.";
		$txt['potion_amount'] = "Bạn không ";
		$txt['potion_life_zero_1'] = "bạn có thể ";
		$txt['potion_life_zero_2'] = " không chữa lành";
		$txt['potion_give_1'] = "bạn cung cấp cho";
		$txt['potion_give_2'] = " Một ";
		$txt['potion_give'] = "Bạn sử dụng một ";
		$txt['potion_give_end_1'] = " được chữa khỏi";
		$txt['potion_give_end_2'] = " đã được chữa lành";
		$txt['potion_give_end_3'] = " được hồi sinh";
		
		//Run
		$txt['success_run'] = "Bạn đã thành công bỏ chạy.";
		$txt['failure_run'] = "Bạn không thể chạy trốn khỏi ";
		
		//Function
		$txt['recieve'] = "nhận được";
		$txt['recieve_boost'] = "được tăng cường";
		//$txt['recieve_premium_boost'] = "got boosted exp and";
		$txt['exp_points'] = "kinh nghiệm.";
	} 
  ######################## Trainer Attack ########################
	elseif($page == 'attack/trainer/trainer-attack'){
  	#Screen
		$txt['you_won'] = 'bạn thắng.';
		$txt['you_lost'] = 'bạn thua.';
		$txt['you_lost_1'] = 'bạn thua <img src=\'images/icons/silver.png\' title=\'Silver\'>';
		$txt['you_lost_2'] = '<br><a href=\'?page=pokemoncenter\'>Trung Tâm PokeMon.</a>';
		$txt['you_first_attack'] = 'Bạn là người đầu tiên tấn công.';
		$txt['opponent_first_attack'] = 'đầu tiên tấn công.';
		$txt['opponents_turn'] = 'đối thủ lần lượt.';
		$txt['your_turn'] = 'Đến lượt bạn tấn công!.';
		$txt['have_to_change_1'] = 'bạn';
		$txt['have_to_change_2'] = 'bị loại ra, bạn phải thay đổi.';
		$txt['next_time_wait'] = 'Đợi đến khi cuộc chiến kết thúc.';
		$txt['fight_finished'] = 'Chiến đấu hơn.';
		$txt['success_catched_1'] = 'Bạn có';
		$txt['success_catched_2'] = 'bị cầm tù!';
		$txt['no_item_selected'] = 'Bạn phải chọn một mục!';
		$txt['potion_no_pokemon_selected'] = 'Bạn phải chọn một pokemon!';
		$txt['busy_with_attack'] = 'Đang tải trận chiến';
		$txt['have_already'] = 'Bạn đã có một';
		$txt['a_wild'] = 'hoang dã';
		$txt['potion_text'] = 'Bạn muốn cung cấp pokemon nào';
		$txt['*'] = '*';
		$txt['pokemon'] = 'Pokemon';
		$txt['level'] = 'Level';
		$txt['health'] = 'HP';
		$txt['potion_egg_text'] = 'Không thể áp dụng';
		$txt['button_potion'] = 'đưa cho';
		$txt['attack'] = 'Tấn Công';
		$txt['change'] = 'Chọn PokeMon';
		$txt['items'] = 'Vật Phẩm';
		$txt['button_item'] = 'Dùng';
		$txt['must_attack'] = 'bạn phải tấn công';
		$txt['is_ko'] = 'has fainted.';
		$txt['flinched'] = 'đã nao núng';
		$txt['sleeps'] = 'Ngủ.';
		$txt['awake'] = 'tỉnh táo.';
		$txt['frozen'] = 'Đông cứng.';
		$txt['no_frozen'] = 'không còn bị đóng băng.';
		$txt['not_paralyzed'] = 'không còn bị tê liệt.';
		$txt['paralyzed'] = 'bị tê liệt.';
		$txt['fight_over'] = 'Trận chiến kết thúc.';
		$txt['choose_another_pokemon'] = 'Chọn một pokemon khác.';
		$txt['use_attack_1'] = 'Đã Dùng';
		$txt['use_attack_2'] = ',pokemon của bạn đã ngất xỉu.<br />';
		$txt['use_attack_2_hit'] = ', đánh trực tiếp.';
		$txt['did'] = 'đã sử dụng';
		$txt['hit!'] = ', đánh!';
		$txt['your_attack_turn'] = '<br />Đến lượt bạn tấn công.';
		$txt['opponent_choose_attack'] = 'chọn một cuộc tấn công.';
		$txt['start_0'] = "bạn đến ";
		$txt['start_1'] = " off.";
		$txt['appears'] = " xuất hiện.";
		$txt['defeated_1'] = "Bạn đã đánh bại";
		$txt['defeated_2'] = "bạn lấy ";
		$txt['defeated_masterball'] = '';
		$txt['get_badge_1'] = '';
		$txt['get_badge_2'] = '';
		$txt['no_badgecase'] = '';
		$txt['has_defeated_you_1'] = 'đánh bại bạn.';
		$txt['has_defeated_you_2'] = ' Anh ta / cô ấy đánh cắp ';
		$txt['bringed'] = 'mang lại';
		                     
		$txt['pagetitle'] = 'Huấn luyện viên';
		
		//Start Fight
		$txt['begindood'] = "Tất cả pokemon của bạn đã ngất xỉu.";
		$txt['opponent_error'] = "Lỗi: Không có đối thủ nào được biết.";
		
		//Attack General
		$txt['new_pokemon_dead']   = " không còn có thể chiến đấu nữa. Pokemon của bạn đã ngất xỉu!";
		$txt['not_your_turn'] = " không phải lượt của bạn.";
		
		//Change Pokemon
		$txt['change_block'] = "Bạn không thể thay đổi pokemon của mình!";
		$txt['change_egg']  = "Bạn không thể chuyển sang một quả trứng!";
		$txt['success_change_1']  = "Bạn chuyển đổi pokemon.";
		$txt['success_change_2'] = "bây giờ có thể thay đổi.";
		$txt['success_change_you_attack'] = "Bạn đã chuyển pokemon. Bây giờ bạn có thể chiến đấu";
			
		//Use potion
		$txt['potion_choose'] = "Chọn một mục mà bạn sở hữu hoặc chiến đấu.";  
		$txt['potion_have'] = "Bạn có một lọ thuốc.";
		$txt['potion_life_full'] = " đã được chữa lành hoàn toàn.";
		$txt['potion_amount'] = "Bạn không ";
		$txt['potion_life_zero_1'] = "bạn có thể ";
		$txt['potion_life_zero_2'] = " không chữa lành";
		$txt['potion_give_1'] = "không chữa lành ";
		$txt['potion_give_2'] = " một ";
		$txt['potion_give'] = "Bạn sử dụng một ";
		$txt['potion_give_end_1'] = " được chữa khỏi";
		$txt['potion_give_end_2'] = " đã được chữa lành";
		$txt['potion_give_end_3'] = " được hồi sinh";
				
		//Function
		$txt['recieve'] = "nhận được";
		$txt['recieve_boost'] = "được tăng cường";
		$txt['exp_points'] = "kinh nghiệm.";
  }
  
    	elseif($page == 'clans' or $page == 'clan-make'){
	######################## Clan texten ########################
	
	$txt['no_clans'] = "Chúng tôi không thể tìm thấy Clan, <a href='?page=clan-make'> Hãy là người đầu tiên và tạo clan!</a>";
	$txt['Clan_Maker'] = "Xin chào, Chào mừng bạn đến với trang sáng lập clan";
  }	
  
  
	######################## Attack Duel ########################
	elseif($page == 'attack/duel/duel-attack'){
		#Screen
		$txt['a_boosted'] = 'có một tăng';
		$txt['exp_points'] = "điểm exp.";
		$txt['recieve'] = 'nhận được';
		$txt['too_late_lost'] = 'Bạn đã quá muộn! Bạn thua!';
		$txt['you_won_dus'] = 'Bạn đã thắng!';
		
		$txt['you_won'] = 'bạn thắng.';
		$txt['you_lost'] = 'bạn thua.';
		$txt['you_lost_1'] = 'bạn thua <img src=\'images/icons/silver.png\' title=\'Silver\'>';
		$txt['you_lost_2'] = '<br><a href=\'?page=pokemoncenter\'>về trung tâm PokeMon.</a>';
		$txt['you_first_attack'] = 'Bạn là người đầu tiên tấn công.';
		$txt['opponent_first_attack'] = 'đầu tiên tấn công.';
		$txt['opponents_turn'] = 'đối thủ lần lượt.';
		$txt['your_turn'] = 'Đến lượt bạn tấn công!.';
		$txt['have_to_change_1'] = 'bạn';
		$txt['have_to_change_2'] = 'bị loại, bạn phải thay đổi.';
		$txt['next_time_wait'] = 'Đợi đến khi cuộc chiến kết thúc.';
		$txt['fight_finished'] = 'Chiến đấu hơn.';
		$txt['success_catched_1'] = 'bạn có';
		$txt['success_catched_2'] = 'bị cầm tù!';
		$txt['no_item_selected'] = 'Bạn phải chọn một mục!';
		$txt['potion_no_pokemon_selected'] = 'Bạn phải chọn một pokemon!';
		$txt['busy_with_attack'] = 'Đang Tải';
		$txt['have_already'] = 'Bạn đã có một';
		$txt['potion_text'] = 'Bạn muốn cung cấp pokemon nào';
		$txt['*'] = '*';
		$txt['pokemon'] = 'Pokemon';
		$txt['level'] = 'Level';
		$txt['health'] = 'Hp';
		$txt['potion_egg_text'] = 'Không thể áp dụng';
		$txt['button_potion'] = 'Đưa cho';
		$txt['attack'] = 'Tấn Công';
		$txt['change'] = 'Đổi PokeMon';
		$txt['items'] = 'Vật Phẩm';
		$txt['button_item'] = 'Dùng';
		$txt['must_attack'] = 'bạn phải tấn công';
		$txt['is_ko'] = 'đã ngất xỉu.';
		$txt['flinched'] = 'đã nao núng';
		$txt['sleeps'] = 'ngủ.';
		$txt['awake'] = 'tỉnh táo.';
		$txt['frozen'] = 'Đóng băng.';
		$txt['no_frozen'] = 'không đóng băng.';
		$txt['not_paralyzed'] = 'không còn bị tê liệt.';
		$txt['paralyzed'] = 'bị tê liệt.';
		$txt['fight_over'] = 'Trận chiến kết thúc.';
		$txt['choose_another_pokemon'] = 'Chọn một pokemon khác.';
		$txt['use_attack_1'] = 'Đã sử dụng';
		$txt['use_attack_2'] = ', your pokemon has fainted.<br />';
		$txt['use_attack_2_hit'] = ', đánh trực tiếp.';
		$txt['did'] = 'đã sử dụng';
		$txt['hit!'] = ', đánh!';
		$txt['your_attack_turn'] = '<br />Đến lượt bạn tấn công.';
		$txt['opponent_choose_attack'] = 'chọn một cuộc tấn công.';
		$txt['opponent_choose_pokemon'] = 'chọn một pokemon.';
		
		$txt['pagetitle'] = 'Trận chiến huấn luyện viên';
	}
?>