<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

// -----------------START MANAGER CONTROLLER-----------------------------
use App\Http\Controllers\Manager\ProductsManagerController;
use App\Http\Controllers\UploadImageController;
use App\Http\Controllers\Manager\PurchasedItemsManagerController;
use App\Http\Controllers\Manager\AddAccountManagerController;
use App\Http\Controllers\Manager\FeedbackQuestionManagerController;
use App\Http\Controllers\Manager\OwnerMessageManagerController;
use App\Http\Controllers\Manager\ViewInventoryManagerControlController;
use App\Http\Controllers\Manager\UploadImageManagerControlController;
use App\Http\Controllers\Manager\ViewInventoryRetailManagerControlController;
use App\Http\Controllers\Manager\ViewInventoryRestaurantManagerControlController;
use App\Http\Controllers\Manager\ViewInventorySalonManagerControlController;
// -----------------END-----------------------------


// -----------------START STAFF CONTROLLER-----------------------------
// ============================ Staff Retail Routes =======================================
use App\Http\Controllers\StaffRetail\DashboardStaffRetailController;
use App\Http\Controllers\StaffRetail\OrderStaffRetailController;
use App\Http\Controllers\StaffRetail\PurchasedItemsStaffRetailController;
use App\Http\Controllers\StaffRetail\FeedbackQuestionStaffRetailController;
use App\Http\Controllers\StaffRetail\ContactManagerStaffRetailController;
// ============================ Staff Salon Routes =======================================
use App\Http\Controllers\StaffSalon\DashboardStaffSalonController;
use App\Http\Controllers\StaffSalon\OrderStaffSalonController;
use App\Http\Controllers\StaffSalon\PurchasedItemsStaffSalonController;
use App\Http\Controllers\StaffSalon\FeedbackQuestionStaffSalonController;
use App\Http\Controllers\StaffSalon\ContactManagerStaffSalonController;
// ============================ Staff Restaurant Routes =======================================
use App\Http\Controllers\StaffRestaurant\DashboardStaffRestaurantController;
use App\Http\Controllers\StaffRestaurant\OrderStaffRestaurantController;
use App\Http\Controllers\StaffRestaurant\PurchasedItemsStaffRestaurantController;
use App\Http\Controllers\StaffRestaurant\FeedbackQuestionStaffRestaurantController;
use App\Http\Controllers\StaffRestaurant\ContactManagerStaffRestaurantController;
// -----------------END-----------------------------

// -----------------START ADMIN CONTROL OR MASTER ADMIN CONTROLLER-----------------------------
use App\Http\Controllers\AdminControl\UserSubscriptionAdminControlController;
use App\Http\Controllers\AdminControl\FeedbackQuestionAdminControlController;
use App\Http\Controllers\AdminControl\DashboardAdminControlController;
use App\Http\Controllers\AdminControl\OwnerMessageAdminControlController;
use App\Http\Controllers\AdminControl\PendingBranchesAdminControlController;
use App\Http\Controllers\AdminControl\PendingViewAdminControlController;
// -----------------END-----------------------------

// -----------------START OWNER ADMIN  CONTROLLER-----------------------------
use App\Http\Controllers\OwnerAdmin\OwnerAdminController;
use App\Http\Controllers\OwnerAdmin\PurchasedItemsOwnerAdminController;
use App\Http\Controllers\OwnerAdmin\RegisterBusinessOwnerAdminController;
use App\Http\Controllers\OwnerAdmin\FeedbackQuestionOwnerAdminController;
use App\Http\Controllers\OwnerAdmin\ContactManagerOwnerAdminController;
use App\Http\Controllers\OwnerAdmin\UploadLogoOwnerAdminController;
use App\Http\Controllers\OwnerAdmin\ManagerAccountOwnerAdminController;

// -----------------END-----------------------------

// -----------------START Users  CONTROLLER-----------------------------
use App\Http\Controllers\Users\FeedbackQuestionUsersController;
// -----------------END-----------------------------
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');





Route::resource('/', WelcomeController::class)->names([
    'index'   => 'home',
    'create'  => 'home.create',
    'store'   => 'home.store',
    'show'    => 'home.show',
    'edit'    => 'home.edit',
    'update'  => 'home.update',
    'destroy' => 'home.destroy',
]);

