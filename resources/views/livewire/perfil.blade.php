<div>
    <div class="space-y-6 mt-4">
        <div class="flex justify-center">
            <img class="h-32 w-32 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
        </div>
        <div class="font-bold text-center">{{ $user->name }}</div>
        <div class="p-2 ">
            <div class="font-semibold">Fecha: {{ now()->format('d/m/Y') }}</div>
            <div class="font-semibold">Hora: {{ now()->format('H:i') }}</div>
            <div class="font-semibold">Motivo: {{ $control->motivo }}</div>
        </div>
    </div>
</div>
