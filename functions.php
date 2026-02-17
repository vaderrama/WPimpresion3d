<?php
// ===========================================
// ENQUEUE STYLES
// ===========================================
add_action('wp_enqueue_scripts', function() {
    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();

    wp_enqueue_style('astra-parent', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('astra-child', get_stylesheet_uri(), ['astra-parent']);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    $footer_css = $theme_dir . '/assets/css/footer.css';
    wp_enqueue_style('ti3d-footer', $theme_uri . '/assets/css/footer.css', ['astra-child'], file_exists($footer_css) ? filemtime($footer_css) : null);

    if (function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout())) {
        $store_css = $theme_dir . '/assets/css/store.css';
        wp_enqueue_style('ti3d-store', $theme_uri . '/assets/css/store.css', ['astra-child'], file_exists($store_css) ? filemtime($store_css) : null);
    }

    if (is_page_template('template-home.php')) {
        $home_css = $theme_dir . '/assets/css/home.css';
        wp_enqueue_style('ti3d-home', $theme_uri . '/assets/css/home.css', ['astra-child'], file_exists($home_css) ? filemtime($home_css) : null);
    }

    if (function_exists('is_product_category') && is_product_category()) {
        $shop_css = $theme_dir . '/assets/css/shop.css';
        wp_enqueue_style('ti3d-shop', $theme_uri . '/assets/css/shop.css', ['astra-child'], file_exists($shop_css) ? filemtime($shop_css) : null);
    }

    if (function_exists('is_account_page') && is_account_page()) {
        $account_css = $theme_dir . '/assets/css/account.css';
        wp_enqueue_style('ti3d-account', $theme_uri . '/assets/css/account.css', ['astra-child'], file_exists($account_css) ? filemtime($account_css) : null);
    }
});

// ===========================================
// DESACTIVAR MALLA GLOBAL (body::after) + BASE CANVAS
// ===========================================
add_action('wp_head', function () {
    ?>
    <style>
        /* Apaga la malla dorada global (la que tienes en body::after) */
        body::after { opacity: 0 !important; }

        /* Canvas global de partículas: detrás de todo */
        #ti3dGlobalParticles{
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.45;
            mix-blend-mode: screen;
        }

        /* Asegura que el contenido esté por encima del canvas */
        #page, .site, .site-content, main, header, footer{
            position: relative;
            z-index: 1;
        }
    </style>
    <?php
}, 20);

// ===========================================
// CARRITO FLOTANTE CON ICONO
// ===========================================
add_action('wp_footer', function() {
    if (!function_exists('WC')) return;
    if (!WC()->cart) return;

    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_url = wc_get_cart_url();
    ?>
    <div class="cart-icon-container">
        <a href="<?php echo esc_url($cart_url); ?>" class="cart-icon-link" title="Ver carrito">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="cart-count <?php echo $cart_count == 0 ? 'hidden' : ''; ?>"><?php echo (int)$cart_count; ?></span>
        </a>
    </div>
    <?php
}, 50);

// Actualizar contador con AJAX
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    if (!function_exists('WC') || !WC()->cart) return $fragments;
    $cart_count = WC()->cart->get_cart_contents_count();
    $fragments['.cart-count'] = '<span class="cart-count ' . ($cart_count == 0 ? 'hidden' : '') . '">' . (int)$cart_count . '</span>';
    return $fragments;
});

// ===========================================
// FOOTER PERSONALIZADO
// ===========================================
add_filter('astra_footer_copyright', function() {
    return 'Todos los derechos © ' . date('Y') . ' tuimpresion3d | Diseñado por <a href="https://cabotechsolutions.com" target="_blank" rel="noopener">CaboTechSolutions S.L.</a>';
});

