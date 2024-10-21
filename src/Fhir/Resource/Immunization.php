<?php

namespace Medina\Fhir\Resource;

use Medina\Fhir\Element\Annotation;
use Medina\Fhir\Element\CodeableConcept;
use Medina\Fhir\Element\Identifier;
use Medina\Fhir\Element\Quantity;
use Medina\Fhir\Element\Reference;

class Immunization extends DomainResource {

    public $identifier, $basedOn, $performer, $note, $reason, $subpotentReason, $programEligibility, $reaction, $protocolMedinalied;
    public $status, $statusReason, $vaccineCode, $administeredProduct, $manufacturer, $lotNumber, $expirationDate, $patient;
    public $encounter, $supportingInformation, $occurrenceDateTime, $occurrenceString, $primarySource, $informationSource;
    public $location, $site, $route, $doseQuantity, $isSubpotent, $fundingSource;

    public function __construct($json = null) {
        $this->resourceType = "Immunization";
        parent::__construct($json);

        $this->identifier = [];
        $this->basedOn = [];
        $this->performer = [];
        $this->note = [];
        $this->reason = [];
        $this->subpotentReason = [];
        $this->programEligibility = [];
        $this->reaction = [];
        $this->protocolMedinalied = [];

        if ($json) $this->loadData($json);
    }

    public function toString(){
        return "Inmunización";
    }

    public function loadData($json) {
        parent::loadData($json);
        if (isset($json->identifier))
            foreach ($json->identifier as $identifier)
                $this->identifier[] = Identifier::Load($identifier);
        if (isset($json->basedOn))
            foreach ($json->basedOn as $basedOn)
                $this->basedOn[] = Reference::Load($basedOn);
        if (isset($json->status))
            $this->status = $json->status;
        if (isset($json->statusReason))
            $this->statusReason = CodeableConcept::Load($json->statusReason);
        if (isset($json->vaccineCode))
            $this->vaccineCode = CodeableConcept::Load($json->vaccineCode);
        if (isset($json->administeredProduct))
            $this->administeredProduct = Reference::Load($json->administeredProduct);
        if (isset($json->manufacturer))
            $this->manufacturer = Reference::Load($json->manufacturer);
        if (isset($json->lotNumber))
            $this->lotNumber = $json->lotNumber;
        if (isset($json->expirationDate))
            $this->expirationDate = $json->expirationDate;
        if (isset($json->patient))
            $this->patient = Reference::Load($json->patient);
        if (isset($json->encounter))
            $this->encounter = Reference::Load($json->encounter);
        if (isset($json->supportingInformation))
            foreach ($json->supportingInformation as $supportingInformation)
                $this->supportingInformation[] = Reference::Load($supportingInformation);
        if (isset($json->occurrenceDateTime))
            $this->occurrenceDateTime = $json->occurrenceDateTime;
        if (isset($json->occurrenceString))
            $this->occurrenceString = $json->occurrenceString;
        if (isset($json->primarySource))
            $this->primarySource = $json->primarySource;
        if (isset($json->informationSource))
            $this->informationSource = Reference::Load($json->informationSource);
        if (isset($json->location))
            $this->location = Reference::Load($json->location);
        if (isset($json->site))
            $this->site = CodeableConcept::Load($json->site);
        if (isset($json->route))
            $this->route = CodeableConcept::Load($json->route);
        if (isset($json->doseQuantity))
            $this->doseQuantity = Quantity::Load($json->doseQuantity);
        if (isset($json->performer))
            foreach ($json->performer as $performer) {
                $perf = [];
                if (isset($performer->function))
                    $perf["function"] = CodeableConcept::Load($performer->function);
                if (isset($performer->actor))
                    $perf["actor"] = Reference::Load($performer->actor);
                $this->performer[] = $perf;
            }
        if (isset($json->note))
            foreach ($json->note as $note)
                $this->note[] = Annotation::Load($note);
        if (isset($json->reason))
            foreach ($json->reason as $reason)
                $this->reason[] = Reference::Load($reason);
        if (isset($json->isSubpotent))
            $this->isSubpotent = $json->isSubpotent;
        if (isset($json->subpotentReason))
            foreach ($json->subpotentReason as $subpotentReason)
                $this->subpotentReason[] = CodeableConcept::Load($subpotentReason);
        if (isset($json->programEligibility))
            foreach ($json->programEligibility as $programEligibility) {
                $program = [];
                if (isset($programEligibility->program))
                    $program["program"] = CodeableConcept::Load($programEligibility->program);
                if (isset($programEligibility->programStatus))
                    $program["programStatus"] = CodeableConcept::Load($programEligibility->programStatus);
                $this->programEligibility[] = $program;
            }
        if (isset($json->fundingSource))
            $this->fundingSource = CodeableConcept::Load($json->fundingSource);
        if (isset($json->reaction))
            foreach ($json->reaction as $reaction) {
                $react = [];
                if (isset($reaction->date))
                    $react["date"] = $reaction->date;
                if (isset($reaction->manifestation))
                    $react["manifestation"] = Reference::Load($reaction->manifestation);
                if (isset($reaction->reported))
                    $react["reported"] = $reaction->reported;
                $this->reaction[] = $react;
            }
        if (isset($json->protocolMedinalied))
            foreach ($json->protocolMedinalied as $protocolMedinalied) {
                $protocol = [];
                if (isset($protocolMedinalied->series))
                    $protocol["series"] = $protocolMedinalied->series;
                if (isset($protocolMedinalied->authority))
                    $protocol["authority"] = Reference::Load($protocolMedinalied->authority);
                if (isset($protocolMedinalied->targetDisease))
                    foreach ($protocolMedinalied->targetDisease as $targetDisease)
                        $protocol["targetDisease"][] = CodeableConcept::Load($targetDisease);
                if (isset($protocolMedinalied->doseNumber))
                    $protocol["doseNumber"] = $protocolMedinalied->doseNumber;
                if (isset($protocolMedinalied->seriesDoses))
                    $protocol["seriesDoses"] = $protocolMedinalied->seriesDoses;
                $this->protocolMedinalied[] = $protocol;
            }
    }