// -----------------START MANAGER CONTROLLER-----------------------------

Route::middleware(['auth', 'verified', 'role:Manager', 'check.subscription'])->group(function () {
    Route::get('manager/dashboard', function () {
        return Inertia::render('manager/Dashboard');
    })->name('manager.dashboard');

    Route::resource('/manager/Inventory', ProductsManagerController::class)->names([
        'index'   => 'manager.Inventory',
        'create'  => 'manager.Inventory.create',
        'store'   => 'manager.Inventory.store',
        'show'    => 'manager.Inventory.show',
        'edit'    => 'manager.Inventory.edit',
        'update'  => 'manager.Inventory.update',
        'destroy' => 'manager.Inventory.destroy',
    ]);

    Route::resource('/manager/InventoryPurchasedItems', PurchasedItemsManagerController::class)->names([
        'index'   => 'manager.InventoryPurchasedItems',
        'create'  => 'manager.InventoryPurchasedItems.create',
        'store'   => 'manager.InventoryPurchasedItems.store',
        'show'    => 'manager.InventoryPurchasedItems.show',
        'edit'    => 'manager.InventoryPurchasedItems.edit',
        'update'  => 'manager.InventoryPurchasedItems.update',
        'destroy' => 'manager.InventoryPurchasedItems.destroy',
    ]);

    Route::resource('/manager/AddAccount', AddAccountManagerController::class)->names([
        'index'   => 'manager.AddAccount',
        'create'  => 'manager.AddAccount.create',
        'store'   => 'manager.AddAccount.store',
        'show'    => 'manager.AddAccount.show',
        'edit'    => 'manager.AddAccount.edit',
        'update'  => 'manager.AddAccount.update',
        'destroy' => 'manager.AddAccount.destroy',
    ]);
    Route::resource('/manager/FeedbackQuestion', FeedbackQuestionManagerController::class)->names([
        'index'   => 'manager.FeedbackQuestion',
        'create'  => 'manager.FeedbackQuestion.create',
        'store'   => 'manager.FeedbackQuestion.store',
        'show'    => 'manager.FeedbackQuestion.show',
        'edit'    => 'manager.FeedbackQuestion.edit',
        'update'  => 'manager.FeedbackQuestion.update',
        'destroy' => 'manager.FeedbackQuestion.destroy',
    ]);
    Route::resource('/manager/OwnerMessage', OwnerMessageManagerController::class)->names([
        'index'   => 'manager.OwnerMessage',
        'create'  => 'manager.OwnerMessage.create',
        'store'   => 'manager.OwnerMessage.store',
        'show'    => 'manager.OwnerMessage.show',
        'edit'    => 'manager.OwnerMessage.edit',
        'update'  => 'manager.OwnerMessage.update',
        'destroy' => 'manager.OwnerMessage.destroy',
    ]);
    Route::resource('/manager/InventoryList/ViewInventoryRetail', ViewInventoryRetailManagerControlController::class)->names([
        'index'   => 'manager.InventoryList.ViewInventoryRetail',
        'create'  => 'manager.InventoryList.ViewInventoryRetail.create',
        'store'   => 'manager.InventoryList.ViewInventoryRetail.store',
        'show'    => 'manager.InventoryList.ViewInventoryRetail.show',
        'edit'    => 'manager.InventoryList.ViewInventoryRetail.edit',
        'update'  => 'manager.InventoryList.ViewInventoryRetail.update',
        'destroy' => 'manager.InventoryList.ViewInventoryRetail.destroy',
    ]);
    Route::resource('/manager/InventoryList/ViewInventoryRestaurant', ViewInventoryRestaurantManagerControlController::class)->names([
        'index'   => 'manager.InventoryList.ViewInventoryRestaurant',
        'create'  => 'manager.InventoryList.ViewInventoryRestaurant.create',
        'store'   => 'manager.InventoryList.ViewInventoryRestaurant.store',
        'show'    => 'manager.InventoryList.ViewInventoryRestaurant.show',
        'edit'    => 'manager.InventoryList.ViewInventoryRestaurant.edit',
        'update'  => 'manager.InventoryList.ViewInventoryRestaurant.update',
        'destroy' => 'manager.InventoryList.ViewInventoryRestaurant.destroy',
    ]);
    Route::resource('/manager/InventoryList/ViewInventorySalon', ViewInventorySalonManagerControlController::class)->names([
        'index'   => 'manager.InventoryList.ViewInventorySalon',
        'create'  => 'manager.InventoryList.ViewInventorySalon.create',
        'store'   => 'manager.InventoryList.ViewInventorySalon.store',
        'show'    => 'manager.InventoryList.ViewInventorySalon.show',
        'edit'    => 'manager.InventoryList.ViewInventorySalon.edit',
        'update'  => 'manager.InventoryList.ViewInventorySalon.update',
        'destroy' => 'manager.InventoryList.ViewInventorySalon.destroy',
    ]);
    //     Route::resource('/manager/upload-products', UploadImageManagerControlController::class)->names([
    //     'index'   => 'manager.InventoryList.upload-products',
    //     'create'  => 'manager.InventoryList.upload-products.create',
    //     'store'   => 'manager.InventoryList.upload-products.store',
    //     'show'    => 'manager.InventoryList.upload-products.show',
    //     'edit'    => 'manager.InventoryList.upload-products.edit',
    //     'update'  => 'manager.InventoryList.upload-products.update',
    //     'destroy' => 'manager.InventoryList.upload-products.destroy',
    // ]);
    Route::post('/manager/upload-logo-owneradmin-revert', [UploadImageManagerControlController::class, 'revertLogo']);
    Route::post('/manager/upload-logo-owneradmin', [UploadImageManagerControlController::class, 'uploadImage'])->name('upload.image');
});

