@extends('layout')

@section('content')

    <head>
        <title>Integration page</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>


        <div class="container">


        </div>
        <div class="float-container">

            <div class="float-child">
                <div class="green">Integrations</div>
                <button id="absenceBtn" type="button" class="btn btn-primary btn-lg">
                    <i class="fa fa-refresh fa-sync"></i> Absences
                </button>

                <button id="empsBtn" type="button" class="btn btn-dark bg-lg">
                    <i class="fa fa-refresh fa-sync"></i> Employees
                </button>

                <button id="empsBtn" type="button" class="btn btn-warning bg-lg">
                    <i class="fa fa-refresh fa-sync"></i> Time Card
                </button>

                <button id="empsBtn" type="button" class="btn btn-info bg-lg"><i class="fa fa-refresh fa-sync"></i>
                    Departments
                </button>
                <button id="empsBtn" type="button" class="btn btn-success bg-lg"><i class="fa fa-refresh fa-sync"></i>
                    Positions
                </button>


            </div>

            <div class="float-child">
                <div class="blue">Display Data</div>
                <button id="absenceBtnData" type="button" class="btn btn-primary btn-lg">
                    Absences
                </button>

                <button id="empsBtn" type="button" class="btn btn-dark bg-lg">
                    Employees
                </button>

                <button id="empsBtn" type="button" class="btn btn-warning bg-lg">
                    Time Card
                </button>

                <button id="empsBtn" type="button" class="btn btn-info bg-lg">
                    Departments
                </button>

                <button id="empsBtn" type="button" class="btn btn-success bg-lg">
                    Positions
                </button>
            </div>

        </div>


    </body>
@endsection
@push('css')
    <style>
        .float-container {
            border: 3px solid #fff;
            padding: 20px;
        }

        .float-child {
            width: 50%;
            height: 380PX;
            float: left;
            padding: 20px;
            border: 2px solid red;
        }

        .float-child button {
            display: block;
            margin: 10px;
            width: 150px;
            height: 50px;
        }

        .green {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            color: green;
        }

        .blue {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            color: blue;
        }
    </style>
@endpush
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('#absenceBtn').click(function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "6000",
                "positionClass": "toast-bottom-right",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
            };
            $('#absenceBtn').prop('disabled', true).removeClass("btn-primary").addClass("btn-secondary")
                .children(
                    "i").addClass("fa-spin");

            $.ajax({
                url: "{{ route('request') }}",
                method: 'GET',
                success: function() {
                    // window.location.href = '/request';

                    $('#absenceBtn').children("i").removeClass("fa-spin");
                    $('#absenceBtn').prop('disabled', false).removeClass("btn-secondary").addClass(
                        "btn-primary");
                    toastr.success('Request Successful');
                },
                error: function(error) {
                    console.error(error);
                    $('#absenceBtn').prop('disabled', false);
                    toastr.success('Request Faild');
                }
            });
        })
        $('#empsBtn').click(function() {
            toastr.options = {
                "positionClass": "toast-bottom-right",

            };
            $('#empsBtn').prop('disabled', true).removeClass("btn-dark").addClass("btn-secondary")
                .children(
                    "i").addClass("fa-spin");

            $.ajax({
                url: "{{ route('requestEmps') }}",
                method: 'GET',
                success: function() {
                    // window.location.href = '/request';
                    $('#empsBtn').children("i").removeClass("fa-spin");
                    $('#empsBtn').prop('disabled', false).removeClass("btn-secondary").addClass(
                        "btn-dark");
                    toastr.success('Request Successful');
                },
                error: function(error) {
                    console.error(error);
                    $('#empsBtn').prop('disabled', false);
                    toastr.success('Request Faild');
                }
            });
        })
        $('#absenceBtnData').click(function() {
            $.ajax({
                url: "{{ route('show-absences') }}",
                method: 'GET',
                success: function() {
                    window.location.href = '/show-absences';
                },
                error: function(error) {
                    console.error(error);
                }
            });
        })
    </script>
@endpush