    // Methods for adding individual elements
    function addIdentifier(Identifier $identifier) {
        $this->identifier[] = $identifier;
    }

    function addBasedOn(Reference $basedOn) {
        $this->basedOn[] = $basedOn;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setStatusReason(CodeableConcept $statusReason) {
        $this->statusReason = $statusReason;
    }

    function setVaccineCode(CodeableConcept $vaccineCode) {
        $this->vaccineCode = $vaccineCode;
    }

    function setAdministeredProduct(Reference $administeredProduct) {
        $this->administeredProduct = $administeredProduct;
    }

    function setManufacturer(Reference $manufacturer) {
        $this->manufacturer = $manufacturer;
    }

    function setLotNumber($lotNumber) {
        $this->lotNumber = $lotNumber;
    }

    function setExpirationDate($expirationDate) {
        $this->expirationDate = $expirationDate;
    }

    function setPatient(Reference $patient) {
        $this->patient = $patient;
    }

    function setEncounter(Reference $encounter) {
        $this->encounter = $encounter;
    }

    function addSupportingInformation(Reference $supportingInformation) {
        $this->supportingInformation[] = $supportingInformation;
    }

    function setOccurrenceDateTime($occurrenceDateTime) {
        $this->occurrenceDateTime = $occurrenceDateTime;
    }

    function setOccurrenceString($occurrenceString) {
        $this->occurrenceString = $occurrenceString;
    }

    function setPrimarySource($primarySource) {
        $this->primarySource = $primarySource;
    }

    function setInformationSource(Reference $informationSource) {
        $this->informationSource = $informationSource;
    }

    function setLocation(Reference $location) {
        $this->location = $location;
    }

    function setSite(CodeableConcept $site) {
        $this->site = $site;
    }

    function setRoute(CodeableConcept $route) {
        $this->route = $route;
    }

    function setDoseQuantity(Quantity $doseQuantity) {
        $this->doseQuantity = $doseQuantity;
    }

    function addPerformer($function, Reference $actor) {
        $performer = ["function" => $function, "actor" => $actor];
        $this->performer[] = $performer;
    }

    function addNote(Annotation $note) {
        $this->note[] = $note;
    }

    function addReason(Reference $reason) {
        $this->reason[] = $reason;
    }

    function setIsSubpotent($isSubpotent) {
        $this->isSubpotent = $isSubpotent;
    }

    function addSubpotentReason(CodeableConcept $subpotentReason) {
        $this->subpotentReason[] = $subpotentReason;
    }

    function addProgramEligibility($program, $programStatus) {
        $programEligibility = ["program" => $program, "programStatus" => $programStatus];
        $this->programEligibility[] = $programEligibility;
    }

    function setFundingSource(CodeableConcept $fundingSource) {
        $this->fundingSource = $fundingSource;
    }

    function addReaction($date, Reference $manifestation, $reported) {
        $reaction = ["date" => $date, "manifestation" => $manifestation, "reported" => $reported];
        $this->reaction[] = $reaction;
    }

    function addProtocolMedinalied($series, Reference $authority, $targetDisease, $doseNumber, $seriesDoses) {
        $protocolMedinalied = [
            "series" => $series,
            "authority" => $authority,
            "targetDisease" => $targetDisease,
            "doseNumber" => $doseNumber,
            "seriesDoses" => $seriesDoses
        ];
        $this->protocolMedinalied[] = $protocolMedinalied;
    }

    function toArray() {
        $arrayData = parent::toArray();
        if (isset($this->identifier)) {
            $arrayData["identifier"] = [];
            foreach ($this->identifier as $identifier)
                $arrayData["identifier"][] = $identifier->toArray();
        }
        if (isset($this->basedOn)) {
            $arrayData["basedOn"] = [];
            foreach ($this->basedOn as $basedOn)
                $arrayData["basedOn"][] = $basedOn->toArray();
        }
        if (isset($this->status))
            $arrayData["status"] = $this->status;
        if (isset($this->statusReason))
            $arrayData["statusReason"] = $this->statusReason->toArray();
        if (isset($this->vaccineCode))
            $arrayData["vaccineCode"] = $this->vaccineCode->toArray();
        if (isset($this->administeredProduct))
            $arrayData["administeredProduct"] = $this->administeredProduct->toArray();
        if (isset($this->manufacturer))
            $arrayData["manufacturer"] = $this->manufacturer->toArray();
        if (isset($this->lotNumber))
            $arrayData["lotNumber"] = $this->lotNumber;
        if (isset($this->expirationDate))
            $arrayData["expirationDate"] = $this->expirationDate;
        if (isset($this->patient))
            $arrayData["patient"] = $this->patient->toArray();
        if (isset($this->encounter))
            $arrayData["encounter"] = $this->encounter->toArray();
        if (isset($this->supportingInformation)) {
            $arrayData["supportingInformation"] = [];
            foreach ($this->supportingInformation as $supportingInformation)
                $arrayData["supportingInformation"][] = $supportingInformation->toArray();
        }
        if (isset($this->occurrenceDateTime))
            $arrayData["occurrenceDateTime"] = $this->occurrenceDateTime;
        if (isset($this->occurrenceString))
            $arrayData["occurrenceString"] = $this->occurrenceString;
        if (isset($this->primarySource))
            $arrayData["primarySource"] = $this->primarySource;
        if (isset($this->informationSource))
            $arrayData["informationSource"] = $this->informationSource->toArray();
        if (isset($this->location))
            $arrayData["location"] = $this->location->toArray();
        if (isset($this->site))
            $arrayData["site"] = $this->site->toArray();
        if (isset($this->route))
            $arrayData["route"] = $this->route->toArray();
        if (isset($this->doseQuantity))
            $arrayData["doseQuantity"] = $this->doseQuantity->toArray();
        if (isset($this->performer)) {
            $arrayData["performer"] = [];
            foreach ($this->performer as $performer) {
                $performerData = [];
                if (isset($performer["function"]))
                    $performerData["function"] = $performer["function"]->toArray();
                if (isset($performer["actor"]))
                    $performerData["actor"] = $performer["actor"]->toArray();
                $arrayData["performer"][] = $performerData;
            }
        }
        if (isset($this->note)) {
            $arrayData["note"] = [];
            foreach ($this->note as $note)
                $arrayData["note"][] = $note->toArray();
        }
        if (isset($this->reason)) {
            $arrayData["reason"] = [];
            foreach ($this->reason as $reason)
                $arrayData["reason"][] = $reason->toArray();
        }
        if (isset($this->isSubpotent))
            $arrayData["isSubpotent"] = $this->isSubpotent;
        if (isset($this->subpotentReason)) {
            $arrayData["subpotentReason"] = [];
            foreach ($this->subpotentReason as $subpotentReason)
                $arrayData["subpotentReason"][] = $subpotentReason->toArray();
        }
        if (isset($this->programEligibility)) {
            $arrayData["programEligibility"] = [];
            foreach ($this->programEligibility as $programEligibility) {
                $program = [];
                if (isset($programEligibility["program"]))
                    $program["program"] = $programEligibility["program"]->toArray();
                if (isset($programEligibility["programStatus"]))
                    $program["programStatus"] = $programEligibility["programStatus"]->toArray();
                $arrayData["programEligibility"][] = $program;
            }
        }
        if (isset($this->fundingSource))
            $arrayData["fundingSource"] = $this->fundingSource->toArray();
        if (isset($this->reaction)) {
            $arrayData["reaction"] = [];
            foreach ($this->reaction as $reaction) {
                $reactionData = [];
                if (isset($reaction["date"]))
                    $reactionData["date"] = $reaction["date"];
                if (isset($reaction["manifestation"]))
                    $reactionData["manifestation"] = $reaction["manifestation"]->toArray();
                if (isset($reaction["reported"]))
                    $reactionData["reported"] = $reaction["reported"];
                $arrayData["reaction"][] = $reactionData;
            }
        }
        if (isset($this->protocolMedinalied)) {
            $arrayData["protocolMedinalied"] = [];
            foreach ($this->protocolMedinalied as $protocolMedinalied) {
                $protocol = [];
                if (isset($protocolMedinalied["series"]))
                    $protocol["series"] = $protocolMedinalied["series"];
                if (isset($protocolMedinalied["authority"]))
                    $protocol["authority"] = $protocolMedinalied["authority"]->toArray();
                if (isset($protocolMedinalied["targetDisease"])) {
                    $protocol["targetDisease"] = [];
                    foreach ($protocolMedinalied["targetDisease"] as $targetDisease)
                        $protocol["targetDisease"][] = $targetDisease->toArray();
                }
                if (isset($protocolMedinalied["doseNumber"]))
                    $protocol["doseNumber"] = $protocolMedinalied["doseNumber"];
                if (isset($protocolMedinalied["seriesDoses"]))
                    $protocol["seriesDoses"] = $protocolMedinalied["seriesDoses"];
                $arrayData["protocolMedinalied"][] = $protocol;
            }
        }

        return $arrayData;
    }

}