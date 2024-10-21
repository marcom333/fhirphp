<?php 
namespace Medina\Fhir\Resource;

class ResourceBuilder{
    public static function make($resource){
        switch($resource->resourceType){
            case "AllergyIntolerance":
                return new AllergyIntolerance($resource);
            case "CarePlan":
                return new CarePlan($resource);
            case "Bundle":
                return new Bundle($resource);
            case "Composition":
                return new Composition($resource);
            case "Condition":
                return new Condition($resource);
            case "DiagnosticReport":
                return new DiagnosticReport($resource);
            case "Encounter":
                return new Encounter($resource);
            case "ImagingStudy":
                return new ImagingStudy($resource);
            case "Location":
                return new Location($resource);
            case "Medication":
                return new Medication($resource);
            case "MedicationAdministration":
                return new MedicationAdministration($resource);
            case "MedicationRequest":
                return new MedicationRequest($resource);
            case "FamilyMemberHistory":
                return new FamilyMemberHistory($resource);
            case "Observation":
                return new Observation($resource);
            case "Organization":
                return new Organization($resource);
            case "Patient":
                return new Patient($resource);
            case "Practitioner":
                return new Practitioner($resource);
            case "PractitionerRole":
                return new PractitionerRole($resource);
            case "Procedure":
                return new Procedure($resource);
            case "Immunization":
                return new Immunization($resource);
            case "MedicationStatement":
                return new MedicationStatement($resource);
            default:
                return new Resource($resource);
        }
    }
}