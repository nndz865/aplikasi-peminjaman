    </div>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.modal').forEach(function(modalEl) {
                document.body.appendChild(modalEl);
            });

            const sidebarToggle = document.getElementById('sidebarToggle');
            const appSidebar = document.getElementById('appSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.querySelector('.main-content');
            const navbarTop = document.querySelector('.navbar-top');
            
            function setSidebar(open) {
                if (!appSidebar) return;
                appSidebar.classList.toggle('sidebar-open', open);
                appSidebar.classList.toggle('sidebar-collapsed', open);
                if (sidebarOverlay) sidebarOverlay.classList.toggle('is-visible', open);
                if (sidebarOverlay) sidebarOverlay.setAttribute('aria-hidden', open ? 'false' : 'true');
                if (sidebarToggle) {
                    sidebarToggle.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
                    sidebarToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                }
                document.body.classList.toggle('overflow-hidden', open);
            }

            if (sidebarToggle && appSidebar) {
                sidebarToggle.addEventListener('click', function() {
                    setSidebar(!appSidebar.classList.contains('sidebar-open'));
                });
                if (sidebarOverlay) sidebarOverlay.addEventListener('click', function() { setSidebar(false); });
                appSidebar.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() { setSidebar(false); });
                });
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') setSidebar(false);
                });
            }

            document.querySelectorAll('input[type="password"]').forEach(function(input) {
                let wrapper = input.parentElement;
                if (!wrapper.classList.contains('input-group')) {
                    wrapper = document.createElement('div');
                    wrapper.className = 'input-group';
                    input.parentNode.insertBefore(wrapper, input);
                    wrapper.appendChild(input);
                }
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'btn btn-outline-secondary';
                button.setAttribute('aria-label', 'Tampilkan password');
                button.innerHTML = '<i class="bi bi-eye"></i>';
                button.addEventListener('click', function() {
                    const visible = input.type === 'text';
                    input.type = visible ? 'password' : 'text';
                    button.setAttribute('aria-label', visible ? 'Tampilkan password' : 'Sembunyikan password');
                    button.innerHTML = visible ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
                });
                wrapper.appendChild(button);
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



