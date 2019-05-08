<?php

namespace alex290\imagelink;

use alex290\imagelink\lib\ImageLnk;

/**
 * This is just an example.
 */
class ImageLink extends \yii\base\Widget
{
    public static function run()
    {
        $config = ['settings' => [
            'addContentLengthHeader' => false,
        ]];
        $app = new \Slim\App($config);
        $container = $app->getContainer();
        $container['view'] = function ($c) {
            $view = new \Slim\Views\Twig(__DIR__ . '/../views', [
                'cache' => __DIR__ . '/../cache/twig'
            ]);
            $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
            $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
            return $view;
        };
        $app->get('/', function ($request, $response, $args) {
            return $this->view->render($response, 'welcome.html.twig', [
                'sites' =>  ImageLnk::getSites(),
            ]);
        });
        $app->get('/api', function ($request, $response, $args) {
            return $this->view->render($response, 'api.html.twig', []);
        });
        $app->get('/api/get', function ($request, $response, $args) {
            $url = $request->getQueryParam('url', '');
            $data = [
                'pageurl' => $url,
            ];
            $r = ImageLnk::getImageInfo($url);
            if ($r) {
                $data['title']     = $r->getTitle();
                $data['referer']   = $r->getReferer();
                $data['backlink']  = $r->getBackLink();
                $data['imageurls'] = $r->getImageURLs();
            }
            return $response->withJson($data);
        });
        $app->run();
    }
}
