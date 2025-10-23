<style>
  /* Contenedor principal con fondo */
  .bg-ripple {
    position: relative;
    min-height: 100vh;
    background: #fff;
    overflow: hidden;
  }

  /* ==== CÍRCULOS ANIMADOS ==== */
  .circle {
    position: absolute;
    border-radius: 50%;
    background: #005a50;
    animation: ripple 15s infinite;
    box-shadow: 0px 0px 1px 0px #009382;
    z-index: 0;
  }

  /* Tamaños y posición inferior izquierda */
  .small { width: 200px; height: 200px; left: -100px; bottom: -100px; }
  .medium { width: 400px; height: 400px; left: -200px; bottom: -200px; }
  .large { width: 600px; height: 600px; left: -300px; bottom: -300px; }
  .xlarge { width: 800px; height: 800px; left: -400px; bottom: -400px; }
  .xxlarge { width: 1000px; height: 1000px; left: -500px; bottom: -500px; }

  /* Sombras y transparencias */
  .shade1 { opacity: 0.15; }
  .shade2 { opacity: 0.3; }
  .shade3 { opacity: 0.45; }
  .shade4 { opacity: 0.6; }
  .shade5 { opacity: 0.75; }

  /* Animación */
  @keyframes ripple {
    0%   { transform: scale(0.8); }
    50%  { transform: scale(1.2); }
    100% { transform: scale(0.8); }
  }
</style>

<!-- === CONTENEDOR PRINCIPAL === -->
<div class="bg-ripple flex justify-center items-center">
    <!-- === CÍRCULOS ANIMADOS === -->
    <div class="circle small shade1"></div>
    <div class="circle medium shade2"></div>
    <div class="circle large shade3"></div>
    <div class="circle xlarge shade4"></div>
    <div class="circle xxlarge shade5"></div>

    <!-- === CONTENIDO DEL LOGIN === -->
    <div class="relative z-10 flex flex-row justify-center items-center gap-10">
        <!-- Imagen lateral -->
        <div class="flex justify-center items-center">
            <img src="{{ asset('src/img/auth/pleno.png') }}" 
                 alt="imagen pleno" 
                 class="object-contain max-h-[480px] drop-shadow-lg">
        </div>

        <!-- Contenedor del login -->
        <div class="flex flex-col justify-center items-center w-96">
            <div class="mb-4">
                {{ $logo }}
            </div>

            <div class="w-full sm:max-w-md px-6 py-6 bg-white/95 shadow-lg rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
