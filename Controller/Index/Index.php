<?php

/**
 * Controller for displaying form
 *
 * @package converter
 * @author Tomasz Biedrzycki <tomasz.biedrzycki@interia.eu>
 */
namespace TBat\Converter\Controller\Index;

use \TBat\Converter\Controller as Controller;

class Index extends Controller\Index {

    /**
     * display form
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
