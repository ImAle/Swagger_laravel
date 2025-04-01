<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info (title="API de libros", version="1.0")
 *
 * @OA\Server (url="http://localhost:8000")
 */
class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get (
     *     path="/api/books",
     *     summary="Mostrar todos los libros",
     *     @OA\Response (
     *         response = 200,
     *         description="Operación exitosa: Muestra todos los libros existentes."
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function index()
    {
        $books = (Book::all());
        return $this->sendResponse($books,'Books retrieved successfully.');
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
    /**
     * @OA\Post (
     *     path="/api/books",
     *     summary="Crear un nuevo libro",
     *     @OA\RequestBody (
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", description="Titulo de libro", example="El señor de los anillos"),
     *             @OA\Property(property="author", type="string", description="Autor del libro", example="J.R.R. Tolkien"),
     *             @OA\Property(property="year", type="string", description="Año de publicación", example="1954"),
     *             @OA\Property(property="genre", type="string", description="Género del libro", example="Fantasía")
     *         )
     *     ),
     *     @OA\Response (
     *         response=201,
     *         description="Libro creado correctamente",
     *     ),
     *     @OA\Response (
     *          response=400,
     *          description="Error de validación",
     *      ),
     *     @OA\Response (
     *          response=500,
     *          description="Error interno del servidor",
     *      )
     * )
     *
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'year' => 'required|string|max:4',
            'genre' => 'required|string|max:150',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $book = Book::create($request->all());

        return $this->sendResponse($book, 'Book created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get (
     *     path="/api/books/{id}",
     *     summary="Obtener un libro por ID",
     *     description="Retorna un libro específico basado en su ID",
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="ID del libro",
     *         required=true
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="Libro recuperado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Libro no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     *
     */
    public function show($id)
    {
        $book = Book::find($id);

        if(is_null($book)){
            return $this->sendError('Book not found.');
        }

        return $this->sendResponse($book, 'Book retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put (
     *     path="/api/books/{id}",
     *     summary="Actualizar un libro por ID",
     *     description="Actualiza un libro especifico",
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="ID del libro",
     *         required=true,
     *     ),
     *     @OA\RequestBody (
     *         required=true,
     *         @OA\Property(property="title", type="string", description="Titulo de libro", example="El señor de los anillos"),
     *         @OA\Property(property="author", type="string", description="Autor del libro", example="J.R.R. Tolkien"),
     *         @OA\Property(property="year", type="string", description="Año de publicación", example="1954"),
     *         @OA\Property(property="genre", type="string", description="Género del libro", example="Fantasía")
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="Libro actualizado correctamente",
     *     ),
     *     @OA\Response (
     *          response=404,
     *          description="Libro no encontrado",
     *      ),
     *     @OA\Response (
     *          response=500,
     *          description="Error interno del servidor",
     *      )
     * )
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'year' => 'required|string|max:4',
            'genre' => 'required|string|max:150',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        $book->update($request->all());
        return $this->sendResponse($book, 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete (
     *     path="/api/books/{id}",
     *     summary="Elimianr un libro por ID",
     *     description="Elimina un libro en especifico",
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="ID del libro",
     *         required=true
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="Libro eliminado correctamente"
     *     ),
     *     @OA\Response (
     *          response=404,
     *          description="Libro no encontrado"
     *      ),
     *     @OA\Response (
     *          response=505,
     *          description="Error interno del servidor"
     *      )
     * )
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return $this->sendResponse([], 'Book deleted successfully.');
    }
}
