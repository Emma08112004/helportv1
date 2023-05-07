<?php

namespace Apps\Controller\Inscription;

use Apps\Core\Controller\ControllerInterface;
use Apps\Core\Controller\Request;
use Apps\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class InscriptionController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function execute(Request $request)
    {
        // Obj connect Mysql -> Obj Questionnaire


        $twig = TwigCore::getEnvironment();

        echo $twig->render('/inscription/inscription.html.twig', [
            'visu' => false
        ]);
    }
}