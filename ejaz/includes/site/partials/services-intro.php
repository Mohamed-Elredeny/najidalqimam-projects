<section id="services-intro" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="intro-images-container d-flex" style="height: 350px;">
                    <?php for ($i = 1; $i <= 3; $i++):
                        $imgKey = "img{$i}";
                        ?>
                        <?php if (!empty($intro[$imgKey])): ?>
                        <div class="intro-image-wrapper me-2" style="flex: 1; overflow: hidden; border-radius: 15px;">
                            <img
                                    src="<?= htmlspecialchars($intro[$imgKey]) ?>"
                                    alt=""
                                    style="width:100%; height:100%; object-fit:cover;"
                            >
                        </div>
                    <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="col-lg-6 text-<?= $lang==='ar' ? 'end' : 'start' ?>">
                <h2 class="mb-4 fw-bold text-primary">
                    <?= $lang==='ar'
                        ? 'شركة انجاز النوادي للمقاولات العامة'
                        : 'Injaz Al‑Nawadi General Contracting Co.' ?>
                </h2>
                <p class="mb-3">
                    <?= nl2br(htmlspecialchars($intro["content_{$lang}"])) ?>
                </p>
                <a href="#" class="btn btn-primary">
                    <?= $lang==='ar' ? 'عرض الكل' : 'View All' ?>
                </a>
            </div>
        </div>
    </div>
</section>
