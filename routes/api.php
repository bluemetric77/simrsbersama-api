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
Route::get('profile', 'Config\CompanyController@profiles');
Route::get('sites', 'Config\CompanyController@getSites');
Route::post('login', 'Config\SecurityController@checklogin');
Route::post('logout', 'Config\SecurityController@logout');
Route::get('/access/securitypage', 'Config\SecurityController@Verified');
Route::get('userprofile', 'Config\UserController@profile');
Route::get('/home/columndef', 'Config\HomeController@Datadef');

Route::get('/home/item', 'Config\HomeController@getItem');
Route::get('/home/reports', 'Config\HomeController@getReport');

Route::get('/access/pageaccess', 'Config\SecurityController@getSecurityForm');

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
    });
    Route::controller(\Setup\DepartmentController::class)->group(function () {
        Route::get('/department', 'index');
        Route::get('/department/get', 'edit');
        Route::delete('/department', 'destroy');
        Route::post('/department', 'store');
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
    Route::get('/inventory/item-group', 'Master\ItemGroupController@index');
    Route::post('/inventory/item-group', 'Master\ItemGroupController@post');
    Route::delete('/inventory/item-group', 'Master\ItemGroupController@delete');
    Route::get('/inventory/item-group/get', 'Master\ItemGroupController@get');
    Route::get('/inventory/item-group/list', 'Master\ItemGroupController@getlist');

    Route::get('/inventory/items', 'Master\ItemsController@index');
    Route::post('/inventory/items', 'Master\ItemsController@post');
    Route::delete('/inventory/items', 'Master\ItemsController@delete');
    Route::get('/inventory/items/get', 'Master\ItemsController@get');
    Route::get('/inventory/items/open', 'Master\ItemsController@open');

    Route::get('/inventory/warehouse', 'Master\WarehouseController@index');
    Route::post('/inventory/warehouse', 'Master\WarehouseController@post');
    Route::delete('/inventory/warehouse', 'Master\WarehouseController@delete');
    Route::get('/inventory/warehouse/get', 'Master\WarehouseController@get');
    Route::get('/inventory/warehouse/list', 'Master\WarehouseController@getlist');


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
Route::group(['prefix' => 'customer-service', 'as' => 'customer-service','middleware'=>'appauth'], function () {
    Route::get('/customer-price', 'CS\CustomerPriceController@index');
    Route::post('/customer-price', 'CS\CustomerPriceController@post');
    Route::delete('/customer-price', 'CS\CustomerPriceController@delete');
    Route::get('/customer-price/get', 'CS\CustomerPriceController@get');
    Route::get('/customer-price/list', 'CS\CustomerPriceController@getlist');
    Route::get('/customer-price/open', 'CS\CustomerPriceController@open');

    Route::get('/order', 'CS\CustomerOrderController@index');
    Route::post('/order', 'CS\CustomerOrderController@post');
    Route::delete('/order/cancel', 'CS\CustomerOrderController@cancel');
    Route::delete('/order', 'CS\CustomerOrderController@delete');
    Route::get('/order/get', 'CS\CustomerOrderController@get');
    Route::get('/order/list', 'CS\CustomerOrderController@getlist');
});

Route::group(['prefix' => 'operation', 'as' => 'operation','middleware'=>'appauth'], function () {
    Route::get('/work-order', 'Operation\OperationController@index');
    Route::post('/work-order', 'Operation\OperationController@post');
    Route::delete('/work-order', 'Operation\OperationController@delete');
    Route::delete('/work-order/cancel', 'Operation\OperationController@cancel');
    Route::get('/work-order/get', 'Operation\OperationController@get');
    Route::get('/work-order/get2', 'Operation\OperationController@get2');
    Route::get('/work-order/get3', 'Operation\OperationController@get3');
    Route::get('/work-order/list', 'Operation\OperationController@getlist');
    Route::get('/work-order/lbo', 'Operation\OperationController@get_lbo');
    Route::post('/work-order/lbo', 'Operation\OperationController@post_lbo');
    Route::post('/work-order/closed-lbo', 'Operation\OperationController@post_closedlbo');
    Route::get('/work-order/print', 'Operation\OperationController@print_sj');
    Route::get('/work-order/lbo/print', 'Operation\OperationController@print_lbo');

    Route::get('/monitoring-unit', 'Operation\MonitoringController@units');
    Route::get('/monitoring-unit-state', 'Operation\MonitoringController@units_state');
    Route::get('/monitoring-unit/operation', 'Operation\MonitoringController@get_operation');
    Route::post('/monitoring-unit/operation', 'Operation\MonitoringController@post_operation');
    Route::get('/monitoring-unit/spj', 'Operation\MonitoringController@spj');
});

Route::group(['prefix' => 'acc', 'as' => 'acc','middleware'=>'appauth'], function () {
    Route::get('/journal', 'Accounting\GLeadgerController@show');
    Route::get('/journal/get', 'Accounting\GLeadgerController@get');
    Route::delete('/journal', 'Accounting\GLeadgerController@destroy');
    Route::get('/journal/print', 'Accounting\GLeadgerController@print');
    Route::post('/journal', 'Accounting\GLeadgerController@post');
    Route::get('/inqjournal', 'Accounting\GLeadgerController@inquery');
    Route::get('/inqjournalxls', 'Accounting\GLeadgerController@inqueryxls');
    Route::get('/generalledger', 'Master\AccountController@GeneralLedger');
    Route::get('/generalledger/report', 'Master\AccountController@GeneralLedgerXLS');
    Route::get('/mutation', 'Master\AccountController@Mutation');
    Route::get('/printgl', 'Accounting\GLeadgerController@Print');
});

Route::group(['prefix' => 'finance', 'as' => 'finance','middleware'=>'appauth'], function () {
    Route::get('/cash_bank', 'Finance\CashBankController@show');
    Route::get('/cash_bank/get', 'Finance\CashBankController@get');
    Route::get('/cash_bank/get2', 'Finance\CashBankController@get2');
    Route::delete('/cash_bank', 'Finance\CashBankController@destroy');
    Route::get('/cash_bank/mutation', 'Finance\CashBankController@mutation');
    Route::get('/cash-bank/balance', 'Finance\CashBankController@state_mutation');
    Route::get('/cash_bank/print', 'Finance\CashBankController@print');
    Route::get('/cash_bank/print2', 'Finance\CashBankController@print2');
    Route::get('/cash_bank/open-lbo', 'Finance\CashBankController@openLBO');
    Route::get('/cash_bank/open-lbo/get', 'Finance\CashBankController@GetLBO');
    Route::get('/cash_bank/lbo', 'Finance\CashBankController@Cashier_LBO');
    Route::post('/cash_bank/lbo', 'Finance\CashBankController@post_LBO');
    Route::post('/cash_bank/cashier_ujo', 'Finance\CashBankController@post_LBO');
    Route::get('/cash_bank/cashier_ujo', 'Finance\CashBankController@get_cashier_ujo');
    Route::get('/cash_bank/cashier_ujo/print', 'Finance\CashBankController@print_lbocashier');
    Route::post('/cash_bank/droping', 'Finance\CashBankController@post_droping');
    Route::get('/cash_bank/droping/open', 'Finance\CashBankController@open_droping');
    Route::post('/cash_bank/droping-receive', 'Finance\CashBankController@post_receive_droping');
    Route::get('/ujo', 'Finance\UJOController@show');
    Route::post('/cash_bank/transaction-out', 'Finance\CashBankController@post_cashbankout');
    Route::post('/cash_bank/transaction-in', 'Finance\CashBankController@post_cashbankin');
    
});
