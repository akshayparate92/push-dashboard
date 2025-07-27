<?php

use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\RecurringPushController;
use App\Http\Controllers\Admin\SinglePushController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCateoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',[ProfileController::class,'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['role:admin'])->group(function(){
        Route::resource('game',GameController::class)->except(['show']);
        Route::resource('single/push',SinglePushController::class)->except(['show','edit','update']);
        Route::resource('push/recurring',RecurringPushController::class)->except(['show','edit','update']);
        Route::get('push/recurring/edit/{game?}/{frequency}',[RecurringPushController::class,'recurringEdit'])->name('edit.recurring.push');
        Route::delete('push/recurring/delete/{game?}/{frequency}',[RecurringPushController::class,'recurringDelete'])->name('delete.recurring.push');
        Route::delete('push/recurring/delete/{messageId}',[RecurringPushController::class,'recurringPushDelete'])->name('recurring.push.destroy');

        Route::post('push/recurring/schedule', [RecurringPushController::class,'recurringScheduleTime'])->name('submit.recurring.push.schedule');
        Route::post('/push/image/upload',[SinglePushController::class,'tinyMCEImageUpload'])->name('tinymce.image.upload');
        Route::get('/delivery/send', [DeliveryController::class, 'showSendPush'])->name('show.delivery.send.push');
        Route::get('/delivery/scheduled', [DeliveryController::class, 'showScheduledPush'])->name('show.delivery.scheduled.push');

        Route::resource('user',UserController::class);
        Route::resource('role',RoleController::class);
        Route::resource('permission',PermissionController::class);
        Route::resource('category',CategoryController::class);
        Route::resource('subcategory',SubCateoryController::class);
        Route::resource('collection',CollectionController::class);
        Route::resource('product',ProductController::class);
        Route::get('/get/subcategory',[ProductController::class,'getsubcategory'])->name('getsubcategory');
        Route::get('/remove-external-img/{id}',[ProductController::class,'removeImage'])->name('remove.image');
    });
});
