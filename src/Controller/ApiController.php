<?php

namespace App\Controller;

use App\Entity\Exception;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController {

    /** @Required */
    public EntityManagerInterface $manager;

    /**
     * @Route("/log", name="api_log", methods={"POST"})
     */
    public function log(Request $request) {
        $exception = new Exception();
        $exception->setInstance($request->request->get("instance"));
        $exception->setContext($request->request->get("context"));
        $exception->setException($request->request->get("exception"));
        $exception->setTime(DateTime::createFromFormat("d-m-Y H:i:s", $request->request->get("time")));

        $this->manager->persist($exception);
        $this->manager->flush();

        return $this->json([
            "success" => true,
            "message" => "Successfully logged exception"
        ]);
    }

}