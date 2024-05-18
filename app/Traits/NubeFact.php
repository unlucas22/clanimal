<?php

namespace App\Traits;

use Illuminate\Support\Facades\{Log, Config};
use DB;

trait NubeFact {

    public function generarFactura($bill)
    {
        $items = [];

        // referencial
        $bill_total = 0;

        if($bill->product_for_sales != null)
        {
            foreach ($bill->product_for_sales as $product)
            {
                if($product->product_details->getPrecioDeOferta() != null)
                {
                    $valor_unitario = $product->product_details->getPrecioDeOferta();
                    $precio_unitario = $product->product_details->getPrecioDeOferta() + ($product->product_details->getPrecioDeOferta() * 0.18);
                    $descuento = $product->cantidad * ($product->product_details->getPrecioDeOferta() * 0.18);
                    
                    $subtotal = 0;
                    
                    for ($i=0; $i < $product->cantidad; $i++)
                    { 
                        $subtotal += $product->product_details->getPrecioDeOferta();
                    }

                    $igv = $product->cantidad * ($product->product_details->getPrecioDeOferta() * 0.18);

                    $total = 0;

                    for ($i=0; $i < $product->cantidad; $i++)
                    { 
                        $total += $product->product_details->getPrecioDeOferta() ;
                    }
                }
                else
                {
                    $valor_unitario = $product->product_details->precio_venta_sin_igv;
                    $precio_unitario = $product->product_details->precio_venta_con_igv;
                    $descuento = $product->cantidad * $product->product_details->discount;
                    $subtotal = $product->getSubTotalByAmount();
                    $igv = $product->cantidad * ($product->product_details->precio_venta_con_igv - $product->product_details->precio_venta_sin_igv);
                    $total = $product->getTotalByAmount();
                }

                /* Calculo de impuestos en total */

                $items[] = [
                    "unidad_de_medida"          => "NIU",
                    "codigo"                    => $product->product_details->products->barcode,
                    "descripcion"               => $product->product_details->products->name,
                    "cantidad"                  => $product->cantidad,
                    "valor_unitario"            => $valor_unitario,
                    "precio_unitario"           => $precio_unitario,
                    "descuento"                 => $descuento,
                    "subtotal"                  => $subtotal,
                    "tipo_de_igv"               => "1",
                    "igv"                       => $igv,
                    "total"                     => $total,
                    "anticipo_regularizacion"   => "false",
                    "anticipo_documento_serie"  => "",
                    "anticipo_documento_numero" => ""
                ];

                $bill_total += $total;
            }
        }

        if($bill->pack_for_sales != null)
        {
            $igv_total = 0;

            foreach ($bill->pack_for_sales as $pack)
            {
                $valor_unitario = $pack->packs->precio;
                $precio_unitario = $valor_unitario * 1.18;
                $total = $pack->cantidad * $valor_unitario;
                $igv = $total * 0.18;

                $productos = '';

                foreach ($pack->packs->product_for_packs as $product)
                {
                    $productos .= $product->products->name.'. ';
                } 

                $items[] = [
                    "unidad_de_medida"          => "NIU",
                    "codigo"                    => 'C'.$pack->pack_id,
                    "descripcion"               => $pack->packs->name.': '.$productos,
                    "cantidad"                  => $pack->cantidad,
                    "valor_unitario"            => $valor_unitario,
                    "precio_unitario"           => $precio_unitario,
                    "descuento"                 => $igv,
                    "subtotal"                  => $total * 1.18,
                    "tipo_de_igv"               => "1",
                    "igv"                       => $igv,
                    "total"                     => $total,
                    "anticipo_regularizacion"   => "false",
                    "anticipo_documento_serie"  => "",
                    "anticipo_documento_numero" => ""
                ];

                $igv_total += $igv;
                $bill_total += $total;
            }

            $bill->update([
                'igv' => $bill->igv + $igv_total,
            ]);
        }

        $data = $bill->factura == true ? $this->datosDeFactura($bill, $items) : $this->datosDeBoleta($bill, $items); 

        $data_json = json_encode($data);

        $ruta = "https://api.nubefact.com/api/v1/7cea489a-71cf-4190-93f9-933cf9430d37";

        $token = Config::get('app.nubefact');

        //Invocamos el servicio de NUBEFACT
        $ch = curl_init();

        if ($ch === false)
        {
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

        if (curl_errno($ch))
        {
            Log::info('Error cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        $leer_respuesta = json_decode($respuesta, true);

        if (isset($leer_respuesta))
        {
            Log::info($leer_respuesta);
        }

        return $leer_respuesta;
    }

    public function consultarUltimoNumero($bill, $products)
    {
        $client = $bill->clients;

        $data = array(
            "operacion"             => "generar_comprobante",
            "tipo_de_comprobante"               => "2",
            "serie"                             => 'BBB1',
            "numero"                => rand(100, 1000), //intval($bill->id) + 3,
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
            "total_descuento"                   => $bill->getDescuento() ?? 0,
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

        $data_json = json_encode($data);

        // $ruta = "https://api.nubefact.com/api/v1/4b1b3538-8b61-43b3-82cc-8eba602586b7";
        $ruta = "https://api.nubefact.com/api/v1/7cea489a-71cf-4190-93f9-933cf9430d37";

        $token = Config::get('app.nubefact');

        //Invocamos el servicio de NUBEFACT
        $ch = curl_init();

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
        
        curl_close($ch);

        $leer_respuesta = json_decode($respuesta, true);

        $serie = null;

        if (preg_match('/\b(\d+)\b/', $leer_respuesta['errors'], $matches))
        {
            $serie = $matches[1];
        }

        return intval($serie);
    }

    public function datosDeFactura($bill, $products)
    {
        $client = $bill->clients;

        return array(
            "operacion"             => "generar_comprobante",
            "tipo_de_comprobante"               => "1",
            "serie"                             => 'FFF1',
            "numero"                =>  $this->consultarUltimoNumero($bill, $products)+1,
            "sunat_transaction"         => "1",
            "cliente_tipo_de_documento"     => "6",
            "cliente_numero_de_documento"   => $bill->ruc,
            "cliente_denominacion"              => $bill->razon_social,
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
            "total_descuento"                   => $bill->getDescuento() ?? 0,
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
            "serie"                             => 'BBB1',
            "numero"                => $this->consultarUltimoNumero($bill, $products)+1,
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
            "total_descuento"                   => $bill->getDescuento() ?? 0,
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