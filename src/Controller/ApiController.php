<?php

namespace App\Controller;

use App\Entity\Exception;
use App\Entity\Instance;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends BaseController {

    /** @Required */
    public EntityManagerInterface $manager;

    /**
     * @Route("/log", name="api_log", methods={"POST"})
     */
    public function log(Request $request) {
        $code = $request->request->get("instance");
        $instance = $this->getDoctrine()->getRepository(Instance::class)->findOneBy(["code" => $code]);
        if(!$instance) {
            $split = explode("-", $code);

            $instance = new Instance();
            $instance->setMode(array_pop($split));
            $instance->setName(implode("-", $split));
            $instance->setCode($code);

            $cache = new FilesystemAdapter();
            $cache->delete("wiilogs.instances");
        }

        $exception = new Exception();
        $exception->setInstance($instance);
        $exception->setContext($request->request->get("context"));
        $exception->setUser($request->request->get("user"));
        $exception->setRequest($request->request->get("request"));
        $exception->setExceptions($request->request->get("exceptions"));
        $exception->setTime(DateTime::createFromFormat("d-m-Y H:i:s", $request->request->get("time")));

        $this->manager->persist($exception);
        $this->manager->flush();

        return $this->json([
            "success" => true,
            "message" => "Successfully logged exception"
        ]);
    }

}