<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(\Config\HomeController::class)->group(function () {
    Route::get('/home/page-environment', 'PageEnvironment');
    Route::get('/home/item', 'ObjectItem');
    Route::get('/home/reports', 'ObjectReport');
});

Route::controller(\Config\CompanyController::class)->group(function () {
    Route::get('profile', 'profiles');
    Route::get('sites', 'getSites');
});

Route::controller(\Config\UserController::class)->group(function () {
    Route::get('user-profile', 'profile');
});

Route::controller(\Config\SecurityController::class)->group(function () {
    Route::post('auth', 'userAuth');
    Route::post('logout', 'logout');
    Route::get('/access/page-verification', 'PageVerified');
    Route::get('/access/page-authorization', 'PageAuthorization');
});

Route::middleware('appauth')->group(function () {
    Route::post('lock', 'Config\UserController@lock');
    Route::post('relogin', 'Config\UserController@relogin');
});

Route::group(['prefix' => 'setup','middleware'=>'appauth'], function () {
    Route::controller(\Setup\ServiceClassController::class)->group(function () {
        Route::get('/class', 'index');
        Route::get('/class/get', 'edit');
        Route::delete('/class', 'destroy');
        Route::post('/class', 'store');
        Route::get('/class/open', 'open');
        Route::get('/class/list', 'openlist');
    });
    Route::controller(\Setup\DepartmentController::class)->group(function () {
        Route::get('/department', 'show');
        Route::get('/department/get', 'get');
        Route::delete('/department', 'destroy');
        Route::post('/department', 'store');
    });
    Route::controller(\Setup\PriceLevelController::class)->group(function () {
        Route::get('/pricelevel', 'index');
        Route::get('/pricelevel/get', 'edit');
        Route::delete('/pricelevel', 'destroy');
        Route::post('/pricelevel', 'store');
    });
    Route::controller(\Setup\ParamedicController::class)->group(function () {
        Route::get('/paramedic', 'index');
        Route::get('/paramedic/get', 'edit');
        Route::delete('/paramedic', 'destroy');
        Route::post('/paramedic', 'store');
    });
    Route::controller(\Setup\ParamedicPriceGroupController::class)->group(function () {
        Route::get('/price-group', 'index');
        Route::get('/price-group/get', 'edit');
        Route::delete('/price-group', 'destroy');
        Route::post('/price-group', 'store');
        Route::get('/price-group/open', 'open');
    });
    Route::controller(\Setup\ParamedicSpecialistController::class)->group(function () {
        Route::get('/specialist', 'index');
        Route::get('/specialist/get', 'edit');
        Route::get('/specialist/open', 'open');
        Route::delete('/specialist', 'destroy');
        Route::post('/specialist', 'store');
    });
    Route::controller(\Setup\WardsController::class)->group(function () {
        Route::get('/ward', 'index');
        Route::get('/ward/get', 'edit');
        Route::get('/ward/open', 'open');
        Route::delete('/ward', 'destroy');
        Route::post('/ward', 'store');
    });
    Route::controller(\Setup\WardRoomsController::class)->group(function () {
        Route::get('/rooms', 'index');
        Route::get('/rooms/get', 'edit');
        Route::get('/rooms/open', 'open');
        Route::delete('/rooms', 'destroy');
        Route::post('/rooms', 'store');
    });

    Route::group(['prefix' => 'application'], function () {
        Route::controller(\Setup\GeneralCodeGroupController::class)->group(function () {
            Route::get('/group-code', 'index');
        });
        Route::controller(\Setup\GeneralCodeController::class)->group(function () {
            Route::get('/standard-code', 'index');
            Route::get('/standard-code/get', 'edit');
            Route::get('/standard-code/open', 'open');
            Route::delete('/standard-code', 'destroy');
            Route::post('/standard-code', 'store');
            Route::get('/standard-code/list', 'get_code');
        });
        Route::controller(\Config\ParametersController::class)->group(function () {
            Route::get('/parameter', 'show');
            Route::get('/parameter/get', 'get');
            Route::get('/parameter/group', 'getgroup');
            Route::post('/parameter', 'post');
        });
    });
});

