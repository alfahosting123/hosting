// Smooth Scroll untuk Navbar
document.querySelectorAll('nav a').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

// Toggle gambar tugas
function toggleImage(imageId) {
  const image = document.getElementById(imageId);
  if (image.style.display === "none") {
    image.style.display = "block";
  } else {
    image.style.display = "none";
  }
}

// Toggle gambar tugas
function toggleImage(imageId) {
  const image = document.getElementById(imageId);
  if (image.style.display === "none") {
    image.style.display = "block";
  } else {
    image.style.display = "none";
  }
}

// Toggle gambar tugas
function toggleImage(imageId) {
  const image = document.getElementById(imageId);
  if (image.style.display === "none") {
    image.style.display = "block";
  } else {
    image.style.display = "none";
  }
}

// Buka modal untuk zoom gambar
function openModal(imageId) {
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImage');
  const captionText = document.getElementById('caption');
  const downloadLink = document.getElementById('downloadLink');

  // Set gambar yang dipilih ke modal
  modal.style.display = "block";
  modalImg.src = document.getElementById(imageId).src;
  captionText.innerHTML = document.getElementById(imageId).alt;

  // Set link download
  downloadLink.href = document.getElementById(imageId).src;
}

// Tutup modal
function closeModal() {
  const modal = document.getElementById('imageModal');
  modal.style.display = "none";
}

// Tutup modal jika klik di luar gambar
window.onclick = function(event) {
  const modal = document.getElementById('imageModal');
  if (event.target === modal) {
    modal.style.display = "none";
  }
}

// Mencegah salin (copy)
document.addEventListener('copy', function(e) {
  e.preventDefault();
  alert("Fitur salin teks dinonaktifkan di situs ini.");
});

// Mencegah seleksi teks
document.addEventListener('selectstart', function(e) {
  e.preventDefault();
});

const modal = document.getElementById("imgModal");
const modalImg = document.getElementById("modalImage");
const captionText = document.getElementById("caption");

document.querySelectorAll('.task-img').forEach(img => {
  img.addEventListener('click', () => {
    modal.style.display = "block";
    modalImg.src = img.src;
    captionText.innerHTML = img.alt;
  });
});

function closeModal() {
  modal.style.display = "none";
}

window.addEventListener('click', function (e) {
  if (e.target == modal) {
    modal.style.display = "none";
  }
});

function toggleMenu() {
  const navLinks = document.querySelector('.nav-links');
  navLinks.classList.toggle('show');
}
