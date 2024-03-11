<!DOCTYPE html>
<html>
<head>
    <title>Send mail to all users using Window's Task Scheduler and Laravel's Command and Queue</title>
</head>
<body>
    <h1>Send mail to all users using Window's Task Scheduler and Laravel's Command and Queue</h1>
    <h1>Send Mail Reminder Daily </h1>
    <h1>Email : {{$user->email}}</h1>
    <h1>Hey <span style="color: #ff5774">{{$user->name}} </span> 
        Have you visited the <a href="{{ \App\Enums\UserEnum::DOMAIN_PATH . 'main/view' }}">Blog</a> today <span style="color: #007bff">{{ date('Y-m-d H:i:s') }}</span> ? 
        There are many articles waiting for you to read ! </h1>
</body>
</html> 
