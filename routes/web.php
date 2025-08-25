<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleChangeController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\ColisController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ConsignataireController;
use App\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard1', [DashboardController::class, 'index'])->name('dashboard');


//Route::get('/dashboard', function () {
    //return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes (doivent être accessibles sans être connecté)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Profile routes (protégées par auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Changement de rôle
Route::get('/changer.role', function () {
    return view('changer.role');
})->name('changer.role');
Route::post('/changer.role', [RoleChangeController::class, 'store'])->name('changer.role');


// Dashboard Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});


//Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
    // ->middleware('auth')
    // ->name('admin.dashboard');




// Dashboard Fournisseur
Route::middleware(['auth'])->group(function () {
    Route::get('/fournisseur/dashboard', [FournisseurController::class, 'dashboard'])->name('fournisseur.dashboard');
});


// Dashboard Consignataire
Route::middleware(['auth'])->group(function () {
    Route::get('/consignataire/dashboard', [ConsignataireController::class, 'dashboard'])->name('consignataire.dashboard');
});

// Dashboard Client
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});



// Gestion des demandes de rôle

//Route::get('/gestion-roles', [RoleRequestController::class, 'index'])->name('role.index');
//Route::post('/gestion-roles/accept/{id}', [RoleRequestController::class, 'accept'])->name('role.accept');
//Route::post('/gestion-roles/refuse/{id}', [RoleRequestController::class, 'refuse'])->name('role.refuse');

// Route pour la redirection après demande de rôle
Route::get('/role.request', [RoleRequestController::class, 'index'])->name('role.request');


// routes changement de rôle
//Route::post('/role-change', [RoleChangeRequestController::class, 'store'])->name('role-change.store');
//Route::get('/admin/role-requests', [RoleChangeRequestController::class, 'index'])->name('role-change.index');


// routes gestionnaire des demandes de rôle
Route::get('/role.requests', [RoleRequestController::class, 'index'])->name('role.requests');
Route::post('/role.request', [RoleRequestController::class, 'store'])->name('role-request.store');


Route::post('/role.requests/{id}/accept', [RoleRequestController::class, 'accept'])->name('role.accept');
Route::post('/role.requests/{id}/refuse', [RoleRequestController::class, 'refuse'])->name('role.refuse');


//Route colis
Route::get('/colis.create', [ColisController::class, 'create'])->name('colis.create');
Route::post('/colis', [ColisController::class, 'store'])->name('colis.store');

// Liste des colis
Route::get('/colis', [App\Http\Controllers\ColisController::class, 'index'])->name('colis.index');

Route::get('/colis/{id}', [ColisController::class, 'show'])->name('colis.show');

//Route::resource('colis', ColisController::class);



