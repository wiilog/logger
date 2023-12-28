<?php

namespace App\Controller;

use App\Entity\Exception;
use App\Entity\Instance;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/")]
class ExceptionController extends AbstractController {

    #[Route("/instance/{instance?}", name: "exception_list")]
    #[Route("/", name: "exception_list_index")]
    public function list(Request                $request,
                         PaginatorInterface     $paginator,
                         EntityManagerInterface $entityManager,
                         ?string                $instance): Response {
        $exceptionRepository = $entityManager->getRepository(Exception::class);
        $instanceRepository = $entityManager->getRepository(Instance::class);

        if ($instance) {
            $instance = $instanceRepository->findOneBy(["code" => $instance]);
            $exceptions = $exceptionRepository->queryInstance($instance);
        } else {
            $exceptions = $exceptionRepository->queryOrdered();
        }

        $exceptions = $paginator->paginate($exceptions, $request->get("page", 1), 15);

        foreach($exceptions as $exception) {
            $trace = $exception->getFirstException()["trace"];

            if(count($trace) >= 2) {
                $exception->method = $trace[1];
            } else {
                $exception->method = "/";
            }
        }

        return $this->render("exception/list.html.twig", [
            "current_instance" => $instance ?? null,
            "exceptions" => $exceptions,
        ]);
    }

    #[Route("/{instance}/show/{exception}", name: "exception_show")]
    public function show(Exception $exception): Response {
        return $this->render("exception/show.html.twig", [
            "current_instance" => $exception->getInstance(),
            "context" => $exception,
        ]);
    }

}