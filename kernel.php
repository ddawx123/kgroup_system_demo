<?php
$config = include(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/api.class.php'); //导入自制API类库

/**
 * 应用层URL路由封装
 */
class Router {

    public function loadApi() {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            Response::jsonEncode(500, '此URL只允许通过POST方式请求');
        }
        self::start();
    }

    public function loadManager() {
        header('Content-Type: text/html; charset=UTF-8');
        $config = include(dirname(__FILE__).'/config.php');
        if(!User::checkPerm()) {
            if($config['passport_ssl']) {
                header('Location: https://'.$config['passport_srv'].'/sso/login?returnUrl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
            }
            else {
                header('Location: http://'.$config['passport_srv'].'/sso/login?returnUrl='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
            }
        }
        else {
            $login_user = $_COOKIE['dingstudio_sso'];
            $operator_token = $_COOKIE['dingstudio_ssotoken'];
        }
    }

    public function start() {
        switch($_POST['type']) {
            case "apply_usr":
            //User::checkReferer($_SERVER['HTTP_REFERER']);
            Model::apply_user($_POST['username'], $_POST['locate'], $_POST['qqnum'], $_POST['like']);
            break;
            default:
            Response::jsonEncode(500, '无效的请求方法');
            break;
        }
    }
}

/**
 * 应用主体操作模型封装
 */
class Model {

    public static function apply_user($username, $locate, $qqnum, $like) {
        if($username == '' || $locate == '' || $qqnum == '' || $like == '') {
            Response::jsonEncode(405, '必填项不能为空');
        }
        $sqlconn = DB::getInstance()->connect();
        $sqlcode = "select * from songusers where qqnum='{$qqnum}'";
        $result = $sqlconn->query($sqlcode);
        $rows = mysqli_fetch_array($result);
        mysqli_free_result($result);
        if($rows['qqnum']==$qqnum) {
            Response::jsonEncode(403, '用户QQ信息已存在');
        }
        $sqlcode = "insert into songusers (name, locate, qqnum, likestr) value ('{$username}', '{$locate}', '{$qqnum}', '{$like}')";
        $result = $sqlconn->query($sqlcode);
        if(!$result) {
            Response::jsonEncode(502, '数据库写入超时');
        }
        else {
            $vistor_token = sha1($qqnum);
            $requestId = date('YmdHis',time());
            $vistor_response = array(
                'token' =>  $vistor_token,
                'requestId' =>  $requestId
            );
            Response::jsonEncode(200, '操作成功', $vistor_response);
        }
    }
}

/**
 * 用户权限以及安全保护功能封装
 */
class User {

    /**
     * 需要管理员权限的页面游客阻断函数
     */
    public static function checkPerm() {
        
        if(!isset($_COOKIE['dingstudio_sso']) || $_COOKIE['dingstudio_sso'] == '' || !isset($_COOKIE['dingstudio_ssotoken']) || $_COOKIE['dingstudio_ssotoken'] == '') {
            return false;
        }
        else {
            return true;
        }
        //TODO
    }

    /**
     * 避免CSRF跨域问题，通过referer白名单方案处理
     * @param string $urlpath 来路URL路径
     * @return JSON
     */
    public static function checkReferer() {
        if($urlpath != $config['trust_uri']) {
            Response::jsonEncode(403, '安全校验无法通过');
        }
    }
}

/**
 * 数据库实例化类
 * @package DingStudio/DBInstance
 * @subpackage SingleInstance.Class
 * @author alone◎浅忆
 * @copyright 2016-2017 DingStudio All Rights Reserved
 */
class DB {

    static private $_instance = null;
    static private $_conn;

    /**
     * 实例化进程初始构造入口
     */
    private function __construct() {
        $config = include(dirname(__FILE__).'/config.php');
        $this->host = $config['mysql_host'];
        $this->user = $config['mysql_user'];
        $this->pwd = $config['mysql_pwd'];
        $this->db = $config['mysql_db'];
    }

    /**
     * 统一数据库实例取得入口
     */
    static public function getInstance() {
        if(!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 建立数据库连接
     */
    public function connect() {
        if(!self::$_conn) {
            self::$_conn = mysqli_connect($this->host, $this->user, $this->pwd);
            if(!self::$_conn) {
                return false;
            }
            mysqli_select_db(self::$_conn, $this->db);
            mysqli_query(self::$_conn, 'set names UTF8');
        }
        return self::$_conn;
    }

    /**
     * 释放数据库连接
     */
    public function disconnect() {
        if(!self::$_conn) {
            exit(0);
        }
        mysqli_close(self::$_conn);
    }
}