<x-menu-item icon="gear" text="ddd"
                 :link="($sidebarUserPermissions['manage_company_setting'] == 4 ? route('company-settings.index') : route('profile-settings.index'))">
        <x-slot name="iconPath">
          <!--pisa papel colocal icono de herramientas-->
        </x-slot>
</x-menu-item>