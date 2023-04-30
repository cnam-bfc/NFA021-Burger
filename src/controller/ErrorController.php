<?php
class ErrorController extends Controller
{
    public static function error($code, $message, $renderView = true)
    {
        // Définition du code d'erreur HTTP
        header("HTTP/1.0 " . $code . " " . $message);

        if ($renderView) {
            $controller = new ErrorController();
            $controller->renderView($code, $message);
        }
    }

    private function renderView($code, $message)
    {
        $view = new View(BaseTemplate::EMPTY, 'ErrorView');

        // Définition des variables utilisées dans la vue
        $view->code = $code;
        $view->message = $message;

        $view->renderView();
    }
}
