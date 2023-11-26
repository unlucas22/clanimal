<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use DB;

trait NubeFact {

    public function generarFactura($bill)
    {
        $products = [];

        foreach ($bill->product_for_sales as $product)
        {
            /* Calculo de impuestos en total */
            $igv = ($product->product_details->precio_venta_con_igv - $product->product_details->precio_venta_sin_igv);

            $products[] = [
                "unidad_de_medida"          => "NIU",
                "codigo"                    => $product->product_details->products->barcode,
                "descripcion"               => $product->product_details->products->name,
                "cantidad"                  => $product->cantidad,
                "valor_unitario"            => $product->product_details->precio_venta_sin_igv,
                "precio_unitario"           => $product->product_details->precio_venta_con_igv,
                "descuento"                 => $product->product_details->discount,
                "subtotal"                  => $product->getSubTotalByAmount(),
                "tipo_de_igv"               => "1",
                "igv"                       => $igv,
                "total"                     => $product->getTotalByAmount(),
                "anticipo_regularizacion"   => "false",
                "anticipo_documento_serie"  => "",
                "anticipo_documento_numero" => ""
            ];
        }
         
        $data = $bill->ruc != null ? $this->datosDeFactura($bill, $products) : $this->datosDeBoleta($bill, $products); 
        $data_json = json_encode($data);

        $ruta = "https://api.nubefact.com/api/v1/4b1b3538-8b61-43b3-82cc-8eba602586b7";

        $token = Config::get('app.nubefact');

        //Invocamos el servicio de NUBEFACT
        $ch = curl_init();

        if ($ch === false) {
            Log::info('Error al inicializar cURL');
        }

        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
        	$ch, CURLOPT_HTTPHEADER, array(
        	'Authorization: Token token="'.$token.'"',
        	'Content-Type: application/json',
        	)
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $respuesta  = curl_exec($ch);

        if (curl_errno($ch)) {
            Log::info('Error cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        $leer_respuesta = json_decode($respuesta, true);

        if (isset($leer_respuesta['errors']))
        {

            Log::info($leer_respuesta['errors']);

            ddd($leer_respuesta);
            return null;
        }

        return $leer_respuesta;
    }

    public function datosDeFactura($bill, $products)
    {
        $client = $bill->clients;

        return array(
            "operacion"             => "generar_comprobante",
            "tipo_de_comprobante"               => "1",
            "serie"                             => 'F' . rand(100, 999),
            "numero"                => intval($bill->id),
            "sunat_transaction"         => "1",
            "cliente_tipo_de_documento"     => "6",
            "cliente_numero_de_documento"   => $bill->ruc,
            "cliente_denominacion"              => $bill->razon_social ?? "NUBEFACT SA",
            "cliente_direccion"                 => $client->address,
            "cliente_email"                     => $client->email,
            "cliente_email_1"                   => "",
            "cliente_email_2"                   => "",
            "fecha_de_emision"                  => $bill->created_at->format('d-m-Y'),
            "fecha_de_vencimiento"              => "",
            "moneda"                            => "1",
            "tipo_de_cambio"                    => "",
            "porcentaje_de_igv"                 => "18",
            "descuento_global"                  => "",
            "descuento_global"                  => "",
            "total_descuento"                   => $bill->descuento ?? 0,
            "total_anticipo"                    => "",
            "total_gravada"                     => $bill->total - $bill->igv,
            "total_inafecta"                    => "",
            "total_exonerada"                   => "",
            "total_igv"                         => $bill->igv,
            "total_gratuita"                    => "",
            "total_otros_cargos"                => "",
            "total"                             => $bill->total,
            "percepcion_tipo"                   => "",
            "percepcion_base_imponible"         => "",
            "total_percepcion"                  => "",
            "total_incluido_percepcion"         => "",
            "detraccion"                        => "false",
            "observaciones"                     => "",
            "documento_que_se_modifica_tipo"    => "",
            "documento_que_se_modifica_serie"   => "",
            "documento_que_se_modifica_numero"  => "",
            "tipo_de_nota_de_credito"           => "",
            "tipo_de_nota_de_debito"            => "",
            "enviar_automaticamente_a_la_sunat" => "true",
            "enviar_automaticamente_al_cliente" => "false",
            "codigo_unico"                      => "",
            "condiciones_de_pago"               => "",
            "medio_de_pago"                     => $bill->metodo_de_pago_formatted,
            "placa_vehiculo"                    => "",
            "orden_compra_servicio"             => "",
            "tabla_personalizada_codigo"        => "",
            "formato_de_pdf"                    => "",
            "items" => $products
        );
    }

    public function datosDeBoleta($bill, $products)
    {
        $client = $bill->clients;

        return array(
            "operacion"             => "generar_comprobante",
            "tipo_de_comprobante"               => "2",
            "serie"                             => 'B' . rand(100, 999),
            "numero"                => intval($bill->id) + 3,
            "sunat_transaction"         => "1",
            "cliente_tipo_de_documento"     => "1",
            "cliente_numero_de_documento"   => $client->dni,
            "cliente_denominacion"              => $client->name,
            "cliente_direccion"                 => $client->address,
            "cliente_email"                     => $client->email,
            "cliente_email_1"                   => "",
            "cliente_email_2"                   => "",
            "fecha_de_emision"                  => $bill->created_at->format('d-m-Y'),
            "fecha_de_vencimiento"              => "",
            "moneda"                            => "1",
            "tipo_de_cambio"                    => "",
            "porcentaje_de_igv"                 => "18",
            "descuento_global"                  => "",
            "descuento_global"                  => "",
            "total_descuento"                   => $bill->descuento ?? 0,
            "total_anticipo"                    => "",
            "total_gravada"                     => $bill->total - $bill->igv,
            "total_inafecta"                    => "",
            "total_exonerada"                   => "",
            "total_igv"                         => $bill->igv,
            "total_gratuita"                    => "",
            "total_otros_cargos"                => "",
            "total"                             => $bill->total,
            "percepcion_tipo"                   => "",
            "percepcion_base_imponible"         => "",
            "total_percepcion"                  => "",
            "total_incluido_percepcion"         => "",
            "detraccion"                        => "false",
            "observaciones"                     => "",
            "documento_que_se_modifica_tipo"    => "",
            "documento_que_se_modifica_serie"   => "",
            "documento_que_se_modifica_numero"  => "",
            "tipo_de_nota_de_credito"           => "",
            "tipo_de_nota_de_debito"            => "",
            "enviar_automaticamente_a_la_sunat" => "true",
            "enviar_automaticamente_al_cliente" => "false",
            "codigo_unico"                      => "",
            "condiciones_de_pago"               => "",
            "medio_de_pago"                     => $bill->metodo_de_pago_formatted,
            "placa_vehiculo"                    => "",
            "orden_compra_servicio"             => "",
            "tabla_personalizada_codigo"        => "",
            "formato_de_pdf"                    => "",
            "items" => $products
        );
    }
}

/* LO QUE DEVUELVE
array:22 [▼
  "tipo_de_comprobante" => 1
  "serie" => "FFF1"
  "numero" => 1
  "enlace" => "https://www.nubefact.com/cpe/4872e0c8-58d9-4c5c-af28-6e6698bdfca7"
  "aceptada_por_sunat" => true
  "sunat_description" => "La Factura Electrónica FFF1-1 ha sido ACEPTADA CON OBSERVACIONES"
  "sunat_note" => null
  "sunat_responsecode" => "0"
  "sunat_soap_error" => ""
  "anulado" => false
  "pdf_zip_base64" => null
  "xml_zip_base64" => null
  "cdr_zip_base64" => null
  "cadena_para_codigo_qr" => "10423703046 | 01 | FFF1 | 000001 | 3.60 | 23.60 | 25/11/2023 | 6 | 20600695771 | odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0= |"
  "codigo_hash" => "odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0="
  "codigo_de_barras" => "10423703046 | 01 | FFF1 | 000001 | 3.60 | 23.60 | 25/11/2023 | 6 | 20600695771 | odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0= |  |"
  "key" => "4872e0c8-58d9-4c5c-af28-6e6698bdfca7"
  "digest_value" => "odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0="
  "enlace_del_pdf" => "https://www.nubefact.com/cpe/4872e0c8-58d9-4c5c-af28-6e6698bdfca7.pdf"
  "enlace_del_xml" => "https://www.nubefact.com/cpe/4872e0c8-58d9-4c5c-af28-6e6698bdfca7.xml"
  "enlace_del_cdr" => "https://www.nubefact.com/cpe/4872e0c8-58d9-4c5c-af28-6e6698bdfca7.cdr"
  "invoice" => array:17 [▼
    "tipo_de_comprobante" => 1
    "serie" => "FFF1"
    "numero" => 1
    "enlace" => "https://www.nubefact.com/cpe/4872e0c8-58d9-4c5c-af28-6e6698bdfca7"
    "aceptada_por_sunat" => true
    "sunat_description" => "La Factura Electrónica FFF1-1 ha sido ACEPTADA CON OBSERVACIONES"
    "sunat_note" => null
    "sunat_responsecode" => "0"
    "sunat_soap_error" => ""
    "pdf_zip_base64" => null
    "xml_zip_base64" => null
    "cdr_zip_base64" => null
    "cadena_para_codigo_qr" => "10423703046 | 01 | FFF1 | 000001 | 3.60 | 23.60 | 25/11/2023 | 6 | 20600695771 | odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0= |"
    "codigo_hash" => "odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0="
    "digest_value" => "odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0="
    "codigo_de_barras" => "10423703046 | 01 | FFF1 | 000001 | 3.60 | 23.60 | 25/11/2023 | 6 | 20600695771 | odxX0WAbECPM55mqtIq3SWrq475Qb6kx/pOYmUoiTt0= |  |"
    "key" => "4872e0c8-58d9-4c5c-af28-6e6698bdfca7"
  ]
]
*/