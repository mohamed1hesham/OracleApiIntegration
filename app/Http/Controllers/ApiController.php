<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employees;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Return_;

class ApiController extends Controller
{
    public function index()
    {
        return view('IntegrationPage');
    }
    public function getGuzzleRequest($endpoint = '', $query)
    {
        $client = new \GuzzleHttp\Client();

        $base_url = 'Enter instance base url';
        $url = $base_url . $endpoint;
        $username = 'username';
        $password = 'pass';

        try {
            $response = $client->get($url, [
                'auth' => [$username, $password],
                'query' => $query
            ]);

            $responses = json_decode($response->getBody()->getContents());
            //  dd($responses);
            return $responses;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            dd($e->getMessage());
        }
    }
    public function EmployeesIntegration()
    {
        $endpoint = '/hcmRestApi/resources/11.13.18.05/emps';
        $limit = 100;
        $offset = 0;
        $data = [];
        do {
            $query = ['limit' => $limit, 'onlyData' => 'true', 'offset' => $offset];
            $response = $this->getGuzzleRequest($endpoint, $query);
            // dd($response);
            $data = array_merge($data, $response->items);
            $offset += $limit;
        } while ($response->hasMore);
        $dataToInsert = array_map(function ($response) {
            return [
                'FirstName' => $response->FirstName,
                'LastName' => $response->LastName,
                'WorkPhoneNumber' => $response->WorkPhoneNumber,
                'WorkEmail' => $response->WorkEmail,
                'NationalId' => $response->NationalId,
                'PersonNumber' => $response->PersonNumber
            ];
        }, $data);
        $dataChunks = array_chunk($dataToInsert, 500);
        foreach ($dataChunks as $chunk) {
            Employees::insertOrIgnore($chunk);
        }
    }
    public function Absences()
    {

        $startTime = microtime(true);
        $endpoint = '/hcmRestApi/resources/11.13.18.05/absences';
        $limit = 100;
        $offset = 0;
        $data = [];
        do {
            $query = [
                'limit' => $limit,
                'onlyData' => 'true',
                'offset' => $offset,
            ];
            $responses = $this->getGuzzleRequest($endpoint, $query);

            $data = array_merge($data, $responses->items);

            //  foreach ($responses->items as $response) {
            //      $data[] = ['absenceType' => $response->absenceType, 'employer' => $response->employer, 'absenceTypeId' => $response->absenceTypeId, 'personAbsenceEntryId' => $response->personAbsenceEntryId];
            //  }
            $offset += $limit;
            $hasMore = $responses->hasMore;
        } while ($hasMore);

        $dataToInsert = array_map(function ($response) {
            return [
                'absenceType' => $response->absenceType,
                'employer' => $response->employer,
                'absenceTypeId' => $response->absenceTypeId,
                'personAbsenceEntryId' => $response->personAbsenceEntryId
            ];
        }, $data);

        $dataChunks = array_chunk($dataToInsert, 500);
        //  dd($dataChunks);
        foreach ($dataChunks as $chunk) {
            Absence::insertOrIgnore($chunk);
        }
        // $allData = array_chunk($data, 500);
        // foreach ($allData as $data) {
        //     Absence::insertOrignore($data);
        // }

        //  Session::flash('message', 'This is message!');
        // Record end time
        $endTime = microtime(true);
        // Calculate execution time
        $executionTime = $endTime - $startTime;

        // Print or log the execution time
        echo "Execution Time: " . number_format($executionTime, 4) . " seconds";

        // return response()->json(['status' => 'success']);
    }

    public function workers()
    {
        $endpoint = '/hcmRestApi/resources/11.13.18.05/publicWorkers';


        $limit = 100;
        $offset = 0;
        $data = [];
        do {
            $query = [
                'limit' => $limit,
                'onlyData' => 'true',
                'offset' => $offset
            ];
            $responses = $this->getGuzzleRequest($endpoint, $query);

            $data = array_merge($data, $responses->items);

            $offset += $limit;
        } while ($responses->hasMore);


        $dataToInsert = array_map(function ($response) {
            return [
                'PersonId' => $response->PersonId,
                'FirstName' => $response->FirstName,
                'LastName' => $response->LastName
            ];
        }, $data);

        ///  dd($data);
        $endpoint2 = "/hcmRestApi/resources/11.13.18.05/publicWorkers/{$data[0]->PersonId}/child/assignments";

        //dd($endpoint2);
        $data2 = [];
        $query = [
            'onlyData' => 'true',
        ];
        $responses2 = $this->getGuzzleRequest($endpoint2, $query);
        $data2 = array_merge($data2, $responses2->items);
        dd($data2);
        // $data3 = array_merge($data2, $data);
        // dd($data3);
    }

    public function showAbsences()
    {
        $absences = Absence::all();
        return view('show_absence', ['absences' => $absences]);
    }
}
