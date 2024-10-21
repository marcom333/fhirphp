<?php 

namespace Medina\Fhir\Resource;

use Medina\Fhir\Element\Annotation;
use Medina\Fhir\Element\CodeableConcept;
use Medina\Fhir\Element\Identifier;
use Medina\Fhir\Element\Period;
use Medina\Fhir\Element\Quantity;
use Medina\Fhir\Element\Range;
use Medina\Fhir\Element\Reference;

class Condition extends DomainResource{
    public function __construct($json = null){
        $this->resourceType = "Condition";
        // $this->referenceDisplay = "Condición";
        parent::__construct($json);
        
        $this->category = [];
        $this->bodySite = [];
        $this->assessment = [];
        $this->detail = [];
        $this->note = [];
        $this->identifier = [];
        $this->stage = [];
        $this->evidence = [];

        if($json) $this->loadData($json);
    }
    public function loadData($json){
        parent::loadData($json);
        if (isset($json->clinicalStatus)){
            $this->clinicalStatus = CodeableConcept::Load($json->clinicalStatus);
        }
        if (isset($json->verificationStatus)){
            $this->verificationStatus = CodeableConcept::Load($json->verificationStatus);
        }
        if (isset($json->category)){
            foreach ($json->category as $category)
                $this->category[] = CodeableConcept::Load($category);
        }
        if (isset($json->severity)){
            $this->severity = CodeableConcept::Load($json->severity);
        }
        if (isset($json->code)){
            $this->code = CodeableConcept::Load($json->code);
        }
        if (isset($json->bodySite)){
            foreach ($json->bodySite as $bodySite)
                $this->bodySite[] = CodeableConcept::Load($bodySite);
        }
        if (isset($json->subject)){
            $this->subject = Reference::Load($json->subject);
        }
        if (isset($json->encounter)){
            $this->encounter = reference::Load($json->encounter);
        }
        if (isset($json->onsetDateTime)){
            $this->onsetDateTime = $json->onsetDateTime;
        }
        if (isset($json->onsetAge)){
            $this->onsetAge = Quantity::Load($json->onsetAge);
        }
        if (isset($json->onsetPeriod)){
            $this->onsetPeriod = Period::Load($json->onsetPeriod);
        }
        if (isset($json->onsetRange)){
            $this->onsetRange = Range::Load($json->onsetRange);
        }
        if (isset($json->onsetString)){
            $this->onsetStrin = $json->onsetString;
        }
        if (isset($json->abatementDateTime)){
            $this->abatementDateTim = $json->abatementDateTime;
        }
        if (isset($json->abatementAge)){
            $this->abatementAge = Quantity::Load($json->abatementAge);
        }
        if (isset($json->abatementPeriod)){
            $this->abatementPeriod = Period::Load($json->abatementPeriod);
        }
        if (isset($json->abatementRange)){
            $this->abatementRange = Range::Load($json->abatementRange);
        }
        if (isset($json->abatementString)){
            $this->abatementString = $json->abatementString;
        }
        if (isset($json->recordedDate)){
            $this->recordedDate = $json->recordedDate;
        }
        if (isset($json->recorder)){
            $this->recorder = Reference::Load($json->recorder);
        }
        if (isset($json->asserter)){
            $this->asserter = Reference::Load($json->asserter);
        }
        if (isset($json->stage)){
            foreach ($json->stage as $stage){
                $stages = [];
                if (isset($stage->summary)){
                    $stages["summary"] = CodeableConcept::Load($stage->summary);
                }
                if (isset($stage->assessment)){
                    $assessments = [];
                    foreach ($stage->assessment as $assessment)
                        $assessments[] = Reference::Load($assessment);
                    $stages["assessment"] = $assessments;
                }
                if (isset($stage->type)){
                    $stages["type"] = CodeableConcept::Load($stage->type);
                }
                $this->stage[] = $stages;
            }
        }
        if (isset($json->evidence)){
            foreach ($json->evidence as $evidence){
                $evidences = [];
                if (isset($evidence->code)){
                    $codes = [];
                    foreach ($evidence->code as $code){
                        $codes[] = CodeableConcept::Load($code);
                    }
                    $evidences["code"] = $codes;
                }
                if (isset($evidence->detail)){
                    $details = [];
                    foreach ($evidence->detail as $detail){
                        $details[] = Reference::Load($detail);
                    }
                    $evidences["detail"] = $details;
                }
                $this->evidence[] = $evidences;
            }
        }
        if (isset($json->note)){
            foreach ($json->note as $note)
                $this->note[] = Annotation::Load($note);
        }
        if (isset($json->identifier)){
            foreach ($json->identifier as $identifier)
                $this->identifier[] = Identifier::Load($identifier);
        }
    }

