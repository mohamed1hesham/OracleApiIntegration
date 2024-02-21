<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">absenceType</th>
            <th scope="col">absenceTypeId</th>
            <th scope="col">personAbsenceEntryId</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all as $one)
            <tr>
                <th scope="row"></th>
                <td>{{ $one['absenceType'] }}</td>
                <td>{{ $one['absenceTypeId'] }}</td>
                <td>{{ $one['personAbsenceEntryId'] }}</td>
            </tr>
        @endforeach


    </tbody>
</table>
{!! $absences->links() !!}


