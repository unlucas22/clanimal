<div><a href="{{ route('dashboard.show.rrhh-spreadsheet', ['hashid' => $item->hashid]) }}"><x-btn/></a></div>
@if($item->status == 'pendiente') 
    @php($showBtn = true)
    @foreach($item->user_for_spreadsheets as $user)
        @if($user->status == 'pendiente')
            @php($showBtn = false)
            @break
        @endif
    @endforeach

    @if($showBtn)
    <div><a onclick='Livewire.emit("enviarPlanilla", {{ $item->id }})'>
        <x-btn-nuevo :content="'Enviar Planilla'"/></a></div>
    @endif
@endif