<x-app-layout>

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