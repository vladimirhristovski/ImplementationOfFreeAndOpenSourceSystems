<?php

enum SpecializationType: string
{
    case FM = 'FAMILY_MEDICINE';
    case C = "CARDIOLOGY";
    case N = 'NEUROLOGY';
    case R = 'RADIOLOGY';
}

trait Treatable
{
    public function diagnose(Patient $patient, string $diagnosis): void
    {
        $patient->addMedicalHistory($diagnosis);
    }

}

class Patient
{
    private $id;
    private $name;
    private $medicalHistory = [];
    private $treatmentHistory = [];

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function addMedicalHistory($medicalHistory): void
    {
        $this->medicalHistory[] = $medicalHistory;
    }

    public function addTreatmentHistory($treatmentHistory): void
    {
        $this->treatmentHistory[] = $treatmentHistory;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMedicalHistory(): array
    {
        return $this->medicalHistory;
    }
}

class Doctor
{
    private $id;
    private $name;
    private SpecializationType $specialization;
    private $experience;
    private $patients = [];

    public function __construct($id, $name, $experience, SpecializationType $specialization)
    {
        $this->id = $id;
        $this->name = $name;
        $this->experience = $experience;
        $this->specialization = $specialization;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getSpecialization(): SpecializationType
    {
        return $this->specialization;
    }

    public function getExperience()
    {
        return $this->experience;
    }

    public function addPatient(Patient $patient): void
    {
        if (isset($this->patients[$patient->getId()])) {
            echo "Patient {$patient->getId()} already exists at this doctor {$this->id}" . '<br>' . PHP_EOL;
        } else {
            $this->patients[$patient->getId()] = $patient;
            echo "Patient {$patient->getId()} successfully added as patient at doctor {$this->id}" . '<br>' . PHP_EOL;

        }
    }

    public function removePatient(Patient $patient): void
    {
        unset($this->patients[$patient->getId()]);
    }

    public function getName()
    {
        return $this->name;
    }

    public function printPatients(): void
    {
        if (sizeof($this->patients) > 0) {
            foreach ($this->patients as $patient) {
                echo "{$patient->getId()}: {$patient->getName()}" . '<br>' . PHP_EOL;
            }
        } else {
            echo "This doctor doesn't have any patients" . '<br>' . PHP_EOL;
        }

    }

}

class FamilyDoctor extends Doctor
{
    use Treatable;

    public function __construct($id, $name, $experience)
    {
        parent::__construct($id, $name, $experience, SpecializationType::FM);
    }

    public function refer(Patient $patient, array $doctors, SpecializationType $specialization): Doctor
    {
        $filtered_doctors = array_filter($doctors, function (Doctor $doctor) use ($specialization) {
            return $doctor->getSpecialization() === $specialization;
        });

        usort($filtered_doctors, function (Doctor $doctorA, Doctor $doctorB) {
            return $doctorB->getExperience() <=> $doctorA->getExperience();
        });

        $filtered_doctors[0]->addPatient($patient);

        return $filtered_doctors[0];
    }
}

class Specialist extends Doctor
{
    public function __construct($id, $name, $experience, SpecializationType $specialization)
    {
        parent::__construct($id, $name, $experience, $specialization);
    }

    public function treatPatient(Patient $patient, string $treatment): void
    {
        $patient->addTreatmentHistory($treatment);
        $this->removePatient($patient);
    }

}

// Create patients
$john = new Patient(1, "John Doe");
$jane = new Patient(2, "Jane Smith");

// Create doctors
$familyDoctor = new FamilyDoctor("D001", "Dr. Brown", 12);
$cardiologist1 = new Specialist("D002", "Dr. Heart", 8, SpecializationType::C);
$cardiologist2 = new Specialist("D003", "Dr. Pulse", 15, SpecializationType::C);
$neurologist = new Specialist("D004", "Dr. Brain", 10, SpecializationType::N);

// Add patient to family doctor
$familyDoctor->addPatient($john);
$familyDoctor->diagnose($john, 'High blood pressure');
// Print before referral
$familyDoctor->printPatients();

// Refer John to cardiologist (most experienced one)
$treatingDoctor = $familyDoctor->refer($john, [$cardiologist1, $cardiologist2, $neurologist], SpecializationType::C);
echo "Referred patient with id {$john->getId()} to doctor {$treatingDoctor->getname()}" . '<br>' . PHP_EOL;

// Refer the same patient again (should return that patient is already referred)
$treatingDoctor = $familyDoctor->refer($john, [$cardiologist1, $cardiologist2, $neurologist], SpecializationType::C);

$treatingDoctor->printPatients();

if ($treatingDoctor instanceof Specialist) {
    $treatingDoctor->treatPatient($john, 'Beta-blockers');
}

// Print specialists’ patients after referral
$treatingDoctor->printPatients();

// Show John’s medical history
echo "Medical history of {$john->getName()}:" . '<br>' . PHP_EOL;
foreach ($john->getMedicalHistory() as $record) {
    echo "- $record" . '<br>' . PHP_EOL;
}