<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <form method="POST" enctype="multipart/form-data" action="{{ route("testImport") }}">
        {{ csrf_field() }}
        <input type="file" name="file">
        <button >Import</button>
    </form>

</body>
</html>