// ===========================================
// FOOTER TOP (3 columnas) - antes del copyright
// ===========================================
add_action('astra_footer', function () {
    ?>
    <div class="ti3d-footer-top">
        <div class="ti3d-footer-container">
            <div class="ti3d-footer-grid">
                <div class="ti3d-footer-col">
                    <div class="ti3d-footer-brand">TUIMPRESION3D</div>
                    <p class="ti3d-footer-text">
                        Diseños 3D premium, prototipado y fabricación. Piezas resistentes, acabados limpios y envío rápido.
                    </p>
                    <div class="ti3d-footer-badges">
                        <span>⭐ Calidad</span>
                        <span>🧱 Materiales PRO</span>
                        <span>📦 Envíos</span>
                    </div>
                </div>

                <div class="ti3d-footer-col">
                    <div class="ti3d-footer-title">Tienda</div>
                    <ul class="ti3d-footer-links">
                        <li><a href="<?php echo esc_url(home_url('/categorias')); ?>">Categorías</a></li>
                        <li><a href="<?php echo esc_url(home_url('/solicitar-presupuesto')); ?>">Solicitar presupuesto</a></li>
                        <li><a href="<?php echo esc_url(home_url('/mi-cuenta')); ?>">Mi cuenta</a></li>
                        <li><a href="<?php echo function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : '#'; ?>">Carrito</a></li>
                    </ul>
                </div>

                <div class="ti3d-footer-col">
                    <div class="ti3d-footer-title">Contacto</div>
                    <ul class="ti3d-footer-links">
                        <li><a href="<?php echo esc_url(home_url('/contacto')); ?>">Formulario</a></li>
                        <li><a href="mailto:info@tuimpresion3d.com">info@tuimpresion3d.com</a></li>
                        <li class="ti3d-footer-muted">Granada · España</li>
                    </ul>

                    <div class="ti3d-footer-social">
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="TikTok">TT</a>
                        <a href="#" aria-label="YouTube">YT</a>
                    </div>
                </div>
            </div>

            <div class="ti3d-footer-bottomline"></div>
        </div>
    </div>
    <?php
}, 5);

// ===========================================
// BODY CLASS (si lo necesitas para estilos específicos)
// ===========================================
add_filter('body_class', function ($classes) {
    // Cambia el nombre si tu template se llama distinto
    if (is_page_template('template-home.php')) {
        $classes[] = 'ti3d-home';
    }

    if (function_exists('is_page') && is_page('solicitar-presupuesto')) {
        $classes[] = 'ti3d-quote-page';
    }

    if (
        function_exists('is_account_page')
        && is_account_page()
        && !is_user_logged_in()
        && isset($_GET['register'])
        && sanitize_text_field(wp_unslash($_GET['register'])) === '1'
    ) {
        $classes[] = 'ti3d-show-register';
    }

    return $classes;
});

// ===========================================
// MI CUENTA (NO LOGUEADO): LOGIN + ENLACE A REGISTRO
// ===========================================
add_action('woocommerce_login_form_end', function () {
    if (!function_exists('wc_get_page_permalink')) {
        return;
    }

    $register_url = add_query_arg('register', '1', wc_get_page_permalink('myaccount'));
    echo '<p class="ti3d-account-switch">¿No tienes cuenta? <a href="' . esc_url($register_url) . '">Crear cuenta</a></p>';
}, 20);

add_action('woocommerce_register_form_end', function () {
    if (!function_exists('wc_get_page_permalink')) {
        return;
    }

    $login_url = wc_get_page_permalink('myaccount');
    echo '<p class="ti3d-account-switch">¿Ya tienes cuenta? <a href="' . esc_url($login_url) . '">Acceder</a></p>';
}, 20);

// ===========================================
// PARTÍCULAS GLOBALES (fondo) - LIGERO
// ===========================================
add_action('wp_footer', function () {
    // Si quieres apagar partículas en checkout/carrito por 100% performance:
    // if (function_exists('is_checkout') && is_checkout()) return;
    // if (function_exists('is_cart') && is_cart()) return;

    ?>
    <canvas id="ti3dGlobalParticles" aria-hidden="true"></canvas>
    <script>
    (function(){
      const c = document.getElementById('ti3dGlobalParticles');
      if(!c) return;
      const ctx = c.getContext('2d');

      let w,h,dpr;
      const P = [];
      const MAX = 78;       // ligero pero visible
      const SPEED = 0.09;   // movimiento mas flotante

      const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      if (reduceMotion) return;

      function resize(){
        dpr = Math.min(window.devicePixelRatio||1, 2);
        w = window.innerWidth; h = window.innerHeight;
        c.width = Math.floor(w*dpr); c.height = Math.floor(h*dpr);
        c.style.width = w+'px'; c.style.height = h+'px';
        ctx.setTransform(dpr,0,0,dpr,0,0);
      }
      function rand(a,b){ return Math.random()*(b-a)+a; }
      function spawn(){
        P.push({
          x: rand(0,w),
          y: rand(-h, h),
          r: rand(0.7, 1.9),
          a: rand(0.07, 0.22),
          vy: rand(SPEED, SPEED+0.22),
          vx: rand(-0.05, 0.05),
          t: rand(0, Math.PI * 2),
          hue: Math.random() < 0.86 ? '0,200,255' : '201,162,39' // mayoría cian, algunos dorados
        });
      }

      function init(){
        resize();
        P.length = 0;
        for(let i=0;i<MAX;i++) spawn();
      }

      function tick(){
        ctx.clearRect(0,0,w,h);

        for(let i=0;i<P.length;i++){
          const p = P[i];
          p.t += 0.012;
          p.x += p.vx + Math.sin(p.t) * 0.09;
          p.y += p.vy;

          if(p.y > h+20){ p.y = -20; p.x = rand(0,w); }
          if(p.x < -20) p.x = w+20;
          if(p.x > w+20) p.x = -20;

          ctx.beginPath();
          ctx.fillStyle = `rgba(${p.hue},${p.a})`;
          ctx.arc(p.x, p.y, p.r, 0, Math.PI*2);
          ctx.fill();
        }

        requestAnimationFrame(tick);
      }

      window.addEventListener('resize', resize, { passive:true });
      init();
      tick();
    })();
    </script>
    <?php
}, 1);

