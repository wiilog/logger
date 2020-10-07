<?php

namespace App\Controller;

use App\Entity\Exception;
use App\Entity\Instance;
use App\Entity\InstanceUser;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
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
        $flatten = unserialize($request->request->get("exception"));

        $exception = new Exception();
        $exception->setHash(hash("sha256", $flatten->getFile() . $flatten->getMessage() . $flatten->getLine()));
        $exception->setInstance($request->request->get("instance"));
        $exception->setMode($request->request->get("mode"));
        $exception->setContext($request->request->get("context"));
        $exception->setUser($request->request->get("user"));
        $exception->setRequest($request->request->get("request"));
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