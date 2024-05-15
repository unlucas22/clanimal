<div>
    <div id="info-producto">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; font-weight: bold;">Producto</th>
                    <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; font-weight: bold;">Unidades en Total</th>
                    <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; font-weight: bold;">Ofertas en Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; text-align:center">{{ $producto['name'] }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd; text-align:center">{{ $producto['unidades_total'] }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;text-align:center">{{ $producto['ofertas_total'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="info-unidades">
        <div>
            <h1 style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3d4852; font-size: 18px; font-weight: bold; margin-top: 0; text-align: left; padding-top:5px;padding-bottom: 5px; margin-left:5px;">Unidades</h1>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; font-weight: bold;">Presentación</th>
                    <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; font-weight: bold;">Precio venta</th>
                    <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2; font-weight: bold;">Precio Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unidades as $unidad)
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; text-align:center">{{ $unidad['presentacion'] }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;text-align:center">{{ $unidad['precio_venta'] }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;text-align:center">{{ $unidad['precio_total'] }}</td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
