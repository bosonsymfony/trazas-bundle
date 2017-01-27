<?php

namespace UCI\Boson\TrazasBundle\Controller;

use UCI\Boson\BackendBundle\Controller\BackendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends BackendController
{
    /**
     * @Route(path="/trazas/admin/scripts/config.trazas.js", name="trazas_app_config")
     */
    public function getAppAction()
    {
        return $this->jsResponse('TrazasBundle:Scripts:config.js.twig');
    }

}
