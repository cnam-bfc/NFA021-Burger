
<?php
class ExempleController extends Controller
{
    public function renderView()
    {
        $view = new View(BaseTemplate::EMPLOYE, 'ExempleView');
        $view->renderView();
    }
}
