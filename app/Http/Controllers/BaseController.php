<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

use App\Models\Locale;
use App\Models\Currency;
use App\Models\Account\Account;

use App\Models\Employee;
use App\Models\User;

class BaseController extends Controller
{

    public function index()
    {
        $data = collect([
            'app_name' => settings()->get('app_name'),
            'company_name' => settings()->get('company_name'),
            'company_email' => settings()->get('company_email'),
            'company_phone' => settings()->get('company_phone'),
            'company_address' => settings()->get('company_address'),
            'date_format' => $this->convertDateFormat(settings()->get('date_format')),
            'time_format' => settings()->get('time_format'),
            'timezone' => settings()->get('timezone'),
            'logo_light' => settings()->get('logo_light'),
            'logo_dark' => settings()->get('logo_dark'),
            'logo_light_sm' => settings()->get('logo_light_sm'),
            'logo_dark_sm' => settings()->get('logo_dark_sm'),
            'locale' => settings()->get('locale'),
            'locales' => Locale::latest()->get(),
        ]);

        return response()->json($data);
    }

    public function setLang($lang)
    {
        App::setLocale($lang);
    }

        
    public function barcode(Request $request)
    {
        $data = collect([
            ['code' => 'C128','label' => 'Code 128'],
            ['code' => 'C39','label' => 'Code 39'],
            ['code' => 'EAN-13','label' => 'EAN-13'],
            ['code' => 'EAN-8','label' => 'EAN-8'],
            ['code' => 'UPC-A','label' => 'UPC-A'],
            ['code' => 'UPC-E','label' => 'UPC-E'],
        ]);

        return response()->json($data, 200);
    }
    

    
    public function timezone()
    {
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

        return response()->json($timezones, 200);
    }
    
    private function convertDateFormat($phpFormat) {
        $replacements = [
            'Y' => 'YYYY',
            'y' => 'YY',
            'm' => 'MM',
            'n' => 'M',
            'F' => 'MMMM',
            'M' => 'MMM',
            'd' => 'DD',
            'j' => 'D',
            'H' => 'HH',
            'h' => 'hh',
            'i' => 'mm',
            's' => 'ss',
            'a' => 'a',
            'A' => 'A',
            'l' => 'dddd',
            'D' => 'ddd',
            'N' => 'E'
        ];
    
        // Escape any backslashes and replace PHP format tokens
        $dayjsFormat = preg_replace_callback(
            '/\\\\.|Y|y|m|n|F|M|d|j|H|h|i|s|a|A|l|D|N/',
            function ($match) use ($replacements) {
                $token = $match[0];
                if (str_starts_with($token, '\\')) {
                    return substr($token, 1);
                }
                return $replacements[$token] ?? $token;
            },
            $phpFormat
        );
    
        return $dayjsFormat;
    }

    
    public function test(Request $request)
    {
        // $user = User::where('id', '>', 3)->delete();
        // dd($user);
        // $user->delete();
        // return response()->json($user, 200);

        // $employees = Employee::where('id', '<', 194)->orderBy('id', "ASC")->get();
        $employees = User::where('id', '>', 1)->orderBy('id', "ASC")->get();        
        foreach ($employees as $index => $employee) {
            // Jika email kosong, beri email default
            // if()
            // $check = User::where('email', $employee->email)->first();
            // if($check) continue;
            // $email = $employee->email ?: 'employee' . ($index + 1) . '@pakarti.com';

            // // Buat user baru dari data employee
            // $user = User::create([
            //     'name' => $employee->name,
            //     'email' => $email,
            //     'employee_id' => $employee->id,
            //     'password' => bcrypt('employee123'), // Set default password
            //     // Kolom lain yang diperlukan untuk user
            // ]);

            $employee->assignRole('employee');
        }

        return response()->json([
            'message' => 'Users created successfully',
            'data' => $employees,
        ], 200);
    }
}