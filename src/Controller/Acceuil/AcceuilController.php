<?php

namespace Apps\Controller\Acceuil;

use Apps\Core\Controller\ControllerInterface;
use Apps\Core\Controller\Request;
use Apps\Core\View\TwigCore;
use Apps\Model\QuestionnaireModel;
use Apps\Error\LoaderError;
use Apps\Error\RuntimeError;
use Apps\Error\SyntaxError;
use PHPMailer\PHPMailer\PHPMailer;

class AcceuilController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function execute(Request $request)
    {
        // Obj connect Mysql -> Obj Questionnaire
        $questionnaireModel = new QuestionnaireModel();

        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = $_ENV["MAIL_USER"];
        $phpmailer->Password = $_ENV["MAIL_PASSWORD"];


        // Si y a pas de GET alors j'affiche tout
        return TwigCore::getEnvironment()->render(
            'acceuil/acceuil.html.twig',
            [
                'questionnaires' => $questionnaireModel->getFechAll(),
                'prenom' => 'benoit'
            ]);
    }
}