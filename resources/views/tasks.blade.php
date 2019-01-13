<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($status)
                <div class="alert alert-success">
                    <ul>
                        <li>{{ $status }}</li>
                    </ul>
                </div>
            @endif
            <form method="POST" action="/tasks">
                @csrf
                <input name="url" type="url">
                <button type="submit">Add</button>
            </form>
        </div>
        <div>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Url</th>
                    <th>Path</th>
                    <th>Status</th>
                    <th>Download at</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                </tr>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->url }}</td>
                        <td>{{ $task->file_path }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->download_at }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>{{ $task->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
