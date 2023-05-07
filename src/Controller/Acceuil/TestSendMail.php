<?php

namespace Apps\Controller\Acceuil;

use Apps\Core\Controller\ControllerInterface;
use Apps\Core\Controller\Request;
use Apps\Core\View\TwigCore;
use PHPMailer\PHPMailer\PHPMailer;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TestSendMail implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function execute(Request $request)
    {
        sendService::sendMailer('Emma Allali', "test", "bonjour ");
        $twig = TwigCore::getEnvironment();

        echo $twig->render('inscription\send.html.twig', [
            'mailStatus' => false
        ]);

        //    echo $twig->render('templates/inscriptio,.html.twig' ,[
        //      'visu' => false
        //  ]);
    }

}