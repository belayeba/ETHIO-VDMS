
<div class="container-fluid">

    <div class="col-lg-8">
    
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: center;
            }
        </style>


        <h2>Users Data</h2>
        <table>
           
            <tbody>
                @foreach($data as $item)
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password(Don't forget to change)</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->password }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
