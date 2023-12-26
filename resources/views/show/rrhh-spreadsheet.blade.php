<x-app-layout>

<x-slot name="header">
    <div class="flex justify-end">
        <a onclick="javascript:history.go(-1)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
    </div>
</x-slot>

<x-basic-card>

    <script>
        function setMontoMinutos(val) {

            if (isNaN(val)) {
                console.error("El valor proporcionado no es un número.");
                return;
            }

            let monto_tardanza = 0;

            if (val < 30) {
                monto_tardanza = 40;
            } else if (val >= 30 && val < 60) {
                monto_tardanza = 80;
            } else if (val >= 60) {
                monto_tardanza = 200;
            }

            document.getElementById('monto_minutos_de_tardanzas').value = monto_tardanza;
        }

        function setMontoDias(val) {

            let sueldo = document.getElementById('sueldo').value;

            if (val === 0) {
                console.error("No se puede dividir por cero.");
                return;
            }

            let monto = (sueldo / 30) * val;

            document.getElementById('monto_dias_no_laborados').value = monto.toFixed(2);
        }
    </script>
    
    @livewire('dashboard.show.rrhh-spreadsheet')
</x-basic-card>

</x-app-layout>