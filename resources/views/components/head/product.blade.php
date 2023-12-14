
{{-- 
<div>
	<a href="#">
		<button type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Importar
		</button>
	</a>
</div>
<div>
	<a href="#">
		<button type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Exportar
		</button>
	</a>
</div>
 --}}

<div>
<!-- The Modal -->
<div id="modal"
    class="hidden fixed top-0 left-0 z-10 w-screen h-screen bg-black/70 flex justify-center items-center">

    <!-- The close button -->
    <a class="fixed z-90 top-6 right-8 text-white text-5xl font-bold" href="javascript:void(0)"
        onclick="closeModal()">&times;</a>

    <!-- A big image will be displayed here -->
    <img id="modal-img" class="max-w-[800px] max-h-[600px] object-cover" />
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
	<div class="flex justify-start">
		<a href="{{ route('dashboard.create.product') }}">
			<x-btn-nuevo/>
		</a>
	</div>
</div>