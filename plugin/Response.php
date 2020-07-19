<?php

namespace Plugin;

class Response
{
    public static function redirectBack()
    {
        return redirect()->back();
    }

    public static function redirectBackWithInput()
    {
        return redirect()->back()->withInput();
    }

    public static function redirectRefresh()
    {
        return redirect()->refresh();
    }

    public static function redirect($path)
    {
        return redirect()->away($path);
    }

    public static function redirectTo($path, $params = false)
    {
        if ($params) {
            return redirect()->to($path, $params);
        }
        return redirect()->to($path);
    }

    public static function redirectToRoute($route, $params = false)
    {
        if ($params) {
            return redirect()->route($route, $params);
        }
        return redirect()->route($route);
    }

    public static function redirectToAction($action, $params = false)
    {
        if ($params) {
            return redirect()->to($action, $params);
        }
        return redirect()->route($action);
    }
}
