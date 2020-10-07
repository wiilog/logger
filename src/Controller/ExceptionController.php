<?php

namespace App\Controller;

use App\Entity\Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ExceptionController extends AbstractController {

    /**
     * @Route("/{instance}/{mode}", name="exception_list")
     */
    public function list(Request $request, PaginatorInterface $paginator, string $instance, string $mode) {
        $exceptions = $this->getDoctrine()
            ->getRepository(Exception::class)
            ->findInstance($instance, $mode);

        $exceptions = $paginator->paginate($exceptions, $request->get("page", 1), 20);
        $items = [];

        /** @var Exception $exception */
        foreach($exceptions as $item) {
            dump($item);
            $exception = $item[0];
            $exception->count = $item["count"];

            $trace = $exception->getException()->getTrace();

            if(count($trace) >= 2) {
                $exception->method = $trace[1]["short_class"] . "::" . $trace[1]["function"];
            } else {
                $exception->method = "/";
            }

            $items[] = $exception;
        }

        $exceptions->setItems($items);

        return $this->render("exception/list.html.twig", [
            "instance" => $instance,
            "mode" => $mode,
            "exceptions" => $exceptions,
        ]);
    }

    /**
     * @Route("/{instance}/{mode}/show/{exception}", name="exception_show")
     */
    public function show(Exception $exception) {
        return $this->render("exception/show.html.twig", [
            "context" => $exception,
        ]);
    }

}