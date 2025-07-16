<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $params;
    protected $columns;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->columns = isset($params['columns']) ? explode(',', $params['columns']) : $this->getDefaultColumns();
    }

    protected function getDefaultColumns()
    {
        return [
            'code', 'name', 'email', 'phone', 'gender', 'birth_date', 
            'department', 'job_position', 'grade', 'status', 'join_date'
        ];
    }

    protected function getColumnMapping()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'birth_place' => 'Birth Place',
            'department' => 'Department',
            'job_position' => 'Job Position',
            'grade' => 'Grade',
            'expertise' => 'Expertise',
            'status' => 'Status',
            'join_date' => 'Join Date',
            'exit_date' => 'Exit Date',
            'ptkp' => 'PTKP',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'zipcode' => 'Zip Code',
            'emergency_contact' => 'Emergency Contact',
            'emergency_phone' => 'Emergency Phone',
            'emergency_relationship' => 'Emergency Relationship',
            'last_education' => 'Last Education',
            'religion' => 'Religion',
            'blood_type' => 'Blood Type',
            'marital_status' => 'Marital Status',
            'mother_name' => 'Mother Name'
        ];
    }

    public function query()
    {
        $query = Employee::with(['department', 'job_position', 'grade', 'expertise'])
            ->when($this->params['q'] ?? null, function($query, $search){
                $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%');
            })
            ->when($this->params['name'] ?? null, function($q, $search){
                $q->where('name', 'LIKE', '%' . $search . '%');
            })
            ->when($this->params['code'] ?? null, function($q, $search){
                $q->where('code', 'LIKE', '%' . $search . '%');
            })
            ->when($this->params['status'] ?? null, function($q, $search){
                $q->where('status', $search);
            })
            ->when($this->params['dept'] ?? null, function($q, $search){
                $q->where('department_id', $search);
            })
            ->when($this->params['pst'] ?? null, function($q, $search){
                $q->where('job_position_id', $search);
            })
            ->when($this->params['superior'] ?? null, function($q, $search){
                $q->where('superior_id', $search);
            });

        return $query;
    }

    public function headings(): array
    {
        $columnMapping = $this->getColumnMapping();
        $headings = [];
        
        foreach ($this->columns as $column) {
            if (isset($columnMapping[$column])) {
                $headings[] = $columnMapping[$column];
            }
        }
        
        return $headings;
    }

    public function map($employee): array
    {
        $data = [];
        
        foreach ($this->columns as $column) {
            switch ($column) {
                case 'code':
                    $data[] = $employee->code;
                    break;
                case 'name':
                    $data[] = $employee->name;
                    break;
                case 'email':
                    $data[] = $employee->email;
                    break;
                case 'phone':
                    $data[] = $employee->phone;
                    break;
                case 'gender':
                    $data[] = $employee->gender;
                    break;
                case 'birth_date':
                    $data[] = $employee->birth_date;
                    break;
                case 'birth_place':
                    $data[] = $employee->birth_place;
                    break;
                case 'department':
                    $data[] = $employee->department->name ?? '';
                    break;
                case 'job_position':
                    $data[] = $employee->job_position->name ?? '';
                    break;
                case 'grade':
                    $data[] = $employee->grade->name ?? '';
                    break;
                case 'expertise':
                    $data[] = $employee->expertise->name ?? '';
                    break;
                case 'status':
                    $data[] = $employee->status;
                    break;
                case 'join_date':
                    $data[] = $employee->join_date;
                    break;
                case 'exit_date':
                    $data[] = $employee->exit_date;
                    break;
                case 'ptkp':
                    $data[] = $employee->ptkp;
                    break;
                case 'address':
                    $data[] = trim($employee->addressline1 . ' ' . $employee->addressline2);
                    break;
                case 'city':
                    $data[] = $employee->city;
                    break;
                case 'state':
                    $data[] = $employee->state;
                    break;
                case 'country':
                    $data[] = $employee->country;
                    break;
                case 'zipcode':
                    $data[] = $employee->zipcode;
                    break;
                case 'emergency_contact':
                    $data[] = $employee->emergency_contact_name;
                    break;
                case 'emergency_phone':
                    $data[] = $employee->emergency_contact_phone;
                    break;
                case 'emergency_relationship':
                    $data[] = $employee->emergency_contact_relationship;
                    break;
                case 'last_education':
                    $data[] = $employee->last_education;
                    break;
                case 'religion':
                    $data[] = $employee->religion;
                    break;
                case 'blood_type':
                    $data[] = $employee->blood_type;
                    break;
                case 'marital_status':
                    $data[] = $employee->marital_status;
                    break;
                case 'mother_name':
                    $data[] = $employee->mother_name;
                    break;
                default:
                    $data[] = '';
                    break;
            }
        }
        
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}