Route::group(['prefix' => 'inventory','middleware'=>'appauth'], function () {
    Route::group(['prefix' => 'purchase'], function () {
        Route::controller(\Inventory\PurchaseOrderController::class)->group(function () {
            Route::get('order', 'index');
            Route::post('order', 'store');
            Route::get('order/get', 'get');
            Route::delete('order', 'destroy');
            Route::post('order/posting', 'posting');
            Route::post('order/unposting', 'unposting');
            Route::get('order/open', 'open');
            Route::get('order/detail', 'detail');
        });
        Route::controller(\Inventory\PurchaseReceiveController::class)->group(function () {
            Route::get('receive', 'index');
            Route::post('receive', 'store');
            Route::get('receive/get', 'get');
            Route::delete('receive', 'destroy');
            Route::get('receive/open', 'open');
            Route::get('receive/detail', 'detail');
            Route::post('receive/credit', 'store_credit');
            Route::delete('receive/credit', 'destroy_credit');
        });
    });

    Route::group(['prefix' => 'item'], function () {
        Route::controller(\Inventory\ItemRequestController::class)->group(function () {
            Route::get('request', 'index');
            Route::post('request', 'store');
            Route::get('request/get', 'get');
            Route::delete('request', 'destroy');
            Route::post('request/posting', 'posting');
            Route::post('request/reopen', 'unposting');
            Route::get('request/open', 'open');
            Route::get('request/detail', 'detail');
        });

        Route::controller(\Inventory\ItemDistributionController::class)->group(function () {
            Route::get('distribution', 'index');
            Route::post('distribution', 'store');
            Route::post('distribution/posting', 'posting');
            Route::get('distribution/get', 'get');
            Route::delete('distribution', 'destroy');
            Route::get('distribution/confirm', 'confirm');
            Route::post('distribution/accepted', 'accepted');
            Route::delete('distribution/rejected', 'rejected');
            Route::get('distribution/open', 'open');
            Route::get('distribution/detail', 'detail');
        });

        Route::controller(\Master\Inventory\InventoryController::class)->group(function () {
            Route::get('stock', 'stock');
        });

        Route::controller(\Inventory\ItemInOutController::class)->group(function () {
            Route::get('inout', 'index');
            Route::post('inout', 'store');
            Route::get('inout/get', 'get');
            Route::delete('inout', 'destroy');
        });

        Route::controller(\Inventory\ItemProductionController::class)->group(function () {
            Route::get('production', 'index');
            Route::post('production', 'store');
            Route::post('production/result', 'store_result');
            Route::get('production/get', 'get');
            Route::delete('production', 'destroy');
            Route::get('production/billofmaterial', 'get_item_production');
        });

        Route::controller(\Inventory\ItemAdjustmentController::class)->group(function () {
            Route::get('adjustment', 'index');
            Route::post('adjustment', 'store');
            Route::get('adjustment/get', 'get');
        });
    });
});

Route::group(['prefix' => 'master','middleware'=>'appauth'], function () {
    Route::group(['prefix' => 'inventory'], function () {
        Route::controller(\Master\Inventory\WarehouseController::class)->group(function () {
            Route::get('/warehouse', 'index');
            Route::get('/warehouse/get', 'edit');
            Route::delete('/warehouse', 'destroy');
            Route::post('/warehouse', 'store');
            Route::get('/warehouse/list', 'getlist');
        });
        Route::controller(\Master\Inventory\ManufacturController::class)->group(function () {
            Route::get('/manufactur', 'index');
            Route::get('/manufactur/get', 'edit');
            Route::delete('/manufactur', 'destroy');
            Route::post('/manufactur', 'store');
        });
        Route::controller(\Master\Inventory\MOUController::class)->group(function () {
            Route::get('/mou', 'index');
            Route::get('/mou/get', 'edit');
            Route::delete('/mou', 'destroy');
            Route::post('/mou', 'store');
            Route::get('/mou/list', 'list');
        });
        Route::controller(\Master\Inventory\SupplierController::class)->group(function () {
            Route::get('/supplier', 'index');
            Route::get('/supplier/get', 'edit');
            Route::delete('/supplier', 'destroy');
            Route::post('/supplier', 'store');
            Route::get('/supplier/list', 'list');
        });
        Route::controller(\Master\Inventory\InventoryGroupController::class)->group(function () {
            Route::get('/inventory-group', 'index');
            Route::get('/inventory-group/get', 'edit');
            Route::delete('/inventory-group', 'destroy');
            Route::post('/inventory-group', 'store');
        });
        Route::controller(\Master\Inventory\InventoryController::class)->group(function () {
            Route::get('/inventory-item', 'index');
            Route::get('/inventory-item/get', 'edit');
            Route::delete('/inventory-item', 'destroy');
            Route::post('/inventory-item', 'store');
            Route::get('/inventory-item/image/download', 'download');
            Route::get('/inventory-item/open', 'open');
            Route::get('/inventory-item/open-stock', 'open_stock');
            Route::get('/inventory-item/getitem', 'get_item');
            Route::get('/inventory-item/mou', 'index_mou');
            Route::get('/inventory-item/mou/get', 'edit_mou');
            Route::delete('/inventory-item/mou', 'destroy_mou');
            Route::post('/inventory-item/mou', 'store_mou');
            Route::get('/inventory-item/bom', 'bom_index');
            Route::get('/inventory-item/bom/get', 'bom_get');
            Route::post('/inventory-item/bom', 'bom_store');
        });
    });

});

