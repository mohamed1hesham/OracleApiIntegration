<!-- resources/views/absences.blade.php -->
@extends('layout')

@section('content')
    {{-- @dd(Route::has('datatable')) --}}

    <head>
        <title>Absence</title>
    </head>
    <h1>Absences Table</h1>
    <div class="table-data">
        <table id="table" class="table">
            <thead class="thead-dark">

                <tr>
                    <th scope="col">absenceType</th>
                    <th scope="col">absenceTypeId</th>
                    <th scope="col">personAbsenceEntryId</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($all as $one)
                    <tr>
                        <th scope="row"></th>
                        <td>{{ $one['absenceType'] }}</td>
                        <td>{{ $one['absenceTypeId'] }}</td>
                        <td>{{ $one['personAbsenceEntryId'] }}</td>
                    </tr>
                @endforeach


            </tbody> --}}
        </table>
        {{-- {!! $absences->links() !!} --}}
    </div>
@endsection

@push('js')
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- DataTables JavaScript CDN -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


    <script>
        // $(document).on('click', '.pagination a', function(e) {
        // e.preventDefault();
        // let page = $(this).attr('href').split('page=')[1]
        // product(page);

        // });
        $(function() {
            $('#table').DataTable({
                serverSide: true,
                processing: true,

                ajax: {
                    url: "{{ route('Absencedatatable') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                },
                columns: [{
                        name: "absenceType"
                    },
                    {
                        name: "absenceTypeId"
                    },
                    {
                        name: "personAbsenceEntryId"
                    },
                ],
                order: [
                    [0, "asc"]
                ],
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     $('.table').DataTable();
        // });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
@endpush
