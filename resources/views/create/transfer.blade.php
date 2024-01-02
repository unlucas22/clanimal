<x-app-layout>
<x-slot name="header">
    <div class="flex justify-end">
        <button onclick="javascript:history.go(-1)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</button>
    </div>
</x-slot>

<x-basic-card>
    @livewire('dashboard.create.transfer')

    <script>
        window.onload = function(){
            const datepickerEl = document.getElementById('datepicker');
            
            new Datepicker(datepickerEl, {
                // options
            });

            datepickerEl.addEventListener('changeDate', (event) => {
                window.livewire.emit('dateSelected', event.detail.date);
            });
        }
    </script>

</x-basic-card>

</x-app-layout>