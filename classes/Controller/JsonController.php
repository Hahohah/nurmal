<?php

/**
 * JsonController class.
 */
header('Content-type: application/json;');
namespace Alltube\Controller;

use Alltube\Library\Exception\AlltubeLibraryException;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Controller that returns JSON.
 */
class JsonController extends BaseController
{
    /**
     * Return the JSON object generated by youtube-dl.
     *
     * @param Request $request PSR-7 request
     * @param Response $response PSR-7 response
     *
     * @return Response HTTP response
     * @throws AlltubeLibraryException
     */
    public function json(Request $request, Response $response): Response
    {
        $url = $request->getQueryParam('url');

        if (isset($url)) {
            $this->video = $this->downloader->getVideo(
                $url,
                $this->getFormat($request),
                $this->getPassword($request)
            );

                    $result = ['status' => true, 'photo' =>$response->withJson($this->video->getJson())];
                    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            return $response->withJson(['error' => 'You need to provide the url parameter'])
                ->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }
    }
}
