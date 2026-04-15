<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Macuin - Autopartes</title>
    <link rel="icon" href="https://res.cloudinary.com/dpvm2gro2/image/upload/e_negate/v1772562917/1_kj2lq7.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    @stack('styles')
    <style>
        /* Global Loader */
        #global-loader {
            display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
            background: #000; z-index: 9999;
            flex-direction: column; justify-content: center; align-items: center; color: white;
            opacity: 1; transition: opacity 0.4s ease;
        }
        #global-loader.hidden { opacity: 0; pointer-events: none; }
        .loader-percent { font-size: 1.1rem; font-weight: 500; font-family: monospace; letter-spacing: 1px; color: #94A3B8; }
        .loader-bar-container { width: 200px; height: 3px; background: #333; margin-top: 1.5rem; border-radius: 999px; overflow: hidden; }
        #loader-bar { width: 0%; height: 100%; background: #3B82F6; transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Glass Modal Premium */
        #glass-modal, #logout-modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
            background: rgba(0, 0, 0, 0.4); z-index: 10000;
            justify-content: center; align-items: center; 
            backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
            opacity: 0; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #glass-modal.show, #logout-modal.show { opacity: 1; display: flex; }
        .glass-modal-content {
            background: rgba(255, 255, 255, 0.1); /* Glass effect base */
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px; padding: 2.5rem; width: 92%; max-width: 400px;
            text-align: center; color: white; 
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3), inset 0 0 20px rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%);
            transform: scale(0.9) translateY(20px); transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        #glass-modal.show .glass-modal-content, #logout-modal.show .glass-modal-content { transform: scale(1) translateY(0); }
        
        .modal-icon { font-size: 3.5rem; margin-bottom: 1.5rem; display: flex; justify-content: center; }
        .modal-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.75rem; color: white; letter-spacing: -0.5px; }
        .modal-body { font-size: 1rem; color: rgba(255, 255, 255, 0.7); margin-bottom: 2rem; line-height: 1.6; }
        
        .modal-btn { 
            background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); 
            padding: 0.8rem 2rem; border-radius: 14px; cursor: pointer; transition: all 0.3s; 
            font-weight: 700; width: 100%; font-size: 1rem;
        }
        .modal-btn:hover { background: rgba(255, 255, 255, 0.3); transform: translateY(-2px); }
        
        .modal-btn-confirm { background: #3B82F6; border: none; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }
        .modal-btn-confirm:hover { background: #2563EB; box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5); }
        
        .modal-btn-cancel { background: transparent; border: 1px solid rgba(255, 255, 255, 0.2); }
        .modal-btn-cancel:hover { background: rgba(255, 255, 255, 0.1); }
        
        /* Dark Mode Text Fixes */
        body.dark-mode .user-profile { background: var(--bg-light) !important; border-color: var(--border) !important; color: var(--text-main) !important; }
        body.dark-mode .user-profile span { color: var(--text-main) !important; }
        body.dark-mode #user-dropdown-menu { background: var(--card-bg) !important; border-color: var(--border) !important; }
        body.dark-mode #user-dropdown-menu a { color: var(--text-main) !important; border-color: var(--border) !important; }
        body.dark-mode #user-dropdown-menu a[onclick*="showLogoutModal"] { color: #EF4444 !important; }
        body.dark-mode a[href*="/carrito"] { background: var(--bg-light) !important; color: var(--text-main) !important; }
        body.dark-mode label[style*="background: #F1F5F9"] { background: var(--bg-light) !important; color: var(--text-main) !important; }
        
        /* Dark Mode Sidebar Fixes */
        body.dark-mode .sidebar .menu-item.active {
            background: #3B82F6 !important;
            color: #FFFFFF !important;
        }
        body.dark-mode .sidebar .menu-item:hover:not(.active) {
            background: #FFFFFF !important;
            color: #1E293B !important;
        }
    </style>
</head>
<body>
    <div id="global-loader">
        <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772562917/1_kj2lq7.png" alt="Macuin Logo" style="width: 80px; filter: brightness(0) invert(1); margin-bottom: 1.5rem;">
        <div class="loader-percent"><span id="loader-percentage">0</span>%</div>
        <div class="loader-bar-container">
            <div id="loader-bar"></div>
        </div>
    </div>

    <div id="glass-modal">
        <div class="glass-modal-content">
            <div class="modal-icon" id="modal-icon-container">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#F87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div class="modal-title" id="modal-title">Error</div>
            <div class="modal-body" id="modal-body">Mensaje de error</div>
            <div id="modal-actions" style="display: flex; gap: 1rem; width: 100%; justify-content: center;">
                <button class="modal-btn" id="modal-btn" onclick="window.closeModal()" style="flex: 1;">Entendido</button>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de cierre de sesión -->
    <div id="logout-modal">
        <div class="glass-modal-content">
            <div class="modal-icon" style="margin-bottom: 1.5rem;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
            <div class="modal-title" style="color: white; font-size: 1.4rem;">Cerrar sesión</div>
            <div class="modal-body" style="font-size: 1rem; margin-bottom: 2rem;">¿Estás seguro de que deseas salir de tu cuenta de MACUIN?</div>
            <div style="display: flex; gap: 1rem; width: 100%;">
                <button class="modal-btn modal-btn-cancel" onclick="closeLogoutModal()">Cancelar</button>
                <button class="modal-btn modal-btn-confirm" onclick="confirmLogoutAction()">Sí, salir</button>
            </div>
        </div>
    </div>

    @if(!isset($noSidebar))
    <!-- Sidebar -->
    <aside class="sidebar">
        <div style="text-align: center; margin-bottom: 2rem;">
            <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772562917/1_kj2lq7.png" alt="Macuin Logo" style="width: 80px; margin-bottom: 1rem; filter: brightness(0) invert(1);">
            <h2>MACUIN</h2>
            <p style="font-size: 0.8rem; color: #94A3B8;">Autopartes</p>
        </div>
        
        <p style="font-size: 0.75rem; color: #64748B; margin-bottom: 0.5rem; text-transform: uppercase;">Área cliente</p>
        <nav>
            <a href="{{ url('/catalogo') }}" class="menu-item {{ request()->is('catalogo*') || request()->is('producto*') ? 'active' : '' }}">Catálogo</a>
            <a href="{{ url('/carrito') }}" class="menu-item {{ request()->is('carrito*') ? 'active' : '' }}">Carrito / Pago</a>
            <a href="{{ url('/historial') }}" class="menu-item {{ request()->is('historial*') ? 'active' : '' }}">Mis pedidos</a>
            <a href="{{ url('/perfil') }}" class="menu-item {{ request()->is('perfil*') ? 'active' : '' }}">Mi perfil</a>
        </nav>

        <a href="#" onclick="showLogoutModal(event)" class="menu-item logout-btn text-decoration-none" style="margin-top: auto;">Cerrar sesión</a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="header topbar-gsap" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="color: var(--text-muted); font-size: 0.875rem;">
                Portal cliente / <span style="font-weight: 600; color: var(--text-main);">Mi cuenta</span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 1.5rem;">

                <!-- Toggle switch para el modo día/noche -->
                <label style="cursor: pointer; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #F1F5F9; border-radius: 50%;">
                    <input type="checkbox" style="display: none;" onclick="toggleDarkMode()">
                    <span id="theme-icon" style="display: flex; align-items: center; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </span>
                </label>

                <!-- Carrito de pago -->
                <a href="{{ url('/carrito') }}" style="text-decoration: none; position: relative; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #F1F5F9; border-radius: 50%; color: #1E293B;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <span id="cart-badge-count" style="display: none; position: absolute; top: -2px; right: -4px; background: #EF4444; color: white; font-size: 0.65rem; padding: 2px 5px; border-radius: 999px; font-weight: bold;">0</span>
                </a>

                <!-- Dropdown del usuario -->
                <div style="position: relative;">
                    <div class="user-profile" style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem; background: #F8FAFC; padding: 0.3rem 0.5rem 0.3rem 1rem; border-radius: 999px; border: 1px solid #E2E8F0;" onclick="toggleUserDropdown(event)">
                        <span id="nav-user-name" style="font-size: 0.875rem; font-weight: 500;">Cargando...</span>
                        <div id="nav-user-initials" style="width: 28px; height: 28px; border-radius: 50%; background: var(--primary); color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; letter-spacing: 0.5px;">--</div>
                    </div>
                    
                    <div id="user-dropdown-menu" style="display: none; position: absolute; right: 0; top: calc(100% + 10px); background: white; border: 1px solid #E2E8F0; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 150px; overflow: hidden; z-index: 50;">
                        <a href="{{ url('/perfil') }}" style="display: block; padding: 0.75rem 1rem; color: #475569; text-decoration: none; font-size: 0.875rem; border-bottom: 1px solid #F1F5F9;">Mi perfil</a>
                        <a href="#" onclick="showLogoutModal(event)" style="display: block; padding: 0.75rem 1rem; color: #EF4444; text-decoration: none; font-size: 0.875rem; font-weight: 500;">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')
    </main>
    @else
        <!-- Login or Full Page Layout -->
        @yield('content')
    @endif


    <script>
        // Glass Modal functions (global)
        window.showModal = function(title, message, type = 'error', extraBtn = null) {
            const titleEl = document.getElementById('modal-title');
            const iconContainer = document.getElementById('modal-icon-container');
            const btnEl = document.getElementById('modal-btn');
            const actionsContainer = document.getElementById('modal-actions');

            titleEl.innerText = title;
            document.getElementById('modal-body').innerText = message;

            if (type === 'success') {
                iconContainer.innerHTML = `<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`;
                titleEl.style.color = '#10B981';
                btnEl.innerText = 'Aceptar';
                btnEl.style.background = 'rgba(255, 255, 255, 0.1)';
                btnEl.style.color = 'white';
            } else if (type === 'info') {
                iconContainer.innerHTML = `<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>`;
                titleEl.style.color = '#3B82F6';
                btnEl.innerText = 'Entendido';
            } else {
                iconContainer.innerHTML = `<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#F87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>`;
                titleEl.style.color = '#F87171';
                btnEl.innerText = 'Entendido';
            }

            const existingExtra = document.getElementById('modal-extra-btn');
            if (existingExtra) {
                existingExtra.remove();
            }

            if (extraBtn) {
                const addBtn = document.createElement('a');
                addBtn.id = 'modal-extra-btn';
                addBtn.href = extraBtn.url;
                addBtn.innerText = extraBtn.text;
                addBtn.className = 'modal-btn';
                addBtn.style.flex = '1';
                addBtn.style.background = 'var(--primary)';
                addBtn.style.color = 'white';
                addBtn.style.border = 'none';
                addBtn.style.textDecoration = 'none';
                addBtn.style.display = 'flex';
                addBtn.style.alignItems = 'center';
                addBtn.style.justifyContent = 'center';
                
                btnEl.style.flex = '1';
                btnEl.style.background = 'transparent';
                
                addBtn.onclick = function() {
                    window.closeModal();
                };
                
                actionsContainer.appendChild(addBtn);
            } else {
                btnEl.style.flex = '1';
            }

            const modal = document.getElementById('glass-modal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('show'), 10);
        };
        
        window.closeModal = function() {
            const modal = document.getElementById('glass-modal');
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 300);
        };

        window.showLogoutModal = function(e) {
            e.preventDefault();
            const modal = document.getElementById('logout-modal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('show'), 10);
        };

        window.closeLogoutModal = function() {
            const modal = document.getElementById('logout-modal');
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 300);
        };

        window.confirmLogoutAction = function() {
            closeLogoutModal();
            startLoader();
            setTimeout(() => {
                window.location.href = "{{ url('/login') }}";
            }, 300);
        };

        // Real Page-State Loader Logic
        const loader = document.getElementById('global-loader');
        const percentEl = document.getElementById('loader-percentage');
        const barEl = document.getElementById('loader-bar');
        
        let simProgress = 0;
        let loaderInterval;

        function startLoader() {
            loader.style.display = 'flex';
            // Force reflow
            void loader.offsetWidth;
            loader.classList.remove('hidden');
            simProgress = 0;
            updateLoader(0);
            
            clearInterval(loaderInterval);
            loaderInterval = setInterval(() => {
                if (simProgress < 85) { // Never goes to 100 unless page is fully loaded
                    simProgress += Math.random() * 8;
                    updateLoader(simProgress);
                }
            }, 100);
        }

        function completeLoader() {
            clearInterval(loaderInterval);
            updateLoader(100);
            setTimeout(() => {
                loader.classList.add('hidden');
                setTimeout(() => {
                    loader.style.display = 'none';
                    updateLoader(0);
                }, 200); // Reducido de 400ms a 200ms
            }, 100); // Reducido de 300ms a 100ms
        }

        function updateLoader(value) {
            let displayVal = Math.floor(value);
            if (displayVal > 100) displayVal = 100;
            percentEl.textContent = displayVal;
            barEl.style.width = displayVal + '%';
        }

        // Start loader automatically for normal page loads
        startLoader();

        // Update when DOM is ready
        document.addEventListener("DOMContentLoaded", () => {
            simProgress = 80;
            updateLoader(80);
            
            // Fallback mucho más corto por seguridad
            setTimeout(completeLoader, 500); 
        });

        // Complete when all assets are fully loaded
        window.addEventListener("load", completeLoader);

        // Intercept form submissions to show loader
        document.addEventListener('submit', function(e) {
            if (!e.defaultPrevented && !e.target.dataset.intercepted) {
                e.preventDefault();
                startLoader();
                e.target.dataset.intercepted = "true";
                
                setTimeout(() => {
                    e.target.submit();
                }, 50); // Casi instantáneo
            }
        });

        // Intercept internal link clicks to show loader
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (e.defaultPrevented) return; // Prevented by other click handlers, e.g., inline onclicks
            
            if (link && link.href) {
                const isAnchor = link.getAttribute('href') && link.getAttribute('href').startsWith('#');
                if (!link.href.startsWith('javascript:') && !isAnchor && link.target !== '_blank') {
                    e.preventDefault();
                    startLoader();
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 50); // Casi instantáneo
                }
            }
        });
        
        // Hide loader when navigating back via bfcache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) completeLoader();
        });

        // Topbar functions
        function toggleUserDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('user-dropdown-menu');
            menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
        }

        // Close dropdown or modals when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('user-dropdown-menu');
            if (menu && menu.style.display === 'block') {
                menu.style.display = 'none';
            }
            
            const logoutModal = document.getElementById('logout-modal');
            if (e.target === logoutModal && logoutModal.classList.contains('show')) {
                closeLogoutModal();
            }
            
            const glassModal = document.getElementById('glass-modal');
            if (e.target === glassModal && glassModal.classList.contains('show')) {
                closeModal();
            }
        });

        // Lógica de perfil dinámico + verificación de cuenta activa
        document.addEventListener("DOMContentLoaded", async () => {
            const userData = localStorage.getItem('macuin_user');
            if (userData) {
                try {
                    const user = JSON.parse(userData);
                    const nameEl = document.getElementById('nav-user-name');
                    const initialsEl = document.getElementById('nav-user-initials');
                    
                    if (user && user.nombre && nameEl && initialsEl) {
                        nameEl.innerText = user.nombre;
                        const parts = user.nombre.split(' ').filter(p => p.trim() !== '');
                        let initials = '';
                        if (parts.length >= 2) {
                            initials = (parts[0][0] + parts[1][0]).toUpperCase();
                        } else if (parts.length === 1) {
                            initials = parts[0].substring(0, 2).toUpperCase();
                        }
                        initialsEl.innerText = initials;
                    }

                    // Verificar que la cuenta sigue activa en la BD
                    if (user && user.id) {
                        try {
                            const res = await fetch('http://localhost:8008/autenticacion/users');
                            if (res.ok) {
                                const allUsers = await res.json();
                                const freshUser = allUsers.find(u => u.id === user.id);
                                if (freshUser && !freshUser.is_active) {
                                    // El admin desactivó la cuenta → cerrar sesión
                                    localStorage.removeItem('macuin_user');
                                    localStorage.removeItem('macuin_cart');
                                    window.location.href = "{{ url('/login') }}?acceso=denegado";
                                }
                            }
                        } catch(e) {
                            // Si falla la red, no cerrar sesión (beneficio de la duda)
                            console.warn('No se pudo verificar estado de cuenta.');
                        }
                    }
                } catch (e) {
                    console.error("Error leyendo datos del usuario", e);
                }
            } else {
                const nameEl = document.getElementById('nav-user-name');
                const initialsEl = document.getElementById('nav-user-initials');
                if (nameEl) nameEl.innerText = "Invitado";
                if (initialsEl) initialsEl.innerText = "IN";
            }
        });

        // Simple dark mode toggle logic
        function toggleDarkMode() {
            const body = document.body;
            const icon = document.getElementById('theme-icon');
            body.classList.toggle('dark-mode');
            
            const sunIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>`;
            const moonIcon = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>`;
            
            if (body.classList.contains('dark-mode')) {
                icon.innerHTML = sunIcon;
                localStorage.setItem('dark-mode', 'true');
            } else {
                icon.innerHTML = moonIcon;
                localStorage.setItem('dark-mode', 'false');
            }
        }
        
        // Funciones Globales para el Carrito
        window.getCart = function() {
            return JSON.parse(localStorage.getItem('macuin_cart') || '[]');
        };

        window.saveCart = function(cart) {
            localStorage.setItem('macuin_cart', JSON.stringify(cart));
            window.updateCartBadge();
        };

        window.addToCartGlobal = function(product, qty = 1) {
            let cart = window.getCart();
            let index = cart.findIndex(item => item.id == product.id);
            if (index !== -1) {
                cart[index].qty += Math.floor(qty);
            } else {
                product.qty = Math.floor(qty);
                cart.push(product);
            }
            window.saveCart(cart);
        };

        window.updateCartBadge = function() {
            let cart = window.getCart();
            let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
            let badgeEl = document.getElementById('cart-badge-count');
            if (badgeEl) {
                if (totalItems > 0) {
                    badgeEl.innerText = totalItems;
                    badgeEl.style.display = 'block';
                } else {
                    badgeEl.style.display = 'none';
                }
            }
        };

        // Cargar estado de dark mode
        if(localStorage.getItem('dark-mode') === 'true') {
            toggleDarkMode();
            document.querySelector("input[onclick='toggleDarkMode()']").checked = true;
        }

        // Inicializar carrito al cargar la app
        document.addEventListener('DOMContentLoaded', () => {
            window.updateCartBadge();
        });
    </script>
</body>
</html>
