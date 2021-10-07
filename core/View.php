<?php


namespace app\core;


class View
{
    public string $title = '';


    public function renderView(string $view, array $params = [])
    {
        return $this->render("/views/$view.php", $params);
    }

    public function render(string $view, array $params)
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent($params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
       /* $validateContent = $this->validateContent($params);
        $page = str_replace("{{validate}}", $page, $validateContent);

        return $page;*/
    }

    public function renderOnlyView(string $view, array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . $view;
        return ob_get_clean();
    }

    public function layoutContent(array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    /** Generate validation code for form with models. Assume that page can contain only one form
     * @param array $params
     * @return false|string
     */
    private function validateContent(array $params)
    {
        ob_start();
        echo '<script>';


        echo '</script>';
        return ob_get_clean();
    }
}