<?php

namespace Modules\Lubot\Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LubotDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $this->call("OthersTableSeeder");

          
            Schema::create('Lubot', function ($table) {
                $table->id();
                $table->string('estado')->default(0);
            });
            Schema::create('Lubot', function ($table) {
                $table->id();
                $table->string('estado')->default(0);
            });
      
         /***     
        $companias = DB::table('companies')->pluck('id');

        // Obtener los IDs de las compañías que ya tienen un registro en custom_link_settings
        $companiasConLinks = DB::table('custom_link_settings')->whereIn('company_id', $companias)->pluck('company_id');
        
        // Filtrar las compañías que no tienen un registro en custom_link_settings
        $companiasSinLinks = $companias->diff($companiasConLinks);
        
        // Preparar los datos para la inserción
        $dataToInsert = $companiasSinLinks->map(function ($id) {
            return [
                'company_id' => $id,
                'link_title' => "Lubut",
                'url' => env('APP_URL').'/lubot/activacion',
                'can_be_viewed_by' => '[1,2,3,4,5,6,7,8,9]',
                'status' => 'active'
            ];
        })->toArray();
        
        // Insertar los datos en la base de datos si hay compañías sin links
        if (!empty($dataToInsert)) {
            DB::table('custom_link_settings')->insert($dataToInsert);
        }
       */
            
            

           
       
       
            $module = Module::create([
                'module_name' => 'Lubot',
                'description' => 'Lubot gestor de empresas',
            ]);

            // Permisos
            $permissionAdmin = Permission::create([
                'name' => 'lubot_admin',
                'display_name' => 'View Lubot Admin',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "none":5}'
            ]);

            $permissionFranchise = Permission::create([
                'name' => 'lubot_permission', 
                'display_name' => 'View Lubot Franchise',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "none":5}'
            ]);

            // Roles
            $role_admin = Role::where('name', 'admin')->where('company_id', 2)->first();
            $role_client = Role::where('name', 'client')->where('company_id', 2)->first();

            // Asignar permisos a roles
            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permissionAdmin->id,
                'permission_type_id' => 5
            ]);

            $permission_role_franchise = PermissionRole::create([
                'role_id' => $role_client->id,
                'permission_id' => $permissionFranchise->id,
                'permission_type_id' => 5
            ]);


            //Informacion General

            $permissionAdmin = Permission::create([
                'name' => 'view_general_information',
                'display_name' => 'View General Information',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "none":5}'
            ]);

            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permissionAdmin->id,
                'permission_type_id' => 5
            ]);


            //Wallet

            $permissionAdmin = Permission::create([
                'name' => 'view_wallet',
                'display_name' => 'View Wallet',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "none":5}'
            ]);

            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_client->id,
                'permission_id' => $permissionAdmin->id,
                'permission_type_id' => 5
            ]);


            // Payments Seller

            $permissionPaymentSeller = Permission::create([
                'name' => 'view_payments_seller',
                'display_name' => 'View Payments Seller',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "none":5}'
            ]);

            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permissionPaymentSeller->id,
                'permission_type_id' => 5
            ]);

            $permissionAddPaymentSeller = Permission::create([
                'name' => 'add_payments_seller',
                'display_name' => 'Add Payments Seller',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "none":5}'
            ]);

            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permissionAddPaymentSeller->id,
                'permission_type_id' => 5
            ]);

            $permissionEditPaymentSeller = Permission::create([
                'name' => 'edit_payments_seller',
                'display_name' => 'Edit Payments Seller',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "added":1, "owned":2,"both":3, "none":5}'
            ]);

            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permissionEditPaymentSeller->id,
                'permission_type_id' => 5
            ]);
            
            $permissionDeletePaymentSeller = Permission::create([
                'name' => 'delete_payments_seller',
                'display_name' => 'Delete Payments Seller',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "added":1, "owned":2,"both":3, "none":5}'
            ]);

            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permissionDeletePaymentSeller->id,
                'permission_type_id' => 5
            ]);

            // Saldo en Carteras

            $permissionSaldoInWallets = Permission::create([
                'name' => 'view_saldo_in_wallets',
                'display_name' => 'View Saldo in Wallets',
                'module_id' => $module->id,
                'is_custom' => 0,
                'allowed_permissions' => '{"all":4, "none":5}'
            ]);

            $permission_role_admin = PermissionRole::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permissionSaldoInWallets->id,
                'permission_type_id' => 5
            ]);
        
         
    }
}