// -----------------END-----------------------------

// -----------------START OWNER ADMIN CONTROLLER-----------------------------
Route::middleware(['auth', 'verified', 'role:OwnerAdmin', 'check.subscription'])->group(function () {
    Route::get('owneradmin/dashboard', function () {
        return Inertia::render('owneradmin/Dashboard');
    })->name('owneradmin.dashboard');

    Route::resource('/owneradmin/PurchasedItems', PurchasedItemsOwnerAdminController::class)->names([
        'index'   => 'owneradmin.PurchasedItems',
        'create'  => 'owneradmin.PurchasedItems.create',
        'store'   => 'owneradmin.PurchasedItems.store',
        'show'    => 'owneradmin.PurchasedItems.show',
        'edit'    => 'owneradmin.PurchasedItems.edit',
        'update'  => 'owneradmin.PurchasedItems.update',
        'destroy' => 'owneradmin.PurchasedItems.destroy',
    ]);

    Route::resource('/owneradmin/RegisterBusiness', RegisterBusinessOwnerAdminController::class)->names([
        'index'   => 'owneradmin.RegisterBusiness',
        'create'  => 'owneradmin.RegisterBusiness.create',
        'store'   => 'owneradmin.RegisterBusiness.store',
        'show'    => 'owneradmin.RegisterBusiness.show',
        'edit'    => 'owneradmin.RegisterBusiness.edit',
        'update'  => 'owneradmin.RegisterBusiness.update',
        'destroy' => 'owneradmin.RegisterBusiness.destroy',
    ]);
    Route::resource('/owneradmin/FeedbackQuestion', FeedbackQuestionOwnerAdminController::class)->names([
        'index'   => 'owneradmin.FeedbackQuestion',
        'create'  => 'owneradmin.FeedbackQuestion.create',
        'store'   => 'owneradmin.FeedbackQuestion.store',
        'show'    => 'owneradmin.FeedbackQuestion.show',
        'edit'    => 'owneradmin.FeedbackQuestion.edit',
        'update'  => 'owneradmin.FeedbackQuestion.update',
        'destroy' => 'owneradmin.FeedbackQuestion.destroy',
    ]);
    Route::resource('/owneradmin/ContactManager', ContactManagerOwnerAdminController::class)->names([
        'index'   => 'owneradmin.ContactManager',
        'create'  => 'owneradmin.ContactManager.create',
        'store'   => 'owneradmin.ContactManager.store',
        'show'    => 'owneradmin.ContactManager.show',
        'edit'    => 'owneradmin.ContactManager.edit',
        'update'  => 'owneradmin.ContactManager.update',
        'destroy' => 'owneradmin.ContactManager.destroy',
    ]);

    Route::post('/upload-logo-owneradmin-revert', [UploadLogoOwnerAdminController::class, 'revertLogo']);
    Route::post('/upload-logo-owneradmin', [UploadLogoOwnerAdminController::class, 'uploadImage'])->name('upload.image');

    Route::resource('/owneradmin/ManagerAccount', ManagerAccountOwnerAdminController::class)->names([
        'index'   => 'owneradmin.ManagerAccount',
        'create'  => 'owneradmin.ManagerAccount.create',
        'store'   => 'owneradmin.ManagerAccount.store',
        'show'    => 'owneradmin.ManagerAccount.show',
        'edit'    => 'owneradmin.ManagerAccount.edit',
        'update'  => 'owneradmin.ManagerAccount.update',
        'destroy' => 'owneradmin.ManagerAccount.destroy',
    ]);
});
// -----------------END-----------------------------

