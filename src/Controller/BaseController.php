<?php

namespace App\Controller;

use App\Entity\Instance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController {

    protected function render(string $view, array $parameters = [], Response $response = null): Response {
        $cache = new FilesystemAdapter();
        $parameters["__instance_menu"] = $cache->get("wiilogs.instances", function() {
            return $this->getDoctrine()
                ->getRepository(Instance::class)
                ->findAll();
        });

        return parent::render($view, $parameters, $response);
    }

}