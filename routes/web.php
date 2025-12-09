<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreCadastroController;
use App\Http\Controllers\FolhaPontoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota inicial
Route::get('/', function () {
    return redirect('/pre-cadastro');
});

// Rotas de Pré-Cadastro (Público)
Route::prefix('pre-cadastro')->name('pre-cadastro.')->group(function () {
    Route::get('/', [PreCadastroController::class, 'index'])->name('index');
    Route::post('/', [PreCadastroController::class, 'store'])->name('store');
    Route::get('/sucesso', [PreCadastroController::class, 'sucesso'])->name('sucesso');
});

// Rotas de Folha de Ponto (Protegidas - dentro do Filament ou com middleware auth)
Route::middleware(['auth'])->group(function () {
    Route::prefix('funcionarios/{funcionario}/folha-ponto')->name('folha-ponto.')->group(function () {
        Route::get('/', [FolhaPontoController::class, 'index'])->name('index');
        Route::get('/criar', [FolhaPontoController::class, 'create'])->name('create');
        Route::post('/', [FolhaPontoController::class, 'store'])->name('store');
        Route::get('/{folha}/editar', [FolhaPontoController::class, 'edit'])->name('edit');
        Route::put('/{folha}', [FolhaPontoController::class, 'update'])->name('update');
        Route::get('/{folha}/pdf', [FolhaPontoController::class, 'pdf'])->name('pdf');
        Route::delete('/{folha}', [FolhaPontoController::class, 'destroy'])->name('destroy');
    });
});
