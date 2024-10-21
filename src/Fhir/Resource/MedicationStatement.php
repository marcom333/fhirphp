<?php

namespace Medina\Fhir\Resource;

use Medina\Fhir\Element\Annotation;
use Medina\Fhir\Element\CodeableConcept;
use Medina\Fhir\Element\Dosage;
use Medina\Fhir\Element\Identifier;
use Medina\Fhir\Element\Period;
use Medina\Fhir\Element\Reference;
use Medina\Fhir\Element\Timing;

class MedicationStatement extends DomainResource {

    public function __construct($json = null) {
        $this->resourceType = "MedicationStatement";
        parent::__construct($json);

        $this->identifier = [];
        $this->partOf = [];
        $this->category = [];
        $this->informationSource = [];
        $this->derivedFrom = [];
        $this->reason = [];
        $this->note = [];
        $this->relatedClinicalInformation = [];
        $this->dosage = [];

        if ($json) $this->loadData($json);
    }

    public function loadData($json) {
        parent::loadData($json);
        if (isset($json->identifier))
            foreach ($json->identifier as $identifier)
                $this->identifier[] = Identifier::Load($identifier);
        if (isset($json->partOf))
            foreach ($json->partOf as $partOf)
                $this->partOf[] = Reference::Load($partOf);
        if (isset($json->status))
            $this->status = $json->status;
        if (isset($json->category))
            foreach ($json->category as $category)
                $this->category[] = CodeableConcept::Load($category);
        if (isset($json->medication))
            $this->medication = Reference::Load($json->medication);
        if (isset($json->subject))
            $this->subject = Reference::Load($json->subject);
        if (isset($json->encounter))
            $this->encounter = Reference::Load($json->encounter);
        if (isset($json->effectiveDateTime))
            $this->effectiveDateTime = $json->effectiveDateTime;
        if (isset($json->effectivePeriod))
            $this->effectivePeriod = Period::Load($json->effectivePeriod);
        if (isset($json->effectiveTiming))
            $this->effectiveTiming = Timing::Load($json->effectiveTiming);
        if (isset($json->dateAsserted))
            $this->dateAsserted = $json->dateAsserted;
        if (isset($json->informationSource))
            foreach ($json->informationSource as $informationSource)
                $this->informationSource[] = Reference::Load($informationSource);
        if (isset($json->derivedFrom))
            foreach ($json->derivedFrom as $derivedFrom)
                $this->derivedFrom[] = Reference::Load($derivedFrom);
        if (isset($json->reason))
            foreach ($json->reason as $reason)
                $this->reason[] = CodeableConcept::Load($reason);
        if (isset($json->note))
            foreach ($json->note as $note)
                $this->note[] = Annotation::Load($note);
        if (isset($json->relatedClinicalInformation))
            foreach ($json->relatedClinicalInformation as $relatedClinicalInformation)
                $this->relatedClinicalInformation[] = Reference::Load($relatedClinicalInformation);
        if (isset($json->renderedDosageInstruction))
            $this->renderedDosageInstruction = $json->renderedDosageInstruction;
        if (isset($json->dosage))
            foreach ($json->dosage as $dosage)
                $this->dosage[] = Dosage::Load($dosage);
        if (isset($json->adherence))
            $this->adherence = new Adherence($json->adherence);
    }

    // Methods for adding individual elements
    function addIdentifier(Identifier $identifier) {
        $this->identifier[] = $identifier;
    }

