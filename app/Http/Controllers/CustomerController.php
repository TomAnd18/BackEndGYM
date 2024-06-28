<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();

        $data = [
            'clientes' => $customers,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validar datos del cliente a crear
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:15',
            'surname' => 'required|max:15',
            'gender' => 'required|max:8',
            'phone_number' => 'required|max:10',
            'subscription' => 'required|max:10',
            'date_of_birth' => 'required|max:10',
            'active' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }


        //Crear cliente
        $customer = Customer::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'subscription' => $request->subscription,
            'date_of_birth' => $request->date_of_birth,
            'active' => $request->active,
        ]);

        if (!$customer) {
            $data = [
                'message' => 'Error al crear el cliente',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'cliente' => $customer,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Buscar cliente
        $customer = Customer::find($id);

        if (!$customer) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        //Cliente encontrado
        $data = [
            'cliente' => $customer,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Buscar cliente
        $customer = Customer::find($id);

        if (!$customer) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }


        //Validar los nuevos datos de cliente
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:15',
            'surname' => 'required|max:15',
            'gender' => 'required|max:8',
            'phone_number' => 'required|max:10',
            'subscription' => 'required|max:10',
            'date_of_birth' => 'required|max:10',
            'active' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos nuevos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        //Actualizar datos nuevos del cliente
        $customer->name = $request->name;
        $customer->surname = $request->surname;
        $customer->gender = $request->gender;
        $customer->phone_number = $request->phone_number;
        $customer->subscription = $request->subscription;
        $customer->date_of_birth = $request->date_of_birth;

        $customer->save();

        $data = [
            'message' => 'Cliente actualizado correctamente',
            'cliente' => $customer,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Buscar cliente
        $customer = Customer::find($id);

        if (!$customer) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        //Eliminar cliente
        $customer->delete();

        $data = [
            'message' => 'Cliente eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
