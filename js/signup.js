// signup.js - Validation simple (simulation)

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('signupForm');
  if (!form) return;

  const msg = document.getElementById('message');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    msg.textContent = '';

    const pseudo = document.getElementById('pseudo').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!pseudo || !email || !password) {
      msg.style.color = 'crimson';
      msg.textContent = '⚠️ Tous les champs sont obligatoires.';
      return;
    }

    if (password.length < 8) {
      msg.style.color = 'crimson';
      msg.textContent = '⚠️ Le mot de passe doit contenir au moins 8 caractères.';
      return;
    }

    if (!email.includes('@')) {
      msg.style.color = 'crimson';
      msg.textContent = '⚠️ Veuillez entrer une adresse email valide.';
      return;
    }

    // Simulation : pas de sauvegarde côté back
    msg.style.color = 'green';
    msg.textContent = '✅ Compte créé avec succès (simulation).';

    // Exemple : redirection après 1.2s
    // setTimeout(() => window.location.href = 'login.html', 1200);
  });
});
