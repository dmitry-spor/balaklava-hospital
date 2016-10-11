<?php


namespace App\Services;

//Exceptions
use App\Exceptions\NurseServiceException;
use App\Exceptions\DALException;
use App\Repositories\Interfaces\HospitalDepartmentRepositoryInterface;
use \Exception;
//Services interfaces
use App\Services\Interfaces\NurseServiceInterface;
//repo interfaces
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\ChamberRepositoryInterface;
use App\Repositories\Interfaces\DressingRepositoryInterface;
use App\Repositories\Interfaces\InspectionRepositoryInterface;
use App\Repositories\Interfaces\OperationRepositoryInterface;
use App\Repositories\Interfaces\SurveyRepositoryInterface;
use App\Repositories\Interfaces\SurveyTypeRepositoryInterface;
use App\Repositories\Interfaces\TreatmentRepositoryInterface;
use App\Repositories\Interfaces\HealthWorkerRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
//
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;


class NurseService implements NurseServiceInterface
{

    private $user_repo;
    private $patient_repo;
    private $chamber_repo;
    private $dressing_repo;
    private $inspection_repo;
    private $operation_repo;
    private $survey_repo;
    private $surveyType_repo;
    private $treatment_repo;
    private $nurse_repo;
    private $department_repo;


    public function __construct(UserRepositoryInterface $user_repo,
                                PatientRepositoryInterface $patient_repo,
                                ChamberRepositoryInterface $chamber_repo,
                                DressingRepositoryInterface $dressing_repo,
                                InspectionRepositoryInterface $inspection_repo,
                                OperationRepositoryInterface $operation_repo,
                                SurveyRepositoryInterface $survey_repo,
                                SurveyTypeRepositoryInterface $surveyType_repo,
                                TreatmentRepositoryInterface $treatment_repo,
                                HospitalDepartmentRepositoryInterface $department_repo,
                                HealthWorkerRepositoryInterface $nurse_repo

    )
    {
        $this->user_repo = $user_repo;
        $this->patient_repo = $patient_repo;
        $this->chamber_repo = $chamber_repo;
        $this->dressing_repo = $dressing_repo;
        $this->inspection_repo = $inspection_repo;
        $this->operation_repo = $operation_repo;
        $this->survey_repo = $survey_repo;
        $this->surveyType_repo = $surveyType_repo;
        $this->treatment_repo = $treatment_repo;
        $this->nurse_repo = $nurse_repo;
        $this->department_repo = $department_repo;
    }

    public function getAllDepartments()
    {
        try {
            $data = $this->department_repo->all(array('department_name'));
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw departments request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw departments request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getDepartmentChambers($department_id)
    {
        try {
            $data['department'] = $this->department_repo->find($department_id, array('department_name'));
            $data['chambers'] = $this->chamber_repo->getNotEmptyChambersByDepartmentNum($department_id,
                array('number', 'beds_occupied_count'));
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw departments request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw departments request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getChamberWithPatients($chamber_id)
    {
        try {
            //$data['department'] = $this->department_repo->find($department_id, array('department_name'));
            //$data['chamber'] = $this->chamber_repo->find($chamber_id, array('number', 'floor'));

            $data = $this->chamber_repo->getChamberWithDepartmentAndPatients($chamber_id);
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw chamber request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw chamber request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getPatientWithTableInfo($patient_id)
    {
        try {
            $data = $this->patient_repo->getPatientWithTableInfo($patient_id);
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw patient request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw patient request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getPatientDressings($patient_id)
    {
        try {
            $data['patient'] = $this->patient_repo->where('id', $patient_id, '=', array('fio', 'birth_date'));
            $data['dressings'] = $this->dressing_repo->getPatientDressingsWithDoctors($patient_id);
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw patient dressings request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw patient dressings request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getPatientInspections($patient_id)
    {
        try {
            $data['patient'] = $this->patient_repo->where('id', $patient_id, '=', array('fio', 'birth_date'));
            $data['inspections'] = $this->inspection_repo->getPatientInspectionsWithDoctors($patient_id);
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw patient inspections request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw patient inspections request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getPatientOperations($patient_id)
    {
        try {
            $data['patient'] = $this->patient_repo->where('id', $patient_id, '=', array('fio', 'birth_date'));
            $data['operations'] = $this->operation_repo->getPatientOperationsWithDoctors($patient_id);
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw patient operations request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw patient operations request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getPatientSurveys($patient_id)
    {
        try {
            $data['patient'] = $this->patient_repo->where('id', $patient_id, '=', array('fio', 'birth_date'));
            $data['surveys'] = $this->survey_repo->getPatientSurveysWithDoctors($patient_id);
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw patient surveys request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw patient surveys request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }

    public function getPatientTreatments($patient_id)
    {
        try {
            $data['patient'] = $this->patient_repo->where('id', $patient_id, '=', array('fio', 'birth_date'));
            $data['treatments'] = $this->treatment_repo->getPatientTreatmentsWithDoctors($patient_id);
            return $data;
        } catch (DALException $e) {
            $message = 'Error while creating withdraw patient treatments request(DAL Error)';
            throw new NurseServiceException($message, 0, $e);
        } catch (Exception $e) {
            $message = 'Error while creating withdraw patient treatments request(UnknownError)';
            throw new NurseServiceException($message, 0, $e);
        }
    }
    
}