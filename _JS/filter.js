document.getElementById('product-filter').addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  const params = new URLSearchParams(formData).toString();
  window.location.href = `?${params}`;
});
