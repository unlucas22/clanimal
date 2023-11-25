<div>
	<h2>RESPUESTA DE SUNAT</h2>
    <table border="1" style="border-collapse: collapse">
        <tbody>
            <tr><th>tipo:</th><td>{{  $leer_respuesta['tipo_de_comprobante']  }}</td></tr>
            <tr><th>serie:</th><td>{{  $leer_respuesta['serie']  }}</td></tr>
            <tr><th>numero:</th><td>{{  $leer_respuesta['numero']  }}</td></tr>
            <tr><th>enlace:</th><td>{{  $leer_respuesta['enlace']  }}</td></tr>
            <tr><th>aceptada_por_sunat:</th><td>{{  $leer_respuesta['aceptada_por_sunat']  }}</td></tr>
            <tr><th>sunat_description:</th><td>{{  $leer_respuesta['sunat_description']  }}</td></tr>
            <tr><th>sunat_note:</th><td>{{  $leer_respuesta['sunat_note']  }}</td></tr>
            <tr><th>sunat_responsecode:</th><td>{{  $leer_respuesta['sunat_responsecode']  }}</td></tr>
            <tr><th>sunat_soap_error:</th><td>{{  $leer_respuesta['sunat_soap_error']  }}</td></tr>
            <tr><th>pdf_zip_base64:</th><td>{{  $leer_respuesta['pdf_zip_base64']  }}</td></tr>
            <tr><th>xml_zip_base64:</th><td>{{  $leer_respuesta['xml_zip_base64']  }}</td></tr>
            <tr><th>cdr_zip_base64:</th><td>{{  $leer_respuesta['cdr_zip_base64']  }}</td></tr>
            <tr><th>codigo_hash:</th><td>{{  $leer_respuesta['cadena_para_codigo_qr']  }}</td></tr>
            <tr><th>codigo_hash:</th><td>{{  $leer_respuesta['codigo_hash']  }}</td></tr>
        </tbody>
    </table>
</div>