// -----------------START STAFF CONTROLLER-----------------------------
// ============================ Staff Retail Routes =======================================
Route::middleware(['auth', 'verified', 'role:StaffRetail', 'check.subscription'])->group(function () {
    
    Route::resource('/staffpanel/staffretail/Dashboard', DashboardStaffRetailController::class)->names([
        'index'   => 'staffpanel.staffretail.Dashboard',
        'create'  => 'staffpanel.staffretail.Dashboard.create',
        'store'   => 'staffpanel.staffretail.Dashboard.store',
        'show'    => 'staffpanel.staffretail.Dashboard.show',
        'edit'    => 'staffpanel.staffretail.Dashboard.edit',
        'update'  => 'staffpanel.staffretail.Dashboard.update',
        'destroy' => 'staffpanel.staffretail.Dashboard.destroy',
    ]);

    Route::resource('/staffpanel/staffretail/Order', OrderStaffRetailController::class)->names([
        'index'   => 'staffpanel.staffretail.Order',
        'create'  => 'staffpanel.staffretail.Order.create',
        'store'   => 'staffpanel.staffretail.Order.store',
        'show'    => 'staffpanel.staffretail.Order.show',
        'edit'    => 'staffpanel.staffretail.Order.edit',
        'update'  => 'staffpanel.staffretail.Order.update',
        'destroy' => 'staffpanel.staffretail.Order.destroy',
    ]);

    Route::resource('/staffpanel/staffretail/PurchasedItems', PurchasedItemsStaffRetailController::class)->names([
        'index'   => 'staffpanel.staffretail.PurchasedItems',
        'create'  => 'staffpanel.staffretail.PurchasedItems.create',
        'store'   => 'staffpanel.staffretail.PurchasedItems.store',
        'show'    => 'staffpanel.staffretail.PurchasedItems.show',
        'edit'    => 'staffpanel.staffretail.PurchasedItems.edit',
        'update'  => 'staffpanel.staffretail.PurchasedItems.update',
        'destroy' => 'staffpanel.staffretail.PurchasedItems.destroy',
    ]);

    Route::resource('/staffpanel/staffretail/FeedbackQuestion', FeedbackQuestionStaffRetailController::class)->names([
        'index'   => 'staffpanel.staffretail.FeedbackQuestion',
        'create'  => 'staffpanel.staffretail.FeedbackQuestion.create',
        'store'   => 'staffpanel.staffretail.FeedbackQuestion.store',
        'show'    => 'staffpanel.staffretail.FeedbackQuestion.show',
        'edit'    => 'staffpanel.staffretail.FeedbackQuestion.edit',
        'update'  => 'staffpanel.staffretail.FeedbackQuestion.update',
        'destroy' => 'staffpanel.staffretail.FeedbackQuestion.destroy',
    ]);
    Route::resource('/staffpanel/staffretail/ContactManager', ContactManagerStaffRetailController::class)->names([
        'index'   => 'staffpanel.staffretail.ContactManager',
        'create'  => 'staffpanel.staffretail.ContactManager.create',
        'store'   => 'staffpanel.staffretail.ContactManager.store',
        'show'    => 'staffpanel.staffretail.ContactManager.show',
        'edit'    => 'staffpanel.staffretail.ContactManager.edit',
        'update'  => 'staffpanel.staffretail.ContactManager.update',
        'destroy' => 'staffpanel.staffretail.ContactManager.destroy',
    ]);
});


