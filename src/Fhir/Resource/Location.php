<?php 

namespace Medina\Fhir\Resource;

use Medina\Fhir\Element\Address;
use Medina\Fhir\Element\CodeableConcept;
use Medina\Fhir\Element\Coding;
use Medina\Fhir\Element\ContactPoint;
use Medina\Fhir\Element\Identifier;
use Medina\Fhir\Element\Reference;

class Location extends DomainResource{
    public function __construct($json = null){
        $this->resourceType = "Location";
        parent::__construct($json);
        $this->identifier = [];
        if($json) $this->loadData($json);
    }
    public function loadData($json){
        parent::loadData($json);
        if (isset($json->identifier))
            foreach ($json->identifier as $identifier)
                $this->identifier[] = Identifier::Load($identifier);
        if (isset($json->status)){
            $array = ["active", "suspended","inactive"];
            $this->status = $json->status;
        }
        if (isset($json->operationalStatus)){
            $this->operationStatus = Coding::Load($json->operationalStatus);
        }
        if (isset($json->name))
            $this->name = $json->name;
        if (isset($json->alias)){
            $aliases = [];
            foreach ($json->alias as $alias)
                $aliases[] = $alias;
            $this->alias = $aliases;
        }
        if (isset($json->description))
            $this->description = $json->description;
        if (isset($json->mode)){
            $array = ["instance", "kind"];
            $this->mode = $json->mode;
        }
        if (isset($json->type)){
            $types = [];
            foreach ($json->type as $type)
                $types[] = CodeableConcept::Load($type);
            $this->type = $types;
        }
        if (isset($json->telecom)){
            $contactpoints = [];
            foreach ($json->telecom as $telecom)
                $contactpoints[] = ContactPoint::Load($telecom);
            $this->telecom = $contactpoints;
        }
        if (isset($json->address))
            $this->address = Address::Load($json->address);
        if (isset($json->physicalType))
            $this->physicalType = CodeableConcept::Load($json->physicalType);
        if (isset($json->position)){
            $this->position = [];
            if (isset($json->position->longitude))
                $this->position["longitude"] = $json->position->longitude;
            if (isset($json->position->latitude))
                $this->position["latitude"] = $json->position->latitude;
            if (isset($json->position->altitude))
                $this->position["altitude"] = $json->position->altitude;
        }
        if (isset($json->managingOrganization))
            $this->managingOrganization = Reference::Load($json->managingOrganization);
        if (isset($json->partOf))
            $this->partOf = Reference::Load($json->partOf);
        if (isset($json->hoursOfOperation)){
            $hours = [];
            foreach ($json->hoursOfOperation as $hoursOfOperation){
                $hours = [];
                if (isset($hoursOfOperation->daysOfWeek)){
                    $days = [];
                    foreach ($hoursOfOperation->daysOfWeek as $daysOfWeek){
                        $array = ["mon","tue","wed","thu","fri","sat","sun"];
                        $days[] = $daysOfWeek;
                    }
                    $hours["hoursOfOperation"] = $days;
                }
                if (isset($hoursOfOperation->allDay))
                    $hours["allDay"] = $hoursOfOperation->allDay;
                if (isset($hoursOfOperation->openingTime))
                    $hours["openingTime"] = $hoursOfOperation->openingTime;
                if (isset($hoursOfOperation->closingTime))
                    $hours["closingTime"] = $hoursOfOperation->closingTime;
            }
        }
        if (isset($json->availabilityExceptions))
            $this->availabilityExceptions = $json->availabilityExceptions;
        if (isset($json->endpoint))
            foreach ($json->endpoint as $endpoint)
                $this->endpoint[] = Reference::Load($endpoint);
    }
    /* campo obligatorio (estandar) */
    public function addIdentifier(Identifier $identifier){
        $this->identifier[] = $identifier;
    }
    /* campo opcional */
    public function setStatus($status){
        $array = ["active", "suspended","inactive"];
        $this->status = $status;
    }
    /* campo opcional */
    public function setOperationalStatus(Coding $operationalStatus){
        $this->operationStatus = $operationalStatus;
    }
    /* campo obligatorio (estandar) */
    public function setName($name){
        $this->name = $name;
    }
    /* campo opcional */
    public function addAlias($alias){
        $this->alias[] = $alias;
    }
    /* campo opcional */
    public function setDescription($description){
        $this->description = $description;
    }
    /* campo opcional */
    public function setMode($mode){
        $array = ["instance", "kind"];
        $this->mode = $mode;
    }
    /* campo obligatorio (estandar) (array 1..*):
        \Fhir\Element\CodeableConcept:    
            "coding": \Fhir\Element\Coding (array 1..*):
                "system": "http://terminology.hl7mx.org/ssa/CodeSystem/tipos-establecimientos",
                "code": "1",
                "display": "DE HOSPITALIZACIÓN"
            "text"
    */
    public function addType(CodeableConcept $type){
        $this->type[] = $type;
    }
    /* campo opcional */
    public function addTelecom(ContactPoint $telecom){
        $this->telecom[] = $telecom;
    }
    /* campo obligatorio (estandar): 
        \Fhir\Element\Address: 
            "type": "both",
            "text": 
            "city": 
            "district":
            "state": 
            "postalCode": 
            "line": (array 1..*)
            "extension": (array 1..*)
                "url": "http://terminology.hl7mx.org/address/colonia",
                "valueString":
    */
    public function setAddress(Address $address){
        $this->address = $address;
    }
    /* campo opcional */
    public function setPhysicalType(CodeableConcept $physicalType){
        $this->physicalType = $physicalType;
    }
    /* campo opcional */
    public function setPosition($longitude, $latitude, $altitude){
        $this->position = [];
        if (isset($longitude))
            $this->position["longitude"] = $longitude;
        if (isset($latitude))
            $this->position["latitude"] = $latitude;
        if (isset($altitude))
            $this->position["altitude"] = $altitude;
    }
    /* campo obligatorio (estandar)
        \Fhir\Element\Reference
            reference: "Organization"
            display:
    */
    public function setManagingOrganization(Resource $managingOrganization){
        $this->managingOrganization = $managingOrganization->toReference();
    }
    /* campo opcional */
    public function setPartOf(Resource $partOf){
        $this->partOf = $partOf->toReference();
    }
    /* campo opcional */
    public function addHoursOfOperation($daysOfWeek, $allDay, $openingTime, $closingTime){
        $hours = [];
        $hours = [];
        if (isset($daysOfWeek)){
            $days = [];
            foreach ($daysOfWeek as $daysdata){
                $array = ["mon","tue","wed","thu","fri","sat","sun"];
                $days[] = $daysdata;
            }
            $hours["daysOfWeek"] =$days;
        }
        if (isset($allDay))
            $hours["allDay"] = $allDay;
        if (isset($openingTime))
            $hours["openingTime"] = $openingTime;
        if (isset($closingTime))
            $hours["closingTime"] = $closingTime;
    }
    /* campo opcional */
    public function setAvailabilityExceptions($availabilityExceptions){
        $this->availabilityExceptions = $availabilityExceptions;
    }
    /* campo opcional */
    public function addEndpoint(Resource $endpoint){
        $this->endpoint[] = $endpoint->toReference();
    }


