<?php

namespace app\core;

use app\controllers\SiteController;
use app\core\exception\PageNotFoundException;
use Closure;
use Dotenv\Util\Regex;

class Router
{
    public Request $request;
    public Response $response;
    public array $params = [];

    protected array $routes = [];

    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }


    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        $path = $this->extractParams($path, $method);
        $callback = $this->routes[$method][$path] ?? false;


        Application::$app->controller = new SiteController();

        if ($callback === false) {
            throw new PageNotFoundException();
        }

        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback)) {
            /**
             * @var Controller $controller
             */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response, $this->params);
    }

    /**
     * Fill the params field if it's exists (params)
     * @param string $path Actual user path
     * @param string $method HTTP method
     * @return string $route, corresponding like a pattern to the $path
     */
    protected function extractParams(string $path, string $method): string
    {
        foreach ($this->routes[$method] as $route => $callback) {
            $keys = [];

            preg_match_all("/(?:{)([\w]+)(?:})/i", $route, $keys);
            if (empty($keys[0])) {
                continue;
            } else {
                unset($keys[0]);
            }

            $values = [];
            preg_match(
                str_replace('\?', '([\w]+)',
                    '/' . preg_quote(
                        preg_replace("/{[\w]+}/i", "?", $route),
                        '/') . '/i'),
                $path,
                $values
            );

            if (empty($values)) {
                continue;
            } else {
                unset($values[0]);

            }

            $keys = array_map(fn($group) => $group[0], $keys);
            $this->params = array_combine($keys,
                array_map(
                    fn($val) =>
                        pg_escape_string(Application::$app->db->pgsql, $val), $values)
                );
            return $route;
        }

        return $path;
    }
}