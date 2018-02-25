<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Futsal Hlinsko</title>

        <style>
          body {
            font-size: 26px;
            font-family: sans-serif;
          }
        </style>
    </head>
    <body>
      <ul>
        @foreach ($tasks as $task)
          <li>
            <a href="tasks/{{ $task->id}}">
              {{ $task->body }}
            </a>
          </li>
        @endforeach
      </ul>
    </body>
</html>
