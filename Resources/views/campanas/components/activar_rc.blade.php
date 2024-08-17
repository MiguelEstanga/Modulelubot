<div id="container_codigo_rc" class="alert" style="display: none;">
    <div class="__container-action">
        @include('lubot::campanas.components.conde_rc_verficacion')
        <div id="cerrar" class="cerrar">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle-fill"
                viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
            </svg>
        </div>
        <div id="conten_loader_rc" class="conten_loader_rc" style="display: none;">
            <div class="loader"></div>
        </div>
        <div class="contenedor_action_center row">
            <div class="logo" class="logo">
                <img src="{{ $logo }}" alt="">
            </div>
            <div class="code_rc_">
                <h2 class="fuente-titulo-xdefecto">
                    Te enviamos una notificación
                </h2>
                <p class="text-layout">
                    Con esta segunda verificación estamos listos!
                </p>
                <div id="_codigo_rc">

                </div>
            </div>

        </div>

    </div>
</div>

<style>
    .cerrar{
        z-index: 20;
    }
    .__container-action {

        position: relative;
        width: 757px;
        height: 251px;
        border-radius: 10px;
        background: #fff;
        transition: all linear 300ms;
        display: flex;
        justify-content: center;
        gap: 30px;
        align-items: center;
    }

    .code_rc_ {
        position: relative;
        top: -20px;
        left: 30px;
        width: 80%;
        display: flex;
        justify-content: center;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
    }

    .conten_loader_rc {
        padding: 10px;
        background: var(--color-primario-text);
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10px;
    }
</style>
<script>
    
</script>