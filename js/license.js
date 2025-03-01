// license.js

const LicenseManager = {
    storageKey: "AeronioLicense",
    
    generateLicense(domain) {
        const key = btoa(`${domain}-${Date.now()}`);
        return key;
    },
    
    saveLicense(key) {
        localStorage.setItem(this.storageKey, key);
    },
    
    getLicense() {
        return localStorage.getItem(this.storageKey);
    },
    
    validateLicense(key) {
        // Simulación de validación (puede mejorarse con un backend)
        return key && key.length > 10;
    },
    
    isDemoMode() {
        const key = this.getLicense();
        return !this.validateLicense(key);
    }
};

// UI para ingresar licencia
document.addEventListener("DOMContentLoaded", () => {
    const licenseForm = document.getElementById("license-form");
    const licenseInput = document.getElementById("license-key");
    const statusMessage = document.getElementById("status");
    
    if (LicenseManager.isDemoMode()) {
        statusMessage.textContent = "Modo Demo - Algunas funciones están restringidas.";
    } else {
        statusMessage.textContent = "Licencia activa.";
    }

    licenseForm?.addEventListener("submit", (e) => {
        e.preventDefault();
        const key = licenseInput.value.trim();
        if (LicenseManager.validateLicense(key)) {
            LicenseManager.saveLicense(key);
            alert("Licencia guardada correctamente.");
            location.reload();
        } else {
            alert("Licencia no válida.");
        }
    });
});

/*
INSTRUCCIONES DE INTEGRACIÓN:
1. Agrega este script en tu proyecto web enlazándolo en el archivo HTML:
   <script src="license.js"></script>

2. Crea un formulario en tu HTML para ingresar la clave de licencia:
   <form id="license-form">
       <input type="text" id="license-key" placeholder="Introduce tu licencia">
       <button type="submit">Activar</button>
   </form>
   <p id="status"></p>

3. Cuando el usuario ingrese una licencia válida, se almacenará en el localStorage y se recargará la página.
4. Puedes utilizar `LicenseManager.isDemoMode()` para bloquear funciones en modo demo.
*/
