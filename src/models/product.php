<?php
require __DIR__ . '/../../vendor/autoload.php'; // MongoDB PHP Library

class Product {
    private $collection;
    private $id;
    private $name;
    private $description;
    private $price;
    private $quantity; 
    private $img_url;
    private $category;
    private $specs; 

    public function __construct($db) {
        $this->collection = $db->products; // a kollekció neve 'products'
    }

    // Setters
    public function setId($id) {
        $this->id = new MongoDB\BSON\ObjectId($id);
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setImg_url($url){
        $this->img_url = $url;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setSpecs($specs) {
        $this->specs = $specs;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getImg_url(){
        return $this->img_url;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getSpecs() {
        return $this->specs;
    }

    // Save method to create or update a product
    public function save() {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category' => $this->category,
            'specs' => $this->specs,
            'img_url' => $this->img_url
        ];

        if ($this->id) {
            // Update existing product
            $result = $this->collection->updateOne(
                ['_id' => $this->id],
                ['$set' => $data]
            );
            return $result->getModifiedCount() > 0;
        }
        else {
            // Create new product
            $result = $this->collection->insertOne($data);
            $this->id = $result->getInsertedId();
            return $result->getInsertedCount() > 0;
        }
    }

    // Read all products
    public function readAll($limit = 20, $sortOptions = [], $filter = []) {
        $pipeline = [];

        // Match stage for filtering
        if (!empty($filter)) {
            $pipeline[] = ['$match' => $filter];
        }

        // Sort stage
        if (!empty($sortOptions)) {
            $pipeline[] = ['$sort' => $sortOptions];
        }

        // Limit stage
        $pipeline[] = ['$limit' => $limit];

        // Execute aggregation pipeline
        $cursor = $this->collection->aggregate($pipeline);

        // Convert cursor to array of results
        return iterator_to_array($cursor);
    }

    // Delete a product by ID
    public function delete($id) {
        $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        return $result->getDeletedCount() > 0;
    }
}
?>
