    <?php
        /**
         * Renderiza la barra de navegación con soporte para elementos dinámicos incluyendo dropdowns
         * 
         * @param array $navItems Array de elementos de navegación con posibles dropdowns
         * @param object $sessionManager Gestor de sesión con información del usuario
         * 
         * Formato de $navItems:
         * [
         *   [
         *     'label' => 'Texto del enlace',
         *     'href' => 'ruta/del/enlace',
         *     'active' => true|false,
         *     'disabled' => true|false,
         *     'icon' => '<svg>...</svg>' (opcional),
         *     'dropdown' => [ // opcional para crear un dropdown
         *       [
         *         'label' => 'Elemento del dropdown',
         *         'href' => 'ruta/del/enlace',
         *         'icon' => '<svg>...</svg>' (opcional),
         *         'divider' => true|false (opcional),
         *         'dropdown' => [...] // para dropdowns anidados
         *       ],
         *       // más elementos...
         *     ]
         *   ],
         *   // más elementos...
         * ]
         */
        function renderNavbar($navItems, $sessionManager) {
        ?>
        <!-- Navegación usando Bootstrap 5 -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top shadow" style="margin-top: 5.1rem;">
            <div class="container-sm">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <?php renderNavItems($navItems); ?>
                    </ul>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>	
                                <span class="ms-2">
                                    <?= htmlspecialchars($sessionManager->getUsuario()->getUserName()); ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="#">Perfil</a></li>
                                <li><a class="dropdown-item" href="#">Firma Digital</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="nav-item">
                                    <form action="../DB/logout.php" method="POST">
                                        <button type="submit" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                                            </svg>
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
        }
    
        /**
         * Función recursiva para renderizar elementos de navegación y sus dropdowns
         * 
         * @param array $items Elementos a renderizar
         * @param int $level Nivel de anidación (0 para el nivel principal)
         */
        function renderNavItems($items, $level = 0) {
            foreach ($items as $item):
                // Verificar si es un dropdown
                $hasDropdown = !empty($item['dropdown']) && is_array($item['dropdown']);
                
                // Clase para el elemento li
                $liClass = 'nav-item';
                if ($hasDropdown) {
                    $liClass .= $level > 0 ? ' dropend' : ' dropdown';
                }
                ?>
                <li class="<?= $liClass ?>">
                    <?php if ($hasDropdown): ?>
                        <a class="nav-link dropdown-toggle<?php 
                            if (!empty($item['active'])) echo ' active';
                            if (!empty($item['disabled'])) echo ' disabled';
                        ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        <?php if (!empty($item['disabled'])): ?>tabindex="-1" aria-disabled="true"<?php endif; ?>>
                            <?php if (!empty($item['icon'])): ?>
                                <?= $item['icon'] ?>
                                <span class="ms-2">
                            <?php endif; ?>
                            
                            <?= htmlspecialchars($item['label']) ?>
                            
                            <?php if (!empty($item['icon'])): ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark<?= $level > 0 ? '' : ' ' ?> shadow">
                            <?php foreach ($item['dropdown'] as $subItem): ?>
                                <?php if (!empty($subItem['divider'])): ?>
                                    <li><hr class="dropdown-divider"></li>
                                <?php elseif (!empty($subItem['dropdown'])): ?>
                                    <?php 
                                        // Caso especial: submenu anidado
                                        renderNavItems([$subItem], $level + 1);
                                    ?>
                                <?php else: ?>
                                    <li>
                                        <a class="dropdown-item<?php if (!empty($subItem['active'])) echo ' active'; ?>" href="<?= htmlspecialchars($subItem['href'] ?? '#') ?>">
                                            <?php if (!empty($subItem['icon'])): ?>
                                                <?= $subItem['icon'] ?>
                                                <span class="ms-2"><?= htmlspecialchars($subItem['label']) ?></span>
                                            <?php else: ?>
                                                <?= htmlspecialchars($subItem['label']) ?>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <a class="nav-link<?php 
                            if (!empty($item['active'])) echo ' active';
                            if (!empty($item['disabled'])) echo ' disabled';
                        ?>" 
                        <?php if (!empty($item['disabled'])): ?>tabindex="-1" aria-disabled="true"<?php endif; ?>
                        href="<?= htmlspecialchars($item['href']) ?>">
                            <?php if (!empty($item['icon'])): ?>
                                <?= $item['icon'] ?>
                                <span class="ms-2"><?= htmlspecialchars($item['label']) ?></span>
                            <?php else: ?>
                                <?= htmlspecialchars($item['label']) ?>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach;
        }
        ?>