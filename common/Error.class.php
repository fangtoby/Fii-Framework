<?php
class Error
{
    //是否显示错误信息
    private static $_show_msg = true;

    private static $_errors = array(
        0 => "No Error", //没有错误
        1 => "General Error", //通用错误

        10000 => "Session Error or Not Login", //会话错误或未登录
        10001 => "Database Connection Failed", //数据库连接失败
        10002 => "DB Query Error", //数据库查询错误

        20000 => "Param Value Error", //参数值错误
        40000 => "Unknown Error" //未知错误
    );

    /**
     * 获取错误信息.
     * @param int $error_code
     * @return array
     */
    public static function getError($error_code)
    {
        $arr = null;
        foreach (self::$_errors as $key => $value) {
            if ($key == $error_code) {
                $arr = array($key, $value);
                break;
            }
        }
        if ($arr == null)
            $arr = array($error_code, "Unknown Error");
        return $arr;
    }

    /**
     * exit with json info.
     * @param int $error_code 错误码
     * @param mixed $addon 附加数据
     */
    public static function exitWithJson($error_code = 0, $addon = null)
    {
        if ($error_code == 0) $arr = array(0, "no error");
        else $arr = self::getError($error_code);
        $arr = array("code" => $arr[0], "msg" => $arr[1]);
        if ($addon) $arr["data"] = $addon;
        if (!self::$_show_msg) unset($arr["msg"]);
        exit(json_encode($arr));
    }

}
