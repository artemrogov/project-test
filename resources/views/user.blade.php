@php echo '<?xml version="1.0" encoding="UTF-8"?>' @endphp
    <user-data id_user="{{$user->id}}">
        <id_user>{{$user->id}}</id_user>
        <username>{{$user->name}}</username>
        <user_email>{{$user->email}}</user_email>
    </user-data>
