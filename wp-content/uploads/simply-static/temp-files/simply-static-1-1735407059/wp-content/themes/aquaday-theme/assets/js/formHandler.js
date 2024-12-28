// js/FormHandler.js
class FormHandler {
  constructor(formId) {
    this.form = document.getElementById(formId);
    if (this.form) {
      this.init();
    }
  }

  init() {
    this.form.addEventListener('submit', (e) => this.handleSubmit(e));
  }

  async handleSubmit(e) {
    e.preventDefault();

    const formData = new FormData(this.form);

    try {
      const response = await fetch(this.form.action, {
        method: 'POST',
        body: formData
      });

      const data = await response.json();

      if (data.success) {
        this.mostrarMensaje('¡Mensaje enviado con éxito!', 'success');
      } else {
        this.mostrarMensaje('Hubo un error al enviar el mensaje', 'error');
      }
    } catch (error) {
      console.error('Error:', error);
      this.mostrarMensaje('Error de conexión', 'error');
    }
  }

  mostrarMensaje(mensaje, tipo) {
    const mensajeEl = document.createElement('div');
    mensajeEl.className = `mensaje mensaje-${tipo}`;
    mensajeEl.textContent = mensaje;

    this.form.insertAdjacentElement('beforebegin', mensajeEl);

    setTimeout(() => {
      mensajeEl.remove();
    }, 3000);
  }
}

export default FormHandler;