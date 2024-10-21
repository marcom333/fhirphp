<?php 

namespace Medina\Fhir\Resource;

use Medina\Fhir\Element\Reference;
use Medina\Fhir\Element\Meta;
use Medina\Fhir\Exception\TextNotDefinedException;

class Resource{
    public $id, $resourceType, $ConceptosSNOMED, $meta, $implicitRules, $language, $referenceDisplay, $display, $mark;

    protected $validationArray = [
        [
            "field"=>"id",
            "validation"=>["defined"=>true, "empty"=>true, "array"=>true, "type"=>"Resource", "instanceOf"=>"Resource", "exact"=>[""]]
        ]
    ];

    protected $validationResoults = [];

    public function __construct($json = null){
        $this->mark = 0;
        $this->ConceptosSNOMED = [];
        // if($json) $this->loadData($json);

        if(!$this->id){
            // dd($json->id,$this);
            $this->setId(hash("MD5", microtime(true) . " " . rand(0, 10000000)));
        }
        // parent::loadData($json);
    }
    public function loadData($json){
        // echo "Resource<br>";
        if(isset($json->id)) { $this->setId($json->id); }
        if(isset($json->meta)) $this->setMeta(Meta::Load($json->meta));
        if(isset($json->implicitRules)) $this->setImplicitRules($json->implicitRules);
        if(isset($json->language)) $this->setLanguage($json->language);
        if(isset($json->display)) $this->setDisplay($json->display);
        if(isset($json->resourceType)) $this->resourceType = $json->resourceType;
        if(isset($json->ConceptosSNOMED)){
            foreach($json->ConceptosSNOMED as $conceptos){
                $this->ConceptosSNOMED[] = $conceptos;
            }
        }
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setMeta(Meta $meta){
        $this->meta = $meta;
    }
    public function setImplicitRules($implicitRules){
        $this->implicitRules = $implicitRules;
    }
    public function setLanguage($language){
        $this->language = $language;
    }
    public function setDisplay($display){
        $this->referenceDisplay = $display;
    }
    public function toArray(){
        $dataArray = [];
        $dataArray["resourceType"]=$this->resourceType;
        if(isset($this->id))
            $dataArray["id"] = $this->id;
        if(isset($this->meta))
            $dataArray["meta"] = $this->meta->toArray();
        if(isset($this->implicitRules))
            $dataArray["implicitRules"] = $this->implicitRules;
        if(isset($this->language))
            $dataArray["language"] = $this->language;
        if(isset($this->display))
            $dataArray["display"] = $this->display;
        return $dataArray;
    }
    public function toJson(){
        return json_encode($this->toArray());
    }
    public function toString(){
        return $this->resourceType;
    }
    
    /* Funciones para clases heredadas */
    public function toReference(){
        $this->referenceDisplay = $this->toString();
        if(isset($this->referenceDisplay))
            return new Reference($this->resourceType, $this->id, $this->referenceDisplay);
        return new Reference($this->resourceType, $this->id);
    }
    public function only($array, $string){
        foreach($array as $item){
            if($item == $string)
                return $item;
        }
        throw new TextNotDefinedException($string, implode($array));
    }

    public function validate(){
        $isValidated = true;
        foreach($this->validationArray as $rule){
            foreach($rule["validation"] as $type => $validation){
                $field = $rule["field"];
                if($type == "defined" && !isset($this->$field)){
                    $isValidated = false;
                    $this->validationResoults[$field] = $type;
                    break;
                }
                if($type == "empty" && $this->$field == ""){
                    $isValidated = false;
                    $this->validationResoults[$field] = $type;
                    break;
                }
                if($type == "array" && sizeof($this->$field) == 0){
                    $isValidated = false;
                    $this->validationResoults[$field] = $type;
                    break;
                }
                if($type == "type" && gettype($this->$field) != $validation){
                    $isValidated = false;
                    $this->validationResoults[$field] = $type;
                    break;
                }
                if($type == "get_class" && get_class($this->$field) != $validation){
                    $isValidated = false;
                    $this->validationResoults[$field] = $type;
                    break;
                }
                if($type == "exact" && !in_array($this->$field, $validation, true)){
                    $isValidated = false;
                    $this->validationResoults[$field] = $type;
                    break;
                }
            }
        }
        return $isValidated;
    }
}