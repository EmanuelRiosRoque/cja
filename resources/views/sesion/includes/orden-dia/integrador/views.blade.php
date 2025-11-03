{{--
** 1 = Ver
** 2 = Cargar Documentos
** 3 = Editar
** 4 = Finalizar
--}}
<div class="flex item-center justify-center">
    <a href="{{ route('sesion.temas', $sesion) }}" class="w-4 mr-2 transform hover:text-emerald-500 hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <circle cx="11" cy="11" r="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35" />
        </svg>
    </a>

    <a href="{{ route('sesion.adjuntar', $sesion) }}" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 15c1.5-3 3.5-6 6-9m0 9c-1.5-1-3-1.5-4.5-1.5m4.5 1.5c.5-.5 1.5-1.5 2-2.5" />
        </svg>
    </a>

    <a href="{{ route('sesion.ordenDia', $sesion)  }}" class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
    </a>

    <a href="{{ route('sesion.ponencia', $sesion)  }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 21h10a2 2 0 002-2V9l-6-6H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3v6h6" />
        </svg>
    </a>
</div>