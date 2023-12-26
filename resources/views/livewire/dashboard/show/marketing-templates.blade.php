<div class="flex justify-center pt-8">
    <form method="POST" action="{{ route('dashboard.update.marketing-templates') }}" class="space-y-4" enctype="multipart/form-data">
    <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-2">Modificar Plantilla</h2>

        @csrf

        <input type="hidden" name="template_id" wire:model="template_id">

        <div class="w-full">
            <x-form.input :label="'Nombre'" :name="'name'" :model="'name'" :required="'required'" />
        </div>

        <div class="w-full">
            <div>
                <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mensaje</label>
                <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" wire:model.defer="content"></textarea>
            </div>
        </div>

        <div class="flex justify-between gap-8">
            <div class="w-full">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Imagen</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="image" id="image" type="file">
            </div>

            @if($image !== null)
            <div class="w-full">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="preview-image">Imagen</label>
                <img id="preview-image" height="300" width="300" src="{{ url('img/emails/'.$image) }}">
            </div>
            @endif
        </div>


        <div class="flex justify-center">
            <div class="flex justify-between gap-8">
                <div>
                    <x-form.input :label="'Texto de Botón'" :name="'button_text'" :model="'button_text'" :required="'required'" />
                </div>
                <div>
                    <x-form.input :label="'URL de Botón'" :name="'button_url'" :model="'button_url'" :required="'required'" />
                </div>
            </div>
        </div>

        <div class="p-4 flex justify-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Guardar
            </button>
        </div>

    </form>
</div>