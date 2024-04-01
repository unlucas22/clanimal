<div>
    <a wire:click='$emit("openModal", "modal.store.finance")'>
        <x-btn-nuevo/>
    </a>
<script>
    function sumarTotal()
    {
        let tarjetaValue = document.getElementById('monto_tarjetas').value;
        let efectivoValue = document.getElementById('monto_efectivo').value;

        // Convert the string values to numbers using parseFloat or parseInt
        let tarjeta = parseFloat(tarjetaValue) || 0; // Use 0 if parsing fails
        let efectivo = parseFloat(efectivoValue) || 0;

        // Perform the addition
        let total = tarjeta + efectivo;

        // Set the result in the monto_total element
        document.getElementById('monto_total').value = total;
    }
</script>
</div>
