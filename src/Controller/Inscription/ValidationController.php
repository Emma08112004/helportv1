<?php

namespace Apps\Controller\Inscription;

use Apps\Controller\Acceuil\sendService;
use Apps\Core\Controller\Request;
use Apps\Core\DebugHandler;
use Apps\Core\Service\DatabaseService;
use Apps\Core\View\TwigCore;
use Apps\Core\Controller\ControllerInterface;
use Studoo\Api\EcoleDirecte\Client;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class
ValidationController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function execute(Request $request)
    {
        $etudiant = null;
        $error = null;

        if (isset($_POST['username']) && isset($_POST['password'])) {
            try {

                $client = new Client([
                    "base_path" => "http://localhost:9042",
                    "client_id" => $_POST['username'],
                    "client_secret" => $_POST['password'],
                ]);
                $etudiant = $client->fetchAccessToken();

                DebugHandler::dump($etudiant);

                if (isset($etudiant->getProfile()["classe"]["code"])) {
                                        $classe = $etudiant->getProfile()["classe"]["code"];
                                    } else
                                    {
                                        $classe = null;

                                    }

                                    $connexion = DatabaseService::getConnect();
                                    $statement = $connexion->prepare("INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `classe`, `password`)
                                VALUES (NULL, '".$etudiant->getNom()."', '".$etudiant->getPrenom()."', '".$etudiant->getEmail()."','".$classe."', 'test');");
                                    $statement->execute();

                sendService::sendMailer($etudiant->getEmail(),$etudiant ->getNom(), "validation du compte", "Ton compte a été crée");

            } catch (Exception $e){
                $error = $e->getCode();
            }

        }
        $twig = TwigCore::getEnvironment();

        echo $twig->render('home/validation.html.twig', [
            'etudiant' => $etudiant, // objet or null
            'error' => $error
        ]);

        //    echo $twig->render('templates/inscriptio,.html.twig' ,[
        //      'visu' => false
        // if (isset($etudiant->getProfile()["classe"]["code"])) {
        //                    $classe = $etudiant->getProfile()["classe"]["code"];
        //                } else
        //                {
        //                    $classe = null;
        //
        //                }
        //
        //                $connexion = DatabaseService::getConnect();
        //                $statement = $connexion->prepare("INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `classe`, `password`)
        //            VALUES (NULL, '".$etudiant->getNom()."', '".$etudiant->getPrenom()."', '".$etudiant->getEmail()."','".$classe."', 'test');");
        //                $statement->execute();
        //  ]);
    }
}
