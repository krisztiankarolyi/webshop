<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
require_once '../src/models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$request_method = $_SERVER["REQUEST_METHOD"];
$syntax = json_encode(array(
    'product' => array(
        'name' => 'str',
        'price' => 'float/str',
        'quantity' => 'int',
        'category' => 'string',
        'specs' => 'dict',
        'description' => 'string',
        'img_url' => 'string'
    )
));

$errorMessage = "Unable to create product. The syntax for inserting a product with JSON is: ";

switch($request_method) {
    case 'GET':
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20; // Alapértelmezett limit 20
        $sort = isset($_GET['sort']) ? $_GET['sort'] : array(); // Alapértelmezett rendezés nincs beállítva
        $id = isset($_GET['id']) ? $_GET['id'] : array();

        // Ellenőrizzük, hogy a sort paraméter be van-e állítva és helyes-e
        $sortOptions = [];
        if ($id) {
            $product = $product->readOne($id);
            if($product)
                echo json_encode($product);
            else
                echo json_encode("The product ($id) does not exist");
            break;
        }

        // Szűrési opciók beállítása
        $filter = [];
        // String típusú mezők szűrése
        if (isset($_GET['name'])) {
            $filter['name'] = $_GET['name'];
        }
        if (isset($_GET['category'])) {
            $filter['category'] = $_GET['category'];
        }
        if (isset($_GET['description'])) {
            $filter['description'] = $_GET['description'];
        }
        if (isset($_GET['img_url'])) {
            $filter['img_url'] = $_GET['img_url'];
        }

        // Float vagy String típusú mező szűrése (pl. price)
        if (isset($_GET['min_price'])) {
            $minPrice = floatval($_GET['min_price']);
            $filter['price'] = ['$gte' => $minPrice];
        }

        // Int típusú mezők szűrése (pl. quantity)
        if (isset($_GET['min_quantity'])) {
            $minQuantity = intval($_GET['min_quantity']);
            $filter['quantity'] = ['$gte' => $minQuantity];
        }
        if (isset($_GET['max_quantity'])) {
            $maxQuantity = intval($_GET['max_quantity']);
            $filter['quantity']['$lte'] = $maxQuantity;
        }

        // Szótár típusú mező szűrése (pl. specs)
        if (isset($_GET['spec_key']) && isset($_GET['spec_value'])) {
            $specKey = $_GET['spec_key'];
            $specValue = $_GET['spec_value'];
            $filter['specs.' . $specKey] = $specValue;
        }

        if ($sort)
        {
            if (strpos($sort, '_') !== false) {
                list($sortField, $sortOrder) = explode('_', $sort);
                if ($sortOrder === 'asc' || $sortOrder === 'desc') {
                    $sortOptions[$sortField] = ($sortOrder === 'asc') ? 1 : -1;
                }
            }
        }
        $products = $product->readAll($limit, $sortOptions, $filter);
        echo json_encode($products);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data)) {
            if(!isset($data['specs'])) $data['specs'] = [];
            if(!isset($data['quantity'])) $data['quantity'] = 1;
            if(!isset($data['img_url'])) $data['img_url'] = "";

            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setQuantity($data['quantity']); 
            $product->setCategory($data['category']); 
            $product->setImg_url($data['img_url']);
            $product->setSpecs($data['specs']); 

            if ($product->save()) {
                echo json_encode(array("message" => "Product". $data["name"] ." was created."));
            } else {
                echo json_encode(array("message" => $errorMessage));
                echo $syntax;

            }
        } else {
            echo json_encode(array("message" => $errorMessage));
            echo $syntax;

        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data) && isset($_GET['id'])) {
            $product->setId($_GET['id']);
            if (isset($data['name'])) $product->setName($data['name']);
            if (isset($data['description'])) $product->setDescription($data['description']);
            if (isset($data['price'])) $product->setPrice($data['price']);
            if (isset($data['quantity'])) $product->setQuantity($data['quantity']); // új quantity beállítása
            if (isset($data['category'])) $product->setCategory($data['category']); // új category beállítása
            if (isset($data['specs'])) $product->setSpecs($data['specs']); // új specs beállítása

            if ($product->save()) {
                echo json_encode(array("message" => "Product was updated."));
            } else {
                echo json_encode(array("message" => "Unable to update product."));
            }
        } else {
            echo json_encode(array("message" => "No data provided or ID missing."));
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            if ($product->delete($_GET['id'])) {
                echo json_encode(array("message" => "Product was deleted."));
            } else {
                echo json_encode(array("message" => "Unable to delete product."));
            }
        } else {
            echo json_encode(array("message" => "ID not provided."));
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
