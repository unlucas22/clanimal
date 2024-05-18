<div class=" p-4">

    <div>
        
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Oferta
            </h3>

            <x-btn-retorno-default />
        </div>
    </div>

    <div class="flex justify-between gap-8">
        <div class="w-full">

            <form wire:submit.prevent="submit" class="space-y-10">
                @csrf

                <div class="grid grid-cols-5  gap-4">
                    <div class="w-full pt-8 flex justify-center">
                        <div>
                            <label class="relative inline-flex items-center mb-5 cursor-pointer">
                                <input type="checkbox" name="active" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full">
                        <div>
                            <label for="precio_total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de la oferta</label>
                            <input type="text" name="name" id="name" wire:model="name" maxlength="30" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div >
                        <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de inicio</label>
                        <div class="relative max-w-sm">
                          <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                             <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                              </svg>
                          </div>
                          <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Seleccionar Fecha" name="fecha" id="fecha-inicio" value="{{ $fecha_inicio ?? date('m/d/Y') }}" onchange="callUpdateFechaInicio()" required>
                        </div>
                        @error('fecha_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div wire:ignore>
                        <label for="fecha-final" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Final</label>
                        <div class="relative max-w-sm">
                          <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                             <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                              </svg>
                          </div>
                          <input type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Seleccionar Fecha" name="fecha" id="fecha-final" onchange="callUpdateFechaFinal()" value="{{ $fecha_final ?? date('m/d/Y') }}" required >
                        </div>
                        @error('fecha_final') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="w-full">
                        <div>
                            <label for="precio_total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio total</label>
                            <input type="number" step="0.1" name="precio_total" id="precio_total" wire:model.defer="precio_total" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        @error('precio_total') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                </div>


                <div class="flex justify-end gap-8"  wire:ignore>
                    <div class="flex justify-end gap-1">
                        <div class="w-full">

                            <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar Producto</div>
                            <div class='relative searchable-list-brand'>
                                <input type='text' class='data-list-brand peer block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' id="product-category" spellcheck="false"  placeholder="Buscar un producto" name="product_category_id"></input>
                                <svg class="outline-none cursor-pointer fill-gray-400 absolute transition-all duration-200 h-full w-4 -rotate-90 right-2 top-[50%] -translate-y-[50%]"
                                    viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="M0 256l512 512L1024 256z"></path>
                                </svg>
                                <ul class='absolute option-list-brand overflow-y-scroll w-full min-h-[0px] flex flex-col top-12 
                                    left-0 bg-white rounded-sm scale-0 opacity-0 
                                    transition-all 
                                    duration-200 origin-top-left z-10'>
                                </ul>
                            </div>
                        </div>
                        <div class="pt-7">
                            <a onclick="setProduct()" class="data-list-brand peer block w-full py-4 px-2 text-sm text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer">AGREGAR
                            </a>
                        </div>
                    </div>

                    <script>
                    const domParser = new DOMParser();
                    const dataListBrand = {
                        el:document.querySelector('.data-list-brand'),
                        listEl:document.querySelector('.option-list-brand'),
                        arrow:document.querySelector(".searchable-list-brand>svg"),
                        currentValue:null,
                        listOpened :false,
                        optionTemplate:
                        `
                        <li
                            class='data-option-brand select-none break-words inline-block text-sm text-gray-500 bg-gray-100 odd:bg-gray-200 hover:bg-gray-300 hover:text-gray-700 transition-all duration-200 font-bold p-3 cursor-pointer max-w-full '>
                                [[REPLACEMENT]]
                        </li>
                        `,
                        optionElements:[],
                        options:[], 
                        find(str){
                            for(let i = 0;i<dataListBrand.options.length;i++){
                                const option = dataListBrand.options[i];
                                if(!option.toLowerCase().includes(str.toLowerCase())){
                                    dataListBrand.optionElements[i].classList.remove('block');
                                    dataListBrand.optionElements[i].classList.add('hidden');
                                }else{
                                    dataListBrand.optionElements[i].classList.remove('hidden');
                                    dataListBrand.optionElements[i].classList.add('block');
                                }
                            }
                        },  
                        remove(value){
                            const foundIndex = dataListBrand.options.findIndex(v=>v===value);
                            if(foundIndex!==-1){
                                dataListBrand.listEl.removeChild(dataListBrand.optionElements[foundIndex])
                                dataListBrand.optionElements.splice(foundIndex,1);
                                dataListBrand.options.splice(value,1);
                            }
                        },
                        append(value){    
                            if(!value || typeof value === 'object' || typeof value === 'symbol' || typeof value ==='function') return;
                            value = value.toString().trim();
                            if(value.length === 0) return; 
                            if(dataListBrand.options.includes(value)) return;

                            const html = dataListBrand.optionTemplate.replace('[[REPLACEMENT]]',value);
                            const targetEle = domParser.parseFromString(html, "text/html").querySelector('li');
                            targetEle.innerHTML = targetEle.innerHTML.trim();
                            dataListBrand.listEl.appendChild(targetEle);
                            dataListBrand.optionElements.push(targetEle);  
                            dataListBrand.options.push(value);

                            if(!dataListBrand.currentValue) dataListBrand.setValue(value);
                  
                            targetEle.onmousedown = (e)=>{
                                dataListBrand.optionElements.forEach((el,index)=>{
                                    if(e.target===el){
                                        dataListBrand.setValue(dataListBrand.options[index]);
                                        dataListBrand.hideList();
                                        return;
                                    }
                                })
                            }
                        },  
                        setValue(value){
                            dataListBrand.el.value = value;
                            dataListBrand.currentValue = value;
                        },
                        showList(){
                            dataListBrand.listOpened = true;
                            dataListBrand.listEl.classList.add('opacity-100');
                            dataListBrand.listEl.classList.add('scale-100');
                            dataListBrand.arrow.classList.add("rotate-0");
                        },
                        hideList(){
                            dataListBrand.listOpened = false;
                            dataListBrand.listEl.classList.remove('opacity-100');
                            dataListBrand.listEl.classList.remove('scale-100');
                            dataListBrand.arrow.classList.remove("rotate-0");
                        },
                        init(){ 
                            dataListBrand.arrow.onclick = ()=>{
                                dataListBrand.listOpened ? dataListBrand.hideList(): dataListBrand.showList();
                            } 
                            dataListBrand.el.oninput = (e)=>{
                                dataListBrand.find(e.target.value);
                            }
                            dataListBrand.el.onclick= (el)=>{
                                dataListBrand.showList();
                                for(let el of dataListBrand.optionElements){
                                    el.classList.remove('hidden');
                                }
                            }
                            dataListBrand.el.onblur = (e)=>{
                                dataListBrand.hideList();
                                dataListBrand.setValue(dataListBrand.currentValue);
                            }
                        }
                    }

                    dataListBrand.init(); 

                    const data = [
                        @foreach($products as $product) "{{ $product['name'] }}", @endforeach
                    ];

                    data.forEach(v=>(dataListBrand.append(v)));

                </script>
                </div>


                <script>
                    function callUpdateFechaInicio()
                    {
                        let fechaInicio = document.getElementById('fecha-inicio').value;
                        window.livewire.emit('fechaInicioSelected', fechaInicio);
                    }

                    function callUpdateFechaFinal()
                    {
                        let fechaFinal = document.getElementById('fecha-final').value;
                        window.livewire.emit('fechaFinalSelected', fechaFinal);
                    }

                    function setProduct()
                    {
                        Livewire.emit('pushProducts', dataListBrand.currentValue);

                        Livewire.emit('refreshComponent');
                    }
                </script>

                <div>
                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow">
                                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                                        <thead class="bg-gray-100 dark:bg-gray-700">
                                            <tr>
                                                @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                                                <th scope="col" class="{{ $colStyle }}">
                                                    ID
                                                </th>

                                                <th scope="col" class="{{ $colStyle }}">
                                                    Imagen
                                                </th>

                                                <th scope="col" class="{{ $colStyle }}">
                                                    Producto
                                                </th>

                                                <th scope="col" class="{{ $colStyle }}">
                                                    Categoría
                                                </th>

                                                <th scope="col" class="{{ $colStyle }}">
                                                    Marca
                                                </th>

                                                <th scope="col" class="{{ $colStyle }}">
                                                    Precio Venta
                                                </th>
                                                
                                                <th scope="col" class="{{ $colStyle }}">
                                                    Última Actualización
                                                </th>
                                                <th scope="col" class="{{ $colStyle }} text-center">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                                        @php($td = 'p-4 text-center text-base font-medium text-gray-900 dark:text-white')

                                        @forelse($products_selected as $index => $product)
                                        <div>
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                                        >
                                            <td class="{{ $td }}">
                                                {{ $product['id'] }}
                                            </td>

                                            <td class="{{ $td }}">
                                                @if($product['photo_url'] !== null)
                                                <a href="#" onclick="showModal('{{  url('storage/'.$product['photo_path']) }}')"><img class="w-20 h-20 rounded" src="{{ url('storage/'.$product['photo_path']) }}"></a>
                                                @else
                                                Sin imagen
                                                @endif
                                            </td>

                                            <td class="{{ $td }}">
                                                {{ $product['name'] }}
                                            </td>

                                            <td class="{{ $td }}">
                                                {{ $product['product_categories']['name'] }}
                                            </td>

                                            <td class="{{ $td }}">
                                                {{ $product['product_brands']['name'] }}
                                            </td>

                                            <td class="{{ $td }}">
                                                @isset($product['product_details'])
                                                S/ {{ $product['product_details'][0]['precio_venta_sin_igv'] }}
                                                @endisset
                                            </td>

                                            <td class="{{ $td }}">
                                                {{ date('d/m/Y h:i A', strtotime($product['updated_at'])) }}
                                            </td>

                                            <td class="p-4 space-x-2 flex justify-center">

                                                <div class="flex justify-between gap-2" style="max-width: 250px;">
                                                    <div>
                                                        <div>
                                                            
                                                        
                                                        <button onclick="callDeleteButton({{ $index }})" type="button" id="deleteProductButton" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                            Eliminar
                                                        </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr class="bg-white border-b">
                                        </div>
                                        @empty
                                        <tr class="text-center py-3">
                                            <td colspan="8" class="py-3 italic">No hay Productos seleccionados</td>
                                        </tr>
                                        @endforelse    
                                        </tbody>
                                    </table>
                                    
                                    <script>
                                        function callDeleteButton(item_id) {
                                            Swal.fire({
                                                title: '¿Estás seguro?',
                                                text: "Una vez que eliminas no lo podrás recuperar su información",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Si, eliminar'
                                            }).then(function (res) {
                                                if (res.isConfirmed) {
                                                    Livewire.emit('removeProducts', item_id);

                                                    Livewire.emit('refreshComponent');
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Get the modal by id
                    var modal = document.getElementById("modal");

                    // Get the modal image tag
                    var modalImg = document.getElementById("modal-img");

                    // this function is called when a small image is clicked
                    function showModal(src) {
                        modal.classList.remove('hidden');
                        modalImg.src = src;
                    }

                    // this function is called when the close button is clicked
                    function closeModal() {
                        modal.classList.add('hidden');
                    }
                </script>

                <div class="flex justify-center gap-8">
                    <div>
                        <button class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Guardar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>