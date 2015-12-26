<?php

namespace Controller;
class Router
{
    public function dispatch($url)
    {
        $parts = explode('/', $url);
        $className = $this->resolveClassName($parts);
        $methodName = $this->resolveMethodName($parts);
        $param = $this->resolveParam($parts);
        if ($className && $methodName) {
            if (class_exists($className)) {
                $controllerInstance = new $className;
                if (is_callable([$controllerInstance, $methodName])) {
                    $controllerInstance->$methodName($param);
                }
            }
        }
        return null;
    }
    protected  function resolveClassName($parts)
    {
        $className = '\\Controller\\';
        $className .= ucfirst(strtolower($parts[0])) . 'Controller';
        return $className;
    }
    protected  function resolveMethodName($parts)
    {
        return isset($parts[1]) ? $parts[1] : null;
    }
    protected function resolveParam($parts)
    {
        return isset($parts[2]) ? $parts[2] : null;
    }
}