// ===========================================
// SISTEMA DE MODELOS 3D PARA CLIENTES
// ===========================================

// 1. Añadir pestaña "Mis Modelos 3D" en Mi Cuenta
add_filter('woocommerce_account_menu_items', function($items) {
    $new_items = [];
    foreach ($items as $key => $value) {
        $new_items[$key] = $value;
        if ($key === 'orders') {
            $new_items['modelos-3d'] = 'Mis Modelos 3D';
        }
    }
    return $new_items;
});

// 2. Registrar el endpoint
add_action('init', function() {
    add_rewrite_endpoint('modelos-3d', EP_ROOT | EP_PAGES);
});

// 3. Contenido de la página de modelos 3D
add_action('woocommerce_account_modelos-3d_endpoint', function() {
    $user_id = get_current_user_id();
    $modelos = get_user_meta($user_id, 'modelos_3d', true);
    ?>
    <div class="modelos-3d-container">
        <div class="modelos-3d-header">
            <h2>Mis Modelos 3D</h2>
            <p>Aquí puedes visualizar los modelos 3D de tus proyectos personalizados.</p>
        </div>

        <?php if (empty($modelos) || !is_array($modelos)) : ?>
            <div class="modelos-3d-empty">
                <div class="empty-icon">🎨</div>
                <h3>Aún no tienes modelos 3D</h3>
                <p>Cuando solicites un diseño personalizado, tu modelo 3D aparecerá aquí para que puedas visualizarlo antes de la fabricación.</p>
                <a href="<?php echo esc_url(home_url('/solicitar-presupuesto')); ?>" class="btn-solicitar">
                    Solicitar diseño personalizado
                </a>
            </div>
        <?php else : ?>
            <div class="modelos-3d-grid">
                <?php foreach ($modelos as $index => $modelo) : ?>
                    <div class="modelo-card">
                        <div class="modelo-viewer">
                            <model-viewer
                                src="<?php echo esc_url($modelo['archivo']); ?>"
                                alt="<?php echo esc_attr($modelo['nombre']); ?>"
                                auto-rotate
                                camera-controls
                                touch-action="pan-y"
                                poster="<?php echo isset($modelo['poster']) ? esc_url($modelo['poster']) : ''; ?>"
                                shadow-intensity="1"
                                exposure="0.8"
                                style="width: 100%; height: 280px; background: #0a0a0a;">
                                <div class="modelo-loading" slot="poster">
                                    <div class="spinner"></div>
                                    Cargando modelo...
                                </div>
                            </model-viewer>
                        </div>
                        <div class="modelo-info">
                            <h3><?php echo esc_html($modelo['nombre']); ?></h3>
                            <?php if (!empty($modelo['descripcion'])) : ?>
                                <p class="modelo-desc"><?php echo esc_html($modelo['descripcion']); ?></p>
                            <?php endif; ?>
                            <div class="modelo-meta">
                                <?php if (!empty($modelo['fecha'])) : ?>
                                    <span class="modelo-fecha">📅 <?php echo esc_html($modelo['fecha']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($modelo['estado'])) : ?>
                                    <span class="modelo-estado estado-<?php echo esc_attr($modelo['estado']); ?>">
                                        <?php
                                        $estados = [
                                            'revision'   => '🔍 En revisión',
                                            'aprobado'   => '✅ Aprobado',
                                            'produccion' => '🏭 En producción',
                                            'enviado'    => '📦 Enviado'
                                        ];
                                        echo isset($estados[$modelo['estado']]) ? $estados[$modelo['estado']] : esc_html($modelo['estado']);
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($modelo['archivo'])) : ?>
                            <a href="<?php echo esc_url($modelo['archivo']); ?>" download class="modelo-download">
                                ⬇️ Descargar modelo
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <?php
});

