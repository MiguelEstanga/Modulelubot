@php
    use  App\Models\Company;
    $company = Company::find(user()->company_id);
    $paquete = json_decode($company->package['module_in_package'] , true);   
    $indice = array_search("Lubot", $paquete);
@endphp
@if ( in_array('admin', user_roles())  && $indice )
    <x-setting-menu-item :active="$activeMenu" menu="lubot_settings" :href="route('lubot.settings')"
                         text="Configuracion de lubot"/>
@endif
