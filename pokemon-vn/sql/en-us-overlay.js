(function () {
    "use strict";

    if (window.PokemonEnglishOverlay && window.PokemonEnglishOverlay.active) {
        return;
    }

    var exact = {
        "PokeMon Việt Nam": "Pokemon Vietnam",
        "PokeMon Viá»‡t Nam": "Pokemon Vietnam",
        "Đang tải dữ liệu trò chơi.": "Loading game data.",
        "Äang táº£i dá»¯ liá»‡u trÃ² chÆ¡i.": "Loading game data.",
        "Nhập nội dung...": "Type a message...",
        "Nháº­p ná»™i dung...": "Type a message...",
        "Đóng": "Close",
        "ÄÃ³ng": "Close",
        "Cài đặt": "Settings",
        "Hướng Dẫn": "Guide",
        "Trò Chuyện": "Chat",
        "Đang gửi.....": "Sending.....",
        "Đang nạp xin chờ...": "Loading, please wait...",
        "Đang tải bản đồ ...": "Loading map...",
        "Đang Tải Dữ Liệu...": "Loading data...",
        "Đang Kết Nối Máy Chủ ...": "Connecting to server...",
        "Xin chờ ....": "Please wait...",
        "Chào mừng bạn quay lại.": "Welcome back.",
        "mat ket noi toi may chu...Vui Long dang nhap lai": "Connection to the server was lost. Please log in again.",
        "Bị mất kết nối tới máy chủ PokeMon - Mời đăng nhập lại..": "Connection to the Pokemon server was lost. Please log in again.",
        "Lâu quá? Hãy Tải lại trang.": "Taking too long? Reload the page.",
        "Vui lòng nói chuyện văn minh,không quảng cáo,spam cám ơn.": "Please chat respectfully. No ads or spam. Thank you.",
        "Chỉ những người chơi trong bản đồ mới thấy bạn chát": "Only players on this map can see your message.",
        "Muốn PVP với bạn ?": "Wants to PVP with you?",
        "Chấp Nhận": "Accept",
        "Từ chối": "Decline",
        "Xin hãy viết dài hơn.": "Please write a longer message.",
        "CHƠI MỚI": "NEW GAME",
        "VÀO GAME": "ENTER GAME",
        "ĐĂNG NHẬP": "LOG IN",
        "Tên đăng nhập": "Username",
        "Mật khẩu": "Password",
        "Chưa có tài khoản ?": "No account yet?",
        "Tên N.Vật :": "Character Name:",
        "Đăng nhập thành công": "Login successful",
        "Tài khoản hoặc mật khẩu chưa chính xác.": "Account or password is incorrect.",
        "CHƯA ĐỌC": "UNREAD",
        "CŨ HƠN": "OLDER",
        "ĐỔI TÀI KHOẢN": "SWITCH ACCOUNT",
        "Liên kết tài khoản": "Link account",
        "Tài Khoản": "Account",
        "Đăng kí": "Register",
        "Đã vào room chat !": "Joined the chat room!",
        "Đạt cấp 2 mới có thể chát.": "You must reach level 2 to chat.",
        "Bạn muốn mua gì nào ?": "What would you like to buy?",
        "Bạn chưa đủ tiền để mua.": "You do not have enough money to buy this.",
        "Bạn không đủ tiền.": "You do not have enough money.",
        "Mua thành công.": "Purchase successful.",
        "Nhận pokemon thành công.": "Pokemon received successfully.",
        "Bạn đã nhận pokemon rồi.": "You have already received this Pokemon.",
        "Lỗi": "Error",
        "Lỗi.": "Error.",
        "lỗi rồi": "Something went wrong.",
        "Thành công :3": "Success :3",
        "Cửa hàng": "Shop",
        "KHÔNG BÁN": "NOT FOR SALE",
        "Giá bán": "Price",
        "Mua thành công.Cám ơn bạn đã ghé thăm.": "Purchase successful. Thanks for visiting.",
        "Nhận nhiệm vụ thành công.": "Quest accepted successfully.",
        "Nhận nhiệm vụ": "Accept Quest",
        "Tạm thời chưa có nhiệm vụ...": "No quests available right now...",
        "Bạn thắng.": "You win.",
        "bạn chiến thắng.": "You win.",
        "PokeMon bạn tấn công đầu tiên": "Your Pokemon attacks first.",
        "đến lượt pokemon bạn tấn công": "It is your Pokemon's turn.",
        "kết thúc trận đấu,xin chờ.": "Battle ended, please wait.",
        "trận đấu kết thúc xin chờ.": "Battle ended, please wait.",
        "Đang tải trận chiến.": "Loading battle...",
        "Vui lòng tới bệnh viện.": "Please go to the hospital.",
        "Hãy tới bệnh viện": "Please go to the hospital.",
        "Bắt pokemon thành công": "Pokemon caught successfully.",
        "Pokemon bạn đã kiệt sức.": "Your Pokemon is exhausted.",
        "Bạn phải đạt cấp 3.": "You must reach level 3.",
        "Bạn phải đạt trình độ 15 trở lên.": "You must be level 15 or higher.",
        "Đổi tên": "Rename",
        "Đổi Tên": "Rename",
        "Đổi Tên Thành Công...": "Rename successful...",
        "Đổi mật khẩu": "Change Password",
        "Gửi thư": "Send Message",
        "Cấp bậc": "Rank",
        "Thắng": "Wins",
        "Thua": "Losses",
        "Tổng trận": "Total Battles",
        "Đội hình": "Team",
        "Hành động": "Action",
        "Không có PokeMon nào trong nhà": "There are no Pokemon in the house.",
        "Tắt âm thanh thành công,vui lòng tải lại game.": "Sound turned off successfully. Please reload the game.",
        "Bật âm thanh thành công,vui lòng tải lại game.": "Sound turned on successfully. Please reload the game.",
        "Phiên bản thử nghiệm không có tính năng này.": "This trial version does not include this feature.",
        "Nâng cấp phiên bản vui lòng liên hệ": "Please contact support to upgrade.",
        "Người trên bản đồ": "Players on this map",
        "FIX GÓC KẸT": "STUCK FIX",
        "Hiện Bàn Phím Ảo": "Show virtual keyboard",
        "Thị Trấn Gió": "Wind Town",
        "Tầng 2 - Nhà": "Floor 2 - House",
        "Mẹ": "Mom",
        "Trưởng Làng": "Village Elder",
        "Nghĩa": "Nghia"
    };

    var replacements = [
        ["PokeMon Việt Nam", "Pokemon Vietnam"],
        ["PokeMon Viá»‡t Nam", "Pokemon Vietnam"],
        ["Đang tải dữ liệu trò chơi.", "Loading game data."],
        ["Äang táº£i dá»¯ liá»‡u trÃ² chÆ¡i.", "Loading game data."],
        ["Nhập nội dung...", "Type a message..."],
        ["Nháº­p ná»™i dung...", "Type a message..."],
        ["Vui lòng nói chuyện văn minh,không quảng cáo,spam cám ơn.", "Please chat respectfully. No ads or spam. Thank you."],
        ["Vui lòng nói chuyện văn minh", "Please chat respectfully"],
        ["không quảng cáo", "no ads"],
        ["cám ơn", "thank you"],
        ["Chỉ những người chơi trong bản đồ mới thấy bạn chát", "Only players on this map can see your message"],
        ["Xin hãy viết dài hơn.", "Please write a longer message."],
        ["Muốn PVP với bạn ?", "Wants to PVP with you?"],
        ["Chấp Nhận", "Accept"],
        ["Từ chối", "Decline"],
        ["Bị mất kết nối tới máy chủ PokeMon - Mời đăng nhập lại..", "Connection to the Pokemon server was lost. Please log in again."],
        ["mat ket noi toi may chu...Vui Long dang nhap lai", "Connection to the server was lost. Please log in again."],
        ["Lâu quá? Hãy Tải lại trang.", "Taking too long? Reload the page."],
        ["Đang Tải Dữ Liệu...", "Loading data..."],
        ["Đang tải bản đồ ...", "Loading map..."],
        ["Đang tải dữ liệu....", "Loading data..."],
        ["Đang tải .....", "Loading..."],
        ["Đang tải", "Loading"],
        ["Đang gửi", "Sending"],
        ["Đang nạp xin chờ", "Loading, please wait"],
        ["Đang Kết Nối Máy Chủ", "Connecting to server"],
        ["Đang Kết Nối", "Connecting"],
        ["Lấy dữ liệu thành công,Đang Kết Nối...", "Data loaded, connecting..."],
        ["Xin chờ", "Please wait"],
        ["Chào mừng bạn quay lại.", "Welcome back."],
        ["Tuyệt đối không thoát !", "Please do not exit!"],
        ["Thao tác thành công", "Action successful"],
        ["Thao tác không thành công", "Action failed"],
        ["Có lỗi xảy ra", "An error occurred"],
        ["Hãy ghi rõ lý do", "Please write a clear reason"],
        ["Nếu không hiển thị hãy thử reload lại", "If it does not appear, try reloading"],
        ["Cài đặt", "Settings"],
        ["Cài Kĩ năng tự động", "Set auto skill"],
        ["Hướng Dẫn", "Guide"],
        ["Trò Chuyện", "Chat"],
        ["Đóng", "Close"],
        ["ÄÃ³ng", "Close"],
        ["CHƠI MỚI", "NEW GAME"],
        ["VÀO GAME", "ENTER GAME"],
        ["ĐĂNG NHẬP", "LOG IN"],
        ["Tên đăng nhập", "Username"],
        ["Mật khẩu", "Password"],
        ["Chưa có tài khoản ?", "No account yet?"],
        ["Tên N.Vật :", "Character Name:"],
        ["Tên nhân vật", "Character name"],
        ["Tài khoản", "Account"],
        ["Tài Khoản", "Account"],
        ["Đăng nhập thành công", "Login successful"],
        ["Đăng nhập", "Log in"],
        ["Đăng kí", "Register"],
        ["Tài khoản hoặc mật khẩu chưa chính xác.", "Account or password is incorrect."],
        ["Tài khoản của bạn bị khóa", "Your account is locked"],
        ["Tài khoản đã được đăng kí bởi người chơi khác.", "This account has already been registered by another player."],
        ["Tên nhận vật đã xác minh rồi.", "This character has already been verified."],
        ["Chơi thử thành công", "Trial play successful"],
        ["Hãy sử dụng các phím lên xuống để di chuyên", "Use the arrow keys to move"],
        ["Chúc các bạn có chuyến phưu lưu vui vẻ.", "Have a great adventure."],
        ["Trò chơi dành cho người 12+", "This game is for ages 12+"],
        ["Chơi quá 180 phút sẽ có hại cho sức khỏe.", "Playing more than 180 minutes can be harmful to your health."],
        ["CHƯA ĐỌC", "UNREAD"],
        ["CŨ HƠN", "OLDER"],
        ["ĐỔI TÀI KHOẢN", "SWITCH ACCOUNT"],
        ["Liên kết tài khoản", "Link account"],
        ["Đã vào room chat !", "Joined the chat room!"],
        ["Đạt cấp 2 mới có thể chát.", "You must reach level 2 to chat."],
        ["bạn đã là bạn bè với người này rồi.", "You are already friends with this player."],
        ["Đã loại bỏ người chơi này ra khỏi danh sách.", "Removed this player from the list."],
        ["Bạn muốn mua gì nào ?", "What would you like to buy?"],
        ["Bạn muốn mua gì ?", "What would you like to buy?"],
        ["Bạn muốn mua gì", "What would you like to buy"],
        ["Bạn chưa đủ tiền để mua.", "You do not have enough money to buy this."],
        ["Bạn không đủ tiền.", "You do not have enough money."],
        ["Bạn không đủ tiền", "You do not have enough money"],
        ["Anh không đủ 40 bạc", "You do not have enough silver"],
        ["Mua thành công.Cám ơn bạn đã ghé thăm.", "Purchase successful. Thanks for visiting."],
        ["Mua thành công.", "Purchase successful."],
        ["Nhận pokemon thành công.", "Pokemon received successfully."],
        ["Bạn đã nhận pokemon rồi.", "You have already received this Pokemon."],
        ["Cửa hàng chúng tôi không có vật phẩm này", "Our shop does not have this item."],
        ["Cửa hàng", "Shop"],
        ["KHÔNG BÁN", "NOT FOR SALE"],
        ["Giá bán", "Price"],
        ["lỗi rồi", "Something went wrong"],
        ["Lỗi", "Error"],
        ["lỗi", "error"],
        ["Thành công", "Success"],
        ["Thất bại", "Failed"],
        ["Bạn chưa có carot.", "You do not have any carrots."],
        ["Bạn chưa có đủ điểm sự kiện", "You do not have enough event points"],
        ["Đổi quà thành công", "Gift exchange successful"],
        ["Bạn có muốn đổi vật phẩm này không ?", "Do you want to exchange this item?"],
        ["Đổi Quà", "Exchange Gifts"],
        ["Đổi quà", "Exchange Gift"],
        ["Đổi thành công", "Exchange successful"],
        ["Đổi", "Exchange"],
        ["Chưa nhập số lượng", "Quantity not entered"],
        ["Vui lòng nhập số lượng hợp lệ", "Please enter a valid quantity"],
        ["Vui lòng nhập số lượng", "Please enter a quantity"],
        ["bạn chưa đủ nguyên liệu nhé.", "You do not have enough materials."],
        ["Bạn nhận được", "You received"],
        ["điểm sự kiện", "event points"],
        ["Lồng đèn", "lanterns"],
        ["xu", "coins"],
        ["bạc", "silver"],
        ["ruby", "rubies"],
        ["carot", "carrot"],
        ["Bạn thắng.", "You win."],
        ["bạn chiến thắng.", "You win."],
        ["PokeMon bạn tấn công đầu tiên", "Your Pokemon attacks first."],
        ["đến lượt pokemon bạn tấn công", "It is your Pokemon's turn."],
        ["Đến lượt bạn tấn công", "It is your turn to attack."],
        ["tới lượt bạn", "your turn"],
        ["tới bạn", "your turn"],
        ["kết thúc trận đấu,xin chờ.", "Battle ended, please wait."],
        ["trận đấu kết thúc xin chờ.", "Battle ended, please wait."],
        ["Đang tải trận chiến.", "Loading battle..."],
        ["đã ngất xỉu", "fainted"],
        ["đã sử dụng", "used"],
        ["đánh trực tiếp", "hit directly"],
        ["không còn bị nhầm lẫn", "is no longer confused"],
        ["Không còn bị bối rối", "is no longer confused"],
        ["không còn Đóng băng", "is no longer frozen"],
        ["không còn tê liệt", "is no longer paralyzed"],
        ["đã bị đánh bại", "was defeated"],
        ["đã tự sát", "knocked itself out"],
        ["Tấn công", "Attack"],
        ["tấn công", "attack"],
        ["phòng thủ", "defense"],
        ["Phòng thủ", "Defense"],
        ["Giảm tốc độ", "Speed decreased"],
        ["Vui lòng tới bệnh viện.", "Please go to the hospital."],
        ["Hãy tới bệnh viện", "Please go to the hospital"],
        ["Bắt pokemon thành công", "Pokemon caught successfully"],
        ["Pokemon bạn đã kiệt sức.", "Your Pokemon is exhausted."],
        ["Bạn phải đạt trình độ cấp", "You must reach level"],
        ["để có thể khiêu chiến với người này.", "to challenge this player."],
        ["Bạn phải đạt cấp 3.", "You must reach level 3."],
        ["Bạn phải đạt trình độ 15 trở lên.", "You must be level 15 or higher."],
        ["Toàn bộ pokemon , của anh đã được hồi phục.", "All of your Pokemon have been restored."],
        ["Boss đã bị tiêu diệt", "The boss has been defeated"],
        ["LIÊN KẾT TÀI KHOẢN", "LINK ACCOUNT"],
        ["Dẫn về", "Return"],
        ["Dùng để học kĩ năng mới cho PokeMon", "Used to teach a new skill to a Pokemon"],
        ["Đổi tên", "Rename"],
        ["Đổi Tên", "Rename"],
        ["Đổi Tên Thành Công", "Rename successful"],
        ["Bạn không có item này để sử dụng", "You do not have this item to use"],
        ["PokeMon được tăng một cấp.", "Pokemon leveled up."],
        ["PokeMon đã đạt cấp 100,không thể dùng.", "Pokemon is already level 100 and cannot be used."],
        ["PokeMon đã học được chiêu thức mới.", "Pokemon learned a new move."],
        ["Chỉ là quả trứng ?", "Just an egg?"],
        ["Bạn làm đéo gì có PokeMon này ? bug cái lồn gì zậy ?", "You do not own this Pokemon."],
        ["Địt nhau à ?", "What are you doing?"],
        ["Đã có 6 PokeMon mang theo trên người.", "You already have 6 Pokemon with you."],
        ["Pokemon này đang được đăng bán trên chợ rồi.", "This Pokemon is already listed on the market."],
        ["Đã cho PokeMon ra trận.", "Pokemon sent into battle."],
        ["Pokemon khởi đầu không thể thả.", "Starter Pokemon cannot be released."],
        ["Đổi mật khẩu", "Change Password"],
        ["Gửi thư", "Send Message"],
        ["Cấp bậc", "Rank"],
        ["Thắng", "Wins"],
        ["Thua", "Losses"],
        ["Tổng trận", "Total Battles"],
        ["Đội hình", "Team"],
        ["Hành động", "Action"],
        ["Vui lòng nhập mật khẩu mới nếu muốn đổi mật khẩu.", "Please enter a new password if you want to change it."],
        ["Không có PokeMon nào trong nhà", "There are no Pokemon in the house."],
        ["Tắt âm thanh thành công,vui lòng tải lại game.", "Sound turned off successfully. Please reload the game."],
        ["Bật âm thanh thành công,vui lòng tải lại game.", "Sound turned on successfully. Please reload the game."],
        ["Phiên bản thử nghiệm không có tính năng này.", "This trial version does not include this feature."],
        ["Nâng cấp phiên bản vui lòng liên hệ", "Please contact support to upgrade"],
        ["BẠN CHƯA DỦ QUYỀN", "YOU DO NOT HAVE PERMISSION"],
        ["bạn muốn làm gì", "What would you like to do?"],
        ["Danh sách bản đồ", "Map list"],
        ["DAnh sách ID NPC", "NPC ID List"],
        ["Sao chép NPC", "Copy NPC"],
        ["Thêm Battel", "Add Battle"],
        ["Khóa nick", "Lock account"],
        ["Đứng im", "Stand still"],
        ["Di chuyển", "Move"],
        ["Giao tiếp", "Interact"],
        ["Sửa", "Edit"],
        ["Xóa", "Delete"],
        ["Xem thử", "Preview"],
        ["Lưu", "Save"],
        ["TÊN NPC:", "NPC Name:"],
        ["Nội dung giao tiếp:", "Dialogue content:"],
        ["Nội dung:", "Content:"],
        ["Sai mã bảo mật", "Invalid security code"],
        ["Nạp thẻ thành công mệnh giá", "Top-up successful for denomination"],
        ["xin chúc mừng bạn đã lên cấp.", "Congratulations, you have leveled up."],
        ["cho đến khi trứng nở", "until the egg hatches"],
        ["Người trên bản đồ", "Players on this map"],
        ["FIX GÓC KẸT", "STUCK FIX"],
        ["Hiện Bàn Phím Ảo", "Show virtual keyboard"],
        ["Tầng 2 - Nhà", "Floor 2 - House"],
        ["Thị Trấn Gió", "Wind Town"],
        ["Tầng", "Floor"],
        ["Nhà", "House"],
        ["Mẹ", "Mom"],
        ["Trưởng Làng", "Village Elder"],
        ["Ngoài kia là cả một thế giới rộng lớn", "There is a vast world out there"],
        ["bạn có chắc muốn nhận pokemon này không ?", "Are you sure you want to receive this Pokemon?"],
        ["Xin chào", "Hello"],
        ["Không", "No"],
        ["không", "not"],
        ["Bạn", "You"],
        ["bạn", "you"]
    ];

    function replaceAllText(text) {
        if (text === null || text === undefined) return text;
        var value = String(text);
        if (!value) return value;
        var trimmed = value.trim();
        if (exact[trimmed]) return value.replace(trimmed, exact[trimmed]);
        var translated = value;
        for (var i = 0; i < replacements.length; i++) {
            translated = translated.split(replacements[i][0]).join(replacements[i][1]);
        }
        return translated;
    }

    function translateAttributes(node) {
        if (!node || node.nodeType !== 1) return;
        var attrs = ["placeholder", "title", "alt", "aria-label"];
        for (var i = 0; i < attrs.length; i++) {
            var attr = attrs[i];
            if (node.hasAttribute && node.hasAttribute(attr)) {
                var before = node.getAttribute(attr);
                var after = replaceAllText(before);
                if (after !== before) node.setAttribute(attr, after);
            }
        }
        if (node.hasAttribute && node.hasAttribute("value")) {
            var type = (node.getAttribute("type") || "").toLowerCase();
            if (type === "button" || type === "submit" || type === "reset") {
                var valueBefore = node.getAttribute("value");
                var valueAfter = replaceAllText(valueBefore);
                if (valueAfter !== valueBefore) node.setAttribute("value", valueAfter);
            }
        }
    }

    function shouldSkip(node) {
        return !!(node && node.nodeName && /^(SCRIPT|STYLE|TEXTAREA|CODE|PRE)$/i.test(node.nodeName));
    }

    function translateDom(root) {
        if (!root || shouldSkip(root)) return;
        if (root.nodeType === 3) {
            var oldText = root.nodeValue;
            var newText = replaceAllText(oldText);
            if (newText !== oldText) root.nodeValue = newText;
            return;
        }
        if (root.nodeType !== 1 && root.nodeType !== 9 && root.nodeType !== 11) return;
        if (root.nodeType === 1) translateAttributes(root);
        var walker = document.createTreeWalker(root, NodeFilter.SHOW_ELEMENT | NodeFilter.SHOW_TEXT, {
            acceptNode: function (node) {
                if (node.nodeType === 1 && shouldSkip(node)) return NodeFilter.FILTER_REJECT;
                return NodeFilter.FILTER_ACCEPT;
            }
        });
        var current;
        while ((current = walker.nextNode())) {
            if (current.nodeType === 3) {
                var before = current.nodeValue;
                var after = replaceAllText(before);
                if (after !== before) current.nodeValue = after;
            } else if (current.nodeType === 1) {
                translateAttributes(current);
            }
        }
    }

    function patchCanvas() {
        var proto = window.CanvasRenderingContext2D && window.CanvasRenderingContext2D.prototype;
        if (!proto || proto.__pokemonEnglishPatched) return;
        ["fillText", "strokeText"].forEach(function (method) {
            var original = proto[method];
            if (typeof original !== "function") return;
            proto[method] = function (text) {
                arguments[0] = replaceAllText(text);
                return original.apply(this, arguments);
            };
        });
        proto.__pokemonEnglishPatched = true;
    }

    function patchWindowDialogs() {
        ["alert", "confirm", "prompt"].forEach(function (name) {
            var original = window[name];
            if (typeof original !== "function" || original.__pokemonEnglishPatched) return;
            window[name] = function () {
                if (arguments.length > 0) arguments[0] = replaceAllText(arguments[0]);
                return original.apply(this, arguments);
            };
            window[name].__pokemonEnglishPatched = true;
        });
    }

    function patchNamedFunctions() {
        ["notice", "GDloading", "setdrawn", "GDnotice"].forEach(function (name) {
            var original = window[name];
            if (typeof original !== "function" || original.__pokemonEnglishPatched) return;
            window[name] = function () {
                for (var i = 0; i < arguments.length; i++) {
                    if (typeof arguments[i] === "string") arguments[i] = replaceAllText(arguments[i]);
                }
                return original.apply(this, arguments);
            };
            window[name].__pokemonEnglishPatched = true;
        });
    }

    function patchJquery() {
        var $ = window.jQuery || window.$;
        if (!$ || !$.fn || $.fn.__pokemonEnglishPatched) return;
        ["html", "text", "append", "prepend", "before", "after"].forEach(function (name) {
            var original = $.fn[name];
            if (typeof original !== "function") return;
            $.fn[name] = function () {
                if (arguments.length > 0) {
                    for (var i = 0; i < arguments.length; i++) {
                        if (typeof arguments[i] === "string") arguments[i] = replaceAllText(arguments[i]);
                    }
                }
                return original.apply(this, arguments);
            };
        });
        var attrOriginal = $.fn.attr;
        if (typeof attrOriginal === "function") {
            $.fn.attr = function (name, value) {
                if (typeof name === "string" && typeof value === "string" && /^(placeholder|title|alt|aria-label)$/i.test(name)) {
                    value = replaceAllText(value);
                }
                return attrOriginal.apply(this, arguments);
            };
        }
        $.fn.__pokemonEnglishPatched = true;
    }

    function startObserver() {
        if (!document.body || window.__pokemonEnglishObserverStarted) return;
        window.__pokemonEnglishObserverStarted = true;
        translateDom(document.body);
        var observer = new MutationObserver(function (mutations) {
            for (var i = 0; i < mutations.length; i++) {
                var mutation = mutations[i];
                for (var j = 0; j < mutation.addedNodes.length; j++) translateDom(mutation.addedNodes[j]);
                if (mutation.type === "characterData") translateDom(mutation.target);
            }
        });
        observer.observe(document.body, { childList: true, subtree: true, characterData: true });
    }

    function boot() {
        patchCanvas();
        patchWindowDialogs();
        patchNamedFunctions();
        patchJquery();
        startObserver();
    }

    var attempts = 0;
    var timer = setInterval(function () {
        attempts++;
        boot();
        if (attempts > 80) clearInterval(timer);
    }, 250);

    if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
    else boot();

    window.PokemonEnglishOverlay = {
        active: true,
        translate: replaceAllText,
        translateDom: translateDom
    };
})();