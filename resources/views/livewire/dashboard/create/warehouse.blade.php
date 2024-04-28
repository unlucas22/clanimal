<div class="p-4">
    <div class="mb-4">
        <h2 class="font-semibold text-xl"></h2>
    </div>

    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Compras realizadas a proveedores
        </h3>

        <div>
            <a href="{{ route('dashboard.compras') }}"><button type="button" class="text-white bg-[#24292F] hover:bg-[#24292F]/90 focus:ring-4 focus:outline-none focus:ring-[#24292F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 font-semibold">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2">
                  <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>

                RETORNO
            </button></a>
        </div>
    </div>

    @if($errors->any())
    <div class="text-center text-red-500 font-semibold mb-4">
        <h4>{{ $errors->first() }}</h4>
    </div>
    @endif

    <form method="POST" action="{{ route('dashboard.store.warehouse') }}" class="space-y-10">

        @csrf

        <div class="grid grid-cols-7 gap-4">

            <div class="w-full">
                <label for="proveedores" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proveedor</label>
                <select id="proveedores" name="supplier_id" wire:model.defer="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @forelse($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @empty
                    <option value="0">Sin Proveedores disponibles</option>
                    @endforelse
                </select>
            </div>

            <div class="w-full">
                <label for="key_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccionar</label>
                <select id="key_type" name="key_type" wire:model.defer="key_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="factura">Factura</option>
                    <option value="boleta de compra">Boleta de Compra</option>
                    <option value="nota de venta">Nota de Venta</option>
                </select>
            </div>

            <div>
                <x-form.input :label="'Número de documento'" :name="'value_type'" :model="'value_type'" :required="'required maxlength=30'" />
            </div>

            <div>
                <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                <div class="relative max-w-sm">
                  <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                     <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                      </svg>
                  </div>
                  <input datepicker datepicker-format="mm/dd/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="datepicker" placeholder="Seleccionar Fecha" name="fecha" id="fecha" value="{{ now()->format('m/d/Y') }}" onchange="handler(event);">
                </div>
            </div>

            <script>

            window.onload = function(){
                const datepickerEl = document.getElementById('datepicker');
                
                new Datepicker(datepickerEl, {
                    // options
                });
            }
            </script>

            <div>
                <div>
                    <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descuento</label>
                    <input type="number" oninput="sumarTotales()" name="discount" id="discount" wire:model.defer="discount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descuento" step="0.01">
                </div>
            </div>

            <div wire:ignore>
                <x-form.input :type="'number'" :id="'total'" :label="'Total'" :name="'total'" :model="'total'" :required="'required step=0.01'" />
            </div>

            <div>
                <label for="proveedores" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                <select id="proveedores" name="status" wire:model.defer="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="crédito">Crédito</option>
                    <option value="contado">Contado</option>
                </select>
            </div>
        </div>

        {{-- DETALLES --}}
        <div>

            {{-- UNIDADES Y PRECIOS SECCION DINAMICA --}}
            <div class="flex justify-between mb-4">
                <div class="flex justify-between gap-4">
                    <div wire:ignore>
                        <div class="w-full">

                            <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</div>
                            <div class='relative searchable-list-product'>
                                <input type='text' class='data-list-product peer block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ' id="product-product" spellcheck="false"  placeholder="Buscar un producto" id="product_search" value="">
                                <svg class="outline-none cursor-pointer fill-gray-400 absolute transition-all duration-200 h-full w-4 -rotate-90 right-2 top-[50%] -translate-y-[50%]"
                                    viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="M0 256l512 512L1024 256z"></path>
                                </svg>
                                <ul class='absolute option-list-product overflow-y-scroll w-full min-h-[0px] flex flex-col top-12 
                                    left-0 bg-white rounded-sm scale-0 opacity-0 
                                    transition-all 
                                    duration-200 origin-top-left'>
                                </ul>
                            </div>
                        </div>

                        <script>
                        const domParser = new DOMParser();
                        const dataListProduct = {
                            el:document.querySelector('.data-list-product'),
                            listEl:document.querySelector('.option-list-product'),
                            arrow:document.querySelector(".searchable-list-product>svg"),
                            currentValue:"...",
                            listOpened :false,
                            optionTemplate:
                            `
                            <li
                                class='data-option-product select-none break-words inline-block text-sm text-gray-500 bg-gray-100 odd:bg-gray-200 hover:bg-gray-300 hover:text-gray-700 transition-all duration-200 font-bold p-3 cursor-pointer max-w-full '>
                                    [[REPLACEMENT]]
                            </li>
                            `,
                            optionElements:[],
                            options:[], 
                            find(str){
                                for(let i = 0;i<dataListProduct.options.length;i++){
                                    const option = dataListProduct.options[i];
                                    if(!option.toLowerCase().includes(str.toLowerCase())){
                                        dataListProduct.optionElements[i].classList.remove('block');
                                        dataListProduct.optionElements[i].classList.add('hidden');
                                    }else{
                                        dataListProduct.optionElements[i].classList.remove('hidden');
                                        dataListProduct.optionElements[i].classList.add('block');
                                    }
                                }
                            },  
                            remove(value){
                                const foundIndex = dataListProduct.options.findIndex(v=>v===value);
                                if(foundIndex!==-1){
                                    dataListProduct.listEl.removeChild(dataListProduct.optionElements[foundIndex])
                                    dataListProduct.optionElements.splice(foundIndex,1);
                                    dataListProduct.options.splice(value,1);
                                }
                            },
                            append(value){    
                                if(!value || typeof value === 'object' || typeof value === 'symbol' || typeof value ==='function') return;
                                value = value.toString().trim();
                                if(value.length === 0) return; 
                                if(dataListProduct.options.includes(value)) return;

                                const html = dataListProduct.optionTemplate.replace('[[REPLACEMENT]]',value);
                                const targetEle = domParser.parseFromString(html, "text/html").querySelector('li');
                                targetEle.innerHTML = targetEle.innerHTML.trim();
                                dataListProduct.listEl.appendChild(targetEle);
                                dataListProduct.optionElements.push(targetEle);  
                                dataListProduct.options.push(value);

                                if(!dataListProduct.currentValue) dataListProduct.setValue(value);
                      
                                targetEle.onmousedown = (e)=>{
                                    dataListProduct.optionElements.forEach((el,index)=>{
                                        if(e.target===el){
                                            dataListProduct.setValue(dataListProduct.options[index]);
                                            dataListProduct.hideList();
                                            return;
                                        }
                                    })
                                }
                            },  
                            setValue(value){
                                dataListProduct.el.value = value;
                                dataListProduct.currentValue = value;
                                Livewire.emit('productSelected', value);
                            },
                            showList(){
                                dataListProduct.listOpened = true;
                                dataListProduct.listEl.classList.add('opacity-100');
                                dataListProduct.listEl.classList.add('scale-100');
                                dataListProduct.arrow.classList.add("rotate-0");
                            },
                            hideList(){
                                dataListProduct.listOpened = false;
                                dataListProduct.listEl.classList.remove('opacity-100');
                                dataListProduct.listEl.classList.remove('scale-100');
                                dataListProduct.arrow.classList.remove("rotate-0");
                            },
                            init(){ 
                                dataListProduct.arrow.onclick = ()=>{
                                    dataListProduct.listOpened ? dataListProduct.hideList(): dataListProduct.showList();
                                } 
                                dataListProduct.el.oninput = (e)=>{
                                    dataListProduct.find(e.target.value);
                                }
                                dataListProduct.el.onclick= (el)=>{
                                    dataListProduct.showList();
                                    for(let el of dataListProduct.optionElements){
                                        el.classList.remove('hidden');
                                    }
                                }
                                dataListProduct.el.onblur = (e)=>{
                                    dataListProduct.hideList();
                                    dataListProduct.setValue(dataListProduct.currentValue);
                                }
                            }
                        }

                        // how to use
                        dataListProduct.init(); 
                        // add items
                        const data = [
                            @foreach($products as $product) "{{ $product->name }}", @endforeach
                        ];
                        data.forEach(v=>(dataListProduct.append(v))); 
                    </script>

                    </div>
                    <div class="pt-11">
                        <a wire:click="agregarPrecio" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">AGREGAR</a>
                    </div>    
                </div>
                <div class="pt-11">
                    <h2 class="mb-4 text-lg tracking-tight font-extrabold text-gray-900 dark:text-white mt-2">Productos. <span class="font-medium">Total: {{ $product_details ?? 0 }}</h2>
                </div>
            </div>

            <input type="hidden" name="product_details" id="product_details" wire:model="product_details" value="{{ $product_details }}">

            <input type="hidden" name="product_name" wire:model="product_name">

            <script>
                function sumarImpuesto(item_id) {

                    let val = parseFloat(document.getElementById('precio_venta'+item_id).value);

                    let total = val + (val * (18/100));

                    let discount_details = document.getElementById('discount_details'+item_id).value;

                    let descuento = (discount_details == NaN) ? 0 : discount_details;

                    let cantidad_details = document.getElementById('cantidad_details.'+item_id).value;
                    let cantidad = (cantidad_details == NaN) ? 0 : cantidad_details;

                    let precio_venta_total = (val * cantidad) - descuento;

                    return parseFloat(precio_venta_total, 2).toFixed(2);
                }

                function sumarTotales() {

                    let sum = 0;
                    let totalImpuesto = 0;

                    let count = document.getElementById('product_details').value;

                    for (var i = 0; i < count; i++)
                    {
                        totalImpuesto = (sumarImpuesto(i) == NaN) ? 0 : sumarImpuesto(i);

                        document.getElementById('precio_venta_total'+i).value = totalImpuesto;
                        
                        sum += parseFloat(totalImpuesto, 2);
                    }

                    sum -= parseFloat(document.getElementById('discount').value, 2).toFixed(2);
                    
                    document.getElementById('total').value = sum.toFixed(2);
                }
            </script>


            @if($product_details)
            <div class="grid grid-cols-10 gap-4">
                <div class="text-center">Item ID</div>
                <div class="col-span-9"></div>
            </div>
            @endif

            @for($i=0; $i < $product_details; $i++)
            <div class="flex justify-center">


                <div class="grid grid-cols-10 gap-2">

                    <div class="pt-8 text-center">
                        {{ $i+1 }}
                    </div>

                    <div class=" w-full mb-6 group">
                        <div>
                            <label for="cantidad_details.{{ $i }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                            <input type="number" name="amount_details[{{ $i }}]" id="cantidad_details.{{ $i }}" wire:model.defer="amount_details.{{ $i }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" oninput="sumarTotales()" required step="0.01" min="1">
                        </div>
                    </div>

                    <div class=" w-full mb-6 group">

                        <x-form.select :name="'product_presentation_details_id['.$i.']'" :model="'product_presentation_details_id.'.$i" :label="'Presentación'" :required="'required'">

                            @php($pd = \App\Models\Product::select('id')->where('name', $product_name[$i])->first())

                            @forelse(\App\Models\ProductDetail::with('product_presentations')->where('product_id', $pd->id)->get() as $product_detail)
                            <option value="{{ $product_detail->product_presentations->id }}">{{ $product_detail->product_presentations->name }}</option>
                            @empty
                                @foreach($product_presentations as $product_presentation)
                                <option value="{{ $product_presentation->id }}">{{ $product_presentation->name }}</option>
                                @endforeach
                            @endforelse
                        </x-form.select>
                    </div>

                    <div>
                        <x-form.input :name="'product_name['.$i.']'" :model="'product_name.'.$i" :label="'Producto'"  :required="'disabled'" />
                    </div>

                    <div class=" w-full mb-6 group">
                        <x-form.input :name="'fecha_de_vencimiento['.$i.']'" :type="'date'" :model="'fecha_de_vencimiento.'.$i" :label="'F. de Vencimiento'" />
                    </div>

                    <div class=" w-full mb-6 group">
                        <div>
                            <label for="precio_venta{{ $i }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Compra</label>
                            <input type="number" step="0.1" name="precio_venta_details[{{ $i }}]" id="precio_venta{{ $i }}" wire:model.defer="precio_venta_details.{{ $i }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" oninput="sumarTotales()" required min=0>
                        </div>
                    </div>

                    <div class=" w-full mb-6 group">
                        <div>
                            <label for="discount_details{{ $i }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descuento</label>
                            <input type="number" name="discount_details[{{ $i }}]" id="discount_details{{ $i }}" wire:model.defer="discount_details.{{ $i }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" oninput="sumarTotales()" placeholder="" value="0" min="0" step="0.01">
                        </div>
                    </div>

                    <div class=" w-full mb-6 group">
                        <div>
                            <label for="precio_venta_total{{ $i }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total</label>
                            <input type="number" step="0.1" name="precio_venta_total[{{ $i }}]" id="precio_venta_total{{ $i }}" wire:model.defer="precio_venta_total.{{ $i }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" disabled>
                        </div>
                    </div>

                    <div class="pt-8">
                        <a wire:click="eliminarPrecio" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 cursor-pointer">Eliminar</a>
                    </div>

                </div>
            </div>
            @endfor
        </div>


        <div class="p-4 flex justify-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">   Guardar
            </button>                
        </div>

    </form>

</div>