// =============================== Staff Salon Routes ========================================
Route::middleware(['auth', 'verified', 'role:StaffSalon', 'check.subscription'])->group(function () {

    
    Route::resource('/staffpanel/staffsalon/Dashboard', DashboardStaffSalonController::class)->names([
        'index'   => 'staffpanel.staffsalon.Dashboard',
        'create'  => 'staffpanel.staffsalon.Dashboard.create',
        'store'   => 'staffpanel.staffsalon.Dashboard.store',
        'show'    => 'staffpanel.staffsalon.Dashboard.show',
        'edit'    => 'staffpanel.staffsalon.Dashboard.edit',
        'update'  => 'staffpanel.staffsalon.Dashboard.update',
        'destroy' => 'staffpanel.staffsalon.Dashboard.destroy',
    ]);

    Route::resource('/staffpanel/staffsalon/Order', OrderStaffSalonController::class)->names([
        'index'   => 'staffpanel.staffsalon.Order',
        'create'  => 'staffpanel.staffsalon.Order.create',
        'store'   => 'staffpanel.staffsalon.Order.store',
        'show'    => 'staffpanel.staffsalon.Order.show',
        'edit'    => 'staffpanel.staffsalon.Order.edit',
        'update'  => 'staffpanel.staffsalon.Order.update',
        'destroy' => 'staffpanel.staffsalon.Order.destroy',
    ]);

    Route::resource('/staffpanel/staffsalon/PurchasedItems', PurchasedItemsStaffSalonController::class)->names([
        'index'   => 'staffpanel.staffsalon.PurchasedItems',
        'create'  => 'staffpanel.staffsalon.PurchasedItems.create',
        'store'   => 'staffpanel.staffsalon.PurchasedItems.store',
        'show'    => 'staffpanel.staffsalon.PurchasedItems.show',
        'edit'    => 'staffpanel.staffsalon.PurchasedItems.edit',
        'update'  => 'staffpanel.staffsalon.PurchasedItems.update',
        'destroy' => 'staffpanel.staffsalon.PurchasedItems.destroy',
    ]);

    Route::resource('/staffpanel/staffsalon/FeedbackQuestion', FeedbackQuestionStaffSalonController::class)->names([
        'index'   => 'staffpanel.staffsalon.FeedbackQuestion',
        'create'  => 'staffpanel.staffsalon.FeedbackQuestion.create',
        'store'   => 'staffpanel.staffsalon.FeedbackQuestion.store',
        'show'    => 'staffpanel.staffsalon.FeedbackQuestion.show',
        'edit'    => 'staffpanel.staffsalon.FeedbackQuestion.edit',
        'update'  => 'staffpanel.staffsalon.FeedbackQuestion.update',
        'destroy' => 'staffpanel.staffsalon.FeedbackQuestion.destroy',
    ]);
    Route::resource('/staffpanel/staffsalon/ContactManager', ContactManagerStaffSalonController::class)->names([
        'index'   => 'staffpanel.staffsalon.ContactManager',
        'create'  => 'staffpanel.staffsalon.ContactManager.create',
        'store'   => 'staffpanel.staffsalon.ContactManager.store',
        'show'    => 'staffpanel.staffsalon.ContactManager.show',
        'edit'    => 'staffpanel.staffsalon.ContactManager.edit',
        'update'  => 'staffpanel.staffsalon.ContactManager.update',
        'destroy' => 'staffpanel.staffsalon.ContactManager.destroy',
    ]);
});

