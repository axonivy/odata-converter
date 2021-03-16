<?php
namespace app\pages\home;

use Slim\Psr7\Request;
use Slim\Psr7\UploadedFile;
use Slim\Views\Twig;
use mikehaertl\shellcommand\Command;
use Slim\Psr7\Response;
use app\Config;

class HomeAction
{
    private Twig $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $uploadedFiles = $request->getUploadedFiles();
        if (isset($uploadedFiles['feilchen'])) {
            $uploadedFile = $uploadedFiles['feilchen'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $id = self::moveUploadedFile($uploadedFile);
                $location = "/pickup/$id";
                return $response->withHeader('Location', $location)->withStatus(302);
            }
        }
        
        return $this->view->render($response, 'home/home.twig');
    }

    private static function moveUploadedFile(UploadedFile $uploadedFile)
    {
        $path = Config::INPUT_DIR;
        if (!file_exists($path)) {
            mkdir($path);
        }
        $id = uniqid();
        $uploadedFile->moveTo("$path/" . $id . '.xml');
        return $id;
    }
}
