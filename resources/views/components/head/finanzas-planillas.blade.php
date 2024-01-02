<div class="flex justify-between gap-4">
    
    {{-- <div>
        <div class="form-group" wire:ignore>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Seleccionar mes y año" name="month" id="datepicker" required>
        </div>
    </div> --}}

    <div class="flex items-center">
        <a wire:click='$emit("openModal", "modal.store.spreadsheet")'>
            <x-btn-nuevo :content="'Generar Planilla'"/>
        </a>
    </div>
</div>


{{-- 
<script>
    window.onload = function() {
        const datepickerEl = document.getElementById('datepicker');
            
        new Datepicker(datepickerEl, {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
    }
</script>
--}}