// =============================== Staff Restaurant Routes ========================================
Route::middleware(['auth', 'verified', 'role:StaffRestaurant', 'check.subscription'])->group(function () {
    
    Route::resource('/staffpanel/staffrestaurant/Dashboard', DashboardStaffRestaurantController::class)->names([
        'index'   => 'staffpanel.staffrestaurant.Dashboard',
        'create'  => 'staffpanel.staffrestaurant.Dashboard.create',
        'store'   => 'staffpanel.staffrestaurant.Dashboard.store',
        'show'    => 'staffpanel.staffrestaurant.Dashboard.show',
        'edit'    => 'staffpanel.staffrestaurant.Dashboard.edit',
        'update'  => 'staffpanel.staffrestaurant.Dashboard.update',
        'destroy' => 'staffpanel.staffrestaurant.Dashboard.destroy',
    ]);
    Route::resource('/staffpanel/staffrestaurant/Order', OrderStaffRestaurantController::class)->names([
        'index'   => 'staffpanel.staffrestaurant.Order',
        'create'  => 'staffpanel.staffrestaurant.Order.create',
        'store'   => 'staffpanel.staffrestaurant.Order.store',
        'show'    => 'staffpanel.staffrestaurant.Order.show',
        'edit'    => 'staffpanel.staffrestaurant.Order.edit',
        'update'  => 'staffpanel.staffrestaurant.Order.update',
        'destroy' => 'staffpanel.staffrestaurant.Order.destroy',
    ]);

    Route::resource('/staffpanel/staffrestaurant/PurchasedItems', PurchasedItemsStaffRestaurantController::class)->names([
        'index'   => 'staffpanel.staffrestaurant.PurchasedItems',
        'create'  => 'staffpanel.staffrestaurant.PurchasedItems.create',
        'store'   => 'staffpanel.staffrestaurant.PurchasedItems.store',
        'show'    => 'staffpanel.staffrestaurant.PurchasedItems.show',
        'edit'    => 'staffpanel.staffrestaurant.PurchasedItems.edit',
        'update'  => 'staffpanel.staffrestaurant.PurchasedItems.update',
        'destroy' => 'staffpanel.staffrestaurant.PurchasedItems.destroy',
    ]);

    Route::resource('/staffpanel/staffrestaurant/FeedbackQuestion', FeedbackQuestionStaffRestaurantController::class)->names([
        'index'   => 'staffpanel.staffrestaurant.FeedbackQuestion',
        'create'  => 'staffpanel.staffrestaurant.FeedbackQuestion.create',
        'store'   => 'staffpanel.staffrestaurant.FeedbackQuestion.store',
        'show'    => 'staffpanel.staffrestaurant.FeedbackQuestion.show',
        'edit'    => 'staffpanel.staffrestaurant.FeedbackQuestion.edit',
        'update'  => 'staffpanel.staffrestaurant.FeedbackQuestion.update',
        'destroy' => 'staffpanel.staffrestaurant.FeedbackQuestion.destroy',
    ]);
    Route::resource('/staffpanel/staffrestaurant/ContactManager', ContactManagerStaffRestaurantController::class)->names([
        'index'   => 'staffpanel.staffrestaurant.ContactManager',
        'create'  => 'staffpanel.staffrestaurant.ContactManager.create',
        'store'   => 'staffpanel.staffrestaurant.ContactManager.store',
        'show'    => 'staffpanel.staffrestaurant.ContactManager.show',
        'edit'    => 'staffpanel.staffrestaurant.ContactManager.edit',
        'update'  => 'staffpanel.staffrestaurant.ContactManager.update',
        'destroy' => 'staffpanel.staffrestaurant.ContactManager.destroy',
    ]);
});
// -----------------END-----------------------------