    function addPartOf(Reference $partOf) {
        $this->partOf[] = $partOf;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function addCategory(CodeableConcept $category) {
        $this->category[] = $category;
    }

    function setMedication(Reference $medication) {
        $this->medication = $medication;
    }

    function setSubject(Reference $subject) {
        $this->subject = $subject;
    }

    function setEncounter(Reference $encounter) {
        $this->encounter = $encounter;
    }

    function setEffectiveDateTime($effectiveDateTime) {
        $this->effectiveDateTime = $effectiveDateTime;
    }

    function setEffectivePeriod(Period $effectivePeriod) {
        $this->effectivePeriod = $effectivePeriod;
    }

    function setEffectiveTiming(Timing $effectiveTiming) {
        $this->effectiveTiming = $effectiveTiming;
    }

    function setDateAsserted($dateAsserted) {
        $this->dateAsserted = $dateAsserted;
    }

    function addInformationSource(Reference $informationSource) {
        $this->informationSource[] = $informationSource;
    }

    function addDerivedFrom(Reference $derivedFrom) {
        $this->derivedFrom[] = $derivedFrom;
    }

    function addReason(CodeableConcept $reason) {
        $this->reason[] = $reason;
    }

    function addNote(Annotation $note) {
        $this->note[] = $note;
    }

    function addRelatedClinicalInformation(Reference $relatedClinicalInformation) {
        $this->relatedClinicalInformation[] = $relatedClinicalInformation;
    }

    function setRenderedDosageInstruction($renderedDosageInstruction) {
        $this->renderedDosageInstruction = $renderedDosageInstruction;
    }

    function addDosage(Dosage $dosage) {
        $this->dosage[] = $dosage;
    }

    function setAdherence(Adherence $adherence) {
        $this->adherence = $adherence;
    }

    function toArray() {
        $arrayData = parent::toArray();
        if (isset($this->identifier)) {
            $arrayData["identifier"] = [];
            foreach ($this->identifier as $identifier)
                $arrayData["identifier"][] = $identifier->toArray();
        }
        if (isset($this->partOf)) {
            $arrayData["partOf"] = [];
            foreach ($this->partOf as $partOf)
                $arrayData["partOf"][] = $partOf->toArray();
        }
        if (isset($this->status))
            $arrayData["status"] = $this->status;
        if (isset($this->category)) {
            $arrayData["category"] = [];
            foreach ($this->category as $category)
                $arrayData["category"][] = $category->toArray();
        }
        if (isset($this->medication))
            $arrayData["medication"] = $this->medication->toArray();
        if (isset($this->subject))
            $arrayData["subject"] = $this->subject->toArray();
        if (isset($this->encounter))
            $arrayData["encounter"] = $this->encounter->toArray();
        if (isset($this->effectiveDateTime))
            $arrayData["effectiveDateTime"] = $this->effectiveDateTime;
        if (isset($this->effectivePeriod))
            $arrayData["effectivePeriod"] = $this->effectivePeriod->toArray();
        if (isset($this->effectiveTiming))
            $arrayData["effectiveTiming"] = $this->effectiveTiming->toArray();
        if (isset($this->dateAsserted))
            $arrayData["dateAsserted"] = $this->dateAsserted;
        if (isset($this->informationSource)) {
            $arrayData["informationSource"] = [];
            foreach ($this->informationSource as $informationSource)
                $arrayData["informationSource"][] = $informationSource->toArray();
        }
        if (isset($this->derivedFrom)) {
            $arrayData["derivedFrom"] = [];
            foreach ($this->derivedFrom as $derivedFrom)
                $arrayData["derivedFrom"][] = $derivedFrom->toArray();
        }
        if (isset($this->reason)) {
            $arrayData["reason"] = [];
            foreach ($this->reason as $reason)
                $arrayData["reason"][] = $reason->toArray();
        }
        if (isset($this->note)) {
            $arrayData["note"] = [];
            foreach ($this->note as $note)
                $arrayData["note"][] = $note->toArray();
        }
        if (isset($this->relatedClinicalInformation)) {
            $arrayData["relatedClinicalInformation"] = [];
            foreach ($this->relatedClinicalInformation as $relatedClinicalInformation)
                $arrayData["relatedClinicalInformation"][] = $relatedClinicalInformation->toArray();
        }
        if (isset($this->renderedDosageInstruction))
            $arrayData["renderedDosageInstruction"] = $this->renderedDosageInstruction;
        if (isset($this->dosage)) {
            $arrayData["dosage"] = [];
            foreach ($this->dosage as $dosage)
                $arrayData["dosage"][] = $dosage->toArray();
        }
        if (isset($this->adherence))
            $arrayData["adherence"] = $this->adherence->toArray();

        return $arrayData;
    }

    public function toString(){
        return "Declaración de Medicación";
    }

}

class Adherence {
    public $code; // CodeableConcept object
    public $reason; // CodeableConcept object

    public function __construct($data = null) {
        if ($data) {
            $this->code = isset($data->code) ? CodeableConcept::Load($data->code) : null;
            $this->reason = isset($data->reason) ? CodeableConcept::Load($data->reason) : null;
        }
    }

    public function toArray() {
        $arrayData = [];
        if (isset($this->code))
            $arrayData["code"] = $this->code->toArray();
        if (isset($this->reason))
            $arrayData["reason"] = $this->reason->toArray();
        return $arrayData;
    }
}

?>
