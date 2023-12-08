<div class="p-6">
    <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-4">Escanea el QR para obtener los datos de {{ $pet->name }}</h2>

    <div class="space-y-10 pt-4">

        <div>
            <div class="flex justify-center">
                <div class="p-2">
                    {!! DNS2D::getBarcodeHTML("{$link}", 'QRCODE') !!}
                </div>
            </div>

            <a href="{{ $link }}">click aquí (link de prueba)</a>
        </div>

        <hr>

        <div class="text-center">

            <div><h2 class="mb-4 text-3xl tracking-tight font-semibold text-center text-gray-900 dark:text-white">{{ $pet->name }}</h2></div>
            <div>{{ $pet->type_of_pets->name }}, {{ $pet->gender }}</div>

            <div class="pt-4 flex justify-center gap-8">
                <div class="font-semibold">Dueño: </div>
                <div>{{ $pet->clients->name }}</div>
            </div>

        </div>
        
    </div>
</div>