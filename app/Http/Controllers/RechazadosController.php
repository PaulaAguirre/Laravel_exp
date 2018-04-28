<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\History;
use App\Area;
use App\Expediente;
use App\Tipoexpediente;
use Carbon\Carbon;
use DB;
use App\Notifications\NuevoPendienteNotification;
class RechazadosController extends Controller
{
    /**
     * RechazadosController constructor.
     */
    public function __construct ()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * muestra la lista de expedientes rechazados por el creador
     */
    public function index(Request $request)
    {
        if ($request) {
            $query=trim($request->get('searchText'));
            /*$rechazados = History::all ()->sortByDesc ( 'id' )->unique ( 'expediente_id' )
                ->where ( 'estado', '=', 'rechazado' );*/
            $expedientes = Expediente::orderBy('fecha_creacion', 'DESC')->paginate (5);

        }
        return view ('expedientes_rechazados.expedientes_rechazados_creador.index', ['expedientes' => $expedientes]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notifications = \Auth::user ()->unreadNotifications
            ->where('type', '=', 'App\Notifications\RechazadosNotification');


        foreach ($notifications as $notification)
        {
            if ($notification->data['expediente_id'] == $id)
            {

                $notification->markAsRead();
                break;
            }

        }

        $expediente = Expediente::findOrFail ($id);

        $rechazado = History::all()->where('expediente_id', '=', $id)
            ->where ('estado', '=', 'rechazado')
            ->sortByDesc ('id')->unique ('expediente_id')->first ();

        $cant_histories = $expediente->histories->count();

        $ultimo = $expediente->histories->last();

        if($cant_histories > 2) {

            if ($ultimo->estado=='rechazado' && $expediente->histories[$cant_histories-2]->estado == 'rechazado')
            {
                $penultimo = $expediente->histories[$cant_histories-2];

            }
            else
            {
                $penultimo = $ultimo;
            }
        }
        else
        {
            $penultimo =$ultimo;
        }




        /**Politicas de acceso*/
        $this->authorize ('edit', $rechazado);


        $redireccion = redirect()->getUrlGenerator()->previous();

        return view ('expedientes_rechazados.expedientes_rechazados_creador.edit',
                        [
                            'expediente' => $expediente,
                            'rechazado' => $rechazado,
                            'redireccion' => $redireccion,
                            'ultimo' => $ultimo,
                            'penultimo' =>$penultimo
                        ]
                     );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expediente = Expediente::findOrFail ( $id );
        $observaciones_regularizacion = $request->get ( 'observaciones_regularizacion' );

        $history = History::all ()->where ( 'expediente_id', '=', $expediente->id )
            ->where ( 'estado', '=', 'rechazado' )
            ->sortByDesc ( 'id' )->unique ( 'expediente_id' )->first ();

        $tipo_id = $expediente->tipoexpediente->id;
        $areas_expediente = Tipoexpediente::findOrFail ( $tipo_id )->areas->pluck ( 'id' )->toArray ();

        //policy
        $this->authorize ('update', $history);

        $sgte_posicion = array_search ( $history->area_id, $areas_expediente ) + 1;

        if ($sgte_posicion < count ( $areas_expediente )) {
            $id_area_sgte = $areas_expediente[$sgte_posicion]; //devuelve el id de la siguiente posicion en el array de areas

            $new_history = new History();
            $new_history->expediente_id = $expediente->id;
            $new_history->area_id = $history->area_id;
            $new_history->estado = 'pendiente';
            $new_history->fecha_entrada = Carbon::now ();
            $new_history->observaciones_regularizacion = $observaciones_regularizacion;
            $new_history->save ();


        } else {
            $new_history = new History();
            $new_history->expediente_id = $id;
            $new_history->area_id = $history->area_id;
            $new_history->estado = 'pendiente';
            $new_history->fecha_entrada = Carbon::now ();
            $new_history->observaciones_regularizacion = $observaciones_regularizacion;
            $new_history->save ();
        }

        $responsable = Area::findOrFail ($new_history->area_id)->user;
        $responsable->notify(new NuevoPendienteNotification($new_history));

        $red = $request->get ( 'redireccion' );


        return redirect($red);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
