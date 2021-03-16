<?php
namespace app\pages\pickup;

use Slim\Psr7\Request;
use Slim\Psr7\UploadedFile;
use Slim\Views\Twig;
use mikehaertl\shellcommand\Command;
use Slim\Psr7\Response;
use Slim\Exception\HttpNotFoundException;
use app\Config;

class PickupAction
{
    private Twig $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        $oldPlace = Config::INPUT_DIR . "/$id.xml";
        $newPlace = Config::OUTPUT_DIR . "/$id.json";

        if (file_exists($newPlace)) {
            $url = "/data/output/$id.json";
            return $this->view->render($response, 'pickup/pickup.twig', ['downloadUrl' => $url]);
        } else if (file_exists($oldPlace)) {
            return $this->view->render($response, 'pickup/wait.twig');
        } else {
            throw new HttpNotFoundException($request);
        }
    }
}
