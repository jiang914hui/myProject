<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/7
 * Time: 15:29
 */
//正确的路由应该是：http://www.myfram.com/TestController/test/a/123
echo '哼~';
//test
$documentPath = $_SERVER['DOCUMENT_ROOT'];
$filePath = __FILE__;
$requestUri = $_SERVER['REQUEST_URI'];

$router = explode('/',$requestUri);
$paramCount = count($router);

if ($paramCount < 2 || ($paramCount % 2) == 0) {
    die('参数错误');
} else {
    $param = array();
    for ($i = 3; $i < $paramCount; $i += 2) {
        $arr_temp_hash = array(strtolower($router[$i]) => $router[$i + 1]);
        $param = array_merge($param, $arr_temp_hash);
    }
}
//var_dump($param);die;
$controller = $router[1];
$method = $router[2];
$module_name = $controller.'Controller';
$module_file = 'action/' . $module_name . '.php';
if (file_exists($module_file)) {
    include $module_file;

    $obj_module = new $module_name();

    if (!method_exists($obj_module, $method)) {
        die("要调用的方法不存在");
    } else {
        if (is_callable(array($obj_module, $method))) {
            $obj_module->$method($param);
        }
    }

} else {
    die("要访问的控制器不存在");
}
