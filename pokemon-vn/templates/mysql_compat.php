<?php
/*
 * Local proof-of-concept compatibility layer.
 *
 * The original Pokemon source uses the removed PHP mysql_* extension.
 * Laragon currently runs PHP 8.x, so these wrappers map the old calls to
 * mysqli without changing hundreds of legacy gameplay files at once.
 */

if (!defined('POKEMON_MYSQL_COMPAT')) {
    define('POKEMON_MYSQL_COMPAT', true);
}

if (!defined('MYSQL_ASSOC')) {
    define('MYSQL_ASSOC', MYSQLI_ASSOC);
}
if (!defined('MYSQL_NUM')) {
    define('MYSQL_NUM', MYSQLI_NUM);
}
if (!defined('MYSQL_BOTH')) {
    define('MYSQL_BOTH', MYSQLI_BOTH);
}

$GLOBALS['__pokemon_mysql_link'] = $GLOBALS['__pokemon_mysql_link'] ?? null;

function pokemon_mysql_link($link = null)
{
    if ($link instanceof mysqli) {
        return $link;
    }

    return ($GLOBALS['__pokemon_mysql_link'] instanceof mysqli)
        ? $GLOBALS['__pokemon_mysql_link']
        : null;
}

if (!function_exists('mysql_connect')) {
    function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0)
    {
        $server = $server ?: 'localhost';
        $username = $username ?? '';
        $password = $password ?? '';

        $mysqli = @mysqli_connect($server, $username, $password);
        if (!$mysqli) {
            return false;
        }

        @mysqli_set_charset($mysqli, 'utf8mb4');
        @mysqli_query($mysqli, "SET SESSION sql_mode=''");
        $GLOBALS['__pokemon_mysql_link'] = $mysqli;

        return $mysqli;
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database_name, $link_identifier = null)
    {
        $link = pokemon_mysql_link($link_identifier);
        return $link ? @mysqli_select_db($link, $database_name) : false;
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link_identifier = null)
    {
        $link = pokemon_mysql_link($link_identifier);
        return $link ? @mysqli_query($link, $query) : false;
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result)
    {
        return ($result instanceof mysqli_result) ? mysqli_fetch_assoc($result) : false;
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
    {
        return ($result instanceof mysqli_result) ? mysqli_fetch_array($result, $result_type) : false;
    }
}

if (!function_exists('mysql_fetch_object')) {
    function mysql_fetch_object($result, $class_name = null, $params = [])
    {
        if (!$result instanceof mysqli_result) {
            return false;
        }

        return $class_name
            ? mysqli_fetch_object($result, $class_name, $params)
            : mysqli_fetch_object($result);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result)
    {
        return ($result instanceof mysqli_result) ? mysqli_num_rows($result) : false;
    }
}

if (!function_exists('mysql_result')) {
    function mysql_result($result, $row = 0, $field = 0)
    {
        if (!$result instanceof mysqli_result || !mysqli_data_seek($result, (int) $row)) {
            return false;
        }

        $data = mysqli_fetch_array($result, MYSQL_BOTH);
        if ($data === null || $data === false) {
            return false;
        }

        return $data[$field] ?? false;
    }
}

