@if ( in_array('admin', user_roles()))
    <x-setting-menu-item :active="$activeMenu" menu="lubot_settings" :href="route('lubot.settings')"
                         text="configuracion de lubot"/>
@endif