Route::group(['prefix' => 'user', 'as' => 'master','middleware'=>'appauth'], function () {
    Route::get('/users', 'Config\UserController@index');
    Route::get('/users/get', 'Config\UserController@get');
    Route::get('/users/profile', 'Config\UserController@profile');
    Route::post('/users/profile', 'Config\UserController@post_profile');
    Route::post('/users/changepassword', 'Config\UserController@changepassword');
    Route::get('/usersaccess', 'Config\UserController@getObjAccess');
    Route::get('/reports', 'Config\HomeController@setReport');

    Route::get('/item', 'Config\UserController@getItem');
    Route::get('/itemaccess', 'Config\UserController@getItemAccess');

    Route::post('/users', 'Config\UserController@post');
    Route::post('/users/photo', 'Config\UserController@uploadfoto');
    Route::post('/users/sign', 'Config\UserController@uploadsign');
    Route::delete('/users', 'Config\UserController@delete');
    Route::get('/users/level', 'Config\UserController@user_level');
    Route::post('/userspwd', 'Config\UserController@changepwd');
    Route::post('/usersaccess', 'Config\UserController@save_security');
});

Route::group(['prefix' => 'master', 'as' => 'master','middleware'=>'appauth'], function () {
    Route::get('/partner/partner', 'Master\PartnerController@index');
    Route::post('/partner/partner', 'Master\PartnerController@post');
    Route::delete('/partner/partner', 'Master\PartnerController@delete');
    Route::get('/partner/partner/get', 'Master\PartnerController@get');
    Route::get('/partner/partner/list', 'Master\PartnerController@getlist');
    Route::get('/partner/partner/open', 'Master\PartnerController@open');

    Route::get('/partner/driver', 'Master\PersonalController@index');
    Route::post('/partner/driver', 'Master\PersonalController@post');
    Route::delete('/partner/driver', 'Master\PersonalController@delete');
    Route::get('/partner/driver/get', 'Master\PersonalController@get');
    Route::get('/partner/driver/list', 'Master\PersonalController@getlist');
    Route::get('/partner/driver/open', 'Master\PersonalController@open');
    Route::post('/partner/driver/upload','Master\PersonalController@upload');
    Route::get('/partner/driver/download','Master\PersonalController@download');

    Route::get('/operational/pool', 'Master\PoolsController@index');
    Route::post('/operational/pool', 'Master\PoolsController@post');
    Route::delete('/operational/pool', 'Master\PoolsController@delete');
    Route::get('/operational/pool/get', 'Master\PoolsController@get');
    Route::get('/operational/pool/list', 'Master\PoolsController@getlist');

    Route::get('/operational/vehicle-group', 'Master\VehicleGroupController@index');
    Route::post('/operational/vehicle-group', 'Master\VehicleGroupController@post');
    Route::delete('/operational/vehicle-group', 'Master\VehicleGroupController@delete');
    Route::get('/operational/vehicle-group/get', 'Master\VehicleGroupController@get');
    Route::get('/operational/vehicle-group/list', 'Master\VehicleGroupController@getlist');
    Route::get('/operational/vehicle-group/main/list', 'Master\VehicleGroupController@maingetlist');

    Route::get('/operational/vehicle', 'Master\VehiclesController@index');
    Route::post('/operational/vehicle', 'Master\VehiclesController@post');
    Route::delete('/operational/vehicle', 'Master\VehiclesController@delete');
    Route::get('/operational/vehicle/get', 'Master\VehiclesController@get');
    Route::get('/operational/vehicle/document', 'Master\VehiclesController@document');
    Route::get('/operational/vehicle/open', 'Master\VehiclesController@open');
    Route::get('/operational/vehicle/list', 'Master\VehiclesController@getlist');
    Route::post('/operational/vehicle/upload', 'Master\VehiclesController@upload');
    Route::get('/operational/vehicle/download', 'Master\VehiclesController@download');
    Route::delete('/operational/vehicle/image-remove','Master\VehiclesController@remove');
    Route::get('/operational/vehicle/gpseasygo','Master\VehiclesController@GPSEasyGo');

    Route::get('/operational/variable-cost', 'Master\VehicleVariableCostController@index');
    Route::post('/operational/variable-cost', 'Master\VehicleVariableCostController@post');
    Route::delete('/operational/variable-cost', 'Master\VehicleVariableCostController@delete');
    Route::get('/operational/variable-cost/get', 'Master\VehicleVariableCostController@get');
    Route::get('/operational/variable-cost/list', 'Master\VehicleVariableCostController@getlist');

    Route::get('/operational/geofance', 'Master\GeofanceController@index');
    Route::post('/operational/geofance', 'Master\GeofanceController@post');
    Route::delete('/operational/geofance', 'Master\GeofanceController@delete');
    Route::get('/operational/geofance/get', 'Master\GeofanceController@get');
    Route::get('/operational/geofance/list', 'Master\GeofanceController@getlist');
    Route::get('/operational/geofance/open', 'Master\GeofanceController@getopen');

    Route::get('/operational/gps-device', 'Master\GPSDeviceController@index');
    Route::post('/operational/gps-device', 'Master\GPSDeviceController@post');
    Route::delete('/operational/gps-device', 'Master\GPSDeviceController@delete');
    Route::get('/operational/gps-device/get', 'Master\GPSDeviceController@get');
    Route::get('/operational/gps-device/list', 'Master\GPSDeviceController@getlist');

    Route::get('/operational/dashboard1', 'Operation\MonitoringController@dashboard1');

    Route::get('/finance/cash-bank', 'Master\CashBankController@index');
    Route::post('/finance/cash-bank', 'Master\CashBankController@post');
    Route::delete('/finance/cash-bank', 'Master\CashBankController@delete');
    Route::get('/finance/cash-bank/get', 'Master\CashBankController@get');
    Route::get('/finance/cash-bank/list', 'Master\CashBankController@getlist');
    Route::get('/finance/cash-bank/list/user', 'Master\CashBankController@getlistbyuser');

    Route::get('/accounting/coa', 'Master\COAController@index');
    Route::post('/accounting/coa', 'Master\COAController@post');
    Route::delete('/accounting/coa', 'Master\COAController@delete');
    Route::get('/accounting/coa/get', 'Master\COAController@get');
    Route::get('/accounting/coa/list', 'Master\COAController@coa');
    Route::get('/accounting/coa/header', 'Master\COAController@getheader');
    Route::get('/accounting/jurnal_type', 'Master\COAController@Getjurnaltype');

    Route::get('/accounting/voucher', 'Master\VoucherController@index');
    Route::post('/accounting/voucher', 'Master\VoucherController@post');
    Route::delete('/accounting/voucher', 'Master\VoucherController@delete');
    Route::get('/accounting/voucher/get', 'Master\VoucherController@get');
    Route::get('/accounting/voucher/list', 'Master\VoucherController@getlist');

    Route::get('/accounting/fiscal-year', 'Master\FiscalYearController@get');
    Route::post('/accounting/fiscal-year', 'Master\FiscalYearController@post');
});


