<?php 
namespace Medina\Fhir\Resource;

use Medina\Fhir\Element\Identifier;
use Medina\Fhir\Exception\IncompleteException;

class Bundle extends DomainResource{

    public array $entry; 
    public string $type;
    public string $timestamp;
    public Identifier $identifier;
    public int $total;

    protected $validationArray = [
        [
            "field"=>"resourceType",
            "validation"=>["defined"=>true, "empty"=>true, "exact"=>["Bundle"]]
        ],
        [
            "field"=>"id",
            "validation"=>["defined"=>true, "empty"=>true]
        ],
        [
            "field"=>"type",
            "validation"=>["defined"=>true, "empty"=>true, "exact"=>["document", "history"]]
        ]
    ];

    public function __construct($json = null){
        $this->resourceType = "Bundle";
        $this->timestamp = "";
        parent::__construct($json);
        $this->entry = [];
        $this->type = "document";
        if($json){
            $this->loadData($json);
        }
    }
    /* adquiere un json y lo transforma a Bundle */
    public function loadData($json){
        parent::loadData($json);
        if(gettype(value: $json) === "string"){
            $json = json_decode($json);
        }
        if(isset($json->entry)){
            foreach($json->entry as $entry){
                if(isset($entry->resource) && isset($entry->resource->resourceType)){
                    // dd($entry);
                    if(!isset($entry->resource->id)){
                        $entry->resource->id = str_replace("urn:uuid:", "",$entry->fullUrl);
                    }
                    // if($entry->resource->resourceType != "Patient") dd($entry);
                    $this->addEntry(resource: ResourceBuilder::make($entry->resource));
                }
            }
        }
        if(isset($json->identifier)){
            $this->setIdentifier(Identifier::Load($json->identifier));
        }
        if(isset($json->type)){
            $this->setType($json->type);
        }
        if(isset($json->tipestamp)){
            $this->setTimestamp($json->timestamp);
        }
        if(isset($json->total)){
            $this->setTotal($json->total);
        }
    }
    public function setIdentifier(Identifier $identifier){
        $this->identifier = $identifier;
    }
    public function setType(String $type){
        $only = ["document","message","transaction","transaction-response","batch","batch-response","history","searchset","collection"];
        $this->type = $this->only($only, $type);
    }
    public function setTimestamp(String $timestamp){
        $this->timestamp = $timestamp;
    }
    public function setTotal(int $total){
        $this->total = $total;
    }
    public function addEntry(Resource $resource){
        $this->entry[$resource->id] = $resource;
        if($resource->resourceType == "Bundle")
            $this->type = "history";
    }
    /**
     * @param string $id
     * @param integer $skip
     * @param integer $mark
     * @return \Medina\Fhir\Resource\Resource
    */
    public function findResource($id, $skip = -1, $mark=0){
        /*
        if(!isset($this->entry[$id])){
            dd([$id,$this->entry]);
        }
        $resource = $this->entry[$id];
        if($skip != $resource->mark && isset($resource->id) && $resource->id == $id){
            $resource->mark=$mark;
            return $resource;
        }*/
        foreach($this->entry as $key => $entry){
            $resource = $entry;
            if($skip != $entry->mark && isset($resource->id) && $resource->id == $id){
                $entry->mark=$mark;
                return $entry;
            }
        }
        return new Resource();
    }
    public function findHistoriaClinica($skip = -1){
        $data = [];
        foreach($this->entry as $key => $entry){
            if($skip != $entry->mark && $entry->resourceType == "Composition" && $entry->esHistoriaClinica()){
                $entry->mark = $skip;
                $data[] = $entry;
            }
            if($skip != $entry->mark && $entry->resourceType == "Bundle"){
                $bundle = $entry->findHistoriaClinica($skip);
                array_merge($data, $bundle);
            }
        }
        return $data;
    }
    public function findNotaEvolucion($skip = -1){
        $data = [];
        foreach($this->entry as $key => $entry){
            if($skip != $entry->mark && $entry->resourceType == "Composition" && $entry->esNotaEvolucion()){
                $entry->mark = $skip;
                $data[] = $entry;
            }
            if($skip != $entry->mark && $entry->resourceType == "Bundle"){
                $bundle = $entry->findNotaEvolucion($skip);
                array_merge($data, $bundle);
            }
        }
        return $data;
    }
    public function findCompositions(){
        $data = [];
        foreach($this->entry as $key => $entry){
            if($entry->resourceType == "Composition"){
                $data[] = $entry;
            }
            if($entry->resourceType == "Bundle"){
                array_merge($data, $entry->findCompositions());
            }
        }
        return $data;
    }
    public function findComposition($mark){
        $resource = new Resource();
        foreach($this->entry as $key => $entry){
            if($entry->resourceType == "Composition"){
                $entry->mark = $mark;
                return $entry;
            }
        }
        return $resource;
    }
    public function findPatient($skip = -1){
        foreach($this->entry as $key => $entry){
            if($skip != $entry->mark && $entry->resourceType == "Patient"){
                $entry->mark = $skip;
                return $entry;
            }
        }
    }
    public function findAllergy($skip = -1){
        $data = [];
        foreach($this->entry as $key => $entry){
            if($skip != $entry->mark && $entry->resourceType == "AllergyIntolerance"){
                $entry->mark = $skip;
                $data [] = $entry;
            }
            if($entry->resourceType == "Bundle"){
                $elements = $entry->findAllergy($skip);
                $data = array_merge($data, $elements);
            }
        }
        return $data;
    }
    public function toString(){
        $compositions = $this->findCompositions();
        if($compositions)
            return $compositions[0]->toString();
        else
            return "Documento " . $this->timestamp;
    }

    public function toArray(){
        if(!$this->validate()) throw new IncompleteException();
        $arrayData = parent::toArray();

        if(isset($this->identifier)){
            $arrayData["identifier"] = $this->identifier->toArray();
        }
        if(isset($this->type)){
            $arrayData["type"] = $this->type;
        }
        if(isset($this->timestamp)){
            $arrayData["timestamp"] = $this->timestamp;
        }
        if(isset($this->total)){
            $arrayData["total"] = $this->total;
        }

        $entryArray = [];
        foreach ($this->entry as $entry) {
            $current = [];
            $current["resource"]=$entry->toArray();
            $current["fullUrl"]= $entry->resourceType . '/' . $entry->id;
            if($this->type == "history"){
                $current["request"] = [
                    "method"=>"POST",
                    "url"=>$entry->resourceType
                ];
    
                $current["response"] = [
                    "status"=>"200 ok"
                ];
            }
            
            $entryArray[] = $current;
        }
        $arrayData["entry"] = $entryArray;

        return $arrayData;
    }
}