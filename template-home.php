<?php
/**
 * Template Name: Inicio Premium
 */
get_header();
?>

<main id="home-premium">

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="hero-overlay"></div>

        <!-- Canvas partículas -->
        <canvas class="hero-particles" id="heroParticles"></canvas>

        <div class="hero-content">
            <span class="hero-badge">Diseño & Fabricación 3D Premium</span>
            <h1 class="hero-title">Piezas únicas para<br><span class="text-gradient-gold">proyectos únicos</span></h1>
            <p class="hero-subtitle">Diseñamos y fabricamos piezas personalizadas de alta calidad para campers, 4x4, náutica y audio profesional</p>
            <div class="hero-buttons">
                <a href="/tienda" class="btn-primary">Ver Catálogo</a>
                <a href="/solicitar-presupuesto" class="btn-outline">Solicitar Diseño</a>
            </div>
        </div>

        <div class="hero-scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- CATEGORÍAS (CON IMÁGENES TIPO MOSAICO) -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Nuestras Especialidades</span>
                <h2 class="section-title">Categorías</h2>
            </div>

            <div class="categories-grid">
                <?php
                $categories = [
                    [
                        'slug'  => 'camper',
                        'name'  => 'Camper & Autocaravana',
                        'tag'   => 'CAMPER',
                        'image' => get_stylesheet_directory_uri() . '/assets/img/cat-camper.jpg',
                        'desc'  => 'Soportes, organizadores y accesorios para tu hogar sobre ruedas'
                    ],
                    [
                        'slug'  => '4x4',
                        'name'  => 'Vehículo 4x4',
                        'tag'   => '4x4',
                        'image' => get_stylesheet_directory_uri() . '/assets/img/cat-4x4.jpg',
                        'desc'  => 'Piezas resistentes para tus aventuras offroad'
                    ],
                    [
                        'slug'  => 'nautica',
                        'name'  => 'Náutica',
                        'tag'   => 'NAUTICA',
                        'image' => get_stylesheet_directory_uri() . '/assets/img/cat-nautica.jpg',
                        'desc'  => 'Componentes resistentes al agua para embarcaciones'
                    ],
                    [
                        'slug'  => 'audio',
                        'name'  => 'Audio Premium',
                        'tag'   => 'AUDIO',
                        'image' => get_stylesheet_directory_uri() . '/assets/img/cat-audio.jpg',
                        'desc'  => 'Adaptadores y wave horns para grandes marcas'
                    ],
                    [
                        'slug'  => 'industrial',
                        'name'  => 'Industrial',
                        'tag'   => 'INDUSTRIAL',
                        'image' => get_stylesheet_directory_uri() . '/assets/img/cat-industrial.jpg',
                        'desc'  => 'Soluciones técnicas para proyectos profesionales'
                    ],
                ];

                foreach ($categories as $cat) :
                    $term_link = get_term_link($cat['slug'], 'product_cat');
                    $link = !is_wp_error($term_link) ? $term_link : '/tienda';

                    $slug_class = 'category-' . sanitize_html_class($cat['slug']);
                ?>
                    <a href="<?php echo esc_url($link); ?>"
                       class="category-card category-card--image <?php echo esc_attr($slug_class); ?>">

                        <span class="category-bg"
                              style="background-image:url('<?php echo esc_url($cat['image']); ?>');"></span>

                        <span class="category-overlay"></span>

                        <div class="category-content">
                            <?php if (!empty($cat['tag'])) : ?>
                                <span class="category-pill"><?php echo esc_html($cat['tag']); ?></span>
                            <?php endif; ?>

                            <h3 class="category-name"><?php echo esc_html($cat['name']); ?></h3>
                            <p class="category-desc"><?php echo esc_html($cat['desc']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- POR QUÉ ELEGIRNOS -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">La Diferencia</span>
                <h2 class="section-title">¿Por qué elegirnos?</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3>Diseño a Medida</h3>
                    <p>Cada pieza se diseña específicamente para tu proyecto. Visualiza el modelo 3D antes de fabricar.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3>Calidad Premium</h3>
                    <p>Materiales de primera calidad: PETG, ABS, Nylon. Resistencia y durabilidad garantizadas.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3>Entrega Rápida</h3>
                    <p>Producción ágil y envío express. Tu pieza lista en el menor tiempo posible.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCTOS DESTACADOS -->
    <section class="products-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Lo Más Vendido</span>
                <h2 class="section-title">Productos Destacados</h2>
            </div>
            <div class="products-grid">
                <?php
                $args = [
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'meta_key'       => 'total_sales',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                ];
                $products = new WP_Query($args);

                if ($products->have_posts()) :
                    while ($products->have_posts()) : $products->the_post();
                        global $product;
                ?>
                <div class="product-card">
                    <a href="<?php the_permalink(); ?>" class="product-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <div class="no-image">3D</div>
                        <?php endif; ?>
                    </a>
                    <div class="product-info">
                        <h3 class="product-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="product-price">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="product-btn">Ver Producto</a>
                    </div>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <p class="no-products">Próximamente nuevos productos</p>
                <?php endif; ?>
            </div>
            <div class="products-cta">
                <a href="/tienda" class="btn-primary">Ver Todo el Catálogo</a>
            </div>
        </div>
    </section>

    <!-- CTA DISEÑO PERSONALIZADO -->
    <section class="cta-section">
        <div class="cta-bg"></div>
        <div class="container">
            <div class="cta-content">
                <span class="section-badge">¿No encuentras lo que buscas?</span>
                <h2 class="cta-title">Diseñamos tu pieza a medida</h2>
                <p class="cta-text">Cuéntanos tu idea. Diseñamos el modelo 3D, lo visualizas antes de aprobar, y lo fabricamos con la máxima calidad.</p>
                <a href="/solicitar-presupuesto" class="btn-primary btn-large">Solicitar Presupuesto Gratis</a>
            </div>
        </div>
    </section>

    <!-- PROCESO -->
    <section class="process-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Cómo Funciona</span>
                <h2 class="section-title">Nuestro Proceso</h2>
            </div>
            <div class="process-grid">
                <div class="process-step">
                    <div class="step-number">01</div>
                    <h3>Cuéntanos tu idea</h3>
                    <p>Describe lo que necesitas, envía fotos o medidas de referencia.</p>
                </div>
                <div class="process-connector"></div>
                <div class="process-step">
                    <div class="step-number">02</div>
                    <h3>Diseñamos en 3D</h3>
                    <p>Creamos el modelo digital y te lo enviamos para que lo visualices.</p>
                </div>
                <div class="process-connector"></div>
                <div class="process-step">
                    <div class="step-number">03</div>
                    <h3>Apruebas el diseño</h3>
                    <p>Revisa el modelo 3D interactivo y solicita ajustes si es necesario.</p>
                </div>
                <div class="process-connector"></div>
                <div class="process-step">
                    <div class="step-number">04</div>
                    <h3>Fabricamos y enviamos</h3>
                    <p>Producimos tu pieza con materiales premium y te la enviamos.</p>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
// 1) Ocultar scroll indicator al hacer scroll
window.addEventListener('scroll', function() {
  const scrollIndicator = document.querySelector('.hero-scroll-indicator');
  if (scrollIndicator) {
    if (window.scrollY > 100) scrollIndicator.classList.add('hidden');
    else scrollIndicator.classList.remove('hidden');
  }
});

// 2) Partículas cian siguiendo el ratón (sutil)
(function(){
  const canvas = document.getElementById('heroParticles');
  if (!canvas) return;

  const hero = document.querySelector('.hero-section');
  const ctx = canvas.getContext('2d');

  let w, h, dpr;
  const particles = [];
  const MAX = 70;

  function resize(){
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    w = hero.clientWidth;
    h = hero.clientHeight;
    canvas.width = Math.floor(w * dpr);
    canvas.height = Math.floor(h * dpr);
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }

  function rand(min,max){ return Math.random()*(max-min)+min; }

  function spawn(x,y){
    particles.push({
      x: x ?? rand(0,w),
      y: y ?? rand(0,h),
      r: rand(0.8, 2.2),
      a: rand(0.12, 0.50),
      vx: rand(-0.25, 0.25),
      vy: rand(-0.15, 0.35),
      life: rand(120, 220)
    });
  }

  function init(){
    resize();
    particles.length = 0;
    for (let i=0;i<MAX;i++) spawn();
  }

  function tick(){
    ctx.clearRect(0,0,w,h);

    for (let i=0;i<particles.length;i++){
      const p = particles[i];
      p.x += p.vx;
      p.y += p.vy;
      p.life -= 1;

      p.vy += 0.0015;
      if (p.x < -10) p.x = w+10;
      if (p.x > w+10) p.x = -10;
      if (p.y > h+20) p.y = -20;

      ctx.beginPath();
      ctx.fillStyle = `rgba(0,200,255,${p.a})`;
      ctx.arc(p.x, p.y, p.r, 0, Math.PI*2);
      ctx.fill();

      for (let j=i+1;j<particles.length;j++){
        const q = particles[j];
        const dx = p.x - q.x;
        const dy = p.y - q.y;
        const d = Math.sqrt(dx*dx + dy*dy);
        if (d < 140){
          ctx.strokeStyle = `rgba(0,200,255,${0.10 * (1 - d/140)})`;
          ctx.lineWidth = 1;
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(q.x, q.y);
          ctx.stroke();
        }
      }
    }

    for (let i=particles.length-1;i>=0;i--){
      if (particles[i].life <= 0) particles.splice(i,1);
    }
    while (particles.length < MAX) spawn();

    requestAnimationFrame(tick);
  }

  window.addEventListener('resize', resize);
  init();
  tick();
})();
</script>

<?php get_footer(); ?>
