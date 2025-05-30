const key = "8EDxuMQ2suon0743sdi1QgDdLd5kLmHRd9heRu8u4kwC0QZBYFaRJQQJ99BEACLArgHXJ3w3AAAbACOGF1VQ";
const endpoint = "https://api.cognitive.microsofttranslator.com/";
const region = "southcentralus";

// Elementos a traducir
const elementosATraducir = {
  ids: [
    "homel", "aboutl", "blogl", "loginn", "search",
    "navCategoria1", "navCategoria2", "navCategoria3", "navCategoria4",
    "homel", "aboutl", "blogl", "loginn", "search", "navCategoria1", "navCategoria2",
    "navCategoria3", "navCategoria4", "parrafoDipsy", "tituloMetas", "tituloMision",
    "parrafoMision", "tituloVision", "parrafoVision", "tituloObjectivo", "parrafoObjectivo",
    "tituloHistoria", "parrafoHistoria", "parrafoFooter", "enlaces", "iniciofo",
    "nosotrosfo", "blogfo", "redessocial", "contacto", "correo", 
    "titulopublicacion1", "resumenpublicacion1", "comentarios",
    "cerrarSesion", "barracolor", "login", "welcome", "passaword", "login3",
    "registrer", "register2", "hola", "notaccount", "register3", "welcomeBack",
    "haveaccount", "login2", "publicacion","tituloPublicacionesRecientes", "tituloUltimasPublicaciones", "tituloPublicacionesRecomendadas" , "tituloCarousel1", "parrafoCarousel1",
    "tituloCarousel2", "parrafoCarousel2", "tituloCarousel3", "parrafoCarousel3", 
    "tituloCarousel4", "parrafoCarousel4", "tituloEcosistemas", "parrafoEcosistemas",
    "tituloContaminacionMarina", "parrafoContaminacionMarina", "tituloPescaSostenible",
    "parrafoPescaSostenible", "tituloEducacionOceanica", "parrafoEducacionOceanica",
    "tituloDescubreMas", "tituloSumate", "parrafoSumate", "botonSumate", "leer", "textopubli", "referencias","tituloComentarios", 
    "tituloReferencias", "titulo", "tituloComentarios", "comentariosPublicacion", "iconoComentarios", "textoVerComentarios", "tituloUltimasPublicaciones",
    "tituloEstadisticas", "parrafoEstadisticas", "h411", "parrafo411", "parrafo412", "idecada", "parrafo413", "parrafo414", 
  ],
  selectores: [
    '.textoblog', '.resumenpublicacion', '.titulopublicacion',
    '.publicacion_tarjeta .titulo_tarjeta', 
    '.publicacion_tarjeta .resumen_tarjeta',
    '.referenciass li:not(:has(a))',
    
    // Selectores para publicaciones en tarjetas
    '.publicacion_car .titulo_tarjeta',
    '.publicacion_car .resumen_tarjeta',
    '.publicacion_car .categoria_tarjetaa',
    // Selectores para publicaciones en lista
    '.publicacion .titulop',
    '.publicacion .resumen',
    '.publicacion .categoriap',
    // Selectores para categorías
    '.tarjetascat .card-title',
    '.tarjetascat .card-text',
    '.btn-primary', "bi bi-eye"// Todos los botones con clase btn-primary
    
    
      // ... otros selectores existentes ...
    ,'.categoria', // Añade este selector
     
    
  ],
  textosDinamicos: [
    'Leer más' // Texto del botón que también debe traducirse
  ]
};




// Cache y textos originales
let traduccionesCache = {};
const originalES = {};

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
  // Cargar caché
  traduccionesCache = JSON.parse(localStorage.getItem('traduccionesCache')) || {};
  
  // Guardar textos originales
  elementosATraducir.ids.forEach(id => {
    const elemento = document.getElementById(id);
    if (elemento) originalES[id] = elemento.textContent;
  });
  
  // Configurar botón de idioma
  const bandera = document.getElementById('banderaIdioma');
  if (bandera) {
    bandera.addEventListener('click', cambiarIdioma);
  }
  
  // Verificar idioma guardado
  const idiomaGuardado = localStorage.getItem('idiomaPreferido');
  if (idiomaGuardado === 'en') {
    traducirContenido('es', 'en');
  }
});

// Función para traducir texto
async function traducirTexto(texto, from, to) {
  if (!texto || /^(https?:\/\/|www\.|\d+)/i.test(texto)) return texto;
  
  const cacheKey = `${from}-${to}-${texto}`;
  if (traduccionesCache[cacheKey]) return traduccionesCache[cacheKey];
  
  try {
    const response = await fetch(`${endpoint}/translate?api-version=3.0&from=${from}&to=${to}`, {
      method: "POST",
      headers: {
        "Ocp-Apim-Subscription-Key": key,
        "Ocp-Apim-Subscription-Region": region,
        "Content-Type": "application/json"
      },
      body: JSON.stringify([{ Text: texto }])
    });
    
    if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
    
    const data = await response.json();
    const resultado = data[0].translations[0].text;
    
    // Actualizar caché
    traduccionesCache[cacheKey] = resultado;
    localStorage.setItem('traduccionesCache', JSON.stringify(traduccionesCache));
    
    return resultado;
  } catch (error) {
    console.error("Error en traducción:", error);
    return texto;
  }
}

// Función principal de traducción
async function traducirContenido(from, to) {
  console.log(`Iniciando traducción de ${from} a ${to}`);
  
  // Traducir elementos por ID
  for (const id of elementosATraducir.ids) {
    const elemento = document.getElementById(id);
    if (!elemento) continue;
    
    const textoOriginal = from === "es" ? originalES[id] || elemento.textContent : elemento.textContent;
    elemento.textContent = await traducirTexto(textoOriginal, from, to);
  }
  
  // Traducir elementos por selector
  for (const selector of elementosATraducir.selectores) {
    const elementos = document.querySelectorAll(selector);
    for (const elemento of elementos) {
      elemento.textContent = await traducirTexto(elemento.textContent, from, to);
    }
  }
  
  // Actualizar bandera e idioma preferido
  const bandera = document.getElementById('banderaIdioma');
  if (bandera) {
    bandera.src = to === "en" ? "img/reino-unido.png" : "img/espana.png";
    localStorage.setItem('idiomaPreferido', to);
  }
  
  console.log("Traducción completada");
}

// Cambiar idioma
function cambiarIdioma() {
  const bandera = document.getElementById('banderaIdioma');
  if (!bandera) return;
  
  const currentLang = bandera.src.includes('reino-unido') ? 'en' : 'es';
  const newLang = currentLang === 'es' ? 'en' : 'es';
  
  traducirContenido(currentLang, newLang);
}