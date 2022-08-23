<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ventas = DB::table('ventas')
            ->leftjoin('productos', 'ventas.ven_producto', '=', 'productos.id')
            ->get();
        //dd($temas);
        return Inertia::render('Ventas/index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function comprar(Request $request)
    {
        //  dd($request);

        $request->validate([
            'ven_producto' => 'required|max:100',
            'ven_cantidad' => 'required|max:100',
        ]);
        $fecha = new Carbon();
        // $user = Auth::user()->id;


        $ventas = new Venta([
            'ven_producto' => $request->input('ven_producto'),
            'ven_cantidad' => $request->input('ven_cantidad'),
            'ven_fecha' => $fecha
        ]);
        $ventas->save();
        if ($ventas->exists == true) {
            $stock = new Stock();
            $cantidad = DB::table('stocks')
                ->where('stocks.sto_producto', '=', $request->input('ven_producto'))
                ->get();
            $resta = $cantidad[0]->sto_cantidad -1;
            DB::table('stocks')
            ->where('sto_producto', $request->input('ven_producto'))
            ->update(['sto_cantidad' => $resta]);
            return response()->json(['success' => 'Guardado correctamente.', 'ejecucion' => true]);
        }
        return response()->json(['success' => 'Vendido correctamente.', 'ejecucion' => true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVentaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVentaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVentaRequest  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVentaRequest $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