    public function toString(){
        return "Localización";
    }

    public function toArray(){
        $arrayData = parent::toArray();
        if (isset($this->identifier))
            foreach ($this->identifier as $identifier)
                $arrayData["identifier"][] = $identifier->toArray();
        if (isset($this->status)){
            $array = ["active", "suspended","inactive"];
            $arrayData["status"] = $this->status;
        }
        if (isset($this->operationalStatus)){
            $arrayData["operationStatus"] = $this->operationalStatus->toArray();
        }
        if (isset($this->name))
            $arrayData["name"] = $this->name;
        if (isset($this->alias)){
            $aliases = [];
            foreach ($this->alias as $alias)
                $aliases[] = $alias;
            $arrayData["alias"] = $aliases;
        }
        if (isset($this->description))
            $arrayData["description"] = $this->description;
        if (isset($this->mode)){
            $array = ["instance", "kind"];
            $arrayData["mode"] = $this->mode;
        }
        if (isset($this->type)){
            $types = [];
            foreach ($this->type as $type)
                $types[] = $type->toArray();
            $arrayData["type"][] = $types;
        }
        if (isset($this->telecom)){
            $contactpoints = [];
            foreach ($this->telecom as $telecom)
                $contactpoints[] = $telecom->toArray();
            $arrayData["telecom"] = $contactpoints;
        }
        if (isset($this->address))
            $arrayData["address"] = $this->address->toArray();
        if (isset($this->physicalType))
            $arrayData["physicalType"] = $this->physicalType->toArray();
        if (isset($this->position)){
            $arrayData["position"] = [];
            if (isset($this->position["longitude"]))
                $arrayData["position"]["longitude"] = $this->position["longitude"];
            if (isset($this->position["latitude"]))
                $arrayData["position"]["latitude"] = $this->position["latitude"];
            if (isset($this->position["altitude"]))
                $arrayData["position"]["altitude"] = $this->position["altitude"];
        }
        if (isset($this->managingOrganization))
            $arrayData["managingOrganization"] = $this->managingOrganization->toArray();
        if (isset($this->partOf))
            $arrayData["partOf"] = $this->partOf->toArray();
        if (isset($this->hoursOfOperation)){
            $hours = [];
            foreach ($this->hoursOfOperation as $hoursOfOperation){
                $hours = [];
                if (isset($hoursOfOperation->daysOfWeek)){
                    $days = [];
                    foreach ($hoursOfOperation->daysOfWeek as $daysOfWeek){
                        $array = ["mon","tue","wed","thu","fri","sat","sun"];
                        $days[] = $daysOfWeek;
                    }
                    $hours["hoursOfOperation"] = $days;
                }
                if (isset($hoursOfOperation->allDay))
                    $hours["allDay"] = $hoursOfOperation->allDay;
                if (isset($hoursOfOperation->openingTime))
                    $hours["openingTime"] = $hoursOfOperation->openingTime;
                if (isset($hoursOfOperation->closingTime))
                    $hours["closingTime"] = $hoursOfOperation->closingTime;
            }
        }
        if (isset($this->availabilityExceptions))
            $arrayData["availabilityExceptions"] = $this->availabilityExceptions;
        if (isset($this->endpoint))
            foreach ($this->endpoint as $endpoint)
                $arrayData["endpoint"] = $endpoint->toArray();
        return $arrayData;
    }
}