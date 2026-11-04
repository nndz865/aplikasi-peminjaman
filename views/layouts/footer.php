    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.modal').forEach(function(modalEl) {
                document.body.appendChild(modalEl);
            });

            // Prevent double submission / double click on all forms
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    if (form.dataset.submitted === 'true') {
                        e.preventDefault();
                        return false;
                    }
                    form.dataset.submitted = 'true';
                    
                    // Disable submit buttons inside the form
                    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function(btn) {
                        btn.disabled = true;
                        let originalText = btn.innerHTML || btn.value;
                        if (btn.tagName === 'BUTTON') {
                            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...';
                        } else {
                            btn.value = 'Memproses...';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>



