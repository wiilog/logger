<?php

namespace App\Controller;

use App\Entity\Exception;
use App\Entity\Instance;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api", name: "api_")]
class ApiController extends AbstractController {

    #[Route("/log", name: "log", methods: ["POST"])]
    public function log(EntityManagerInterface $entityManager,
                        Request                $request): JsonResponse {
        // Ignore requests from outside the cluster
        if(!preg_match("/10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/", $request->getClientIp())) {
            throw new NotFoundHttpException();
        }

        $code = $request->request->get("instance");

        $instanceRepository = $entityManager->getRepository(Instance::class);
        $instance = $instanceRepository->findOneBy(["code" => $code]);
        if(!$instance) {
            $split = explode("-", $code);

            $instance = new Instance();
            $instance->setMode(array_pop($split));
            $instance->setName(implode("-", $split));
            $instance->setCode($code);

            $cache = new FilesystemAdapter();
            $cache->delete("wiilogs.instances");
        }

        $requestStr = $request->request->getString("request");
        $exceptionsStr = $request->request->getString("exceptions");

        if(($requestStr !== '' && !$this->isJson($requestStr)) || !$this->isJson($exceptionsStr)) {
            return $this->json([
                "success" => false,
                "message" => "Payload is not valid JSON"
            ]);
        }

        $exception = new Exception();
        $exception->setInstance($instance);
        $exception->setContext($request->request->all("context"));
        $exception->setUser($request->request->all("user"));
        $exception->setRequest($requestStr ?: 'Error from cron job');
        $exception->setExceptions($exceptionsStr);
        $exception->setTime(DateTime::createFromFormat("d-m-Y H:i:s", $request->request->get("time")));

        $entityManager->persist($exception);
        $entityManager->flush();

        return $this->json([
            "success" => true,
            "message" => "Successfully logged exception"
        ]);
    }

    #[Route("/ping", name: 'ping', options: ["expose" => true], methods: ['GET'])]
    public function ping(): JsonResponse {
        $response = new JsonResponse(['success' => true]);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET');
        return $response;
    }

    private function isJson(?string $string): bool {
        json_decode($string);
        return json_last_error() == JSON_ERROR_NONE;
    }

}