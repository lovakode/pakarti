<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
        
        .no-wrap {
            white-space: nowrap;
        }
        
        .employee-photo {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            object-fit: cover;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-permanent {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-contract {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-resigned {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-retired {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .status-passed_away {
            background-color: #343a40;
            color: #ffffff;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Employee Data Export</h1>
        <p>Generated on {{ date('d F Y H:i:s') }}</p>
        <p>Total Records: {{ count($employees) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                @if(in_array('code', $columns))
                    <th class="no-wrap">Code</th>
                @endif
                @if(in_array('name', $columns))
                    <th class="no-wrap">Name</th>
                @endif
                @if(in_array('email', $columns))
                    <th class="no-wrap">Email</th>
                @endif
                @if(in_array('phone', $columns))
                    <th class="no-wrap">Phone</th>
                @endif
                @if(in_array('gender', $columns))
                    <th class="no-wrap">Gender</th>
                @endif
                @if(in_array('birth_date', $columns))
                    <th class="no-wrap">Birth Date</th>
                @endif
                @if(in_array('birth_place', $columns))
                    <th class="no-wrap">Birth Place</th>
                @endif
                @if(in_array('department', $columns))
                    <th class="no-wrap">Department</th>
                @endif
                @if(in_array('job_position', $columns))
                    <th class="no-wrap">Job Position</th>
                @endif
                @if(in_array('grade', $columns))
                    <th class="no-wrap">Grade</th>
                @endif
                @if(in_array('expertise', $columns))
                    <th class="no-wrap">Expertise</th>
                @endif
                @if(in_array('status', $columns))
                    <th class="no-wrap">Status</th>
                @endif
                @if(in_array('join_date', $columns))
                    <th class="no-wrap">Join Date</th>
                @endif
                @if(in_array('exit_date', $columns))
                    <th class="no-wrap">Exit Date</th>
                @endif
                @if(in_array('ptkp', $columns))
                    <th class="no-wrap">PTKP</th>
                @endif
                @if(in_array('address', $columns))
                    <th class="no-wrap">Address</th>
                @endif
                @if(in_array('city', $columns))
                    <th class="no-wrap">City</th>
                @endif
                @if(in_array('state', $columns))
                    <th class="no-wrap">State</th>
                @endif
                @if(in_array('country', $columns))
                    <th class="no-wrap">Country</th>
                @endif
                @if(in_array('zipcode', $columns))
                    <th class="no-wrap">Zip Code</th>
                @endif
                @if(in_array('emergency_contact', $columns))
                    <th class="no-wrap">Emergency Contact</th>
                @endif
                @if(in_array('emergency_phone', $columns))
                    <th class="no-wrap">Emergency Phone</th>
                @endif
                @if(in_array('emergency_relationship', $columns))
                    <th class="no-wrap">Emergency Relationship</th>
                @endif
                @if(in_array('last_education', $columns))
                    <th class="no-wrap">Last Education</th>
                @endif
                @if(in_array('religion', $columns))
                    <th class="no-wrap">Religion</th>
                @endif
                @if(in_array('blood_type', $columns))
                    <th class="no-wrap">Blood Type</th>
                @endif
                @if(in_array('marital_status', $columns))
                    <th class="no-wrap">Marital Status</th>
                @endif
                @if(in_array('mother_name', $columns))
                    <th class="no-wrap">Mother Name</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                @if(in_array('code', $columns))
                    <td class="no-wrap">{{ $employee->code }}</td>
                @endif
                @if(in_array('name', $columns))
                    <td class="no-wrap">{{ $employee->name }}</td>
                @endif
                @if(in_array('email', $columns))
                    <td>{{ $employee->email }}</td>
                @endif
                @if(in_array('phone', $columns))
                    <td class="no-wrap">{{ $employee->phone }}</td>
                @endif
                @if(in_array('gender', $columns))
                    <td class="text-center">{{ ucfirst($employee->gender) }}</td>
                @endif
                @if(in_array('birth_date', $columns))
                    <td class="no-wrap">{{ $employee->birth_date ? date('d/m/Y', strtotime($employee->birth_date)) : '-' }}</td>
                @endif
                @if(in_array('birth_place', $columns))
                    <td>{{ $employee->birth_place ?? '-' }}</td>
                @endif
                @if(in_array('department', $columns))
                    <td>{{ $employee->department->name ?? '-' }}</td>
                @endif
                @if(in_array('job_position', $columns))
                    <td>{{ $employee->job_position->name ?? '-' }}</td>
                @endif
                @if(in_array('grade', $columns))
                    <td class="text-center">{{ $employee->grade->name ?? '-' }}</td>
                @endif
                @if(in_array('expertise', $columns))
                    <td>{{ $employee->expertise->name ?? '-' }}</td>
                @endif
                @if(in_array('status', $columns))
                    <td class="text-center">
                        <span class="status-badge status-{{ $employee->status }}">
                            {{ ucfirst(str_replace('_', ' ', $employee->status)) }}
                        </span>
                    </td>
                @endif
                @if(in_array('join_date', $columns))
                    <td class="no-wrap">{{ $employee->join_date ? date('d/m/Y', strtotime($employee->join_date)) : '-' }}</td>
                @endif
                @if(in_array('exit_date', $columns))
                    <td class="no-wrap">{{ $employee->exit_date ? date('d/m/Y', strtotime($employee->exit_date)) : '-' }}</td>
                @endif
                @if(in_array('ptkp', $columns))
                    <td class="text-center">{{ $employee->ptkp ?? '-' }}</td>
                @endif
                @if(in_array('address', $columns))
                    <td>{{ trim($employee->addressline1 . ' ' . $employee->addressline2) }}</td>
                @endif
                @if(in_array('city', $columns))
                    <td>{{ $employee->city }}</td>
                @endif
                @if(in_array('state', $columns))
                    <td>{{ $employee->state }}</td>
                @endif
                @if(in_array('country', $columns))
                    <td>{{ $employee->country }}</td>
                @endif
                @if(in_array('zipcode', $columns))
                    <td class="text-center">{{ $employee->zipcode }}</td>
                @endif
                @if(in_array('emergency_contact', $columns))
                    <td>{{ $employee->emergency_contact_name }}</td>
                @endif
                @if(in_array('emergency_phone', $columns))
                    <td class="no-wrap">{{ $employee->emergency_contact_phone }}</td>
                @endif
                @if(in_array('emergency_relationship', $columns))
                    <td>{{ $employee->emergency_contact_relationship }}</td>
                @endif
                @if(in_array('last_education', $columns))
                    <td>{{ $employee->last_education }}</td>
                @endif
                @if(in_array('religion', $columns))
                    <td>{{ $employee->religion }}</td>
                @endif
                @if(in_array('blood_type', $columns))
                    <td class="text-center">{{ $employee->blood_type }}</td>
                @endif
                @if(in_array('marital_status', $columns))
                    <td>{{ $employee->marital_status }}</td>
                @endif
                @if(in_array('mother_name', $columns))
                    <td>{{ $employee->mother_name }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system</p>
    </div>
</body>
</html>