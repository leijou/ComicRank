<?php
namespace ComicRank;

require_once(__DIR__.'/../core.php');

// Get URI from apache rewrite
$url = '/index';
if (isset($_SERVER['REDIRECT_URL'])) $url = urldecode($_SERVER['REDIRECT_URL']);

// Remove leading & trailing slash
$url = substr($url, 1);
if (substr($url, -1) == '/') $url = substr($url, 0, -1);

$routes = [
    'comic/([0-9a-z]{4})' => ['comic/view','id'],
    'comic/([0-9a-z]{4})/edit' => ['comic/edit','id'],
    'comic/([0-9a-z]{4})/stats' => ['comic/stats','id'],
    'comic/([0-9a-z]{4})/code' => ['comic/code','id'],
    'comic/([0-9a-z]{4})/(.+)' => ['comic/view','id','title'],

    'user/add/([0-9A-Z]{8,})' => ['user/add','key'],
    'user/([0-9a-z]{4})' => ['user/view','id'],
    'user/([0-9a-z]{4})/edit' => ['user/edit','id'],
    'user/([0-9a-z]{4})/(.+)' => ['user/view','id','name'],

    'mailing/([0-9a-z]{5,})' => ['mailing/manage','token'],

    'forum/([0-9]+)' => ['forum/view','id'],

    'error/([0-9]{3})' => ['error','code'],
];

$handler = false;
switch ($url) {
    case 'forum':
        $url .= '/';
    case '':
        $url .= 'index';
    case 'index':
    case 'about':
    case 'contact':
    case 'terms':
    case 'comic/add':
    case 'user/login':
    case 'user/logout':
    case 'user/add':
    case 'user/invite':
    case 'mailing/add':
    case 'forum/about':
        $handler = $url;
        break;

    default:
        $matches = array();
        foreach ($routes as $regex => $info) {
            if (preg_match('#^'.$regex.'$#', $url, $matches)) {
                $params = array_flip($info);
                foreach ($info as $k => $v) {
                    if ($k == 0) {
                        $handler = $v;
                    } else {
                        $_GET[$v] = $matches[$k];
                    }
                }
                break;
            }
        }
        break;
}

if (!$handler) $handler = 'error';
require(__DIR__.'/../handler/'.$handler.'.php');
