<?php

namespace App\Http\Controllers\API;
use Log;
use App\IncidenceType;
use App\Http\Resources\IncidenceTypeResource;
use App\Http\Requests\IncidenceTypeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncidenceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        Log::info("Soy un Señor test :-d ");
        $type = $request->input('type');
        $query = IncidenceType::when($type, function($query) use ($type){
            return $query->where('type','like','%'. $type .'%');
        })
        ->orderBy('id','desc');
        return IncidenceTypeResource::collection($query->paginate(12));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncidenceTypeRequest $request)
    {
        $validated = $request->validated();
        return response()->json(IncidenceType::create($validated),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IncidenceType  $incidenceType
     * @return \Illuminate\Http\Response
     */
    public function show(IncidenceType $incidenceType)
    {
        return new IncidenceTypeResource($incidenceType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncidenceType  $incidenceType
     * @return \Illuminate\Http\Response
     */
    public function update(IncidenceTypeRequest $request, IncidenceType $incidenceType)
    {
        $validated = $request->validated();
        $incidenceType->update($validated);
        return response()->json($incidenceType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IncidenceType  $incidenceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncidenceType $incidenceType)
    {
        $incidenceType->delete();
        return response()->json([],204);
    }
}
