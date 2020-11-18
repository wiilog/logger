<?php

namespace App\Controller;

use App\Entity\Exception;
use App\Entity\Instance;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ExceptionController extends BaseController {

    /**
     * @Route("/{instance?}", name="exception_list")
     */
    public function list(Request $request, PaginatorInterface $paginator, ?string $instance) {
        $er = $this->getDoctrine()->getRepository(Exception::class);

        if($instance) {
            $instance = $this->getDoctrine()
                ->getRepository(Instance::class)
                ->findOneBy(["code" => $instance]);

            $exceptions = $er->queryInstance($instance);
        } else {
            $exceptions = $er->queryOrdered();
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

    /**
     * @Route("/{instance}/show/{exception}", name="exception_show")
     */
    public function show(Exception $exception) {
        return $this->render("exception/show.html.twig", [
            "current_instance" => $exception->getInstance(),
            "context" => $exception,
        ]);
    }

}