<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function show_absence()
    {
        // [$all, $absences] = $this->mainPagination();
        //  $absences = Absence::latest()->paginate(15);
        //$all = [];
        //$absences->each(function ($item) use (&$all) {
        //  $all[] = ['absenceType' => $item->absenceType, 'employer' => $item->employer, 'absenceTypeId' => $item->absenceTypeId, 'personAbsenceEntryId' => $item->personAbsenceEntryId];
        //});

        //   foreach ($all as $one) {
        //       dd($one['absenceType']);
        //  }
        // dd($all);
        return view('show_absence');
        //  echo json_encode($all);
    }

    public function pagination2()
    {
        [$all, $absences] = $this->mainPagination();

        return view('pagination', ['all' => $all, 'absences' => $absences])->render();
    }


    private function mainPagination()
    {
        $absences = Absence::latest()->paginate(15);
        $all = $absences->map(function ($item) {
            return [
                'absenceType' => $item->absenceType,
                'employer' => $item->employer,
                'absenceTypeId' => $item->absenceTypeId,
                'personAbsenceEntryId' => $item->personAbsenceEntryId,
            ];
        });

        return [$all, $absences];
    }

    public function Absencedatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];

        $query = Absence::select('absenceType', 'absenceTypeId', 'personAbsenceEntryId');

        // Apply search filter
        if ($searchValue) {
            $query->where('absenceType', 'LIKE', '%' . $searchValue . '%');
        }

        // Get total records without filtering
        $totalRecords = $query->count();

        // Get filtered records
        $absences = $query->skip($start)->take($length)->get();
        //     dd($absences);
        $data_arr = [];
        foreach ($absences as $item) {
            $data_arr[] = [
                $item->absenceType ?? '',
                $item->absenceTypeId ?? '',
                $item->personAbsenceEntryId ?? '',
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data_arr,
        ];

        return response()->json($response);
    }
}
