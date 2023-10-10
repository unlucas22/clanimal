<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Imagenes de {{ $pet->name }}
    </h2>
</x-slot>

<div class="pt-8">
    <div class="bg-white shadow rounded-lg max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8  mx-auto">
        <div class="mt-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Cargar las imagenes de la mascota</h2>
            <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 sm:text-xl"> Las imagenes deben tener las siguientes extensiones .png, .jpeg, .jpg</p>

            <form method="POST" action="{{ route('dashboard.update.pet-images') }}" enctype="multipart/form-data" class="space-y-10">

                @csrf

                <input type="hidden" name="pet_id" value="{{ $pet->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="files-boxs">
                    @for($i=0; $i < 3; $i++)
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file-{{ $i }}" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <div id="output-text-{{ $i }}">
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click para cargar</span> o arrastra y suelta </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG.</p>
                                </div>
                                <img width="150" id="output-{{ $i }}" style="display:none">
                            </div>
                            <input id="dropzone-file-{{ $i }}" name="images_{{ $i }}" onchange="loadFile(event, {{ $i }})" type="file" class="hidden" accept="image/jpg, image/jpeg, image/png" />
                        </label>
                    </div>
                    @endfor
                </div>

                <script>
                    function loadFile(event, id) {
                        
                        var output = document.getElementById('output-'+id);
                        
                        output.src = URL.createObjectURL(event.target.files[0]);

                        output.style.display = 'block';

                        document.getElementById('output-text-'+id).style.display = 'none';
                        
                        output.onload = function() {
                            URL.revokeObjectURL(output.src)
                        }; // free memory
                    }
                </script>

                <div class="p-4">
                    <x-jet-button>
                        {{ __('Cargar imagenes') }}
                    </x-jet-button>                
                </div>

            </form>

        </div>
    </div>
</div>
</x-app-layout>