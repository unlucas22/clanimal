<div class="flex justify-center p-4">
    <div class="w-full">
        <form method="POST" action="{{ route('dashboard.store.product') }}" class="space-y-4" enctype="multipart/form-data" id="form-producto">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Registrar Producto
                </h3>

                <x-btn-retorno-default />
            </div>

            @csrf


            <div class="flex justify-between gap-8" >

                <div class="flex justify-center gap-1 w-full" wire:ignore>
                    <div class="w-full">

                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marca</div>
                        <div class='relative searchable-list-brand'>
                            <input type='text' class='data-list-brand peer block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ' id="product-brand" spellcheck="false"  placeholder="Buscar una marca" name="product_brand_id"></input>
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
                        @error('product_brand_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>


                    <div class="pt-7">
                        <a wire:click='$emit("openModal", "modal.store.product-brand")' class="data-list-brand peer block w-full py-4 px-2 text-sm text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer">AGREGAR
                        </a>
                    </div>
                </div>

                <div class="flex justify-center gap-1 w-full" wire:ignore>
                    <div class="w-full">

                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoría</div>
                        <div class='relative searchable-list-category'>
                            <input type='text' class='data-list-category peer block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' id="product-category" spellcheck="false"  placeholder="Buscar una marca" name="product_category_id"></input>
                            <svg class="outline-none cursor-pointer fill-gray-400 absolute transition-all duration-200 h-full w-4 -rotate-90 right-2 top-[50%] -translate-y-[50%]"
                                viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M0 256l512 512L1024 256z"></path>
                            </svg>
                            <ul class='absolute option-list-category overflow-y-scroll w-full min-h-[0px] flex flex-col top-12 
                                left-0 bg-white rounded-sm scale-0 opacity-0 
                                transition-all 
                                duration-200 origin-top-left z-10'>
                            </ul>
                        </div>
                        @error('product_category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-7">
                        <a wire:click='$emit("openModal", "modal.store.product-category")' class="data-list-brand peer block w-full py-4 px-2 text-sm text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer">AGREGAR
                        </a>
                    </div>
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

            const dataListCategory = {
                el:document.querySelector('.data-list-category'),
                listEl:document.querySelector('.option-list-category'),
                arrow:document.querySelector(".searchable-list-category>svg"),
                currentValue:null,
                listOpened :false,
                optionTemplate:
                `
                <li
                    class='data-option-category select-none break-words inline-block text-sm text-gray-500 bg-gray-100 odd:bg-gray-200 hover:bg-gray-300 hover:text-gray-700 transition-all duration-200 font-bold p-3 cursor-pointer max-w-full '>
                        [[REPLACEMENT]]
                </li>
                `,
                optionElements:[],
                options:[], 
                find(str){
                    for(let i = 0;i<dataListCategory.options.length;i++){
                        const option = dataListCategory.options[i];
                        if(!option.toLowerCase().includes(str.toLowerCase())){
                            dataListCategory.optionElements[i].classList.remove('block');
                            dataListCategory.optionElements[i].classList.add('hidden');
                        }else{
                            dataListCategory.optionElements[i].classList.remove('hidden');
                            dataListCategory.optionElements[i].classList.add('block');
                        }
                    }
                },  
                remove(value){
                    const foundIndex = dataListCategory.options.findIndex(v=>v===value);
                    if(foundIndex!==-1){
                        dataListCategory.listEl.removeChild(dataListCategory.optionElements[foundIndex])
                        dataListCategory.optionElements.splice(foundIndex,1);
                        dataListCategory.options.splice(value,1);
                    }
                },
                append(value){    
                    if(!value || typeof value === 'object' || typeof value === 'symbol' || typeof value ==='function') return;
                    value = value.toString().trim();
                    if(value.length === 0) return; 
                    if(dataListCategory.options.includes(value)) return;

                    const html = dataListCategory.optionTemplate.replace('[[REPLACEMENT]]',value);
                    const targetEle = domParser.parseFromString(html, "text/html").querySelector('li');
                    targetEle.innerHTML = targetEle.innerHTML.trim();
                    dataListCategory.listEl.appendChild(targetEle);
                    dataListCategory.optionElements.push(targetEle);  
                    dataListCategory.options.push(value);

                    if(!dataListCategory.currentValue) dataListCategory.setValue(value);
          
                    targetEle.onmousedown = (e)=>{
                        dataListCategory.optionElements.forEach((el,index)=>{
                            if(e.target===el){
                                dataListCategory.setValue(dataListCategory.options[index]);
                                dataListCategory.hideList();
                                return;
                            }
                        })
                    }
                },  
                setValue(value){
                    dataListCategory.el.value = value;
                    dataListCategory.currentValue = value;
                },
                showList(){
                    dataListCategory.listOpened = true;
                    dataListCategory.listEl.classList.add('opacity-100');
                    dataListCategory.listEl.classList.add('scale-100');
                    dataListCategory.arrow.classList.add("rotate-0");
                },
                hideList(){
                    dataListCategory.listOpened = false;
                    dataListCategory.listEl.classList.remove('opacity-100');
                    dataListCategory.listEl.classList.remove('scale-100');
                    dataListCategory.arrow.classList.remove("rotate-0");
                },
                init(){ 
                    dataListCategory.arrow.onclick = ()=>{
                        dataListCategory.listOpened ? dataListCategory.hideList(): dataListCategory.showList();
                    } 
                    dataListCategory.el.oninput = (e)=>{
                        dataListCategory.find(e.target.value);
                    }
                    dataListCategory.el.onclick= (el)=>{
                        dataListCategory.showList();
                        for(let el of dataListCategory.optionElements){
                            el.classList.remove('hidden');
                        }
                    }
                    dataListCategory.el.onblur = (e)=>{
                        dataListCategory.hideList();
                        dataListCategory.setValue(dataListCategory.currentValue);
                    }
                }
            }
            
            // how to use
            dataListBrand.init(); 
            // add items
            const data = [
                @foreach($product_brands as $product_brand) "{{ $product_brand->name }}", @endforeach
            ];
            data.forEach(v=>(dataListBrand.append(v)));

            dataListCategory.init(); 

            const dataCategory = [
                @foreach($product_categories as $product_category) "{{ $product_category->name }}", @endforeach
            ];
            dataCategory.forEach(v=>(dataListCategory.append(v))); 
        </script>

        <script>
            document.addEventListener('updateBrand', event => {
                dataListBrand.append(event.detail.value);
                console.log(event.detail.value);
            });

             document.addEventListener('updateCategory', event => {
                dataListCategory.append(event.detail.value);
                console.log(event.detail.value);
            });
        </script>

            <div class="flex justify-between gap-8">
                <div class="w-full">
                    <x-form.input :label="'Producto o Servicio'" :name="'name'" :model="'name'" :required="'required maxlength=50'" />
                </div>
                <div class="w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Subir</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="photo" id="file_input" type="file">
                </div>
            </div>

            <div class="flex justify-between gap-8">

                <div class="flex justify-between w-full gap-4">
                    <div class="w-full">
                        <x-form.input :label="'Palabras clave'" :name="'palabras_clave'" :model="'palabras_clave'" :placeholder="'palabra, clave, entre, comas'" :required="'maxlength=80'" />
                    </div>
                    <div class="w-full">
                        <x-form.input :name="'alerta_stock'" :model="'alerta_stock'" :label="'Alerta de Bajo Stock'" :type="'number'" :required="'required'" />
                        @error('alerta_stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                </div>
                <div class="w-full">
                    <label for="barcode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código de barras</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="barcode" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="barcode" name="barcode" min="100000000000" max="9999999999999" maxlength="12" required>
                        <a wire:click="getBarcode" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">Generar</a>
                    </div>
                    @error('barcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="relative inline-flex items-center mb-5 cursor-pointer">
                    <input type="checkbox" name="active" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</span>
                </label>
            </div>

            {{-- UNIDADES Y PRECIOS SECCION DINAMICA --}}

            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Unidades Y Precios. <span class="font-medium">Total: {{ $product_details ?? 0 }}</span>
                </h3>

                <div>
                    <a wire:click="agregarPrecio" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">AGREGAR PRECIO</a>
                </div>
            </div>

            <input type="hidden" name="product_details" id="product-details-count" wire:model="product_details" value="{{ $product_details }}">
            <input type="hidden" name="product_ofertas" id="product-ofertas" value="{{ count($product_ofertas) }}">

            @for($i=0; $i < $product_details; $i++)
            <div class="flex justify-center">

                <div class="grid grid-cols-7 gap-4">
                    
                    <div class="w-full mb-6 pt-8 flex justify-center">
                        <label class="relative inline-flex items-center mb-5 cursor-pointer">
                            <input type="checkbox" name="active_details[{{ $i }}]" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</span>
                        </label>
                    </div>

                    <div class="w-full mb-6 group">

                        <x-form.select :name="'product_presentation_details_id['.$i.']'" :model="'product_presentation_details_id.'.$i" :label="'Presentación'" :required="'required'">
                            @foreach($product_presentations as $product_presentation)
                            <option value="{{ $product_presentation->id }}">{{ $product_presentation->name }}</option>
                            @endforeach
                        </x-form.select>
                        </select>
                    </div>

                    <div class="w-full mb-6 group">
                        <div>
                            <label for="precio_venta{{ $i }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio sin IGV</label>
                            <input type="number" step="0.1" name="precio_venta_details[{{ $i }}]" id="precio_venta{{ $i }}" wire:model.defer="precio_venta_details.{{ $i }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" oninput="sumarImpuesto({{ $i }})" required>
                        </div>
                    </div>

                    <div class="w-full mb-6 group">
                        <x-form.input :id="'precio_venta_con_igv_details.'.$i" :name="'precio_venta_con_igv_details['.$i.']'" :model="'precio_venta_con_igv_details.'.$i" :label="'Precio Venta con IGV'" :type="'number'" :required="'disabled'" />
                    </div>

                    <div class="w-full mb-6 group">
                        <div>
                            <label for="discount_details{{ $i }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descuento</label>
                            <input type="number" name="discount_details[{{ $i }}]" id="discount_details{{ $i }}" wire:model.defer="discount_details.{{ $i }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" oninput="sumarImpuesto({{ $i }})" value="0">
                        </div>
                    </div>

                    <div class="w-full mb-6 group">
                        <div>
                            <label for="precio_venta_total{{ $i }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Total</label>
                            <input type="number" step="0.1" name="precio_venta_total[{{ $i }}]" id="precio_venta_total{{ $i }}" wire:model.defer="precio_venta_total.{{ $i }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>

                    <div class="pt-8 w-full flex justify-center">
                        <div>
                            <a wire:click="eliminarPrecio" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 cursor-pointer">Eliminar</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex justify-end">
                <div>
                    <a wire:click="agregarOferta({{ $i }})" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">AGREGAR OFERTA</a>
                </div>
            </div>

            @for($z=0; $z < count($product_ofertas); $z++)

            @if($product_ofertas[$z]['product_detail_id'] != $i)
            @continue
            @endif

            <div class="flex justify-center">

                <div class="grid grid-cols-7 gap-4 w-full">

                    <div class="w-full mb-6 pt-8 flex justify-center">
                        <label class="relative inline-flex items-center mb-5 cursor-pointer">
                            <input type="checkbox" name="active_oferta[{{ $i }}][{{ $z }}]" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</span>
                        </label>
                    </div>

                    <div class="w-full mb-6">
                        <label for="precio_oferta{{ $i }}.{{ $z }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Total</label>
                        <input type="number" step="0.1" name="precio_oferta[{{ $i }}][{{ $z }}]" id="precio_oferta{{ $i }}.{{ $z }}" value="{{ $product_ofertas[$z]['precio_total'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:change="setPrecioOferta({{ $z }}, document.getElementById('precio_oferta{{ $i }}.{{ $z }}').value)">
                    </div>

                    <div class="w-full mb-6 col-span-2">
                        <label for="fecha_inicio_oferta{{ $i }}.{{ $z }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio_oferta[{{ $i }}][{{ $z }}]" id="fecha_inicio_oferta{{ $i }}.{{ $z }}" value="{{ $product_ofertas[$z]['fecha_inicio'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="w-full mb-6 col-span-2">
                        <label for="fecha_final_oferta{{ $i }}.{{ $z }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Final</label>
                        <input type="date" name="fecha_final_oferta[{{ $i }}][{{ $z }}]" id="fecha_final_oferta{{ $i }}.{{ $z }}" value="{{ $product_ofertas[$z]['fecha_final'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="pt-8 w-full flex justify-center">
                        <div>
                            <a wire:click="eliminarOferta({{ $i }}, {{ $z }})" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 cursor-pointer">Eliminar</a>
                        </div>
                    </div>

                </div>
            </div>

            @endfor
            @endfor

            <script>
                function sumarImpuesto(item_id) {

                    let val = parseFloat(document.getElementById('precio_venta'+item_id).value);

                    let total = val + (val * (18/100));

                    document.getElementById('precio_venta_con_igv_details.'+item_id).value = total;

                    let descuento = document.getElementById('discount_details'+item_id).value; 

                    let precio_venta_total = total - descuento;

                    document.getElementById('precio_venta_total'+item_id).value = parseFloat(precio_venta_total + (precio_venta_total * 0.4), 2).toFixed(2) ;
                }

                function verificarGanancia()
                {
                    let count = document.getElementById('product-details-count').value;
                    let formulario = document.getElementById('form-producto');

                    if(count == 0)
                    {
                        formulario.submit();
                    }
                    else
                    {
                        Livewire.emit('enviarEmail');

                        Livewire.on('respuestaEmail', (resultado) => {
                            
                            console.log(resultado);

                            if(resultado == false)
                            {
                                formulario.submit();
                            }
                        });

                        // enviar email
                        Swal.fire({
                            title: "Autorización",
                            text: "Se require código de autorización de Gerente de Tienda para autorizar un precio total menor al 40% de ganancia.\nColocar el código enviado al correo electronico del Gerente de Tienda",
                            input: 'text',
                            showCancelButton: false       
                        }).then((result) => {
                            if (result.value) {
                                console.log(result.value);
                                Livewire.emit('validarAutorizacion', result.value);
                            }
                        });

                        Livewire.on('respuestaValidacion', (resultado) => {
                            
                            console.log(resultado);

                            if(resultado == true)
                            {
                                formulario.submit();
                            }
                        });
                    }
                }

            </script>
        </form>
        <div class="p-4 pt-0 flex justify-center gap-8">
            <div>
                <button onclick="verificarGanancia()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Guardar</button>
            </div>
            <div>
                <button onclick="javascript:history.go(-1)" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Cerrar</button>
            </div>
        </div>
    </div>
</div>