// 4. Panel de administración para gestionar modelos de usuarios
add_action('show_user_profile', 'ti3d_mostrar_campos_modelos_3d');
add_action('edit_user_profile', 'ti3d_mostrar_campos_modelos_3d');

function ti3d_mostrar_campos_modelos_3d($user) {
    if (!current_user_can('edit_users')) return;

    $modelos = get_user_meta($user->ID, 'modelos_3d', true);
    if (!is_array($modelos)) $modelos = [];
    ?>
    <h2>Modelos 3D del Cliente</h2>
    <p class="description">Gestiona los modelos 3D asociados a este cliente. Archivos en formato GLB o GLTF.</p>

    <table class="form-table" id="modelos-3d-table">
        <tbody>
            <?php if (!empty($modelos)) : ?>
                <?php foreach ($modelos as $index => $modelo) : ?>
                    <tr class="modelo-row">
                        <th>Modelo #<?php echo $index + 1; ?></th>
                        <td>
                            <p>
                                <label>Nombre:</label><br>
                                <input type="text" name="modelos_3d[<?php echo $index; ?>][nombre]"
                                       value="<?php echo esc_attr($modelo['nombre']); ?>" class="regular-text">
                            </p>
                            <p>
                                <label>URL del archivo (GLB/GLTF):</label><br>
                                <input type="url" name="modelos_3d[<?php echo $index; ?>][archivo]"
                                       value="<?php echo esc_url($modelo['archivo']); ?>" class="large-text">
                                <button type="button" class="button upload-modelo-btn">Subir archivo</button>
                            </p>
                            <p>
                                <label>Descripción:</label><br>
                                <textarea name="modelos_3d[<?php echo $index; ?>][descripcion]" rows="2" class="large-text"><?php echo esc_textarea($modelo['descripcion'] ?? ''); ?></textarea>
                            </p>
                            <p>
                                <label>Fecha:</label>
                                <input type="date" name="modelos_3d[<?php echo $index; ?>][fecha]"
                                       value="<?php echo esc_attr($modelo['fecha'] ?? ''); ?>">

                                <label style="margin-left:20px;">Estado:</label>
                                <select name="modelos_3d[<?php echo $index; ?>][estado]">
                                    <option value="revision" <?php selected($modelo['estado'] ?? '', 'revision'); ?>>En revisión</option>
                                    <option value="aprobado" <?php selected($modelo['estado'] ?? '', 'aprobado'); ?>>Aprobado</option>
                                    <option value="produccion" <?php selected($modelo['estado'] ?? '', 'produccion'); ?>>En producción</option>
                                    <option value="enviado" <?php selected($modelo['estado'] ?? '', 'enviado'); ?>>Enviado</option>
                                </select>
                            </p>
                            <p><button type="button" class="button button-link-delete eliminar-modelo-btn">Eliminar</button></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><button type="button" class="button button-secondary" id="agregar-modelo-btn">+ Añadir nuevo modelo 3D</button></p>

    <script>
    jQuery(document).ready(function($) {
        var idx = <?php echo count($modelos); ?>;

        $('#agregar-modelo-btn').on('click', function() {
            var html = '<tr class="modelo-row"><th>Modelo #'+(idx+1)+'</th><td>'+
                '<p><label>Nombre:</label><br><input type="text" name="modelos_3d['+idx+'][nombre]" class="regular-text"></p>'+
                '<p><label>URL del archivo (GLB/GLTF):</label><br><input type="url" name="modelos_3d['+idx+'][archivo]" class="large-text"> '+
                '<button type="button" class="button upload-modelo-btn">Subir archivo</button></p>'+
                '<p><label>Descripción:</label><br><textarea name="modelos_3d['+idx+'][descripcion]" rows="2" class="large-text"></textarea></p>'+
                '<p><label>Fecha:</label> <input type="date" name="modelos_3d['+idx+'][fecha]" value="'+new Date().toISOString().split('T')[0]+'"> '+
                '<label style="margin-left:20px;">Estado:</label> <select name="modelos_3d['+idx+'][estado]">'+
                '<option value="revision">En revisión</option><option value="aprobado">Aprobado</option>'+
                '<option value="produccion">En producción</option><option value="enviado">Enviado</option></select></p>'+
                '<p><button type="button" class="button button-link-delete eliminar-modelo-btn">Eliminar</button></p></td></tr>';
            $('#modelos-3d-table tbody').append(html);
            idx++;
        });

        $(document).on('click', '.eliminar-modelo-btn', function() {
            if(confirm('¿Eliminar este modelo?')) $(this).closest('tr').remove();
        });

        $(document).on('click', '.upload-modelo-btn', function(e) {
            e.preventDefault();
            var btn = $(this), input = btn.prev('input');
            var uploader = wp.media({title:'Seleccionar archivo 3D', button:{text:'Usar archivo'}, multiple:false});
            uploader.on('select', function() {
                input.val(uploader.state().get('selection').first().toJSON().url);
            });
            uploader.open();
        });
    });
    </script>
    <?php
}

