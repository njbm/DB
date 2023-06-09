<?php

namespace BITM\SEIP12;

use BITM\SEIP12\Config;

class Slider
{

    public $id = null;
    public $uuid = null;
    public $src = null;
    public $alt = null;
    public $title = null;
    public $caption = null;

    private $data = null;
    private $conn = null;

    public function __construct(){

        if(Config::$driver == 'mysql'){
            $this->connectdb();
        }elseif(Config::$driver == 'json'){
            $this->connectjson();
        }      
    }

    public function index()
    {
        $stmt = $this->conn->prepare('SELECT * FROM sliders');
        $stmt->execute();
        // Fetch the records so we can display them in our template.
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "\BITM\SEIP12\Slider");
        $sliders = $stmt->fetchAll();
        return $this->conn = $sliders;
    }

    public function store($slider){
            
        // prepare the sql; INSERT
        $stmt = $this->conn->prepare('INSERT INTO `sliders`  (`uuid`, `title`, `src`, `alt`, `caption`, `created_at`, `updated_at`, `created_by`, `updated_by`) 
        VALUES (:uuid, :title, :path, :alt, :caption, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :created_by, :updated_by)');
        
        $stmt->bindParam(':uuid', $slider->uuid, \PDO::PARAM_STR);
        $stmt->bindParam(':title',$slider->title, \PDO::PARAM_STR);
        $stmt->bindParam(':path', $slider->src, \PDO::PARAM_STR);
        $stmt->bindParam(':alt', $slider->alt, \PDO::PARAM_STR);
        $stmt->bindParam(':caption', $slider->caption, \PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $slider->created_by, \PDO::PARAM_STR);
        $stmt->bindParam(':updated_by', $slider->updated_by, \PDO::PARAM_STR);

        // insert the data to database : Execute
        try{
            $stmt->execute();
            return true;
        }catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function show($id)
    {
        return $this->find($id);
    }


    public function edit($id = null)
    {
        return $this->find($id);
    }

    public function update($slider) {
        // Prepare the SQL statement
        $stmt = $this->conn->prepare('UPDATE `sliders` SET  `title` = :title, `src` = :path,
         `alt` = :alt, `caption` = :caption, `updated_at` = CURRENT_TIMESTAMP, `created_by` = :created_by,
          `updated_by` = :updated_by WHERE `id` = :id');
    
        // Bind the parameters
      
        $stmt->bindParam(':title', $slider->title, \PDO::PARAM_STR);
        $stmt->bindParam(':path', $slider->src, \PDO::PARAM_STR);
        $stmt->bindParam(':alt', $slider->alt, \PDO::PARAM_STR);
        $stmt->bindParam(':caption', $slider->caption, \PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $slider->created_by, \PDO::PARAM_STR);
        $stmt->bindParam(':updated_by', $slider->updated_by, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $slider->id, \PDO::PARAM_INT); // Assuming `$slider` has an `id` property
    
        try {
            // Execute the update statement
            $stmt->execute();
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    


    public function delete($id)
    {
        $stmt = $this->conn->prepare('DELETE FROM sliders WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
    
        try {
            $stmt->execute();
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    

    public function trash() { }

    public function delete2() { }   //soft delete 

    public function pdf() { }

    public function xl() { }

    public function word() { }

    public function last_highest_id()
    {
        $curentUniqueId = null;

        if (count($this->data) > 0) {
            // finding unique ids
            $ids = [];
            foreach ($this->data as $aslide) {
                $ids[] = $aslide->id;
            }
            sort($ids);
            $lastIndex = count($ids) - 1;
            $highestId = $ids[$lastIndex];

            $curentUniqueId = $highestId + 1;
        } else {
            $curentUniqueId = 1;
        }
        return $curentUniqueId;
    }

    private function prepare($slider)
    {
        if (is_null($slider->id) || empty($slider->id)) {
            $slider->id = $this->last_highest_id();
        }
        if (is_null($slider->uuid) || empty($slider->uuid)) {
            $slider->uuid = uniqid();
        }
        return $slider;
    }


    public function find($id = null)
    {
        if (is_null($id) || empty($id)) {
            return null;
        }

        $stmt = $this->conn->prepare('SELECT * FROM sliders WHERE id = ?');
        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();

        $sliderData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($sliderData) {
            $slider = new Slider();
            $slider->id = $sliderData['id'];
            $slider->alt = $sliderData['alt'];
            $slider->title = $sliderData['title'];
            $slider->caption = $sliderData['caption'];
            $slider->src = $sliderData['src'];

            return $slider;
        }
        return null; // Return null if the slider with the provided ID is not found
    }

    public function findAll() { }

    private function connectdb()
    {     
        try {   
            $this->conn = new \PDO('mysql:host=' . Config::DB_HOST . ';dbname=' . 
            Config::DB_NAME . ';charset=utf8', Config::DB_USER, Config::DB_PASSWORD);
        } catch (\PDOException $e) {
            // If there is an error with the connection, stop the script and display the error.
            echo $e->getMessage();
            //echo 'Failed to connect to database!';
        }
    }

    private function connectjson(){
        $dataSlides = file_get_contents(Config::datasource().'slideritems.json');
        $this->data = json_decode($dataSlides);
    }

}
