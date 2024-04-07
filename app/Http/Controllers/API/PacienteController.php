<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarPacienteRequest;
use App\Http\Requests\GuardarPacientesRequest;
use App\Http\Resources\PacienteResource;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Paciente::all();
        return PacienteResource::collection(Paciente::paginate(3));//Paciente::all()
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarPacientesRequest $request)
    {
        /*
        Paciente::create($request->all());
        return response()->json([
            'res'=>true,
            'msg'=>'Paciente Guardado Correctamente'
        ],200);
        */
        return (new PacienteResource(Paciente::create($request->all())))
        ->additional(['msg'=>'Paciente Registrado Correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente) //$id otra opcion
    { //retorna la data de un paciente
        /*
                return response()->json([
            'res'=>true,
            'paciente'=>$paciente
        ],200);
        */
        return new PacienteResource($paciente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarPacienteRequest $request, Paciente $paciente)
    {
        $paciente->update($request->all());
        /*
        return response()->json([
            'res' => true,
            'mensaje' => "Paciente actualizado Correctamente"
        ], 200);
        */
        return  (new PacienteResource($paciente))
        ->additional(['msg'=>'Paciente actualizado Correctamente'])
        ->response()
        ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        /*
        return response()->json([
        'res' => true,
        'mensaje' => "Paciente eliminado Correctamente"
        ], 200);
        */
        return (new PacienteResource($paciente))->additional(['msg'=>'Paciente eliminado Correctamente']);
    }
    //se puede usar los recursos o no (al usar los recursos pude ser mas estructurado)
}