// 5. Guardar los modelos 3D
add_action('personal_options_update', 'ti3d_guardar_modelos_3d');
add_action('edit_user_profile_update', 'ti3d_guardar_modelos_3d');

function ti3d_guardar_modelos_3d($user_id) {
    if (!current_user_can('edit_users')) return;

    if (isset($_POST['modelos_3d']) && is_array($_POST['modelos_3d'])) {
        $modelos = [];
        foreach ($_POST['modelos_3d'] as $modelo) {
            if (!empty($modelo['nombre']) && !empty($modelo['archivo'])) {
                $modelos[] = [
                    'nombre' => sanitize_text_field($modelo['nombre']),
                    'archivo' => esc_url_raw($modelo['archivo']),
                    'descripcion' => sanitize_textarea_field($modelo['descripcion'] ?? ''),
                    'fecha' => sanitize_text_field($modelo['fecha'] ?? ''),
                    'estado' => sanitize_text_field($modelo['estado'] ?? 'revision')
                ];
            }
        }
        update_user_meta($user_id, 'modelos_3d', $modelos);
    } else {
        delete_user_meta($user_id, 'modelos_3d');
    }
}

// 6. Permitir subir archivos GLB y GLTF
add_filter('upload_mimes', function($mimes) {
    $mimes['glb'] = 'model/gltf-binary';
    $mimes['gltf'] = 'model/gltf+json';
    return $mimes;
});

add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext === 'glb') {
        $data['ext'] = 'glb';
        $data['type'] = 'model/gltf-binary';
    }
    if ($ext === 'gltf') {
        $data['ext'] = 'gltf';
        $data['type'] = 'model/gltf+json';
    }
    return $data;
}, 10, 4);

// 7. Cargar media uploader en perfil de usuario
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'user-edit.php' || $hook === 'profile.php') {
        wp_enqueue_media();
    }
});

// ===========================================
// CABECERA VISUAL EN CATEGORIAS DE PRODUCTO
// ===========================================

/**
 * Obtiene la imagen de cabecera para una categoria de producto.
 * Prioridad:
 * 1) Miniatura de la categoria en WooCommerce.
 * 2) Fallback por slug usando imagenes del tema.
 */
function ti3d_get_product_cat_header_image_url($term) {
    if (!$term || is_wp_error($term)) {
        return '';
    }

    $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
    if (!empty($thumb_id)) {
        $thumb_url = wp_get_attachment_image_url((int) $thumb_id, 'full');
        if (!empty($thumb_url)) {
            return $thumb_url;
        }
    }

    $fallback_by_slug = [
        'camper'     => '/assets/img/cat-camper.jpg',
        '4x4'        => '/assets/img/cat-4x4.jpg',
        'nautica'    => '/assets/img/cat-nautica.jpg',
        'audio'      => '/assets/img/cat-audio.jpg',
        'industrial' => '/assets/img/cat-industrial.jpg',
    ];

    $slug = isset($term->slug) ? (string) $term->slug : '';
    if ($slug && isset($fallback_by_slug[$slug])) {
        return get_stylesheet_directory_uri() . $fallback_by_slug[$slug];
    }

    return '';
}

add_action('woocommerce_before_shop_loop', function() {
    if (!is_product_category()) {
        return;
    }

    $term = get_queried_object();
    if (!$term || is_wp_error($term)) {
        return;
    }

    $image_url = ti3d_get_product_cat_header_image_url($term);
    if (empty($image_url)) {
        return;
    }
    ?>
    <section class="ti3d-cat-hero" aria-label="<?php echo esc_attr($term->name); ?>">
        <div class="ti3d-cat-hero__bg" style="background-image:url('<?php echo esc_url($image_url); ?>');"></div>
        <div class="ti3d-cat-hero__overlay"></div>
        <div class="ti3d-cat-hero__content">
            <span class="ti3d-cat-hero__eyebrow">Categoria</span>
            <h2 class="ti3d-cat-hero__title"><?php echo esc_html($term->name); ?></h2>
        </div>
    </section>
    <?php
}, 5);
