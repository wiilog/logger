<?php

namespace App\Controller;

use App\Entity\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ExceptionController extends AbstractController {

    /**
     * @Route("/show/{exception}", name="exception_show")
     */
    public function show(Exception $exception) {
        return $this->render("exception/exception.html.twig", [
            "context" => $exception,
        ]);
    }

}