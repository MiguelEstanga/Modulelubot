<div class="mobile-close-overlay w-100 h-100" id="close-settings-overlay"></div>
<div class="settings-sidebar bg-white py-3" id="mob-settings-sidebar">
    <ul class="settings-menu" id="settingsMenu">
        <div class="container">
            <a class="btn btn-success" id="lubot_test" >
                lubot Text
            </a>
        </div>
        <x-setting-menu-item active="swsqwsq" menu="company_settings" :href="route('lubot.admin')" text="Activacion" />
        <x-setting-menu-item active="campanas.index" menu="company_settings" :href="route('campanas.index')" text="seleccion de semento" />
        <x-setting-menu-item active="campanas.index" menu="company_settings" :href="route('ver_campanas.todas')" text="Campañas" />
      
   </ul>
   <script>
 

</script>

</div>

</div>
