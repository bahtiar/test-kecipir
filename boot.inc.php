<?php
define('APP_PATH', __DIR__);
define('SYS_GLOBAL_VAR', '_d326_fw');
session_start();

function set($name, $value)
{
    $GLOBALS[SYS_GLOBAL_VAR][$name] = $value;
}

function get($name, $default = null)
{
    return isset($GLOBALS[SYS_GLOBAL_VAR][$name]) ? $GLOBALS[SYS_GLOBAL_VAR][$name] : $default;
}

function createUrl($route, $params = [])
{
    $url = get('baseUrl') . '/' . rtrim($route, '/');
    if (!empty($params) && ($query = http_build_query($params)) !== '') {
        $url .= '?' . $query;
    }
    return $url;
}

function redirectTo($route, $params = [])
{
    header('Location: ' . createUrl($route, $params));
    exit();
}

function render($view, $params = [])
{
    $content = renderPartial($view, $params);
    return renderFile(APP_PATH . '/views/layout.php', ['content' => $content]);
}

function renderPartial($view, $params = [])
{
    if (strncmp($view, '/', 1) !== 0) { // kalau diawali '/' berarti absolut path
        $view = APP_PATH . '/views/' . $view;
    }
    if (!is_file($view) && is_file($view . '.php')) {
        $view .= '.php';
    }
    return renderFile($view, $params);
}

function renderFile($_file_, $_params_ = [])
{
    ob_start();
    ob_implicit_flush(false);
    extract($_params_, EXTR_OVERWRITE);
    require($_file_);
    return ob_get_clean();
}

function bootRun()
{
    
    set('baseUrl', $_SERVER['SCRIPT_NAME']);
    $route = substr($_SERVER['REQUEST_URI'], 1);

    if (empty($route)) {
        $route = 'textAnalizer';
        $controllerFunction = 'index';
    } else {
        $expRoutes = explode('/', $route);
        $route = $expRoutes[0];
        $controllerFunction = (count($expRoutes) == 1) ? 'index' : $expRoutes[1];
    }
    
    set('route', $route);
    if (!file_exists("controllers/{$route}.php")){
        require "views/noaccess.php";
    } else {
        require "controllers/{$route}.php";
        $controller = new TextAnalizer();
        $viewData = $controller->index();
    }
}