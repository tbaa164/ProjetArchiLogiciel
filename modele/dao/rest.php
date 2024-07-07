<?php
require_once 'ConnexionManager.php';
require_once 'ArticleDao.php';
require_once 'CategorieDao.php';

function sendResponse($data, $format) {
    if ($format === 'xml') {
        header('Content-Type: application/xml');
        echo arrayToXml($data, new SimpleXMLElement('<root/>'))->asXML();
    } else {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

function arrayToXml($data, $xml_data) {
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            if (is_numeric($key)) {
                $key = 'item' . $key; // dealing with <0/>..<n/> issues
            }
            $subnode = $xml_data->addChild($key);
            arrayToXml($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
    return $xml_data;
}

$articleDao = new ArticleDao();
$categorieDao = new CategorieDao();

$format = isset($_GET['format']) ? $_GET['format'] : 'json';
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getAllArticles':
        $articles = $articleDao->getAllArticles();
        sendResponse($articles, $format);
        break;
    
    case 'getArticlesByCategory':
        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];
            $articles = $articleDao->getArticlesByCategory($categoryId);
            sendResponse($articles, $format);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Category ID is required']);
        }
        break;

    case 'getArticlesGroupedByCategory':
        $categories = $categorieDao->getAllCategories();
        $data = [];
        foreach ($categories as $category) {
            $articles = $articleDao->getArticlesByCategory($category['id']);
            $data[] = [
                'category' => $category['libelle'],
                'articles' => $articles
            ];
        }
        sendResponse($data, $format);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
?>