// -----------------START ADMIN CONTROL OR MASTER ADMIN CONTROLLER-----------------------------
Route::middleware(['auth', 'verified', 'role:AdminControl', 'check.subscription'])->group(function () {


    Route::resource('/admincontrol/dashboard', DashboardAdminControlController::class)->names([
        'index'   => 'admincontrol.dashboard',
        'create'  => 'admincontrol.dashboard.create',
        'store'   => 'admincontrol.dashboard.store',
        'show'    => 'admincontrol.dashboard.show',
        'edit'    => 'admincontrol.dashboard.edit',
        'update'  => 'admincontrol.dashboard.update',
        'destroy' => 'admincontrol.dashboard.destroy',
    ]);

    Route::resource('/admincontrol/UserSubscription', UserSubscriptionAdminControlController::class)->names([
        'index'   => 'admincontrol.UserSubscription',
        'create'  => 'admincontrol.UserSubscription.create',
        'store'   => 'admincontrol.UserSubscription.store',
        'show'    => 'admincontrol.UserSubscription.show',
        'edit'    => 'admincontrol.UserSubscription.edit',
        'update'  => 'admincontrol.UserSubscription.update',
        'destroy' => 'admincontrol.UserSubscription.destroy',
    ]);
    Route::resource('/admincontrol/FeedbackQuestion', FeedbackQuestionAdminControlController::class)->names([
        'index'   => 'admincontrol.FeedbackQuestion',
        'create'  => 'admincontrol.FeedbackQuestion.create',
        'store'   => 'admincontrol.FeedbackQuestion.store',
        'show'    => 'admincontrol.FeedbackQuestion.show',
        'edit'    => 'admincontrol.FeedbackQuestion.edit',
        'update'  => 'admincontrol.FeedbackQuestion.update',
        'destroy' => 'admincontrol.FeedbackQuestion.destroy',
    ]);

    Route::resource('/admincontrol/OwnerMessage', OwnerMessageAdminControlController::class)->names([
        'index'   => 'admincontrol.OwnerMessage',
        'create'  => 'admincontrol.OwnerMessage.create',
        'store'   => 'admincontrol.OwnerMessage.store',
        'show'    => 'admincontrol.OwnerMessage.show',
        'edit'    => 'admincontrol.OwnerMessage.edit',
        'update'  => 'admincontrol.OwnerMessage.update',
        'destroy' => 'admincontrol.OwnerMessage.destroy',
    ]);

    Route::resource('/admincontrol/PendingBranches', PendingBranchesAdminControlController::class)->names([
        'index'   => 'admincontrol.PendingBranches',
        'create'  => 'admincontrol.PendingBranches.create',
        'store'   => 'admincontrol.PendingBranches.store',
        'show'    => 'admincontrol.PendingBranches.show',
        'edit'    => 'admincontrol.PendingBranches.edit',
        'update'  => 'admincontrol.PendingBranches.update',
        'destroy' => 'admincontrol.PendingBranches.destroy',
    ]);

    Route::resource('/admincontrol/branchesrequest/PendingView', PendingViewAdminControlController::class)->names([
        'index'   => 'admincontrol.branchesrequest.PendingView',
        'create'  => 'admincontrol.branchesrequest.PendingView.create',
        'store'   => 'admincontrol.branchesrequest.PendingView.store',
        'show'    => 'admincontrol.branchesrequest.PendingView.show',
        'edit'    => 'admincontrol.branchesrequest.PendingView.edit',
        'update'  => 'admincontrol.branchesrequest.PendingView.update',
        'destroy' => 'admincontrol.branchesrequest.PendingView.destroy',
    ]);
});
// -----------------END-----------------------------

// routes/web.php
Route::post('/upload-products', [UploadImageController::class, 'uploadImage'])->name('upload.image');

Route::post('/upload-products-revert', [UploadImageController::class, 'revert']);

Route::get('/errors/unauthorized', function () {
    return Inertia::render('Errors/Unauthorized');
})->name('errors.unauthorized');

// Do NOT protect this route with check.expiredsub
Route::middleware(['auth', 'verified', 'check.expiredsub'])->group(function () {
    Route::get('/SubscriptionExpired/Expired', function () {
        return Inertia::render('SubscriptionExpired/Expired');
    })->name('SubscriptionExpired.Expired');
});


Route::middleware(['auth', 'verified', 'check.expiredsubuser'])->group(function () {
    Route::get('/usersportal/dashboard', function () {
        return Inertia::render('usersportal/dashboard');
    })->name('usersportal.dashboard');

    Route::resource('/usersportal/FeedbackQuestion', FeedbackQuestionUsersController::class)->names([
        'index'   => 'usersportal.FeedbackQuestion',
        'create'  => 'usersportal.FeedbackQuestion.create',
        'store'   => 'usersportal.FeedbackQuestion.store',
        'show'    => 'usersportal.FeedbackQuestion.show',
        'edit'    => 'usersportal.FeedbackQuestion.edit',
        'update'  => 'usersportal.FeedbackQuestion.update',
        'destroy' => 'usersportal.FeedbackQuestion.destroy',
    ]);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
