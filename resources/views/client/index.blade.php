<h1>Clients</h1>

@foreach($clients as $client)
    <p>{{ $client->user->name }} - {{ $client->phone }}</p>
@endforeach