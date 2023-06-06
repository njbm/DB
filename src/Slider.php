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
        return $this->data;
    }

    public function index2()
    {
        $stmt = $this->conn->prepare('SELECT * FROM sliders');
        $stmt->execute();
        // Fetch the records so we can display them in our template.
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "\BITM\SEIP12\Slider");
        $sliders = $stmt->fetchAll();
        return $this->data = $sliders;
    }

    public function create()
    {
    }

    public function store($slider)
    {
        $slider = $this->prepare($slider);
        $this->data[] = (object) (array) $slider; // data is a slider object
        return $this->insert();
    }

    public function store2($slider){
            
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

    public function show2($id){

        $stmt = $this->conn->prepare('SELECT * FROM sliders WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "\BITM\SEIP12\Slider");
        return $slider = $stmt->fetch();
       
    }

    public function edit($id = null)
    {
        return $this->find($id);
    }

    public function update($slider)
    {

        $slider = $this->prepare($slider);

        foreach ($this->data as $key => $aslide) {
            if ($aslide->id == $slider->id)
                break;
        }

        $this->data[$key] =  $slider;
        return $this->insert();
    }

    public function destroy($id = null)
    { //completely removed
        if (empty($id)) {
            return;
        }

        foreach ($this->data as $key => $slide) {
            if ($slide->id == $id) {
                break;
            }
        }
        // dd($key); to be deleted

        unset($this->data[$key]);
        //reindexing the array
        $this->data = array_values($this->data);

        //array_splice($slides, $key, 1); // it reindexes
        //$data_slides = json_encode($slides);

        return $this->insert();
    }


    public function trash()
    {
    }

    public function delete()
    { //soft delete

    }


    public function pdf()
    {
    }


    public function xl()
    {
    }


    public function word()
    {
    }

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


    private function insert()
    {

        $datafile = Config::datasource() . "slideritems.json";
        if (file_exists($datafile)) {
            file_put_contents($datafile, json_encode($this->data));
            return true;
        } else {
            echo "File not found";
            return false;
        }
    }

    public function find($id = null)
    {
        if (is_null($id) || empty($id)) {
            return true;
        }
        $slide = null;
        foreach ($this->data as $aslide) {
            if ($aslide->id == $id) {
                $slide = $aslide;
                break;
            }
        }
        return $slide;
    }

    public function findAll()
    {
    }

    private function connectdb()
    {     
        try {
            
                $this->conn = new \PDO('mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8', Config::DB_USER, Config::DB_PASSWORD);
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
