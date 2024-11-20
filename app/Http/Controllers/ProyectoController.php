<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProyectoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $proyectos = Proyecto::where('user_id', Auth::id())->paginate();

        return view('proyecto.index', compact('proyectos'))
            ->with('i', ($request->input('page', 1) - 1) * $proyectos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $proyecto = new Proyecto();

        return view('proyecto.create', compact('proyecto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProyectoRequest $request): RedirectResponse
    {
        // Validar los datos del formulario
        $data = $request->validated();

        // Verificar si el formulario incluye un archivo de imagen
        if ($request->hasFile('imagen')) {
            // Obtener el archivo de imagen del request
            $file = $request->file('imagen');

            // Generar un nombre único para la imagen usando la hora actual
            $filename = time() . '_' . $file->getClientOriginalName();

            // Guardar la imagen en la carpeta 'imagenes' dentro del almacenamiento público
            // Esto creará la imagen en 'storage/app/public/imagenes'
            $path = $file->storeAs('imagenes', $filename, 'public');

            // Almacenar la ruta de la imagen en el array de datos
            $data['imagen'] = $path;
        }

        // Asignar el ID del usuario autenticado para el proyecto
        $data['user_id'] = Auth::id();

        // Crear el proyecto con los datos proporcionados, incluyendo la imagen si fue cargada
        Proyecto::create($data);

        // Redireccionar al índice de proyectos con un mensaje de éxito
        return Redirect::route('proyectos.index')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $proyecto = Proyecto::where('id', $id)
            ->where('user_id', Auth::id()) // Filtra por usuario autenticado
            ->firstOrFail();

        return view('proyecto.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $proyecto = Proyecto::where('id', $id)
            ->where('user_id', Auth::id()) // Filtra por usuario autenticado
            ->firstOrFail();

        return view('proyecto.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        if ($proyecto->user_id !== Auth::id()) {
            abort(403); // Retorna error si el proyecto no pertenece al usuario
        }

        // Verifica si hay una nueva imagen
        if ($request->hasFile('imagen')) {
            // Elimina la imagen anterior si existe
            if ($proyecto->imagen && file_exists(storage_path('app/public/' . $proyecto->imagen))) {
                unlink(storage_path('app/public/' . $proyecto->imagen));
            }

            // Sube la nueva imagen
            $imagePath = $request->file('imagen')->store('proyectos', 'public'); // Guarda la imagen en el directorio 'storage/app/public/proyectos'
            $proyecto->imagen = $imagePath; // Actualiza la ruta de la imagen en el modelo
        }

        // Actualiza el resto de los campos
        $proyecto->nombre = $request->input('nombre');
        $proyecto->descripcion = $request->input('descripcion');
        $proyecto->url = $request->input('url');
        $proyecto->save(); // Guarda los cambios

        return Redirect::route('proyectos.index')
            ->with('success', 'Proyecto actualizado exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $proyecto = Proyecto::where('id', $id)
            ->where('user_id', Auth::id()) // Filtra por usuario autenticado
            ->firstOrFail();

        $proyecto->delete();

        return Redirect::route('proyectos.index')
            ->with('success', 'Proyecto eliminado exitosamente');
    }
}
