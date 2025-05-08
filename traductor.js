const key = "62HkFjFgVyzqTROujhufoPujQ1TZoqzbmRoauRoP03t0SCSZH00dJQQJ99BEACLArgHXJ3w3AAAbACOGwckh";
const endpoint = "https://api.cognitive.microsofttranslator.com/";
const region = "southcentralus";

// Función para traducir un texto individual
async function traducirTexto(texto, from, to) {
  const url = `${endpoint}translate?api-version=3.0&from=${from}&to=${to}`;

  const respuesta = await fetch(url, {
    method: "POST",
    headers: {
      "Ocp-Apim-Subscription-Key": key,
      "Ocp-Apim-Subscription-Region": region,
      "Content-Type": "application/json"
    },
    body: JSON.stringify([{ Text: texto }])
  });

  const datos = await respuesta.json();
  return datos[0].translations[0].text;
}

// Lista de IDs a traducir
const ids = [
  "navInicio", "navAcercaDe", "navBlog", "navCategoria1", "navCategoria2",
  "navCategoria3", "navCategoria4", 
  "parrafoDipsy", "tituloMetas", "tituloMision", "parrafoMision",
  "tituloVision", "parrafoVision", "tituloObjectivo", "parrafoObjectivo",
  "tituloHistoria", "parrafoHistoria", "parrafoFooter"
];

// Diccionario para guardar el contenido original (en español)
const originalES = {};

window.addEventListener("DOMContentLoaded", () => {
  ids.forEach(id => {
    const elemento = document.getElementById(id);
    if (elemento) {
      originalES[id] = elemento.textContent; // Guardar texto original en español
    }
  });
});

// Función para traducir todo el contenido
async function traducirContenido(from, to) {
  for (const id of ids) {
    const elemento = document.getElementById(id);
    if (elemento) {
      const textoOriginal = (from === "es") ? elemento.textContent : originalES[id];
      const textoTraducido = await traducirTexto(textoOriginal, from, to);
      elemento.textContent = textoTraducido;
    }
  }
}



  