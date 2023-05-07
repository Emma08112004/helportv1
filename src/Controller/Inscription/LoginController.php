<?php

namespace Apps\Controller\Inscription;



    use Apps\Core\Controller\Request;
    use Apps\Core\View\TwigCore;
    use Apps\Core\Controller\ControllerInterface;
    use Apps\sendService;
    use Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use Studoo\Api\EcoleDirecte\Client;
    use Studoo\Api\EcoleDirecte\Exception\NotDataResponseException;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

class LoginController implements ControllerInterface
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function execute(Request $request)
    {$error="";
        $etudiant="";
        try {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $client = new Client([
                    "client_id" => $_POST['username'],
                    "client_secret" => $_POST['password'],
                    'verify' => false,
                ]);
                $etudiant = $client->fetchAccessToken();

                //DebugHandler::dump($etudiant);
            }

        }catch (NotDataResponseException $e){
            $error = $e->getCode();
        }

        if ($error ==500){
            $twig = TwigCore::getEnvironment();
            echo $twig->render('error\http-500.html.twig', [
                'error' => $etudiant
            ]);
        }
        elseif ($error ==403){
            $twig = TwigCore::getEnvironment();
            echo $twig->render('error\http-403.html.twig', [
                'error' => $etudiant
            ]);
        }
        elseif ($error ==404){
            $twig = TwigCore::getEnvironment();
            echo $twig->render('error\http-404.html.twig', [
                'error' => $etudiant
            ]);
        }
        else {
            $twig = TwigCore::getEnvironment();
            echo $twig->render('home\login.html.twig', [
                'etudiantAPI' => $etudiant
            ]);
}


        //    echo $twig->render('templates/inscriptio,.html.twig' ,[
        //      'visu' => false
        //  ]);



    }

}