    /* campo opcional */
    public function setClinicalStatus(CodeableConcept $clinicalStatus){
        $this->clinicalStatus = $clinicalStatus;
    }
    /* campo opcional */
    public function setVerificationStatus(CodeableConcept $verificationStatus){
        $this->verificationStatus = $verificationStatus;
    }
    /* campo opcional */
    public function addCategory(CodeableConcept $category){
        $this->category[] = $category;
    }
    /* campo opcional */
    public function setSeverity(CodeableConcept $severity){
        $this->severity = $severity;
    }
    /* Campo obligatorio (estandar) 
        \Fhir\Element\CodeableConcepto:
            "code": \Fhir\Element\Code (array 1..*)
                system: http://snomed.info/sct
                code: codigo snomed
                display: texto
            text: texto
    */
    public function setCode(CodeableConcept $code){
        $this->code = $code;
    }
    /* campo opcional */
    public function addBodySite(CodeableConcept $bodySite){
        $this->bodySite[] = $bodySite;
    }
    /* Campo obligatorio (estandar) */
    public function setSubject(Resource $subject){
        $this->subject = $subject->toReference();
    }
    /* campo opcional */
    public function setEncounter(Resource $encounter){
        $this->encounter = $encounter->toReference();
    }
    /* campo opcional */
    public function setOnsetDateTime($onsetDateTime){
        $this->onsetDateTime = $onsetDateTime;
    }
    /* campo opcional */
    public function setOnsetAge(Quantity $onsetAge){
        $this->onsetAge = $onsetAge;
    }
    /* campo opcional */
    public function setOnsetPeriod(Period $onsetPeriod){
        $this->onsetPeriod = $onsetPeriod;
    }
    /* campo opcional */
    public function setOnsetRange(Range $onsetRange){
        $this->onsetRange = $onsetRange;
    }
    /* campo opcional */
    public function setOnsetStrin($onsetString){
        $this->onsetStrin = $onsetString;
    }
    /* campo opcional */
    public function setAbatementDateTim($abatementDateTime){
        $this->abatementDateTim = $abatementDateTime;
    }
    /* campo opcional */
    public function setAbatementAge(Quantity $abatementAge){
        $this->abatementAge = $abatementAge;
    }
    /* campo opcional */
    public function setAbatementPeriod(Period $abatementPeriod){
        $this->abatementPeriod = $abatementPeriod;
    }
    /* campo opcional */
    public function setAbatementRange(Range $abatementRange){
        $this->abatementRange = $abatementRange;
    }
    /* campo opcional */
    public function setAbatementString($abatementString){
        $this->abatementString = $abatementString;
    }
    /* Campo obligatorio (estandar) */
    public function setRecordedDate($recordedDate){
        $this->recordedDate = $recordedDate;
    }
    /* campo opcional */
    public function setRecorder(Resource $recorder){
        $this->recorder = $recorder->toReference();
    }
    /* campo opcional */
    public function setAsserter(Resource $asserter){
        $this->asserter = $asserter->toReference();
    }
    /* campo opcional */
    public function addStage(CodeableConcept $summary, $assessments, CodeableConcept $type){
        $stages = [];
        if (isset($summary)){
            $stages["summary"] = $summary;
        }
        if (isset($assessments)){
            $assessmentsAr = [];
            foreach ($assessments as $assessment)
                $assessmentsAr[] = $assessment;
            $stages["assessment"] = $assessmentsAr;
        }
        if (isset($type)){
            $stages["type"] = $type;
        }
        $this->stage[] = $stages;
    }
    /* campo opcional */
    public function addEvidence($codes, $details){
        $evidences = [];
        if (isset($codes)){
            $codesAr = [];
            foreach ($codes as $code){
                $codesAr[] = $code;
            }
            $evidences["code"] = $codesAr;
        }
        if (isset($details)){
            $detailsAr = [];
            foreach ($details as $detail){
                $detailsAr[] = Reference::Load($detail);
            }
            $evidences["detail"] = $detailsAr;
        }
        $this->evidence[] = $evidences;
    }
    /* campo opcional */
    public function addNote(Annotation $note){
        $this->note[] = $note;
    }
    /* campo opcional */
    public function addIdentifier(Identifier $identifier){
        $this->identifier[] = $identifier;
    }
    
