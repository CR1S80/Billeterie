<?php


namespace App\Controller;


use Symfony\Bundle\TwigBundle\Controller\ExceptionController as ExceptionControllerAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionController extends ExceptionControllerAlias
{
    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function error() {
         $this->twig->render('test.html.twig', [
             'status_code' => $_SERVER['REQUEST_URI'],
             'status_text' => $_SERVER['REQUEST_URI']
         ]) ;
    }



}