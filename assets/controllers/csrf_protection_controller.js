// Expresiones regulares para validar el nombre y el token CSRF
var nameCheck = /^[-_a-zA-Z0-9]{4,22}$/;
var tokenCheck = /^[-_/+a-zA-Z0-9]{24,}$/;

// Generar y enviar un token CSRF en un campo de formulario y una cookie, según lo definido por SameOriginCsrfTokenManager de Symfony
document.addEventListener('submit', function (event) {
    var csrfField = event.target.querySelector('input[data-controller="csrf-protection"]');

    if (!csrfField) {
        return;
    }

    var csrfCookie = csrfField.getAttribute('data-csrf-protection-cookie-value');
    var csrfToken = csrfField.value;

    // Si no hay cookie CSRF y el token es válido, generar un nuevo token y establecerlo en la cookie y el campo del formulario
    if (!csrfCookie && nameCheck.test(csrfToken)) {
        csrfField.setAttribute('data-csrf-protection-cookie-value', csrfCookie = csrfToken);
        csrfField.value = csrfToken = btoa(String.fromCharCode.apply(null, (window.crypto || window.msCrypto).getRandomValues(new Uint8Array(18))));
    }

    // Si hay cookie CSRF y el token es válido, establecer la cookie con el token CSRF
    if (csrfCookie && tokenCheck.test(csrfToken)) {
        var cookie = csrfCookie + '_' + csrfToken + '=' + csrfCookie + '; path=/; samesite=strict';
        document.cookie = window.location.protocol === 'https:' ? '__Host-' + cookie + '; secure' : cookie;
    }
});

// Cuando @hotwired/turbo maneja envíos de formularios, enviar el token CSRF en un encabezado además de una cookie
// La opción de configuración `framework.csrf_protection.check_header` debe estar habilitada para que se verifique el encabezado
document.addEventListener('turbo:submit-start', function (event) {
    var csrfField = event.detail.formSubmission.formElement.querySelector('input[data-controller="csrf-protection"]');

    if (!csrfField) {
        return;
    }

    var csrfCookie = csrfField.getAttribute('data-csrf-protection-cookie-value');

    // Si el token y la cookie son válidos, agregar el token CSRF al encabezado de la solicitud
    if (tokenCheck.test(csrfField.value) && nameCheck.test(csrfCookie)) {
        event.detail.formSubmission.fetchRequest.headers[csrfCookie] = csrfField.value;
    }
});

// Cuando @hotwired/turbo maneja envíos de formularios, eliminar la cookie CSRF una vez que se haya enviado un formulario
document.addEventListener('turbo:submit-end', function (event) {
    var csrfField = event.detail.formSubmission.formElement.querySelector('input[data-controller="csrf-protection"]');

    if (!csrfField) {
        return;
    }

    var csrfCookie = csrfField.getAttribute('data-csrf-protection-cookie-value');

    // Si el token y la cookie son válidos, eliminar la cookie CSRF
    if (tokenCheck.test(csrfField.value) && nameCheck.test(csrfCookie)) {
        var cookie = csrfCookie + '_' + csrfField.value + '=0; path=/; samesite=strict; max-age=0';

        document.cookie = window.location.protocol === 'https:' ? '__Host-' + cookie + '; secure' : cookie;
    }
});

/* stimulusFetch: 'lazy' */
export default 'csrf-protection-controller';
