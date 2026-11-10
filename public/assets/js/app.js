'use strict';
(() => {
  const menuButton = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  if (menuButton && nav) {
    menuButton.addEventListener('click', () => {
      const opened = nav.classList.toggle('is-open');
      menuButton.setAttribute('aria-expanded', String(opened));
      menuButton.setAttribute('aria-label', opened ? 'Cerrar menú' : 'Abrir menú');
    });
    nav.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
      nav.classList.remove('is-open');
      menuButton.setAttribute('aria-expanded', 'false');
    }));
  }

  const form = document.getElementById('config-form');
  if (!form) return;
  const quoteItems = document.getElementById('quote-items');
  const quoteTotal = document.getElementById('quote-total');
  const quoteCount = document.getElementById('quote-count');
  const quoteComplete = document.getElementById('quote-complete');
  const quoteBar = document.getElementById('quote-bar');
  const required = ['body', 'engine', 'paint', 'doors', 'wheels', 'drive'];
  const names = { body: 'Carrocería', engine: 'Motor', paint: 'Pintura', doors: 'Puertas', wheels: 'Ruedas', drive: 'Tracción', accessory: 'Accesorios' };
  const euros = (cents) => (cents / 100).toLocaleString('es-ES', { style: 'currency', currency: 'EUR' });
  // La vista previa es informativa; el precio definitivo se calcula en el servidor.
  const refresh = () => {
    const selected = Array.from(form.querySelectorAll('input[data-price]:checked'));
    const cents = selected.reduce((total, field) => total + Math.round(Number(field.dataset.price) * 100), 0);
    const filled = required.filter((category) => form.querySelector(`input[name="${category}"]:checked`)).length;
    quoteItems.replaceChildren();
    if (!selected.length) {
      const message = document.createElement('p');
      message.textContent = 'Selecciona piezas para construir tu coche.';
      quoteItems.append(message);
    } else {
      selected.forEach((field) => {
        const line = document.createElement('div');
        line.className = 'quote-line';
        const description = document.createElement('span');
        const kind = field.name === 'accessory[]' ? 'accessory' : field.name;
        description.textContent = `${names[kind]} · ${field.dataset.label}`;
        const price = document.createElement('strong');
        price.textContent = euros(Math.round(Number(field.dataset.price) * 100));
        line.append(description, price);
        quoteItems.append(line);
      });
    }
    quoteTotal.textContent = euros(cents);
    quoteCount.textContent = `${filled} de ${required.length} apartados`;
    quoteComplete.textContent = filled === required.length ? 'Listo para guardar' : 'Por configurar';
    quoteBar.style.width = `${Math.round(filled / required.length * 100)}%`;
  };
  form.addEventListener('change', refresh);
  refresh();
})();
