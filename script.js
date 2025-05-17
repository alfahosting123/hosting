document.getElementById("reportForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('php/send_email.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(result => {
    document.getElementById("formResponse").textContent = result;
    this.reset();
  })
  .catch(error => {
    document.getElementById("formResponse").textContent = "Terjadi kesalahan. Silakan coba lagi.";
  });
});

// Mencegah salin (copy)
document.addEventListener('copy', function(e) {
  e.preventDefault();
  alert("Fitur salin teks dinonaktifkan di situs ini.");
});

// Mencegah klik kanan
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
  alert("Klik kanan dinonaktifkan.");
});

// Opsional: Mencegah seleksi teks (blok)
document.addEventListener('selectstart', function(e) {
  e.preventDefault();
});


<script>
  const backgroundImageInput = document.getElementById('backgroundImage');
  const heroSection = document.querySelector('.hero');

  backgroundImageInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        heroSection.style.backgroundImage = `url(${e.target.result})`;
      };
      reader.readAsDataURL(file);
    }
  });
</script>