if (!function_exists('mysql_data_seek')) {
    function mysql_data_seek($result, $row_number)
    {
        return ($result instanceof mysqli_result) ? mysqli_data_seek($result, (int) $row_number) : false;
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($link_identifier = null)
    {
        $link = pokemon_mysql_link($link_identifier);
        return $link ? mysqli_insert_id($link) : false;
    }
}

if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows($link_identifier = null)
    {
        $link = pokemon_mysql_link($link_identifier);
        return $link ? mysqli_affected_rows($link) : false;
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($unescaped_string, $link_identifier = null)
    {
        $link = pokemon_mysql_link($link_identifier);
        return $link ? mysqli_real_escape_string($link, (string) $unescaped_string) : addslashes((string) $unescaped_string);
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error($link_identifier = null)
    {
        $link = pokemon_mysql_link($link_identifier);
        return $link ? mysqli_error($link) : '';
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($link_identifier = null)
    {
        $link = pokemon_mysql_link($link_identifier);
        if (!$link) {
            return false;
        }

        $GLOBALS['__pokemon_mysql_link'] = null;
        return mysqli_close($link);
    }
}

if (!function_exists('split')) {
    function split($pattern, $string, $limit = -1)
    {
        $pattern = '/' . str_replace('/', '\/', $pattern) . '/';
        return preg_split($pattern, (string) $string, (int) $limit);
    }
}

if (!function_exists('each')) {
    function each(&$array)
    {
        $key = key($array);
        if ($key === null) {
            return false;
        }

        $value = current($array);
        next($array);

        return [
            1 => $value,
            'value' => $value,
            0 => $key,
            'key' => $key,
        ];
    }
}

if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc()
    {
        return false;
    }
}


if (!defined('POKEMON_LEGACY_ARRAY_KEYS')) {
    define('POKEMON_LEGACY_ARRAY_KEYS', true);
    foreach ([
    'a',
    'aaaa',
    'aanval',
    'add',
    'addpkm',
    'admin',
    'adnv',
    'amthanh',
    'Array2XML',
    'attack_base',
    'auto',
    'b',
    'bac',
    'ban',
    'banbe',
    'bandau',
    'beschikbaar',
    'boss',
    'button',
    'cha',
    'choingay',
    'chucnang',
    'code',
    'dai',
    'dan',
    'dangki',
    'dangnhap',
    'data',
    'day',
    'di',
    'dichchuyen',
    'direction',
    'div',
    'doc',
    'docnv',
    'doi',
    'doinl',
    'doiqua',
    'doiskin',
    'dotphao',
    'ducnghia',
    'ducnghia_thoigiankhoa',
    'edit',
    'editgrass',
    'editinfo',
    'en',
    'exp',
    'expmax',
    'fixket',
    'follow',
    'gia',
    'giabac',
    'giaotiep',
    'giatoc',
    'giavang',
    'giftcode',
    'gioithieu',
    'gioithieu2',
    'GM',
    'grass',
    'hien',
    'hienthi',
    'hoihp',
    'hoimau',
    'home',
    'hp',
    'i',
    'icon',
    'id',
    'id_p',
    'idpkm',
    'img',
    'in_hand',
    'inbox',
    'info',
    'item',
    'keo',
    'keotang',
    'ketban',
    'khan',
    'khoa',
    'khoanick',
    'kinang',
    'kinh',
    'leotop',
    'level',
    'leven',
    'levenmax',
    'loai',
    'loaitb',
    'loaitien',
    'luu',
    'lv',
    'lvpkm',
    'ma',
    'macode',
    'map',
    'map_num',
    'map_x',
    'map_y',
    'mapID',
    'matkhau',
    'menu',
    'mod',
    'move',
    'movement',
    'msg',
    'muaban',
    'muaskin',
    'music',
    'mx',
    'my',
    'n1',
    'n3',
    'n4',
    'naam',
    'name',
    'nghia',
    'ngonngu',
    'nhan',
    'nhannv',
    'nhanpkm',
    'nhanvat',
    'nhiemvu',
    'nieuw_id',
    'noidung',
    'non',
    'npc',
    'nut',
    'o1',
    'o3',
    'o4',
    'ok',
    'okdoi',
    'okecai',
    'omschrijving_en',
    'onclick',
    'optional',
    'opzak',
    'opzak_nummer',
    'pass',
    'pk',
    'pkmmap',
    'pokemon',
    'pokemonnv',
    'qua',
    'quay',
    'query',
    'r',
    'regchoi',
    'release',
    'remove',
    'ruby',
    'ruongdo',
    's',
    'sao',
    'saveedit',
    'scriptData',
    'server_script',
    'sesion',
    'shop',
    'shopskin',
    'show',
    'silver',
    'skill',
    'skin',
    'soluong',
    'soluong_mua',
    'SONG',
    'soort',
    'sprite',
    'sterkte',
    'style',
    'sua',
    'sudung',
    'sukien',
    'taikhoan',
    'tang',
    'tangkeo',
    'tao',
    'taodata',
    'taonv',
    'ten',
    'tenvatpham',
    'text',
    'thang',
    'them',
    'tho',
    'thoigian',
    'thoitiet',
    'thongbao',
    'thongtin',
    'thua',
    'thuong',
    'time',
    'timeauto',
    'timebaove',
    'timesudung',
    'tmhm',
    'tn',
    'toctruong',
    'tool',
    'top',
    'totalexp',
    'trai',
    'trainer',
    'tranv',
    'tui',
    'type',
    'type1',
    'type2',
    'uid',
    'uidname',
    'user_id',
    'username',
    'users',
    'vatpham',
    'venha',
    'viettat',
    'vinhvien',
    'vitri',
    'wild_id',
    'x',
    'xac',
    'xem',
    'xemskin',
    'xmap',
    'xoa',
    'xu',
    'y',
    'ymap',
    ] as $legacyKey) {
        if (!defined($legacyKey)) {
            define($legacyKey, $legacyKey);
        }
    }
}