    /* campo opcional */
    public function toArray(){
        $arrayData = parent::toArray();
        if (isset($this->clinicalStatus)){
            $arrayData["clinicalStatus"] = $this->clinicalStatus->toArray();
        }
        if (isset($this->verificationStatus)){
            $arrayData["verificationStatus"] = $this->verificationStatus->toArray();
        }
        if (isset($this->category)){
            foreach ($this->category as $category)
                $arrayData["category"][] = $category->toArray();
        }
        if (isset($this->severity)){
            $arrayData["severity"] = $this->severity->toArray();
        }
        if (isset($this->code)){
            $arrayData["code"] = $this->code->toArray();
        }
        if (isset($this->bodySite)){
            foreach ($this->bodySite as $bodySite)
                $arrayData["bodySite"][] = $bodySite->toArray();
        }
        if (isset($this->subject)){
            $arrayData["subject"] = $this->subject->toArray();
        }
        if (isset($this->encounter)){
            $arrayData["encounter"] = $this->encounter->toArray();
        }
        if (isset($this->onsetDateTime)){
            $arrayData["onsetDateTime"] = $this->onsetDateTime;
        }
        if (isset($this->onsetAge)){
            $arrayData["onsetAge"] = $this->onsetAge->toArray();
        }
        if (isset($this->onsetPeriod)){
            $arrayData["onsetPeriod"] = $this->onsetPeriod->toArray();
        }
        if (isset($this->onsetRange)){
            $arrayData["onsetRange"] = $this->onsetRange->toArray();
        }
        if (isset($this->onsetString)){
            $arrayData["onsetStrin"] = $this->onsetString;
        }
        if (isset($this->abatementDateTime)){
            $arrayData["abatementDateTim"] = $this->abatementDateTime;
        }
        if (isset($this->abatementAge)){
            $arrayData["abatementAge"] = $this->abatementAge->toArray();
        }
        if (isset($this->abatementPeriod)){
            $arrayData["abatementPeriod"] = $this->abatementPeriod->toArray();
        }
        if (isset($this->abatementRange)){
            $arrayData["abatementRange"] = $this->abatementRange->toArray();
        }
        if (isset($this->abatementString)){
            $arrayData["abatementString"] = $this->abatementString;
        }
        if (isset($this->recordedDate)){
            $arrayData["recordedDate"] = $this->recordedDate;
        }
        if (isset($this->recorder)){
            $arrayData["recorder"] = $this->recorder->toArray();
        }
        if (isset($this->asserter)){
            $arrayData["asserter"] = $this->asserter->toArray();
        }
        if (isset($this->stage)){
            foreach ($this->stage as $stage){
                $stages = [];
                if (isset($stage["summary"])){
                    $stages["summary"] = $stage["summary"]->toArray();
                }
                if (isset($stage["assessment"])){
                    $assessments = [];
                    foreach ($stage["assessment"] as $assessment)
                        $assessments[] = $assessment->toArray();
                    $stages["assessment"] = $assessments;
                }
                if (isset($stage["type"])){
                    $stages["type"] = $stage["type"]->toArray();
                }
                $arrayData["stage"][] = $stages;
            }
        }
        if (isset($this->evidence)){
            foreach ($this->evidence as $evidence){
                $evidences = [];
                if (isset($evidence["code"])){
                    $codes = [];
                    foreach ($evidence["code"] as $code){
                        $codes[] = $code->toArray();
                    }
                    $evidences["code"] = $codes;
                }
                if (isset($evidence["detail"])){
                    $details = [];
                    foreach ($evidence["detail"] as $detail){
                        $details[] = $detail->toArray();
                    }
                    $evidences["detail"] = $details;
                }
                $arrayData["evidence"][] = $evidences;
            }
        }
        if (isset($this->note)){
            foreach ($this->note as $note)
                $arrayData["note"][] = $note->toArray();
        }
        if (isset($this->identifier)){
            foreach ($this->identifier as $identifier)
                $arrayData["identifier"][] = $identifier->toArray();
        }
        return $arrayData;
    }
    public function toString(){
        return "Condición";
    }
}